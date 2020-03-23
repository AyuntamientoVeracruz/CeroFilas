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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
            if ($exception->getStatusCode() == 404) {
                return response()->view('errors.404', [], 404);
            }
        }

        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {                        
            if ($request->ajax()) {
                return response([
                    'error' => 'Lo sentimos, tu sesión expiró. Refresca el sitio web presionando F5.',
                    'success' => false,
                ], 302);
            } else {
                return redirect('/')->withErrors(['token_error' => 'Lo sentimos, tu sesión expiró. Refresca el sitio web presionando F5.']);
            }
        }

        return parent::render($request, $exception);
    }
}
