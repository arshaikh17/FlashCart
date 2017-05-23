<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Session;

class PrivilegeMiddleware
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
        $privilege = $request->session()->has('privilege');

        if($request->session()->has('privilege'))
        {
            if($privilege == "Owner" || $privilege == "owner")
            {
                return $next($request);
            }
            else
            {
                return redirect()->back()->withErrors(['check' => "You are not privileged to go there!."]);
            }
        }
        return '/user/home';
    }
}
