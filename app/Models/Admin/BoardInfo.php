<?php

namespace App\Models\Admin;

use Exception;
use Illuminate\Database\Eloquent\Model;

class BoardInfo extends Model
{
    static $use_data_name = "BoardInfo";
    static $table_name_ko = "게시판기본정보";

    protected $guarded = [];

    protected $casts = [
        'last_article_date' => 'datetime',
        'comment_use' => 'boolean',
        'reply_use' => 'boolean',
        'file_use' => 'boolean',
        'secret_use' => 'boolean',
        'notice_use' => 'boolean',
        'search_use' => 'boolean',
        'notify_email_use' => 'boolean',
        'notify_sms_use' => 'boolean'
    ];

    static $cascade = [
        'depth' => 0,
        'object' => []
    ];

    static $desc = [
        'class_name' => "BoardInfo",
        'table_name' => [
            'ko' => "게시판기본정보"
        ]
    ];

    static $type = array(
        'A' => "일반",
        'B' => "이미지",
        'K' => "배너",
        'E' => "QnA",
        'H' => "FAQ",
        'I' => "1:1"
    );

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
        $board_info = BoardInfo::where($where)->first();

        return $board_info;
    }
}
