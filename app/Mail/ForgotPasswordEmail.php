<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function build()
    {
        return $this->view('emails.forgot_password')
            ->with([
                'token' => $this->token,
                'email' => $this->email
            ])
            ->subject('Recuperação de Senha - Solicitação');
    }
}
