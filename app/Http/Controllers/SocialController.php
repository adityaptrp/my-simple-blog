<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Str;

class SocialController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected $providers = [
        'facebook','google','twitter'
    ];

    public function redirectToProvider($driver)
    {
        if( ! $this->isProviderAllowed($driver) ) {
            return $this->sendFailedResponse("{$driver} is not currently supported");
        }

        try {
            return Socialite::driver($driver)->redirect();
        } catch (Exception $e) {
            // You should show something simple fail message
            return $this->sendFailedResponse($e->getMessage());
        }
    }

    public function handleProviderCallback( $driver )
    {
        try {
            $user = Socialite::driver($driver)->user();
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }

        // check for email in returned user
        return empty( $user->email )
            ? $this->sendFailedResponse("No email id returned from {$driver} provider.")
            : $this->loginOrCreateAccount($user, $driver);
    }

    protected function sendSuccessResponse()
    {
        return redirect()->route('home');
    }

    protected function sendFailedResponse($msg = null)
    {
        return redirect()->route('login')
            ->with(['error' => $msg ?: 'Unable to login, try with another provider to login.']);
    }

    protected function loginOrCreateAccount($providerUser, $driver)
    {
        // check for already has account
        $user = User::where('email', $providerUser->getEmail())->first();

        // if user already found
        if( $user ) {
            // update the avatar and provider that might have changed
            $user->update([
                'provider' => $driver,
                'provider_id' => $providerUser->id,
            ]);
            if (str_contains($user->profile_picture, 'http')) {
                $user->update([
                    'profile_picture' => $providerUser->avatar,
                ]);
            }
        } else {
            // create a new user
            if($providerUser->getEmail()){ //Check email exists or not. If exists create a new user
                $user = User::create([
                    'name' => $providerUser->getName(),
                    'username' => $this->makeUsername($providerUser->getEmail()),
                    'email' => $providerUser->getEmail(),
                    'profile_picture' => $providerUser->getAvatar(),
                    'provider' => $driver,
                    'provider_id' => $providerUser->getId(),
                    'password' => '' // user can use reset password to create a password
                ]);
                if ($user->markEmailAsVerified()) {
                    event(new Verified($user));
                }
            }else {
                //Show message here what you want to show
                return redirect()->route('login')->with('errors', 'Please user another provider');
            }
        }

        // login the user
        Auth::login($user, true);

        return $this->sendSuccessResponse();
    }

    private function isProviderAllowed($driver)
    {
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }

    private function makeUsername($name) {
        $arrayName = explode('@', $name);
        return $arrayName[0];
    }
}
