<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\UserVerify;
use Illuminate\Support\Facades\Hash;
use App\Events\FireLoginSuccessful;
use Illuminate\Support\Facades\Config;

use App\Events\UserEventLoginSuccessfulForSendEmail;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendEmailJob;

use Carbon\Carbon;
use App\Jobs\SendWelcomeEmail;
use App\Jobs\SendVerifyEmail;
use Illuminate\Support\Facades\Route;
//use Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use App\Helpers\Custom\Utils As CustomUtils;

class UserController extends CustomBaseController
{

    /**
     * Login username to be used by the controller.
     *
     * @var string
     */
    protected $username;
    public $methods = 1;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->auth = array(
            'user' => array('edit_form'),
            'admin' => "all"
        );
        $this->admin = false;
        $this->user = true;
        $this->redirect_type = "login_form"; //login_form, error_page
        $this->username = $this->findUsername();
        ## 자신만 접속이 가능한 페이지



        $route = Route::current();

        //$name = Route::currentRouteName();

        //$action = Route::currentRouteAction();
        //dd($route->parameters['function_name']);

        //echo Route::getActionName();

    }


    public function login_form()
    {
        /*
        $to_name = "윤석영";
        $to_email = "9971005090@naver.com";
        $data = array("name"=>"seokiyo", "body" => "테스트 메일");
        Mail::send(
            "emails.mail",
            $data,
            function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)->subject("라라벨 테스트1");
                $message->from("seokiyo@gmail.com","테스트 메일");
            }
        );
        */
        /*
        $a = new SendEmailJob();
        dispatch();
        */
        return view('user.login');
    }

    /* @POST

     */
    public function login(Request $request)
    {
        /*
        // you clear specific caches at this stage
        //$arr_caches = ['categories', 'products'];
        $aaa = "1234";
        $arr_caches = array(
            'aaa' => "1234",
            'bbb' => "asdf"
        );
        // want to raise ClearCache event
        event(new ClearCache($arr_caches));
        */
        #$user = new User;
        //dd(User::get_validate());
        //$user = User::find(1);
        //dd($user);
        $validate_add = "";
        /*
        if($this->username == "email")
        {
            $validate_add = "|email";
        }
        */
        /*
        $this->validate($request, [

            $this->username => 'required'.$validate_add,

            'password' => 'required',

        ]);

        $messages = [
            'email.required' => '이메일을 입력하세요!',
            'email.regex' => '이메일 형식에 맞춰 입력하세요!',
            'email.unique' => '이미 사용하고 있는 이메일입니다!',
        ];
        $this->validate($request, [

            'email' => 'required|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|unique:users,email',
            'password' => 'required',

        ], $messages);
        */
        $this->validate($request, User::$validate['login']['rule'], User::$validate['login']['message']);


        /*
        $user_data = array(
            'email' => $request->email,
            'password' => $request->password
        );

        if(!Auth::attempt([$user_data])){
            return redirect('/user/login_form')->with('error', 'Invalid Email address or Password');
        }

        if ( Auth::check() ) {
            dd("23456");
            $data = $request->session()->all();
            dd($data);
            event(new UserEventLoginSuccessful(Auth::user()->id));
            return redirect('/dashboard');
        }
        */

        if (Auth::attempt([

            'user_name' => $request->user_name,
            'password' => $request->pass])

        ){
            //$data = $request->session()->all();
            //event(new UserEventLoginSuccessfulForSendEmail());

            $emailJob = new SendWelcomeEmail(Auth::user());
            SendWelcomeEmail::dispatch($emailJob);
            //$result = event(new UserEventLoginSuccessful($request, Auth::user()->id));
            $result = event(new FireLoginSuccessful(Auth::user(), $request));
            if(is_array($result) === true)
            {
                if($result[0] === true)
                {
                    if($request->session()->has("redirect_url") === true)
                    {
                        return redirect($request->session()->pull("redirect_url"));
                    }
                    return redirect('/home');
                }
                else
                {
                    Auth::logout();
                    return redirect('/user/login_form')->with('error', '잘못된 아이디 또는 패스워드입니다. 다시 입력해주세요!');
                }
            }
            else
            {
                Auth::logout();
                return redirect('/user/login_form')->with('error', '잘못된 아이디 또는 패스워드입니다. 다시 입력해주세요!');
            }
        }
        return redirect('/user/login_form')->with('error', '잘못된 아이디 또는 패스워드입니다. 다시 입력해주세요!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function join_form()
    {
        return view('user/join');
    }

    public function join_end()
    {
        if(session()->has('user_id') === false)
        {
            return redirect('/error')->with('error', '잘못된 접근입니다!');
        }
        return view('user/join_end');
    }

    public function join(Request $request)
    {
        $this->validate($request, User::$validate['join']['rule'], User::$validate['join']['message']);

        /*
        $validator = Validator::make($request->all(), User::$validate['join']['rule'], User::$validate['join']['message']);
        if ($validator->fails()) {
            return redirect('user/join_form')
                ->withErrors($validator)
                ->withInput();
        }
        */
        $user_object = new User;
        $user = $user_object->run_create($request);

        ## 일반 사용자 권한 조회
        if($user['code'] == 200)
        {
            $user_verify_object = new UserVerify;
            $user_verify_object->run_create($user['data_object']);
            $pass_user = $user_object->get_info($user['data_object']->id, "id", 1, "UserProfile");
            $pass_parameter = array('user' => $pass_user);
            $email_verify_Job = new SendVerifyEmail($pass_parameter);
            SendVerifyEmail::dispatch($email_verify_Job);

            return redirect('/user/join_end')->with('user_id', $user['data_object']->id);
        }
        else
        {
            return redirect('/user/join_form')->with('error', $user['msg'])->withInput();
        }
    }


    /**
     * 이메일 인증 처리 액션
     *
     * @param string $token 이메일 인증 토큰 값 (구성은 users.id @||@ users.user_name)
     * @param integer $cascade 정보 조회시 하위 릴레이션 테이블의 추가 조회 여부
     * @param string $except 하위 릴레이션 테이블 조회시 제외 테이블 정보(문자열로 처리 , 구분자 예:'UserProfile,UserVerify')
     * @return null 또는 데이타 객체
     */
    public function email_verify_confirm(Request $request, $token)
    {
        $result = array(
            'code' => 200,
            'msg' => null
        );
        if($token == null)
        {
            $result['code'] = 400;
            $result= '잘못된 접근입니다!';
        }
        
        # 토큰이 유효한 값인지 조회(암호화를 풀어서 변수가 3개가 되는지 확인 후 디비에서 확인)
        $decrypted = Crypt::decryptString($token);
        $temp = explode("@||@", $decrypted);
        if ($result['code'] != 400 && count($temp) != 3)
        {
            $result['code'] = 400;
            $result['msg'] = '유효한 토큰값이 아닙니다!';
        }
        $user_verify_object = new UserVerify;
        $verify = $user_verify_object->get_info($token, "token");
        if ($result['code'] != 400 && $verify == null)
        {
            $result['code'] = 400;
            $result['msg'] = '유효한 토큰값이 아닙니다!!';
        }
        
        # 디비에 입력된 참조값과 토큰에서 확인된 참조값을 확인하여 맞는지 확인, 이미 사용한것인지 확인, 만료 시간이 지났는지 확인
        $today = CustomUtils::get_today("Y-m-d H:i:s", "UTC");
        if ($result['code'] != 400 && $verify['user_id'] != $temp[0])
        {
            $result['code'] = 400;
            $result['msg'] = '유효한 토큰값이 아닙니다!!!';
        }
        if ($result['code'] != 400 && $verify['is_expire'] === true)
        {
            $result['code'] = 400;
            $result['msg'] = '유효한 토큰값이 아닙니다!!!!';
        }
        if ($result['code'] != 400 && $verify['token_limited_at'] < $today)
        {
            $result['code'] = 400;
            $result['msg'] = '유효한 토큰값이 아닙니다!!!!!';
        }
        
        # users.email_verified_at, user_verifies.token_used_at, user_verifiles.is_expire 업데이트
        $user_object = new User;
        $update = $user_object->run_update_email_verified($verify['user_id'], $today);
        if ($result['code'] != 400 && $update <= 0)
        {
            $result['code'] = 400;
            $result['msg'] = '인증에 실패했습니다. 잠시후에 다시 시도해주세요!';
        }
        $update = $user_verify_object->run_update_use_token($verify['id'], $today);
        if ($result['code'] != 400 && $update <= 0)
        {
            $result['code'] = 400;
            $result['msg'] = '인증에 실패했습니다. 잠시후에 다시 시도해주세요!';
        }
        
        return view('user/email_verify_confirm', array('result' => $result));
    }


    ## 자신인지 확인하는 함수
    public function _is_my_use($check_id)
    {
        $result = array(
            'code' => 200,
            'message' => null,
            'url' => null
        );

        if(Auth::check() === false)
        {
            $result['code'] = 400;
            $result['message'] = '로그인이 필요한 요청입니다.';
            $result['url'] = '/user/login_form';
            //redirect('/user/login_form')->with('error', '로그인이 필요한 요청입니다.');
            return $result;
        }
        $user = User::where('id', $check_id)->first();
        if($user == null)
        {
            $result['code'] = 400;
            $result['message'] = '회원 정보를 찾을 수 없습니다.';
            $result['url'] = '/home';
            //redirect('/home')->with('error', '회원 정보를 찾을 수 없습니다.');
            return $result;
        }
        if($user->id != Auth::user()->id)
        {
            $result['code'] = 400;
            $result['message'] = '잘못된 요청입니다.';
            $result['url'] = '/home';
            //redirect('/home')->with('error', '잘못된 요청입니다.');
            return $result;
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->_is_my_use($id);
        if($result['code'] == 400)
        {
            return redirect($result['url'])->with('error', $result['message']);
        }

        if (Hash::check('111111', Auth::user()->password)) {
            dd("true");
        }
        dd("show");
    }


    public function edit_form(Request $request, $id)
    {
        /*
        if(session()->has('info') === false && session('errors') == null)
        {
            ## 내 정보를 요청하는게 맞는지
            if(User::is_mine($id) === false && session()->has('error') === false && session()->has('errors') === false)
            {
                $request->session()->put('service_type', "user");
                return redirect('/error')->with('error', '자신의 정보만 요청 가능합니다');
            }

            ## 비밀번혼 확인창을 통해서 접근을 하였는지...
            if($request->exists('pass') === true)
            {
                $this->validate($request, User::$validate['mine_confirm']['rule'], User::$validate['mine_confirm']['message']);
                if (Hash::check($request->input('pass'), Auth::user()->password) === false)
                {
                    #return redirect('/user/edit_form/'.Auth::user()->id)->with('error', '비밀번호가 정확하지 않습니다!')->withInput();
                    return redirect('/user/edit_form/'.Auth::user()->id)->withErrors(['pass'=> '비밀번호가 정확하지 않습니다!']);
                }
            }
            else
            {
                return view('user/edit_pass_confirm', ['user' => Auth::user()]);
            }
        }
        */

        if(session()->has('edit_run') === true)
        {
            session()->pull('edit_run');
            return view('user/edit_form', ['user' => Auth::user()]);
        }

        if(session()->has('info') === false && session()->has('errors') === false)
        {
            ## 내 정보를 요청하는게 맞는지
            if(User::is_mine($id) === false && $request->exists('pass') === false)
            {
                $request->session()->put('service_type', "user");
                return redirect('/error')->with('error', '자신의 정보만 요청 가능합니다');
            }

            ## 비밀번혼 확인창을 통해서 접근을 하였는지...
            if($request->exists('pass') === true)
            {
                $this->validate($request, User::$validate['mine_confirm']['rule'], User::$validate['mine_confirm']['message']);
                if (Hash::check($request->input('pass'), Auth::user()->password) === false)
                {
                    #return redirect('/user/edit_form/'.Auth::user()->id)->with('error', '비밀번호가 정확하지 않습니다!')->withInput();
                    return redirect('/user/edit_form/'.Auth::user()->id)->withErrors(['pass'=> '비밀번호가 정확하지 않습니다!']);
                }
            }
            else
            {
                return view('user/edit_pass_confirm', ['user' => Auth::user()]);
            }
        }
        if(session()->has('errors') === true)
        {
            return view('user/edit_pass_confirm', ['user' => Auth::user()]);
        }
        return view('user/edit_form', ['user' => Auth::user()]);
    }

    public function edit(Request $request, $id)
    {
        session()->put('edit_run', true);
        $rule = User::$validate['edit']['rule'];
        $message = User::$validate['edit']['message'];
        if($request->exists('email') === true)
        {
            if(blank($request->exists('email')) === false)
            {
                if(Auth::user()->email == $request['email'])
                {
                    $rule = Arr::except($rule, ['email']);
                }
            }
        }
        $this->validate($request, $rule, $message);
        $user = User::where('id', $id)->first();
        $update = $user->update(["real_name" => $request['real_name'], "email" => $request['email']]);
        if($update === true)
        {
            return redirect('/user/edit_form/'.Auth::user()->id)->with('info', '정상적으로 수정됐습니다.')->withInput();
        }
        else
        {
            return redirect('/user/edit_form/'.Auth::user()->id)->with('error', '수정하지 못했습니다. 다시 시도해주세요.')->withInput();
        }

    }


    public function leave(Request $request)
    {
        $result = $this->_is_my_use(Auth::user()->id);
        if($result['code'] == 400)
        {
            return redirect($result['url'])->with('error', $result['message']);
        }
        if(session()->has('info') === false && session('errors') == null)
        {
            ## 비밀번혼 확인창을 통해서 접근을 하였는지...
            if($request->exists('pass') === true)
            {
                $this->validate($request, User::$validate['mine_confirm']['rule'], User::$validate['mine_confirm']['message']);
                if (Hash::check($request->input('pass'), Auth::user()->password) === false)
                {
                    //$this->validate->add('pass', '비밀번호가 정확하지 않습니다!');
                    //->withErrors(['error_input'=> 'error text');
                    //return redirect('/user/leave')->with('error', '비밀번호가 정확하지 않습니다!')->withInput();
                    return redirect('/user/leave')->withErrors(['pass'=> '비밀번호가 정확하지 않습니다!']);
                }
            }
            else
            {
                return view('user/leave_pass_confirm', ['user' => Auth::user()]);
            }
        }
        if(session('errors') != null)
        {
            return view('user/leave_pass_confirm', ['user' => Auth::user()]);
        }
        $user = User::where('id', Auth::user()->id)->first();
        Auth::logout();
        $delete = $user->delete();
        if($delete === true)
        {
            return redirect('/home')->with('info', '정상적으로 탈퇴됐습니다.')->withInput();
        }
        else
        {
            return redirect('/user/leave')->with('error', '탈퇴에 실패패했습니다.')->withInput();
        }
    }





    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function findUsername()
    {
        /*
        $login = request()->input('email');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';

        request()->merge([$fieldType => $login]);

        return $fieldType;
        */
        return "user_name";
    }

    public function username()
    {
        return $this->username;
    }
}
