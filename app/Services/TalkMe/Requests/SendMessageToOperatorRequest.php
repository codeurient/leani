<?php

namespace App\Services\TalkMe\Requests;

use App\Services\TalkMe\Traits\HasClientId;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class SendMessageToOperatorRequest extends FormRequest
{
    use HasClientId;

    public function rules(): array
    {
        return [
            'text' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
