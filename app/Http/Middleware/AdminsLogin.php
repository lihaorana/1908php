<?php

namespace App\Http\Middleware;

use Closure;

class AdminsLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $admins=session('admins');
        if(!$admins){
            return redirect('/admins/login');
        }
        return $next($request);
    }
}
