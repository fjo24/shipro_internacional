<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{

    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    public function render($request, Exception $exception)
    {

        if (isset($exception->getStatusCode)) {
            if ($exception->getStatusCode() == 500){
                return response()->view('errores.error', [], 500);
            }
        }

        return parent::render($request, $exception);
    }
}
