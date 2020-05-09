<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    static $use_data_name = "UserProfile";
    static $table_name_ko = "회원프로필";

    protected $guarded = [];

    public function User() {
        return $this->belongsTo('App\User', 'user_id');
    }

    static $cascade = [
        'depth' => 1,
        'object' => []
    ];

    static $desc = [
        'class_name' => "UserProfile",
        'table_name' => [
            'ko' => "회원프로필"
        ]
    ];

    static function get_info($user_id, $cascade=null)
    {
        if($user_id === null)
        {
            return null;
        }
        $user_profile = UserProfile::where([['user_id', '=', $user_id]])->first();
        if($user_profile != null)
        {
            if($cascade != null)
            {
                if(UserProfile::$cascade['depth'] < $cascade)
                {
                    for($i=0;$i<sizeof(UserProfile::$cascade['object']);$i++)
                    {
                        $obj = UserProfile::$cascade['object'][$i];
                        $user_profile->{$obj::$desc['class_name']} = $obj::get_info($user_profile->id, $cascade);
                    }
                }
            }
        }
        return $user_profile;
    }
}
