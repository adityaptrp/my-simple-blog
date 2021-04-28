<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login', [
            'setting' => Setting::find(1),
        ]);
    }

    // validate Login
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string|max:50',
            'password' => 'required|string',
        ]);
    }
    
    // Login Username
    public function username()
    {
        return 'username';
    }

    // The user has logged out of the application.
    protected function loggedOut(Request $request)
    {
        return redirect()->route('login')->with('success', 'You have successfully logged out');
    }
}
