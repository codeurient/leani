<?php

namespace App\Services\TalkMe\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SetMessageStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'message_id' => 'required|numeric',
            'status' => ['required', Rule::in(['delivered', 'readed'])],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
