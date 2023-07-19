<?php

namespace App\Services\Yookassa;

use App\Http\Requests\YookassaNotificationRequest;
use App\Models\Order;
use YooKassa\Client;
use YooKassa\Request\Payments\CreatePaymentRequest;

class YookassaService
{
    const STATUS_PENDING = 'pending';
    const STATUS_WAITING = 'waiting_for_capture';
    const STATUS_SUCCEEDED = 'succeeded';
    const STATUS_CANCELED = 'canceled';
    private Client $client;
    private $secretKey;
    private $shopID;
    private Order $order;

    public function __construct()
    {
        if (app()->environment('production')) {
            $this->secretKey = config('yookassa.secret');
            $this->shopID = config('yookassa.shop_id');
        } else {
            $this->secretKey = config('yookassa.test_secret');
            $this->shopID = config('yookassa.test_shop_id');
        }

        $this->client = new Client();
        $this->client->setAuth($this->shopID, $this->secretKey);
    }

    public function shopInfo()
    {
        try {
            $response = $this->client->me();
        } catch (\Exception $e) {
            $response = $e;
            $this->logError($response);
        }

        return $response;
    }

    private function logError($error)
    {
        if (!is_string($error)) $error = json_encode($error, JSON_UNESCAPED_UNICODE);

        \Log::error('Yookassa error: ' . $error);;
    }

    /**
     * Create payment in Yookassa from order and returns redirect url
     *
     * @throws \YooKassa\Common\Exceptions\NotFoundException
     * @throws \YooKassa\Common\Exceptions\ResponseProcessingException
     * @throws \YooKassa\Common\Exceptions\ApiException
     * @throws \YooKassa\Common\Exceptions\ExtensionNotFoundException
     * @throws \YooKassa\Common\Exceptions\BadApiRequestException
     * @throws \YooKassa\Common\Exceptions\InternalServerError
     * @throws \YooKassa\Common\Exceptions\ForbiddenException
     * @throws \YooKassa\Common\Exceptions\TooManyRequestsException
     * @throws \YooKassa\Common\Exceptions\UnauthorizedException
     */
    public function createPayment(Order $order, string $description = null, string $paymentType = ''): string
    {
        $payload = CreatePaymentRequest::builder();
        $payload->setAmount($order->total_cost)->setCurrency('RUB');
        $payload->setDescription($description);
        $payload->setCapture(true)->setConfirmation([
            'type' => 'redirect',
            'locale' => 'ru_RU',
            'return_url' => config('yookassa.redirect_url') . '/thank-page?order_id=' . $order->id,
        ]);

        $payload->setReceipt([
            'customer' => [
                'fullName' => $order->name . ' ' . $order->surname,
                'email' => $order->email,
                'phone' => $order->phone,
            ]
        ]);

        $payload->setMetadata([
            'orderId' => $order->id,
        ]);

        if ($paymentType) $payload->setPaymentMethodData($paymentType);

        $cart_cost = 0;
        foreach ($order->cart as $cart) {
            $cart->calcCost();
            $cart_cost += $cart->total_cost;

            $payload->addReceiptItem(
                $cart->title,
                $cart->cost,
                $cart->count,
                1,
            );
        }

        if ($order->total_cost > $cart_cost) {
            $payload->addReceiptItem(
                'Доставка',
                $order->total_cost - $cart_cost,
                1,
                1,
            );
        }

        $response = $this->client->createPayment($payload->build(),
            uniqid('', true)
        );

        // get confirmationUrl for redirect
        return $response->getConfirmation()->getConfirmationUrl();
    }

    public function notification(YookassaNotificationRequest $request)
    {
        $payment = $this->paymentInfo($request->object['id']);

        $orderId = $payment->metadata['orderId'] ?? '';

        if ($payment->status === 'canceled') {
            \Log::info('Payment for order #' . $orderId . ' canceled');
            return response('', 200);
        }

        $this->order = Order::where('id', $orderId)->with(['cart' => function ($q) {
            $q->with(['product' => function ($q) {
                $q->with(['colors', 'sizes', 'sizesBottom']);
            }]);
        }])->first();

        if (!$this->order) {
            \Log::error('Order for payment not found. Request: ' . json_encode($request, JSON_UNESCAPED_UNICODE));
            return response('Order error', 404);
        }

        switch ($payment->status) {
            case self::STATUS_PENDING:
                $this->order->status = Order::STATUS_PROCESSING;
                break;
            case self::STATUS_SUCCEEDED:
                $this->orderSucceed();
                break;
            case self::STATUS_WAITING:
                if ($this->capturePayment($request->object['id'], $this->order->total_cost)) {
                    $this->orderSucceed();
                } else {
                    \Log::error('Payment not captured: ' . json_encode($request, JSON_UNESCAPED_UNICODE));
                }
                break;
            case self::STATUS_CANCELED:
                $this->order->status = Order::STATUS_FAILED;
                break;
        }

        if ($this->order->isDirty()) {
            $this->order->save();

            if ($this->order->status === Order::STATUS_PAYED) $this->order->processOrder();
            if ($this->order->status === Order::STATUS_FAILED) $this->order->orderFailed();
        }

        return response('', 200);
    }

    public function paymentInfo($paymentId)
    {
        return $this->client->getPaymentInfo($paymentId);
    }

    private function orderSucceed()
    {
        \Log::info('Order (ID #' . $this->order->id . ') confirmed.');
        $this->order->status = Order::STATUS_PAYED;
    }

    public function capturePayment($paymentId, float $amount): bool
    {
        $payment = $this->client->capturePayment(
            [
                'amount' => [
                    'value' => $amount,
                    'currency' => 'RUB',
                ]
            ],
            $paymentId,
            uniqid('', true));

        return $payment->status === self::STATUS_SUCCEEDED;
    }

    public function checkSucceededPayments()
    {
        $cursor = null;
        $params = [
            'status' => self::STATUS_SUCCEEDED,
        ];

        do {
            $params['cursor'] = $cursor;
            $payments = $this->client->getPayments($params);

            foreach ($payments->getItems() as $payment) {
                $request = new YookassaNotificationRequest();
                $request->object = ['id' => $payment->id];

                $this->notification($request);
            }
        } while ($cursor = $payments->getNextCursor());
    }
}
