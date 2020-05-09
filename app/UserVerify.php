<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserVerify extends Model
{
    static $use_data_name = "UserVerify";
    static $table_name_ko = "회원인증";

    protected $guarded = [];

    public function User() {
        return $this->belongsTo('App\User', 'user_id');
    }

    static $cascade = [
        'depth' => 1,
        'object' => []
    ];

    static $desc = [
        'class_name' => "UserVerify",
        'table_name' => [
            'ko' => "회원인증"
        ]
    ];

    static function get_info($user_id, $cascade=null)
    {
        if($user_id === null)
        {
            return null;
        }
        $user_verify = UserVerify::where([['user_id', '=', $user_id]])->first();
        if($user_verify != null)
        {
            if($cascade != null)
            {
                if(UserVerify::$cascade['depth'] < $cascade)
                {
                    for($i=0;$i<sizeof(UserVerify::$cascade['object']);$i++)
                    {
                        $obj = UserVerify::$cascade['object'][$i];
                        $user_verify->{$obj::$desc['class_name']} = $obj::get_info($user_verify->id, $cascade);
                    }
                }
            }
        }
        return $user_verify;
    }
}
