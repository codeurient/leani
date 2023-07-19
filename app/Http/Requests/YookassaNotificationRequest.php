<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class YookassaNotificationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'object' => 'required|array',
            'object.id' => 'required|string',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
