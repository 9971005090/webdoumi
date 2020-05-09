<?php

namespace App\Listeners;

use App\Events\FireLoginSuccessful;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoginSuccessful
{
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
     * @param  LoginSuccessful  $event
     * @return void
     */
    public function handle(FireLoginSuccessful $event)
    {
        $event->user->last_login = gmdate("Y-m-d H:i:s");
        $event->user->last_login_ip = $event->request->getClientIp();
        return $event->user->save();
    }
}
