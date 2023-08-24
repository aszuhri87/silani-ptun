<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicantHandling
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('applicant')->check()) {
            if (isset(Auth::guard('applicant')->user()->user_id)) {
                return $next($request);
            }  else {
                return redirect('login')->with('error', "You don't have admin access.");
            }
        } else {
            return redirect('login')->with('error', "You don't have applicant access.");
        }
    }
}
