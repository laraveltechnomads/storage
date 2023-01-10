<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->check() &&  auth()->user()->isUser()  )
        {   
            if ($request->expectsJson()) {
                return $next($request);
            }
            $response = $next($request);
            return $response->header('Cache-Control','no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma','no-cache')
            ->header('Expires','Sun, 02 Jan 1990 00:00:00 GMT');
        }
        if (request()->expectsJson()) {
            return response([
                'success' => false,
                'message' => config('constants.invalidToken.message'),
            ], config('constants.invalidToken.statusCode'));
        }   
        Auth::logout();
        return redirect('login');
    }
}
