<?php


namespace App\Services\TalkMe\Traits;


use App\Models\Client;
use Illuminate\Validation\Validator;

trait HasClientId
{
    public function rules()
    {
        return array_merge([
            'client_id' => 'sometimes|string'
        ], parent::rules());
    }

    public function withValidator(Validator $validator)
    {
        parent::withValidator();

        $validator->after(function (Validator $validator) {
            if ($validator->failed()) return;

            if (!$this->client_id) $this->client_id = uniqid('generated_');
            elseif(is_numeric($this->client_id)) {
                $client = Client::find($this->client_id);
                if($client) $this->client_info = $client;
            }
        });
    }
}
