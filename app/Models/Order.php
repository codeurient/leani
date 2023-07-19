<?php

namespace App\Models;

use App\Services\Cactus\CactusOrdersService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Mail;

class Order extends Model
{
    const STATUS_WAIT_FOR_PAYMENT = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_PAYED = 10;
    const STATUS_FAILED = -1;

    protected $casts = [
        'delivery' => 'object',
        'address' => 'object',

        'total_cost' => 'float',
    ];

    public static array $statusMsg = [
        self::STATUS_WAIT_FOR_PAYMENT => 'В ожидании оплаты',
        self::STATUS_PROCESSING => 'Обработка оплаты',
        self::STATUS_PAYED => 'Оплачен',
        self::STATUS_FAILED => 'Неуспешная оплата',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function processOrder()
    {
        // Add bonuses from order to user
        if ($this->customer_id) {
            $this->customer->bonus += ceil($this->total_cost * Customer::BONUSES_FROM_ORDER);
            $this->customer->save();
        }

        // Raw query to update cart status and relate to created order
        Cart::whereIn('id', $this->cart()->pluck('id')->toArray())->update(['payed' => true]);

        try {
            // Send mail to customer
            Mail::to($this->email)->queue(new \App\Mail\OrderCreatedMail($this));
        } catch (\Exception $exception) {
            \Log::error('Error when sending mail ' . $exception);
        }

        try {
            $cactusOrder = new CactusOrdersService($this);
            $cactusOrder->createOrder();
        } catch (\Exception $exception) {
            \Log::error('Error when creating order at cactus ' . $exception);
        }
    }

    public function cart(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function orderFailed()
    {
        // Return used bonuses
        if($this->bonus_used and $this->customer) {
            $this->customer->bonus += $this->bonus_used;
            $this->customer->save();
        }

        // Remove cart and delete order
        $this->cart()->update(['order_id' => null, 'payed' => false]);
        $this->delete();
    }
}
