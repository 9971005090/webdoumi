<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends CustomBaseController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }


    public function index(Request $request)
    {
        $service_type = "user";
        if($request->session()->has("service_type") === true)
        {
            $service_type = $request->session()->get("service_type");
        }
        return view('error/landing', ['service_type' => $service_type]);
    }
}
