<?php

namespace App\Http\Requests;

use App\Traits\HasSessionCart;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class CartListRequest extends FormRequest
{
    use HasSessionCart;

    public function rules(): array
    {
        return [
            'session_cart' => ['array']
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            if($validator->failed()) return;

            if(!auth('api')->check() and !isset($this->session_cart)) {
                $validator->errors()->add('session_cart', trans('validation.required', ['attribute' => 'session_cart']));
                return;
            }
        });
    }
}
