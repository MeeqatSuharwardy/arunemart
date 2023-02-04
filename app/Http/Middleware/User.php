<?php

namespace App\Http\Middleware;
use Laravel\Cashier\Billable;

use Closure;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    use Billable;

    public function handle($request, Closure $next)
    {
        if(empty(session('user'))){
            return redirect()->route('login.form');
        }
        else{
            return $next($request);
        }
    }
}
