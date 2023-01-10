<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientMiddleware
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
        if(request()->expectsJson() && $request->user()->tokenCan('client'))
        {
            $user = $request->user();
            Auth::guard('client')->login($user);
            return $next($request);
        }else{
            Auth::guard('client')->logout();
            if (request()->expectsJson()) {
                return sendError('Unauthenticated', [], 404);
            }   
            return $next($request);
        }
    }   
}
