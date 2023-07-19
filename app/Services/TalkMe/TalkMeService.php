<?php


namespace App\Services\TalkMe;


use App\Services\TalkMe\Requests\GetMessagesByClientRequest;
use App\Services\TalkMe\Requests\SendMessageToOperatorRequest;
use App\Services\TalkMe\Requests\SetMessageStatusRequest;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Log;

class TalkMeService
{
    private string $apiURL = 'https://lcab.talk-me.ru/json/v1.0';
    private PendingRequest $request;

    public function __construct()
    {
        $this->initRequest();
    }

    private function initRequest()
    {
        $this->request = \Http::acceptJson()->contentType('application/json')
            ->withHeaders(['X-Token' => 'token']);
    }

    private function getResponseSetClientId(\Illuminate\Http\Client\Response $response, $client_id = null)
    {
        $response = $response->json();
        $response->client_id = $client_id;
        return $response;
    }

    /*
     * Get latest 100 messages in desc order, then invert to normal order
     */
    public function getMessagesByClient(GetMessagesByClientRequest $request)
    {
        $response = $this->request->post($this->apiURL . '/chat/message/getClientMessageList', [
            'client' => [
                'clientId' => $request->client_id,
            ],
            'orderDirection' => 'desc',
            'limit' => 100
        ]);

        if (!$response->successful()) {
            Log::error('Talk me messages fetch error' . $response->json());
        }

        return $this->getResponseSetClientId($response, $request->client_id);
    }

    public function sendMessage(SendMessageToOperatorRequest $request)
    {
        $response = $this->request->post($this->apiURL . '/chat/message/sendToOperator', [
            'client' => [
                'id' => $request->client_id,
                'name' => $request->client_info ? $request->client_info->full_name : null,
                'phone' => $request->client_info ? $request->client_info->phone : null,
                'email' => $request->client_info ? $request->client_info->email : null,
            ],
            'message' => [
                'text' => $request->text,
            ],
        ]);

        if (!$response->successful()) {
            Log::error('Talk me messages send error' . $response->json());
        }

        return $this->getResponseSetClientId($response, $request->client_id);
    }

    public function setMessageStatus(SetMessageStatusRequest $request)
    {
        $response = $this->request->post($this->apiURL . '/chat/message/setStatus', [
            'messageId' => $request->message_id,
            'status' => $request->status,
        ]);

        return $this->getResponseSetClientId($response);
    }
}
