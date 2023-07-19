<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CactusTariffsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'region_fias' => 'nullable|string',
            'area_fias' => 'nullable|string',
            'city_fias' => 'nullable|string',
            'settlement_fias' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'weight' => 'nullable|numeric',
            'insurance_sum' => 'required|numeric',
            'cod_sum' => 'required|numeric',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
