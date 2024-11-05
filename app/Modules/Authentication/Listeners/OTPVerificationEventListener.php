<?php

namespace App\Modules\Authentication\Listeners;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class OTPVerificationEventListener implements ShouldQueue
{
    use Queueable;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $data['user'] = $event->user;
        $data['otpCode'] = $event->otpCode;
        $data['type'] = $event->type;

        Notification::send($event->user, new \App\Modules\Authentication\Notifications\OTPVerificationNotification($data));
    }
}
