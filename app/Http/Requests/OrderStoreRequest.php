<?php

namespace App\Http\Requests;

use App\Traits\HasSessionCart;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderStoreRequest extends FormRequest
{
    use HasSessionCart;

    const PAYMENT_YOOKASSA = 'yookassa';
    const PAYMENT_PAYPAL = 'paypal';

    public static array $availablePayments = [
        self::PAYMENT_YOOKASSA,
        self::PAYMENT_PAYPAL,
    ];

    public static array $pvz = ['PVZ', 'Postamat'];

    public function rules(): array
    {
        return [
            'session_cart' => 'sometimes|array',

            'payment' => ['required', Rule::in(self::$availablePayments)],

            'receiver' => 'required|array',
            'receiver.phone' => 'required|string',
            'receiver.email' => 'required|string|email',
            'receiver.name' => 'required|string',
            'receiver.surname' => 'nullable|string',

            'comment' => 'sometimes|nullable|string',
            'bonus_subtract' => 'sometimes|numeric',

            'delivery' => 'required|array',
            'delivery.code' => 'required|string',
            'delivery.type' => 'required|string',
            'delivery.title' => 'required|string',
            'delivery.pickupPointId' => 'nullable|string',

            'address' => 'required|array',
            'address.country' => 'required|string',
            'address.countryCode' => 'required|string',
            'address.region' => 'required|string',
            'address.settlement' => 'nullable|string',
            'address.street' => 'nullable|string',
            'address.house' => ['nullable', 'string', Rule::requiredIf(!in_array($this->delivery['type'], self::$pvz))],
            'address.block' => 'nullable|string',
            'address.building' => 'nullable|string',
            'address.flat' => 'nullable|string',
            'address.fullAddress' => 'nullable|string',
            'address.fullCity' => 'nullable|string',
            'address.rawData' => 'nullable|string',
            'address.zip' => 'nullable|string',
            'address.regionFias' => 'nullable|string',
            'address.areaFias' => 'nullable|string',
            'address.cityFias' => 'nullable|string',
            'address.settlementFias' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
          'address.house.required' => 'Вы должны указать дом в поле Адреса',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
