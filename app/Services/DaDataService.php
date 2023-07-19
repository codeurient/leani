<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

/**
 * Class DaDataService
 * @package App\Services
 * @author Alexander Strilec <alex.stril.by@gmail.com>
 */
class DaDataService extends Controller
{
    private string $api_token = '75f3c9724981e3711b65ea83ef5e497eb6e283df';
    private array $action_urls = [
        'organization' => 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/party',
        'address' => 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address',
    ];

    /**
     * Store time in seconds
     * @var int
     */
    private int $store_time = 60 * 60 * 24 * 7;
    private \Illuminate\Http\Client\PendingRequest $request;

    public function __construct()
    {
        $this->request = Http::withHeaders([
            'Authorization' => 'Token ' . $this->api_token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);
    }

    public function fetch(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'string', Rule::in(array_keys($this->action_urls))],
            'query' => 'nullable|string',
        ]);

        if (!$data['query']) return [];

        $dadata = \Cache::get("dadata.{$data['type']}.{$data['query']}");

        if (!$dadata) {
            $response = $this->request->post($this->action_urls[$data['type']], [
                'query' => $data['query']
            ]);

            $dadata = json_decode($response->body());

            \Cache::put("dadata.{$data['type']}.{$data['query']}", $dadata, $this->store_time);
        }

        return $dadata;
    }
}
