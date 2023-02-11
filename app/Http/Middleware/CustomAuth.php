<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomAuth
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

        $path = $request->path();
        if (($path == 'login') && Session::get('user')) {
            return redirect("index");
        } 
        return $next($request);
        

        // $response = $next($request);
        // if (Session::get('user')) {
        //     return $response;
        // } else {
        //     return redirect(url('/'));
        // };

    }
}
