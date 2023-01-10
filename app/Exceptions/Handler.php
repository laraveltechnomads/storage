<?php

namespace App\Exceptions;

use ErrorException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use ParseError;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            // dd($e->getMessage());
        });


        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return sendErrorHelper('Record not found.', [], 404);
            }
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->is('api/*')) {
                return sendErrorHelper('The specified method for the request is invalid.', [], 405);
            }
        });

        // $this->renderable(function (QueryException $e, $request) {
        //     if ($request->is('api/*')) {
        //         return sendErrorHelper('Database Table Column not found', [], 500);
        //     }
        // });
        $this->renderable(function (ParseError $e, $request) {
            return 'errorexception';
            if ($request->is('api/*')) {    
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found.'
                ], 404);
            }
        });
    }
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        /** Unauthenticated */ 
        if (request()->expectsJson()) {
            return sendErrorHelper('Unauthenticated', [], 401);
        }
    
    }
}
