<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayPalWebhookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|string',
            'event_type' => 'required|string',
            'resource' => 'required|array',
            'resource.purchase_units' => 'required|array',
            'resource.purchase_units.*.reference_id' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
