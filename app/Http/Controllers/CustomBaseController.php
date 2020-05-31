<?php
/**
* webdoumi 기업형 홈페이지 제작 패키지에서 사용되는 실질적인 최상위 controller
* - 검색관련 기본값 정의
* - 인증 관련 검사 처리
*
* @author seokiyo <9971005090@naver.com>
* @package App\Http\Controllers
* @version 0.1
*/

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CustomBaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
    * auth
    * - 사용자, 관리자에서 인증이 필요한 기능 정보 list
    *     - user, admin 에 배열로 인증이 필요한 method 명을 넘긴다.
    *
    * @var array
    */
    protected $auth;

    /**
     * admin
     * - 관리자 기능 사용 여부
     *
     * @var boolean
     */
    protected $admin;

    /**
     * user
     * - 사용자 기능 사용 여부
     *
     * @var boolean
     */
    protected $user;

    /**
     * redirect_type
     * -인증 확인 후 이동 종류(로그인페이지, 에러페이지)
     *     -login_form, error_page
     *
     * @var string
     */
    protected $redirect_type;

    /**
     * CustomUtils
     * -webdoumi 패키지에서 사용하는 공통 함수 클래스
     *
     * @var string
     */
    protected $CustomUtils;

    /**
     * search_info
     * - 목록에서 사용하는 검색 기본 값을 정의
     *
     * @var array
     */
    public $search_info = array(
        'columns' => array(
            array('name' => "search_keyword", 'default' => null),
            array('name' => "per_page", 'default'  => 10)
        ),
        'date_column' => array(
            'use' => true,
            'begin' => "begin",
            'end' => "end",
            'term_string' => "-5 months"
        ),
        'order_by_column' => array(
            'use' => true,
            'default' => "id||desc"
        ),
        'per_page_column' => array(
            'use' => true,
            'default' => 10
        )
    );
    public $search_form_select_options = array(
        'per_page' => array(
            10 => "10개 보기",
            20 => "20개 보기",
            30 => "30개 보기",
            40 => "40개 보기",
            50 => "50개 보기",
            60 => "60개 보기",
            70 => "70개 보기",
            80 => "80개 보기",
            90 => "90개 보기",
            100 => "100개 보기"
        ),
        'order_by' => array(
            'id||desc' => "가입일↓",
            'id||asc' => "가입일↑"
        )
    );

    public $base_url = null;


    /**
     * laravel에서 제공되는 magic method
     * - 현재는 인증 관련 확인만 구현되어 있음.
     * - 향후 공통적으로 처리 할 내용은 여기에 추가함
     *
     * @param string $method 하위 controller 에서 사용 할 method 명
     * @param array $parameters 하위 controller 에서 사용 할 method 의 파라미터
     *        - 배열이지만 최종 method 에서는 순차적으로 파라미터로 전달한다.
     *
     * @return void
     * @throws
     */
    public function callAction($method, $parameters)
    {
        $this->base_url = App::make('url')->to('/');
        $this->CustomUtils = app()->make('\App\Helpers\Custom\Utils');
        if($this->admin === true)
        {
            if($method != "login_form" && $method != "login")
            {
                if(Auth::check() === false)
                {
                    if($this->redirect_type == "login_form")
                    {
                        #$parameters['request']->session()->put('redirect_url', url()->current());
                        session()->put('redirect_url', url()->current());
                        return redirect($this->base_url.'/admin/user/login_form')->with('error', '관리자만 접속이 가능합니다');
                    }
                }
                if(Auth::user()->role_name != "admin")
                {
                    return redirect($this->base_url.'/admin/user/login_form')->with('error', '관리자만 접속이 가능합니다');
                }
                if(Auth::user()->confirmed !== true)
                {
                    return redirect($this->base_url.'/admin/user/login_form')->with('error', '관리자만 접속이 가능합니다');
                }
            }
        }
        else if($this->user === true)
        {
            if (in_array($method, $this->auth['user']))
            {
                if(Auth::check() === false)
                {
                    if($this->redirect_type == "login_form")
                    {
                        #$parameters['request']->session()->put('redirect_url', url()->current());
                        session()->put('redirect_url', url()->current());
                        return redirect($this->base_url.'/user/login_form')->with('error', '로그인이 필요한 요청입니다')->withInput();
                    }
                }
                if(Auth::user()->confirmed !== true)
                {
                    return redirect($this->base_url.'/user/login_form')->with('error', '가입 승인 처리가 되지 않았습니다. 관리자에게 문의하세요!');
                }
            }
        }
        return parent::callAction($method, $parameters);
    }
}
