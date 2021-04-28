<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function showSettingApplication()
    {
        return view('cms.settings.application');
    }

    public function updateWallpaper(Request $request)
    {
        // validate
        $setting = Setting::first();
        $request->validate([
            'auth_wallpaper' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ], [
            'auth_wallpaper.image' => 'The Picture 1 must be an image.',
        ]);

        if (request()->file('auth_wallpaper')) {
            Storage::delete($setting->auth_wallpaper);
            $auth_wallpaper = request()->file('auth_wallpaper')->store("images/settings");
        } else {
            $auth_wallpaper = $setting->auth_wallpaper;
        }

        $attr['auth_wallpaper'] = $auth_wallpaper;
        $setting->update($attr);

        session()->flash('successUpdateSetting', 'Wallpaper updated successfully.');
        return redirect()->back();
    }

    public function updateAuthSetting(Request $request)
    {
        // dd($request->all());
        // validate
        $this->validateRequest($request);

        $setting = Setting::first();
        $attr = $request->all();
        $setting->update($attr);

        session()->flash('successUpdateSetting', 'Successfully updated setting.');
        return redirect()->back();
    }

    private function validateRequest(Request $request) {
        $request->validate([
            'auth_caption' => ['required', 'string', 'max:30'],
            'auth_owner_name' => ['required', 'string', 'max:30'],
            'auth_unsplash_username' => ['required', 'string', 'max:30', 'regex:/^[A-Za-z0-9.]+$/'],
        ], [
            // Membuat rules message alert
            'auth_caption.required' => 'Please enter your caption.',
            'auth_caption.max' => 'Your caption is too long.',
            'auth_owner_name.required' => 'Please enter owner name.',
            'auth_owner_name.max' => 'Owner name is too long.',
            'auth_unsplash_username.required' => 'Please enter your unsplash username.',
            'auth_unsplash_username.max' => 'Unsplash username is too long.',
            'auth_unsplash_username.regex' => 'Contains invalid characters.',
        ]);
    }
}
