<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Rules\FakeEmail;
use App\Rules\StrongPassword;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    public function showRegistrationForm()
    {
        return view('auth.register', [
            'setting' => Setting::first(),
        ]);
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:50'],
            'username' => ['required', 'unique:users', 'string', 'max:30','regex:/^[A-Za-z0-9_]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', new FakeEmail],
            'password' => ['required', 'string', 'min:5', 'max:50', 'confirmed', new StrongPassword],
            'terms_of_service' => ['required'],
        ], [
            // Membuat rules message alert
            'name.required' => 'Please enter your name.',
            'name.max' => 'Your name is too long.',
            'username.required' => 'Please enter your username.',
            'username.max' => 'Your username is too long.',
            'username.regex' => 'Your username can only contain letters, numbers and "_"',
            'email.required' => 'Please enter your email.',
            'password.required' => 'Please enter your password.',
            'terms_of_service.required' => 'Please agree with our terms of service.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    // The user has been registered.
    protected function registered()
    {
        return view('auth.verify', [
            'setting' => Setting::first(),
        ]);
    }

    // Set password for user login with provider
    protected function setPasswordsUserProvider(Request $request ,User $user) {
        $this->validateSetPassword($request);
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('home');
    }

    private function validateSetPassword(Request $request) {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed', new StrongPassword],
        ], [
            // Membuat rules message alert
            'password.required' => 'Please enter your password.',
        ]);
    }
}
