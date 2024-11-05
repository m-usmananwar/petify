<?php

namespace App\Modules\Authentication\Listeners;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class WelcomeEventListener implements ShouldQueue
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
        $data['verificationCode'] = $event->verificationCode;

        Notification::send($event->user, new \App\Modules\Authentication\Notifications\WelcomeNotification($data));
    }
}
