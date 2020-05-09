<?php

namespace App\Http\Controllers\Admin;

use App\Events\FireLoginSuccessful;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;


class AdminLoginController extends Controller
{

    /**
     * Login username to be used by the controller.
     *
     * @var string
     */
    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function index()
    {
        return view('admin/default/login/login_form');
    }

    public function login(Request $request)
    {
        $this->validate($request, User::$validate['login']['rule'], User::$validate['login']['message']);

        if (Auth::attempt(['user_name' => $request->user_name, 'password' => $request->pass]))
        {
            $result = event(new FireLoginSuccessful(Auth::user(), $request));
            if(is_array($result) === true)
            {
                if($result[0] === true)
                {
                    if($request->session()->has("redirect_url") === true)
                    {
                        return redirect($request->session()->pull("redirect_url"));
                    }
                    return redirect('/admin');
                }
                else
                {
                    Auth::logout();
                    return redirect('/admin/login')->with('error', '잘못된 아이디 또는 패스워드입니다. 다시 입력해주세요!');
                }
            }
            else
            {
                Auth::logout();
                return redirect('//admin/login')->with('error', '잘못된 아이디 또는 패스워드입니다. 다시 입력해주세요!');
            }
        }
        return redirect('/admin/login')->with('error', '잘못된 아이디 또는 패스워드입니다. 다시 입력해주세요!');
    }
}
