<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ContactSendMail extends Mailable
{
    public $subject = 'Новое сообщение с формы "Напишите нам".';

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
        return $this->view('emails.contact-send');
    }
}
