<?php


namespace App\Services;


use Illuminate\Support\Facades\Http;

class SMSService
{
    private string $baseURL;

    public function __construct()
    {
        $this->baseURL = 'https://' . config('sms_aero.email') . ':' . config('sms_aero.key') . '@gate.smsaero.ru/v2';
    }

    public function sendSMS($phone, $text): bool
    {
        if ($phone[0] !== '+') $phone = '+' . $phone;

        $response = HTTP::post($this->baseURL . '/sms/send', [
            'number' => $phone,
            'text' => $text,
            'sign' => 'SMS Aero',
        ]);

        if (!$response->successful()) {
            \Log::error('SMS Aero error: ' . $response->body());
            return false;
        }

        return true;
    }
}
