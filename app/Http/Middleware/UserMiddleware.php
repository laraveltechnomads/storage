<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if(request()->expectsJson() && $request->user()->tokenCan('user'))
        {
            Auth::guard('user')->login($user);
            return $next($request);
        }else{
            // dd(111);
            // Auth::guard('user')->logout();
            if (request()->expectsJson()) {
            return response([
            'success' => false,
            'message' => 'Unauthenticated',
            'data' => []
            ], config('constants.invalidResponse.statusCode'));
            // $error_message = "Unauthenticated, Not a User";
            // return somethingWrong($error_message);
            }
            return $next($request);
        }
    }
}