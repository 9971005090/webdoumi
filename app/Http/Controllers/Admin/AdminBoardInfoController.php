<?php
/**
 * webdoumi 기업형 홈페이지 제작 패키지에서 사용되는 관리자 > 게시판관리 controller
 *
 * @author seokiyo <9971005090@naver.com>
 * @package App\Http\Controllers\Admin
 * @version 0.1
 */

namespace App\Http\Controllers\Admin;

use App\Events\FireLoginSuccessful;
use App\Http\Controllers\CustomBaseController;
use App\Models\Admin\BoardInfo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Support\Arr;
use App\Helpers\Custom\Utils As CustomUtils;


class AdminBoardInfoController extends CustomBaseController
{
    

    /**
     * data_model
     * - controller에서 주 사용되는 모델의 클래스
     *
     * @var object
     */
    public $data_model;
    //public $methods = 1;

    /**
     * $except_parameter
     * - request 객체에서 기능 전환시 위조용 파라미터 제외에 추가로 제외를 하고픈 변수명 목록
     *
     * @var array
     */
    // public $except_parameter = array("user_name", "real_name", "email", "is_requested");
    public $except_parameter = array();



    public function __construct()
    {
        $this->auth = array(
            'user' => null,
            'admin' => array("all")
        );
        $this->admin = true;
        $this->user = false;
        $this->redirect_type = "login_form"; //login_form, error_page
        $this->data_model = BoardInfo::class;

        $this->search_form_select_options = array(
            'per_page' => array(
                10 => "10개 보기",
                20 => "20개 보기",
                30 => "30개 보기"
            ),
            'order_by' => array(
                'id||desc' => "등록일↓",
                'id||asc' => "등록일↑"
            ),
            'type' => BoardInfo::$type,
            'search_method' => array(
                'all' => "전체",
                'title' => "이름"
            )
        );
        $this->search_form_select_options['type'] = array('all' => '전체') + $this->search_form_select_options['type'];
    }


    public function index(Request $request, $query_string)
    {
        ## 검색시 검색 관련 필더의 기본값은 route에서 모두 처리한다.
        DB::enableQueryLog();

        ## search_form_select_options 멤버 변수는 부모 클래스에서 상속받는다.
        ## 기능별로 값을 달리 하기 위해선 __construct 에서 오버라이딩 한다.
        $form_select_options = $this->search_form_select_options;


        $where = array();
        if($request->filled('search_keyword') === true)
        {
            if($request->filled('search_method') === true)
            {
                if($request['search_method'] === "all")
                {
                    array_push($where, array('title', 'like', '%'.$request['search_keyword'].'%'));
                }
                else 
                {
                    array_push($where, array($request['search_method'], 'like', '%'.$request['search_keyword'].'%'));
                }
            }
        }
        if($request->filled('begin') === true && $request->filled("end") === true)
        {
            $begin = new DateTime($request['begin']);
            $begin->setTime(0, 0, 0);
            array_push($where, array("created_at", ">=", $begin->format("Y-m-d H:i:s")));

            $end = new DateTime($request['end']);
            $end->setTime(23, 59, 59);
            array_push($where, array("created_at", "<=", $end->format("Y-m-d H:i:s")));
        }
        $order_by_raw = "id desc";
        if($this->search_info['order_by_column']['use'] === true)
        {
            $temp = explode("||", $request['order_by']);
            $order_by_raw = $temp[0]." ".$temp[1];
        }

        $board_infos = BoardInfo::where($where)->orderByRaw($order_by_raw)->paginate($request['per_page']);
        $queries = DB::getQueryLog();
        //echo "<pre>";
        //print_r($queries);
        //echo "</pre>";
        //dd(date("Y-m-d 00:00:00", time()));
        //dd($parameters['end']);
        return view('/admin/default/board_info/index', compact('board_infos', 'form_select_options', 'queries', 'query_string'));
    }


    public function add_form(Request $request, $query_string)
    {
        return view('/admin/default/user/add_form', compact('query_string'));
    }


    public function edit_form(Request $request, $user, $query_string)
    {
        return view('/admin/default/user/edit_form', compact('user', 'query_string'));
    }


    public function add(Request $request, $add_form_url, $list_url)
    {
        $this->validate($request, User::$validate['join']['rule'], User::$validate['join']['message']);

        ## 일반 사용자 권한 조회
        $user_role = Role::where('name', Config::get('DB.ROLE.NAME.USER'))->first();
        if($user_role == null)
        {
            return redirect($add_form_url)->with('error', '지금은 회원 가입을 할 수 없습니다. 나중에 다시 시도해주세요.')->withInput();
        }
        $user = User::create([
            'role_name' => $user_role->name,
            'user_name' => $request['user_name'],
            'real_name' => $request['real_name'],
            'email' => $request['email'],
            'password' => Hash::make($request['pass']),
        ]);
        if($user != null)
        {
            $profile_data = array(
                'phone' => $request['phone'],
                'mobile_phone' => $request['mobile_phone'],
                'gender' => $request['gender'],
                'birthday' => $request['birthday'],
                'zipcode' => $request['zipcode'],
                'address1' => $request['address1'],
                'address2' => $request['address2']
            );
            $profile_update = $user->UserProfile()->create($profile_data);
            if($profile_update != null)
            {
                if($request['move'] == "yes")
                {
                    return redirect($list_url)->with("info", "정상적으로 등록됐습니다.");
                }
                else
                {
                    return redirect($add_form_url)->with("info", "정상적으로 등록됐습니다.");
                }
            }
            else
            {
                $user->delete();
                return redirect($add_form_url)->with("error", "등록에 실패했습니다. 관리자에게 문의하세요.");
            }
        }
        else
        {
            return redirect($add_form_url)->with("error", "등록에 실패했습니다. 관리자에게 문의하세요.");
        }
    }


