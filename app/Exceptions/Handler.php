<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($this->isHttpException($exception)) {

            $statusCode = $exception->getStatusCode();
            if ($statusCode == "404" || $statusCode == "500")
            {
                $msg = "'".url()->current()."' 잘못된 접근입니다!";
                session()->put('error', $msg);
                session()->save();
                return redirect('/error')->with('error', $msg);
            }
        }
        if (get_class($exception) == "BadMethodCallException" || get_class($exception) == "ReflectionException") {
            $msg = "'".url()->current()."' 잘못된 접근입니다!";
            return redirect('/error')->with('error', $msg);
        }
        return parent::render($request, $exception);
    }
}
