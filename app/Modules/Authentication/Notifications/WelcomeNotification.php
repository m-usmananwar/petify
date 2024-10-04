<?php

namespace App\Modules\Authentication\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements ShouldQueue
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
        $verificationCode = $this->data['verificationCode'];

        return (new MailMessage)
                ->subject('Welcome to Petify!')
                ->view('emails.authentication.welcome', compact('user','verificationCode'));
    }
}
