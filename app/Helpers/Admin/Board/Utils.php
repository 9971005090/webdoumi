<?php
/**
 * webdoumi 기업형 홈페이지 제작 패키지에서 사용되는 공통함수 모음 클래스
 *
 * @author seokiyo <9971005090@naver.com>
 * @package App\Helpers
 * @version 0.1
 */

namespace App\Helpers\Admin\Board;

use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;
use Validator;
use App\Models\Admin\BoardInfo;

class Utils
{
    /**
     * 파라미터로 전달받은 모델, prkey 로 데이타가 있는지 확인하는 함수
     *
     * @param string $process_type "delete/edit"
     * @param object $model user_model
     * @param integer $id users.id
     * @param integer $cascade (모델의 하위 모델 조회시 단계 표시)
     *
     * @return array('code': 200/400, 'msg':400일때 에러 메세지)
     */
    public static function get_type($check)
    {
        foreach(BoardInfo::$type as $key=>$value)
        {
            if($key == $check)
            {
                return $value;
            }
        }
        return "";
    }
}