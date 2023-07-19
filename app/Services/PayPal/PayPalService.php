<?php

namespace App\Services\PayPal;

use App\Http\Requests\PayPalWebhookRequest;
use App\Models\Order;
use Illuminate\Support\Facades\Http;

class PayPalService
{
    private string $client_id;
    private string $secret;

    private string $apiURL;
    private string $currency = 'RUB';

    public function __construct()
    {
        if (app()->environment('production')) {
            $this->client_id = config('paypal.client_id');
            $this->secret = config('paypal.secret');

            $this->apiURL = 'https://api-m.paypal.com';
        } else {
            $this->client_id = config('paypal.sandbox_client_id');
            $this->secret = config('paypal.sandbox_secret');

            $this->apiURL = 'https://api-m.sandbox.paypal.com';
        }


    }

    /**
     * @param Order $order Order data
     * @return ?string ID of created order
     */
    public function createOrder(Order $order): ?string
    {
        $address = [
            'address_line_1' => $order->address->fullAddress ?? null,
            'admin_area_2' => $order->address->city ?? $order->address->region,
            'postal_code' => $order->address->zip ?? null,
            'country_code' => $order->address->countryCode ?? null,
        ];

        $payload = [
            'intent' => 'CAPTURE', // CAPTURE, AUTHORIZE
            'payer' => [
                'email_address' => $order->email,
                'name' => [
                    'given_name' => $order->name,
                    'surname' => $order->surname,
                ],
                'address' => $address,
            ],
            'purchase_units' => [
                [
                    'reference_id' => $order->id,
                    'amount' => [
                        'currency_code' => $this->currency,
                        'value' => $order->total_cost,
                    ],
                    'items' => [],
                    'shipping' => [
                        'name' => [
                            'full_name' => $order->name . ' ' . $order->surname,
                        ],
                        'type' => 'SHIPPING',
                        'address' => $address,
                    ],
                ]
            ],
            'application_context' => [
                'brand_name' => mb_substr(config('app.name'), 0, 127),
                'locale' => app()->getLocale(),
                'landing_page' => 'NO_PREFERENCE', // LOGIN, BILLING, NO_PREFERENCE
                'shipping_preference' => 'SET_PROVIDED_ADDRESS', // GET_FROM_FILE, NO_SHIPPING, SET_PROVIDED_ADDRESS
                'user_action' => 'PAY_NOW', // CONTINUE, PAY_NOW
                'return_url' => config('app.land_url') . '/thank-page?order_id=' . $order->id,
                'cancel_url' => config('app.land_url'),
            ],
        ];

        $cart_cost = 0;
        foreach ($order->cart as $cart) {
            $cart->calcCost();
            $cart_cost += $cart->total_cost;

            $payload['purchase_units'][0]['items'][] = [
                'name' => $cart->product->name,
                'unit_amount' => [
                    'currency_code' => $this->currency,
                    'value' => $cart->cost
                ],
                'quantity' => $cart->count,
            ];
        }

        $payload['purchase_units'][0]['amount']['breakdown'] = [
            'item_total' => [
                'currency_code' => $this->currency,
                'value' => $cart_cost,
            ],
            'shipping' => [
                'currency_code' => $this->currency,
                'value' => $order->total_cost - $cart_cost,
            ]
        ];

        $response = $this->makeRequest()->post($this->apiURL . '/v2/checkout/orders', $payload);

        if (!$response->successful()) {
            \Log::error($response->json());
        }

        return $response->json('id');
    }

    public function webhooks(PayPalWebhookRequest $request)
    {
        if (!$this->verifyWebhook($request)) abort(401);

        $order = Order::where('id', $request->resource['purchase_units'][0]['reference_id'] ?? '')->with(['cart' => function ($q) {
            $q->with(['product' => function ($q) {
                $q->with(['colors', 'sizes', 'sizesBottom']);
            }]);
        }])->first();

        if (!$order) {
            \Log::error('Order with ID ' . $$request->resource['purchase_units'][0]['reference_id'] . ' not found');
            abort(404);
        }

        switch ($request->event_type) {
            case 'CHECKOUT.ORDER.COMPLETED':
                $order->status = Order::STATUS_PAYED;
        }


        if ($order->isDirty()) {
            \Log::debug('Order #' . $order->id . ' status changed to ' . $order->status);

            $order->save();

            if ($order->status === Order::STATUS_PAYED) $order->processOrder();
            if ($order->status === Order::STATUS_FAILED) $order->orderFailed();
        }

        return response('', 200);
    }

    public function verifyWebhook(PayPalWebhookRequest $request): bool
    {
        if (!app()->environment('production')) return true;

        $response = $this->makeRequest()->post($this->apiURL . '/v1/notifications/verify-webhook-signature', [
            'auth_algo' => $request->header('PAYPAL-AUTH-ALGO'),
            'cert_url' => $request->header('PAYPAL-CERT-URL'),
            'transmission_id' => $request->header('PAYPAL-TRANSMISSION-ID'),
            'transmission_sig' => $request->header('PAYPAL-TRANSMISSION-SIG'),
            'transmission_time' => $request->header('PAYPAL-TRANSMISSION-TIME'),
            'webhook_id' => $request->id,
            'webhook_event' => $request->input(),
        ]);

        $successful = false;
        if (!$response->successful()) {
            \Log::error('Error when validating PayPal webhook: ' . $response->json());
        } elseif ($response->json('verification_status') === 'SUCCESS') {
            $successful = true;
        }

        \Log::debug('Webhook validate status: ' . (string)$successful);

        return $successful;
    }

    private function makeRequest(): \Illuminate\Http\Client\PendingRequest
    {
        return Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($this->client_id . ':' . $this->secret),
        ])->acceptJson();
    }
}
