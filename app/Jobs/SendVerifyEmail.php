<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\User;
use App\Helpers\Custom\Utils As CustomUtils;

class SendVerifyEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;
    protected $parameter;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($param)
    {
        $this->parameter = $param;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $to_email = $this->parameter->parameter['user']['email'];
        $to_name = $this->parameter->parameter['user']['real_name'];
        $data = array(
            "member" => $this->parameter->parameter['user'], 
            "weekday_string" => CustomUtils::get_weekday_string()
        );
        Mail::send(
            "emails.verify",
            $data,
            function($message) use ($to_name, $to_email) {
                $subject = "[웹도우미] ".$to_name."님 이메일 인증을 하셔야 가입이 완료됩니다.";
                $message->to($to_email, $to_name)->subject($subject);
                $message->from("admin@webdoumi.com","관리자");
            }
        );
    }
}
