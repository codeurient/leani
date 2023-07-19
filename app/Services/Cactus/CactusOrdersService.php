<?php


namespace App\Services\Cactus;


use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;

class CactusOrdersService extends CactusService
{
    public Order $order;

    public function __construct(Order $order)
    {
        parent::__construct();

        $this->order = $order;
    }

    /**
     * Create or update cactus order from order data
     * @return array|null
     * @throws \Exception
     */
    public function createOrder(): ?array
    {
        $cactusOrderId = config('app.name') . '-' . $this->order->id;

        $payload = [
            'id' => $cactusOrderId,
            'externalId' => $this->order->id,
            'date' => $this->order->created_at->format('Y-m-d H:i:s'),
            'needReserve' => true,
            'totalOrderSum' => $this->order->total_cost,
            'insuranceSum' => $this->order->total_cost,
            'insuranceSumAutoCalculation' => true,
            'paymentStatus' => $this->order->status === Order::STATUS_PAYED ? 'PAID' : 'NOT_PAID', // NOT_PAID, PAID
            'paymentMethodCode' => 'no-cod', // cod-cash, cod-card, online, no-cod
            'needCustomerPayment' => false,
            'confirmStatus' => 'NEED_CONFIRM', // NEED_CONFIRM, APPROVED, CANCELED
            'comment' => $this->order->comment ?? '',
            'promocode' => '',
            'tags' => [],
            'orderTag' => !app()->environment('production') ? 'testing' : '',
            'delivery' => [
                'code' => $this->order->delivery->code ?? null,
                'title' => $this->order->delivery->title ?? null,
                'pickupPointId' => $this->order->delivery->pickupPointId ?? null,
                'address' => [
                    'country' => $this->order->address->country ?? null,
                    'countryCode' => $this->order->address->countryCode ?? null,
                    'region' => $this->order->address->region ?? null,
                    'area' => $this->order->address->region ?? null,
                    'city' => $this->order->address->region ?? null,
                    'settlement' => $this->order->address->settlement ?? null,
                    'street' => $this->order->address->street ?? null,
                    'house' => $this->order->address->house ?? null,
                    'block' => $this->order->address->block ?? null,
                    'building' => $this->order->address->building ?? null,
                    'flat' => $this->order->address->flat ?? null,
                    'fullAddress' => $this->order->address->fullAddress ?? null,
                    'fullCity' => $this->order->address->fullCity ?? null,
                    'rawData' => $this->order->address->rawData ?? null,
                    'zip' => $this->order->address->zip ?? null,
                    'regionFias' => $this->order->address->regionFias ?? null,
                    'areaFias' => $this->order->address->areaFias ?? null,
                    'cityFias' => $this->order->address->cityFias ?? null,
                    'settlementFias' => $this->order->address->settlementFias ?? null,
                ],
                'receiver' => [
                    'name' => $this->order->name,
                    'surname' => $this->order->surname,
                    'patronymic' => '',
                    'phone' => $this->order->phone,
                    'alternativePhone' => '',
                    'email' => $this->order->email,
                ],
            ],
            'items' => [
            ],
            'warehouseName' => 'Tempoline',
            'onlinePaymentType' => 'FULL',
            'warehouseShippingOptions' => [
                'monopackingsOnly' => true,
            ],
        ];

        if (!in_array($this->order->delivery->type, OrderStoreRequest::$pvz)) {
            $payload['delivery']['type'] = $this->order->delivery->type ?? null;
        }

        $itemsCost = 0;
        $lastIndex = 0;
        foreach ($this->order->cart as $index => $item) {
            $item->calcCost();

            $top = $item->product->sizes->first(function ($value, $key) use ($item) {
                return $value->id === $item->product_color_size_id;
            });
            if(!$top->cactus_id) throw new \Exception("Top doesn't have cactus id for creation, top: " . json_encode($top));

            $bottom = $item->product->sizesBottom->first(function ($value, $key) use ($item) {
                return $value->id === $item->product_color_bottom_size_id;
            });
            if(!$bottom->cactus_id) throw new \Exception("Bottom doesn't have cactus id for creation, bottom: " . json_encode($bottom));


            $payload['items'][] = [
                'num' => ++$lastIndex,
                'variantId' => $top->cactus_id,
                'variantExtId' => $top->id,
                'name' => $item->title,
                'quantity' => $item->count,
                'price' => $item->cost / 2,
                'vatRate' => 'VAT_20',
            ];

            $payload['items'][] = [
                'num' => ++$lastIndex,
                'variantId' => $bottom->cactus_id,
                'variantExtId' => $bottom->id,
                'name' => $item->title,
                'quantity' => $item->count,
                'price' => $item->cost / 2,
                'vatRate' => 'VAT_20',
            ];

            $itemsCost += $item->total_cost;
        }

        if ($itemsCost !== $this->order->total_cost) {
            $payload['items'][] = [
                'num' => $lastIndex + 1,
                'variantId' => 'delivery',
                'name' => 'Доставка',
                'quantity' => 1,
                'price' => $this->order->total_cost - $itemsCost,
                'vatRate' => 'VAT_20',
            ];
        }

        $response = $this->initRequest()->post($this->apiUrl . '/api/lite/orders', $payload);

        if (!$response->successful() or !$response->json('success')) {
            throw new \Exception('Error when creating order in cactus. Payload: ' . json_encode($payload) . '. Response: ' . json_encode($response->json()));
        }

        \Log::info('Cactus order created: ' . json_encode($response->json()));

        $this->order->cactus_order_id = $cactusOrderId;
        $this->order->save();

        return $response->json();
    }
}
