<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Order;
use App\Services\Cactus\CactusOrdersService;
use App\Services\PayPal\PayPalService;
use App\Services\ResponseService;
use App\Services\Yookassa\YookassaService;
use App\Traits\HasAuthCheck;

class OrderController extends Controller
{
    use HasAuthCheck;

    public function store(OrderStoreRequest $request)
    {
        $cart = Cart::notPayed()->searchByCustomer($this->customer_id, $request->session_cart)->with(['product' => function ($q) {
            $q->with('colors', 'sizes', 'sizesBottom');
        }])->get();

        // If nothing found in cart
        if ($cart->count() === 0) {
            return ResponseService::error(['payment' => [trans('payment.cart_empty')]]);
        }

        // Create order and fill with data
        $order = new Order();
        $order->customer_id = $this->customer_id;
        $order->email = $request->receiver['email'];
        $order->phone = $request->receiver['phone'];
        $order->name = $request->receiver['name'];
        $order->surname = $request->receiver['surname'] ?? null;
        $order->address = $request->address;
        $order->delivery = $request->delivery;
        $order->comment = $request->comment;
        $order->total_cost = 0;
        $order->status = Order::STATUS_WAIT_FOR_PAYMENT;

        // Calc cost of items in cart based on variants and calc total order cost
        foreach ($cart as &$item) {
            $item->calcCost();
            $order->total_cost += $item->total_cost;
        }

        $order->total_cost += $request->delivery_cost;

        // Check if bonuses can be used
        if (auth('api')->check() and $request->bonus_subtract) {
            // Check bonuses available for user and amount of payment not exited
            if (auth('api')->user()->bonus < $request->bonus_subtract
                or $request->bonus_subtract > $order->total_cost * Customer::BONUSES_AVAILABLE_FOR_ORDER_PAYMENT
            ) {
                return ResponseService::error([
                    'bonus_subtract' => [trans('validation.custom.bonus_subtract.limit')],
                ]);
            }

            $order->total_cost -= $request->bonus_subtract;
            $order->bonus_used = $request->bonus_subtract;

            auth('api')->user()->bonus -= $request->bonus_subtract;
            auth('api')->user()->save();
        }

        $order->save();

        // Raw query to update cart status and relate to created order
        Cart::whereIn('id', $cart->pluck('id')->toArray())->update(['order_id' => $order->id, 'payed' => true]);

        // Generate redirect url and create order
        try {
            // Try to create order before payment creation
            try {
                $cactusOrder = new CactusOrdersService($order);
                $cactusOrder->createOrder();
            } catch (\Exception $exception) {
                throw new \Exception('Error when creating order at cactus ' . $exception);
            }

            switch ($request->payment) {
                case OrderStoreRequest::PAYMENT_YOOKASSA:
                    $yookassa = new YookassaService();
                    $redirectUrl = $yookassa->createPayment($order);
                    return ResponseService::success(['redirect_url' => $redirectUrl]);
                case OrderStoreRequest::PAYMENT_PAYPAL:
                    $paypal = new PayPalService();
                    $orderId = $paypal->createOrder($order);

                    if (!$orderId) return ResponseService::error([
                        'payment' => [trans('payment.paypal_error')]
                    ]);

                    return ResponseService::success(['order_id' => $orderId, 'isSandbox' => app()->environment('local')]);
                    break;
                default:
                    throw new \Exception('Payment type not found: ' . $request->payment);
            }
        } catch (\Exception $exception) {
            // Raw query to update cart status and relate to created order
            $order->orderFailed();

            \Log::error($exception);
            return ResponseService::error(['payment' => [trans('payment.server_error')]], $exception);
        }
    }
}
