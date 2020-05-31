<?php
/**
 * webdoumi 기업형 홈페이지 제작 패키지에서 사용되는 공통함수 모음 클래스
 *
 * @author seokiyo <9971005090@naver.com>
 * @package App\Helpers
 * @version 0.1
 */

namespace App\Helpers\Custom;

use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;
use Validator;

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
    public static function is_exist($process_type, $model, $id, $cascade=null)
    {
        $result = array(
            'code' => 400,
            'msg' => null,
            'data_object' => null
        );
        if($id === null)
        {
            $result['msg'] = "잘못된 요청입니다.";
            return $result;
        }
        $user = $model::get_info($id, "id", $cascade);
        if($user === null)
        {
            $process_type_string = "삭제";
            if($process_type == "edit_form")
            {
                $process_type_string = "수정";
            }
            $result['msg'] = $process_type_string."하려는 ".$model::$desc['table_name']['ko']."의 정보가 존재하지 않습니다.";
            return $result;
        }
        $result['code'] = 200;
        $result['data_object'] = $user;
        return $result;
    }


    /**
     * 파라미터로 전달받은 Request 객체에 post 데이타 저장시 요청 위조 검사용 파라미터를 제거하여 반환하는 함수
     *
     * @param Request $request Request 객체
     * @param array $except_parameter 제외 파라미터
     *
     * @return array(parameter 중 csrf 관련 변수만 제거 하고 그대로 전달)
     */
    public static function except_parameter(Request $request, $except_parameter)
    {
        $result = array();
        foreach($request->all() as $key=>$value)
        {
            $local_parameter_check = true;
            for($i=0;$i<sizeof($except_parameter);$i++)
            {
                if($key == $except_parameter[$i])
                {
                    $local_parameter_check = false;
                }
            }
            if($key != "_token" && $key != "_method" && $local_parameter_check === true)
            {
                $result[$key] = $value;
            }
        }
        return $result;
    }


    /**
     * 파라미터로 전달받은 Request 객체의 파라미터 기본값을 세팅하는 함수
     *
     * @param Request $request Request 객체
     * @param array $search_info 검색에 필요한 설정 값들
     *
     * @return Request(Request 객체)
     */
    public static function request_init(Request $request, $search_info)
    {

        for($i=0;$i<sizeof($search_info['columns']);$i++)
        {
            $column = $search_info['columns'][$i];
            $request->merge([$column['name'] => $request->input($column['name'], $column['default'])]);
        }
        if($search_info['date_column']['use'] === true)
        {
            $date_column = $search_info['date_column'];
            $request->merge([$date_column['end'] => $request->input($date_column['end'], date("Y-m-d", time()))]);
            $request->merge([$date_column['begin'] => $request->input($date_column['begin'], date("Y-m-d", strtotime($date_column['term_string'])))]);
        }
        if($search_info['order_by_column']['use'] === true)
        {
            $order_by_column = $search_info['order_by_column'];
            $request->merge(['order_by' => $request->input('order_by', $order_by_column['default'])]);
        }
        if($search_info['per_page_column']['use'] === true)
        {
            $per_page_column = $search_info['per_page_column'];
            $request->merge(['per_page' => $request->input('per_page', $per_page_column['default'])]);
        }
        return $request;
    }


    /**
     * 데이타 목록에서 사용되는 가상번호 처리
     *
     * @param object $datas 데이타 목록 객체
     * @param integer $point 데이타 포인트
     *
     * @return integer
     */
    public static function virtual_number($datas, $point)
    {
        return $datas->total() - (($datas->currentPage() - 1) * $datas->perPage()) - $point;
    }


    /**
     * 바이트로 넘겨 받은 사이즈를 kb, mb, gb로 변환
     *
     * @param integer $size byte 사이즈
     *
     * @return string
     */
    public static function get_file_size($size)
    {
        $cal = [
            ['string' => "kb", 'cal' => 1024],
            ['string' => "mb", 'cal' => 1048576],
            ['string' => "gb", 'cal' => 1073741824]
        ];
        for($i=0;$i<sizeof($cal);$i++)
        {
            $temp_size = $size;
            for($j=3;$j>=1;$j--)
            {
                if($j == 3)
                {
                    $temp_size = round($temp_size / $cal[$i]['cal'], $j);
                }
                else
                {

                    $temp_size = round($temp_size, $j);
                }
            }
            if($temp_size < 1024)
            {
                return $temp_size.$cal[$i]['string'];
            }
        }
    }


    /**
     * utc 날짜를 원하는 타임존으로 변경
     *
     * @param string $date_string 날짜
     * @param string $timezone 타임존
     * @param string $view_type 응답형태
     *
     * @return string
     * @throws
     */
    public static function get_date_change($date_string, $timezone="Asia/Seoul", $view_type="Y-m-d H:i:s")
    {
        $dt = new DateTime($date_string, new DateTimeZone('UTC'));
        $dt->setTimezone(new DateTimeZone($timezone));
        return $dt->format($view_type);
    }


    /**
     * 날짜를 utc 날짜 타임존으로 변경
     *
     * @param string $date_string 날짜
     *
     * @return string
     * @throws
     */
    public static function get_date_change_from_seoul_to_utc($date_string)
    {
        $dt = new DateTime($date_string, new DateTimeZone("Asia/Seoul"));
        $dt->setTimezone(new DateTimeZone("UTC"));
        return $dt->format("Y-m-d H:i:s");
    }


    /**
     * 오늘 날짜
     *
     * @param string $format
     * @param string $timezone 타임존
     *
     * @return string
     * @throws
     */
    public static function get_today($format, $timezone="Asia/Seoul")
    {
        $dt = new DateTime(date('Y-m-d H:i:s', time()), new DateTimeZone('UTC'));
        if ($timezone != "UTC")
        {
            $dt->setTimezone(new DateTimeZone($timezone));
        }
        return $dt->format($format);
    }


    /**
     * 특정일 한글일
     *
     * @param string $date_string 날짜 문자열(2020-12-23)
     * @param string $date_full_name 응답시 '요일'을 붙일지 여부
     * @param string $timezone 타임존
     *
     * @return string
     * @throws
     */
    public static function get_weekday_string($date_string=null, $date_full_name=true, $timezone="Asia/Seoul")
    {
        $week_strings = array("월요일" , "화요일" , "수요일" , "목요일" , "금요일" ,"토요일", "일요일");       
        $date_string = $date_string == null ? date('Y-m-d', time()) : $date_string;
        $dt = new DateTime($date_string, new DateTimeZone('UTC'));
        $week_number = $dt->format('N') - 1;
        if ($date_full_name === true)
        {
            return $week_strings[$week_number];
        }
        else
        {
            return str_replace("요일", "", $week_strings[$week_number]);
        }
    }


    /**
     * 일정 시간 이후 날짜
     *
     * @param string $after_term 이후 시간(추가하려는 시간)
     * @param string $timezone 특정 시간이후 설정이 필요할 경우의 특정시간
     *
     * @return string
     * @throws
     */
    public static function get_after_date($after_term, $date_string=null)
    {
        $date_string = $date_string == null ? date('Y-m-d 00:00:00', time()) : $date_string;
        $dt = new DateTime($date_string, new DateTimeZone('UTC'));
        $dt->modify($after_term);
        return $dt->format('Y-m-d H:i:s');
    }
}