<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\WelcomeEmail;
use App\User;

class SendWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;
    protected $member;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mem)
    {
        $this->member = $mem;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new WelcomeEmail();


//        $user = User::get_info(1);
//        Mail::to($user)->send($email);
//
//        Mail::to('9971005090@naver.com')->send($email);
        $to_email = $this->member->member['email'];
        $to_name = $this->member->member['real_name'];
        $data = array("name" => $to_name, "body" => "테스트 메일1");
        Mail::send(
            "emails.welcome",
            $data,
            function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)->subject("라라벨 테스트1");
                $message->from("seokiyo@gmail.com","테스트 메일a");
            }
        );
    }
}
