<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => 'required|string|exists:customers,phone',
            'code' => 'sometimes|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
