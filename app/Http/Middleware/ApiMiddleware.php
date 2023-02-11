<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;

use Auth;
// 
class ApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        
     
        // return $next($request);
        if (Auth::guard($guard)->guest()) {
            return route('invalid');
        }else{
            return $next($request);
        }

        // if(auth()->user()){
        //     return $next($request);
        // }else{
        //     return route('invalid');
        // }
        
    
    }
}
