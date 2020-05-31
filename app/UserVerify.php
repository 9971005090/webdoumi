<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Helpers\Custom\Utils As CustomUtils;

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


    /**
     * 데이타 정보 조회
     *
     * @param mixed $find_value user_id 또는 tokend 값
     * @param string $column find_value 에 대응되는 칼럼 값
     * @param integer $cascade 정보 조회시 하위 릴레이션 테이블의 추가 조회 여부
     * @param string $except 하위 릴레이션 테이블 조회시 제외 테이블 정보(문자열로 처리 , 구분자 예:'UserProfile,UserVerify')
     * @return null 또는 데이타 객체
     */
    static function get_info($find_value, $column="user_id", $cascade=null, $except=null)
    {
        if($find_value === null)
        {
            return null;
        }

        $where = array();
        array_push($where, array($column, '=', $find_value));
        array_push($where, array('is_expire', '=', false));
        array_push($where, array('token_limited_at', '>=', CustomUtils::get_today("Y-m-d H:i:s", "UTC")));
        $user_verify = UserVerify::where($where)->first();
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

    /**
     * 회원 verifay 데이타 입력
     *
     * @param  object User $user
     * @return array('code': 200/400, 'msg': 400일때 에러 메세지, 'data_object': 가입된 회원 데이타)
     */ 
    static function run_create(User $user)
    {
        $result = array(
            'code' => 400,
            'msg' => null,
            'data_object' => null
        );

        try 
        {
            $token = Crypt::encryptString($user->id."@||@".$user->user_name."@||@".$user->email);
            $user_verify = UserVerify::create([
                'user_id' => $user->id,
                'token' => $token,
                'token_limited_at' => CustomUtils::get_after_date("+7 day")
            ]);

            $update = UserVerify::run_update_all_another($user, $token);
            if($update === false)
            {
                $result['msg'] = "지금은 회원 가입을 할 수 없습니다. 나중에 다시 시도해주세요.";
                return $result;
            }
        } 
        catch (Exception $e) 
        {
            // dd($e);
            // dd($e->getSql());
            // dd($e->getMessage());
            $result['msg'] = "지금은 회원 가입을 할 수 없습니다. 나중에 다시 시도해주세요.";
            return $result;
        }

        
        if($user_verify != null)
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


    /**
     * 회원 verifay 데이타 입력
     *
     * @param  object User $user
     * @return array('code': 200/400, 'msg': 400일때 에러 메세지, 'data_object': 가입된 회원 데이타)
     */ 
    static function run_update_all_another(User $user, $token)
    {
        $where = array();
        array_push($where, array('user_id', '=', $user->id));
        array_push($where, array('token', '!=', $token));
        array_push($where, array('is_expire', '=', false));
        $datas = UserVerify::where($where);
        $update = $datas->update(array('is_expire' => true)); # 업데이트가 된 데이타 숫자 응답
        return $update;
    }


    /**
     * 사용된 token 없데이트 
     *
     * @param  integer $id (users.id)
     * @param  string $date_string (처리시간)
     * @return integer $update 업데이트 row 수
     */ 
    static function run_update_use_token($id, $date_string)
    {
        $where = array();
        array_push($where, array('id', '=', $id));
        $columns = array('token_used_at' => $date_string, 'is_expire' => true);
        $datas = UserVerify::where($where);
        $update = $datas->update($columns); # 업데이트가 된 데이타 숫자 응답
        return $update;
    }
}
