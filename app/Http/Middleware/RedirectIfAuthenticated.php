<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @param string|null                                                                                       ...$guards
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next, $guard=null)
    {
        if (Auth::guard($guard)->check()) {
            if(Auth::user()->category == 'admin'){
                return redirect('admin/dashboard');
            } else if (Auth::user()->category == 'umum' || Auth::user()->category == null || Auth::user()->category == 'karyawan'){
                return redirect('applicant/dashboard');
            } else{
                return redirect('login');
            }
        } else {
            return $next($request);
        }
    }
}
