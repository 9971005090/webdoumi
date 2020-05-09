<?php

namespace App\Events;
use Illuminate\Queue\SerializesModels;
class UserEventLoginSuccessfulForSendEmail
{
    use SerializesModels;

    public $user_id = null;
    public $request = null;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    /*
    public function __construct($request, $user_id)
    {
        $this->user_id = $user_id;
        $this->request = $request;
    }
    */
    public function __construct()
    {
    }
}
