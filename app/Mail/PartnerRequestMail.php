<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class PartnerRequestMail extends Mailable
{
    public $subject = 'Новая заявка на партнёрство.';

    public string $name;
    public string $phone;
    public string $email;
    public string $clientMessage;

    public function __construct(
        string $name,
        string $phone,
        string $email,
        string $clientMessage)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->clientMessage = $clientMessage;
    }

    public function build()
    {
        return $this->view('emails.partner-request');
    }
}
