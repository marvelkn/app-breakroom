<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationCode;  // Changed from $otp to match template

    public function __construct($verificationCode)  // Changed parameter name
    {
        $this->verificationCode = $verificationCode;  // Changed variable name
    }

    public function build()
    {
        return $this->view('emails.verification')
                    ->subject('Email Verification - Breakroom');
    }
}