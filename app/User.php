<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\UserProfile;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*
    protected $fillable = [
        'name', 'email', 'password', 'real_name'
    ];
    */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'confirmed' => 'boolean',
        'suspended' => 'boolean'
    ];

    public function UserProfile() {
        return $this->hasOne('App\UserProfile');
    }

    static $validate = [
        'login' => [
            'rule' => [
                'user_name' => 'required',
                //'email' => 'required|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/',
                'pass' => 'required'
            ],
            'message' => [
                //'email.required' => '이메일을 입력하세요!',
                //'email.regex' => '이메일 형식에 맞춰 입력하세요!',
                'user_name.required' => '아이디를 입력하세요!',
                'pass.required' => '비밀번호를 입력하세요!',
            ]
        ],
        'join' => [
            'rule' => [
                'user_name' => 'required|unique:users,user_name',
                'real_name' => 'required',
                'email' => 'required|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|unique:users,email',
                'pass' => 'required',
                'pass_confirm' => 'required|same:pass',
            ],
            'message' => [
                'user_name.required' => '아이디를 입력하세요!',
                'user_name.unique' => '이미 사용하고 있는 아이디입니다!',
                'real_name.required' => '이름을 입력하세요!',
                'pass.required' => '비밀번호를 입력하세요!',
                'pass_confirm.required' => '비밀번호를 입력하세요!',
                'pass_confirm.same' => '비밀번호를 정확하게 입력하세요!',
                'email.required' => '이메일을 입력하세요!',
                'email.regex' => '이메일 형식에 맞춰 입력하세요!',
                'email.unique' => '이미 사용하고 있는 이메일입니다!',
            ]
        ],
        'mine_confirm' => [
            'rule' => [
                'pass' => 'required'
            ],
            'message' => [
                'pass.required' => '비밀번호를 입력하세요!'
            ]
        ],
        'edit' => [
            'rule' => [
                'real_name' => 'required',
                //'email' => 'required|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|unique:users,email',
                'gender' => "required|in:M,F"
            ],
            'message' => [
                'real_name.required' => '이름을 입력하세요!',
                'email.required' => '이메일을 입력하세요!',
                'email.regex' => '이메일 형식에 맞춰 입력하세요!',
                'email.unique' => '이미 사용하고 있는 이메일입니다!',
            ]
        ]
    ];

    static $cascade = [
        'depth' => 0,
        'object' => [
            UserProfile::class
        ]
    ];

    static $desc = [
        'class_name' => "User",
        'table_name' => [
            'ko' => "회원"
        ]
    ];

    static function get_validate()
    {
        return self::$validate;
    }

    static function is_mine($id)
    {
        $user = User::where('id', $id)->first();
        if($user === null)
        {
            return false;
        }
        if($user->id == Auth::user()->id)
        {
            return true;
        }
        return false;
    }

    static function get_info($id, $cascade=null)
    {
        if($id === null)
        {
            return null;
        }
        $user = User::where([['id', '=', $id]])->first();
        //$user = User::with('UserProfile')->where([['id', '=', $id]])->first();


        if($user != null)
        {
            if($cascade != null)
            {
                if(User::$cascade['depth'] < $cascade)
                {
                    for($i=0;$i<sizeof(User::$cascade['object']);$i++)
                    {
                        $obj = User::$cascade['object'][$i];
                        $user->{$obj::$desc['class_name']} = $obj::get_info($user->id, $cascade);
                    }
                }

            }
        }

        return $user;
    }

    static function run_delete($id)
    {
        return User::where([['id', '=', $id]])->delete();
    }
}