    public function edit(Request $request, $user, $edit_form_url, $list_url)
    {
        if($user->email != $request['email'])
        {
            User::$validate['edit']['rule']['email'] = 'required|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|unique:users,email';
        }
        $validate_rule = array_merge(User::$validate['edit']['rule'], UploadFile::$validate['user_profile_image']['rule']);
        $validate_msg = array_merge(User::$validate['edit']['message'], UploadFile::$validate['user_profile_image']['message']);
        $this->validate($request, $validate_rule, $validate_msg);

        $data = array(
            'real_name' => $request['real_name'],
            'email' => $request['email']
        );
        $update = $user->update($data);
        if($update == true)
        {
            $upload = "ok";
            $hash_name = null;
            if($request['file'] != null)
            {
                $directory = CustomUtils::get_today("Ymd")."/profile";
                Storage::makeDirectory($directory);
                $request['file']->store($directory);

                $hash_name = str_replace(".".$request['file']->getClientOriginalExtension(), "", $request['file']->hashName());
                $file = [
                    'hash_name' => $hash_name,
                    'file_path' => $directory,
                    'file_local_name' => $request['file']->hashName(),
                    'file_original_name' => $request['file']->getClientOriginalName(),
                    'file_mime_type' => $request['file']->getMimeType(),
                    'file_extension' => $request['file']->getClientOriginalExtension(),
                    'file_size' => $request['file']->getSize(),
                    'file_size_string' => CustomUtils::get_file_size($request['file']->getSize())
                ];
                // echo Config::get('filesystems.disks.local.root');
                $upload = UploadFile::create($file);
            }

            if($upload != null)
            {
                $profile_data = array(
                    'phone' => $request['phone'],
                    'mobile_phone' => $request['mobile_phone'],
                    'gender' => $request['gender'],
                    'birthday' => CustomUtils::get_date_change_from_seoul_to_utc($request['birthday']),
                    'zipcode' => $request['zipcode'],
                    'address1' => $request['address1'],
                    'address2' => $request['address2']
                );
                if($hash_name != null)
                {
                    $profile_data['image_hash_name'] = $hash_name;
                }
                $profile_update = $user->UserProfile()->update($profile_data);
                echo $profile_update;
                if($profile_update == true)
                {
                    if($request['move'] == "yes")
                    {
                        return redirect($list_url)->with("info", "수정에 성공했습니다.");
                    }
                    else
                    {
                        return redirect($edit_form_url)->with("info", "수정에 성공했습니다.");
                    }
                }
                else
                {
                    return redirect($edit_form_url)->with("error", "수정에 실패했습니다. 관리자에게 문의하세요!!!");
                }
            }
            else
            {
                return redirect($edit_form_url)->with("error", "수정에 실패했습니다. 관리자에게 문의하세요!!");
            }
        }
        else
        {
            return redirect($edit_form_url)->with("error", "수정에 실패했습니다. 관리자에게 문의하세요!");
        }
    }


    public function delete(Request $request, $user, $list_url)
    {
        ## route에서 삭제 요청의 검증이 끝나 삭제 처리만 진행하면 된다.
        $delete = $user->delete();
        if($delete === true)
        {
            return redirect($list_url)->with("info", "삭제에 성공했습니다.");
        }
        else
        {
            return redirect($list_url)->with("error", "삭제에 실패했습니다. 관리자에게 문의하세요.");
        }
    }



    public function find_zipcode(Request $request, $address_dong)
    {
        if($address_dong !== null)
        {
            $url = "http://www.juso.go.kr/addrlink/addrLinkApi.do";
            $params = array(
                'currentPage' => 1,
                'countPerPage' => 100,
                'resultType' => 'json',
                'confmKey' => 'U01TX0FVVEgyMDE3MDkxMjEzMDU0NjEwNzM0Mjg=',
                'keyword' => $address_dong
            );
            $this->snoopy->httpmethod = "POST";
            $this->snoopy->submit($url, $params);
            $response = $this->snoopy->results;
            //$json = substr($response, 1, -1);
            die($response);
        }
        else
        {
            $results = array(
                'results' => array(
                    'common' => array(
                        'errorMessage' => "검색하고자 하는 키워드값이 없습니다!"
                    ),
                    'juso' => null
                )
            );
            die(json_encode($results));
        }
    }















}
