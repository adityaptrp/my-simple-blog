<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPasswordEmpty
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
        // If password user still empty because register with provider
        if (Auth::user()) {
            if (!Auth::user()->password) {
                return redirect()->route('home');
            }
        }
        return $next($request);
    }
}
