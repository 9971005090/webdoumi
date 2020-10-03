<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Encryption\QueryException;
use Exception;


use App\UserProfile;
use App\UserVerify;
use App\Role;

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
                #'email' => 'required|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|unique:users,email',
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
                #'email.unique' => '이미 사용하고 있는 이메일입니다!',
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
                'email' => 'required|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|unique:users,email',
                //'gender' => "required|in:M,F"
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
            UserProfile::class,
            UserVerify::class
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


    /**
     * 데이타 정보 조회
     *
     * @param mixed $find_value user_id 또는 다른 값
     * @param string $column find_value 에 대응되는 칼럼 값
     * @param integer $cascade 정보 조회시 하위 릴레이션 테이블의 추가 조회 여부
     * @param string $except 하위 릴레이션 테이블 조회시 제외 테이블 정보(문자열로 처리 , 구분자 예:'UserProfile,UserVerify')
     * @return null 또는 데이타 객체
     */
    static function get_info($find_value, $column="id", $cascade=null, $except=null)
    {
        if($find_value === null)
        {
            return null;
        }
        $where = array();
        array_push($where, array($column, '=', $find_value));
        $user = User::where($where)->first();
        //$user = User::with('UserProfile')->where([['id', '=', $id]])->first(); 이렇게 하면 하위 릴레이션 테이블로 조회가 된다

        if($user != null)
        {
            if($cascade != null)
            {
                if(User::$cascade['depth'] < $cascade)
                {
                    for($i=0;$i<sizeof(User::$cascade['object']);$i++)
                    {
                        $obj = User::$cascade['object'][$i];
                        if (strpos($except, $obj::$desc['class_name']) === false)
                        {
                            $user->{$obj::$desc['class_name']} = $obj::get_info($user->id, "user_id", $cascade);
                        }
                    }
                }
            }
        }

        return $user;
    }
    
    /**
     * 회원 데이타 입력
     *
     * @param  array $request
     * @return array('code': 200/400, 'msg': 400일때 에러 메세지, 'data_object': 가입된 회원 데이타)
     */ 
    static function run_create($request)
    {
        $result = array(
            'code' => 400,
            'msg' => null,
            'data_object' => null
        );

        ## 일반 사용자 권한 조회
        $user_role = Role::where('name', Config::get('DB.ROLE.NAME.USER'))->first();
        if($user_role == null)
        {
            $result['msg'] = "지금은 회원 가입을 할 수 없습니다. 나중에 다시 시도해주세요.";
            return $result;
        }
        try 
        {
            $user = User::create([
                'role_name' => $user_role->name,
                'user_name' => $request['user_name'],
                'real_name' => $request['real_name'],
                'email' => $request['email'],
                'password' => Hash::make($request['pass']),
            ]);
        } 
        catch (Exception $e) 
        {
            // dd($e);
            // dd($e->getSql());
            // dd($e->getMessage());
            $result['msg'] = "지금은 회원 가입을 할 수 없습니다. 나중에 다시 시도해주세요.";
            return $result;
        }

        
        if($user != null)
        {
            $result['code'] = 200;
            $result['data_object'] = $user;
        }
        else
        {
            $result['msg'] = "회원 가입에 실패했습니다. 다시 시도해주세요.";
            return $result;
        }
        return $result;
    }

    static function run_delete($id)
    {
        return User::where([['id', '=', $id]])->delete();
    }


    /**
     * 이메일 token 인증완료시 email_verified_at 시간을 업데이트 
     *
     * @param  integer $id (users.id)
     * @param  string $date_string (처리시간)
     * @return integer $update 업데이트 row 수
     */ 
    static function run_update_email_verified($id, $date_string)
    {
        $where = array();
        array_push($where, array('id', '=', $id));
        $datas = User::where($where);
        $columns = array('email_verified_at' => $date_string, 'confirmed' => true);
        $update = $datas->update($columns); # 업데이트가 된 데이타 숫자 응답
        return $update;
    }
}
