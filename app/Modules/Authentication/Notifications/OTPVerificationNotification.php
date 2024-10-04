<?php

namespace App\Modules\Authentication\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OTPVerificationNotification extends Notification
{
    use Queueable;

    public function __construct(public array $data)
    {

    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $user = $this->data['user'];
        $otpCode = $this->data['otpCode'];
        $type = $this->data['type'];

        return (new MailMessage)
                ->subject('OTP Verification!')
                ->view('emails.authentication.otp-verification', compact('user','otpCode', 'type'));
    }
}
