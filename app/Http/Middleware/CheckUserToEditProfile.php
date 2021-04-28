<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserToEditProfile
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
        if ($request->route('user')) {
            $user = $request->route('user'); // tangkap langsung model user dari parameter di route
        } else if ($request->route('username')) {
            $username = $request->route('username');
            $user = User::where('username', $username)->first();
        }
        if (Auth::user()->id == $user->id) {
            return $next($request);
        }
        return abort(403, 'Unauthorized action.');
    }
}
