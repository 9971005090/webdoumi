<?php

namespace App\Http\Controllers\Admin;

use App\Events\FireLoginSuccessful;
use App\Http\Controllers\CustomBaseController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;


class AdminMainController extends CustomBaseController
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
        $this->auth = array(
            'user' => null,
            'admin' => array('all')
        );
        $this->admin = true;
        $this->user = false;
        $this->redirect_type = "login_form"; //login_form, error_page
    }

    public function index()
    {
        return view('admin/default/main/index');
    }
}
