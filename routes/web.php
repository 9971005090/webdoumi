<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




/*
|--------------------------------------------------------------------------
| 규정된 라우트
|--------------------------------------------------------------------------
*/


Route::get('/admin/{controller_name?}/{function_name?}/{query?}/{query2?}',
    function ($controller_name = "user", $function_name = "index", $query = null, $query2 = null) {
        // var_dump($controller_name, $function_name, $query, $query2);
        $request = request();
        $app = app();
        $controller = $app->make('\App\Http\Controllers\Admin\\'.'Admin'.ucfirst($controller_name).'Controller');
        $request = CustomUtils::request_init($request, $controller->search_info);
        $query_string = Arr::query(CustomUtils::except_parameter($request, $controller->except_parameter));

        $result = null;
        if($function_name == "edit_form")
        {
            $url = url("admin/".$controller_name."/index?".Arr::query(CustomUtils::except_parameter($request, $controller->except_parameter)));
            $result = CustomUtils::is_exist("edit_form", $controller->data_model, $query, 99);
            if($result['code'] == 400)
            {
                return redirect($url)->with('error', $result['msg']);
            }
        }

        $parameters = array();
        $parameters['request'] = $request;
        if($result != null)
        {
            $parameters['data_object'] = $result['data_object'];
        }
        else
        {
            if($query != null)
            {
                $parameters['param1'] = $query;
            }
            if($query2 != null)
            {
                $parameters['param2'] = $query2;
            }
        }
        $parameters['query_string'] = $query_string;
        return $controller->callAction($function_name, $parameters);
    });


Route::post('/admin/{controller_name}/{function_name}/{query?}/{query2?}',
    function ($controller_name, $function_name, $query = null, $query2 = null) {
        //var_dump($controller_name, $function_name, $query, $query2);
        $request = request();
        $app = app();
        $controller = $app->make('\App\Http\Controllers\Admin\\'.'Admin'.ucfirst($controller_name).'Controller');
        $url = url("admin/".$controller_name."/add_form");
        $list_url = url("admin/".$controller_name."/index");
        $parameters = array();
        $parameters['request'] = $request;
        $parameters['url'] = $url;
        $parameters['list_url'] = $list_url;
        return $controller->callAction($function_name, $parameters);
    });
Route::put('/admin/{controller_name}/{function_name}/{query?}/{query2?}',
    function ($controller_name, $function_name, $query = null, $query2 = null) {
        //var_dump($controller_name, $function_name, $query, $query2);
        $request = request();
        $app = app();
        $controller = $app->make('\App\Http\Controllers\Admin\\'.'Admin'.ucfirst($controller_name).'Controller');

        $result = null;
        $url = url("admin/".$controller_name."/edit_form/".$query."?".Arr::query(CustomUtils::except_parameter($request, $controller->except_parameter)));
        $list_url = url("admin/".$controller_name."/index?".Arr::query(CustomUtils::except_parameter($request, $controller->except_parameter)));
        $result = CustomUtils::is_exist("edit_form", $controller->data_model, $query, 99);
        if($result['code'] == 400)
        {
            return redirect($url)->with('error', $result['msg']);
        }
        $parameters = array();
        $parameters['request'] = $request;
        if($result != null)
        {
            $parameters['data_object'] = $result['data_object'];
        }
        $parameters['url'] = $url;
        $parameters['list_url'] = $list_url;
        return $controller->callAction($function_name, $parameters);
    });

Route::delete('/admin/{controller_name}/{function_name}/{query?}/{query2?}',
    function ($controller_name, $function_name, $query = null, $query2 = null) {
        //var_dump($controller_name, $function_name, $query, $query2);
        $request = request();
        $app = app();
        $controller = $app->make('\App\Http\Controllers\Admin\\'.'Admin'.ucfirst($controller_name).'Controller');
        $url = url("admin/".$controller_name."/index?".Arr::query(CustomUtils::except_parameter($request, $controller->except_parameter)));
        $result = CustomUtils::is_exist("delete", $controller->data_model, $query);
        if($result['code'] == 400)
        {
            return redirect($url)->with('error', $result['msg']);
        }
        return $controller->callAction($function_name, $parameters = array(
            'request' => $request,
            'data_object' => $result['data_object'],
            'list_url' => $url,
            'param' => $query2
        ));
    });



Route::get('/{controller_name}/{function_name}/{query?}/{query2?}',
    function ($controller_name, $function_name, $query = null, $query2 = null) {
        //var_dump($controller_name, $function_name, $query, $query2);
        $request = request();
        $app = app();
        $controller = $app->make('\App\Http\Controllers\\'.ucfirst($controller_name).'Controller');
        return $controller->callAction($function_name, $parameters = array(
            'request' => $request,
            'param1' => $query,
            'param2' => $query2
        ));
    });
Route::post('/{controller_name}/{function_name}/{query?}/{query2?}',
    function ($controller_name, $function_name, $query = null, $query2 = null) {
        //var_dump($controller_name, $function_name, $query, $query2);
        $request = request();
        $app = app();
        $controller = $app->make('\App\Http\Controllers\\'.ucfirst($controller_name).'Controller');
        return $controller->callAction($function_name, $parameters = array(
            'request' => $request,
            'param1' => $query,
            'param2' => $query2
        ));
    });
Route::get('/{controller_name}',
    function ($controller_name) {
        //var_dump($controller_name, $function_name);
        $request = request();
        $app = app();
        try 
        {            
            $controller = $app->make('\App\Http\Controllers\\'.ucfirst($controller_name).'Controller');
            return $controller->callAction("index", $parameters = array(
                'request' => $request
            ));
        } 
        catch (Exception $e) 
        {
            $msg = "'".url()->current()."' 잘못된 접근입니다!";
            return redirect('/error')->with('error', $msg);
        }
    });









/*
|--------------------------------------------------------------------------
| 직접 선언하는 라우트는 위치와 상관없이 일치하는 것을 실행함.
|--------------------------------------------------------------------------
*/

Route::get('email-test', function(){
    $details['email'] = '9971005090@naver.com';
    dispatch(new App\Jobs\SendEmailTest($details));
    dd('done');
});

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();



Route::get('/home', 'HomeTwoController@index')->name('home');
Route::get('/abc/{query?}/{query2?}', function()
{
    return App::call('Admin\AdminErrorController@index');
});

