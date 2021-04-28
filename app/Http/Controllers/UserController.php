<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Rules\CheckCurrentPassword;
use App\Rules\FakeEmail;
use App\Rules\StrongPassword;
use App\Rules\VerifyDeleteAccount;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show(User $user)
    {
        $arrPostId = Post::where('user_id', $user->id)->pluck('id')->toArray();
        $count_responses = Comment::whereIn('post_id', $arrPostId)->where('is_approved', 1)->count();
        return view('profile', [
            'new_post' => Post::latest()->first(),
            'categories' => Category::first()->get(),
            'posts' => Post::where('user_id', $user->id)->orderBy('created_at', 'DESC')->paginate(4, ['*'], 'postList'),
            'posts_count' => Post::where('user_id', $user->id)->count(),
            'count_responses' => $count_responses,
            'user' => $user,
            'all_posts' => true,
        ]);
    }

    public function showSettingAccount()
    {
        return view('cms.settings.account');
    }

    public function likesProfile(User $user)
    {
        Cookie::queue('profile_liked', true, 1440, "/profile/@$user->username");
        $user->increment('count_likes');
        $user->save();
        return $user->count_likes . '<span class="ml-1 font-normal">Likes</span>';
    }

    public function allPosts(User $user)
    {
        $arrPostId = Post::where('user_id', $user->id)->pluck('id')->toArray();
        $count_responses = Comment::whereIn('post_id', $arrPostId)->where('is_approved', 1)->count();
        return view('profile', [
            'new_post' => Post::latest()->first(),
            'categories' => Category::first()->get(),
            'posts' => Post::where('user_id', $user->id)->orderBy('created_at', 'DESC')->paginate(4, ['*'], 'postList'),
            'posts_count' => Post::where('user_id', $user->id)->count(),
            'count_responses' => $count_responses,
            'user' => $user,
            'all_posts' => true,
        ]);
    }

    public function mostPopular(User $user)
    {
        $arrPostId = Post::where('user_id', $user->id)->pluck('id')->toArray();
        $count_responses = Comment::whereIn('post_id', $arrPostId)->where('is_approved', 1)->count();
        return view('profile', [
            'new_post' => Post::latest()->first(),
            'categories' => Category::first()->get(),
            'posts' => Post::where('user_id', $user->id)->orderBy('views_count', 'DESC')->orderBy('likes_count', 'DESC')->paginate(4, ['*'], 'postList'),
            'posts_count' => Post::where('user_id', $user->id)->count(),
            'count_responses' => $count_responses,
            'user' => $user,
            'popular_posts' => true,
        ]);
    }

    public function socialMedia(User $user)
    {
        $arrPostId = Post::where('user_id', $user->id)->pluck('id')->toArray();
        $count_responses = Comment::whereIn('post_id', $arrPostId)->where('is_approved', 1)->count();
        return view('profile', [
            'new_post' => Post::latest()->first(),
            'categories' => Category::first()->get(),
            'posts' => Post::where('user_id', $user->id)->orderBy('views_count', 'DESC')->orderBy('likes_count', 'DESC')->paginate(4, ['*'], 'postList'),
            'posts_count' => Post::where('user_id', $user->id)->count(),
            'count_responses' => $count_responses,
            'user' => $user,
            'social_media' => true,
        ]);
    }

    public function update(Request $request, User $user)
    {
        // validate
        $this->validateRequest($request, $user);

        if (request('use_gravater')) {
            Storage::delete($user->profile_picture);
            $profile_picture = null;
        } else {
            if (request()->file('profile_picture')) {
                Storage::delete($user->profile_picture);
                $profile_picture = request()->file('profile_picture')->store("images/users");
            } else {
                $profile_picture = $user->profile_picture;
            }
        }
        
        $attr = $request->all();
        $attr['profile_picture'] = $profile_picture;
        $user->update($attr);

        session()->flash('alert', 'Successfully updated your profile.');
        return redirect()->route('profile.show', $user->username);
    }

    public function updateBanner(Request $request, User $user)
    {
        // validate
        $request->validate([
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ], [
            'banner.image' => 'The Picture 1 must be an image.',
        ]);

        if (request('remove_banner')) {
            Storage::delete($user->banner);
            $banner = null;
        } else {
            if (request()->file('banner')) {
                Storage::delete($user->banner);
                $banner = request()->file('banner')->store("images/users/banners");
            } else {
                $banner = $user->banner;
            }
        }

        $attr['banner'] = $banner;
        $user->update($attr);

        session()->flash('alert', 'Successfully updated your cover.');
        return redirect()->route('profile.show', $user->username);
    }

    public function updatePassword(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $request->validate([
            'current_password' => ['required', new CheckCurrentPassword],
            'password' => ['required', 'string', 'min:8', 'confirmed', new StrongPassword],
        ], [
            // Membuat rules message alert
            'current_password.required' => 'Please enter your current password.',
            'password.required' => 'Please enter your password.',
        ]);
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        return redirect()->back()->with('success', 'You have successfully updated your password!');
    }

    public function updateEmail(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        // dd($request->all());
        $user->forceFill(['email_verified_at' => null]);
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', new FakeEmail],
        ], [
            'email.required' => 'Please enter your new email.',
        ]);

        $user->update([
            'email' => $request->email,
        ]);
        // send email verification
        $user->sendEmailVerificationNotification();
        return redirect()->back();
    }

    public function deleteAccount(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'deactive_account' => ['required', 'string', new VerifyDeleteAccount],
        ], [
            'deactive_account.required' => 'Please enter the verification code.',
        ]);

        // delete all about user
        $this->deleteAllAboutUser(auth()->user());
        $user = User::where('id', auth()->user()->id);
        $user->delete();
        return redirect()->route('home');
    }

    public function deleteAllAboutUser($user)
    {
        // delete all posts
        $posts = $user->posts()->get();
        foreach ($posts as $post) {
            Storage::delete($post->thumbnail);
            Storage::delete($post->sub_thumbnail_one);
            Storage::delete($post->sub_thumbnail_two);
            
            // delete relation tags
            $post->tags()->detach();

            // delete comments
            $post->allComments()->delete();
            // delete post
            $post->delete();
        }
    }


    private function validateRequest(Request $request, User $user) {
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'username' => ['required', Rule::unique('users')->ignore($user->id), 'string', 'max:15','regex:/^[A-Za-z0-9_]+$/'],
            'bio' => ['max:160'],
            'youtube_link_id' => ['max:35'],
            'instagram' => ['max:30', 'nullable', 'regex:/^[A-Za-z0-9_-]+$/'],
            'twitter' => ['max:30', 'nullable', 'regex:/^[A-Za-z0-9_]+$/'],
            'facebook' => ['max:50', 'nullable', 'regex:/^[A-Za-z0-9.]+$/'],
            'website' => ['max:100', 'nullable', 'url'],
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ], [
            // Membuat rules message alert
            'name.required' => 'Please enter your name.',
            'name.max' => 'Your name is too long.',
            'username.required' => 'Please enter your username.',
            'username.max' => 'Your username is too long.',
            'username.regex' => 'Your username can only contain letters, numbers and underscores',
            'bio.max' => 'Your bio is too long.',
            'youtube_link_id.max' => 'Your youtube ID is too long.',
            'instagram.max' => 'Your username IG is too long.',
            'instagram.regex' => 'Usernames can only use letters, numbers, underscores and periods.',
            'twitter.max' => 'Your username twitter is too long.',
            'twitter.regex' => 'Usernames can only use letters, numbers and underscores.',
            'facebook.max' => 'Your username facebook is too long.',
            'facebook.regex' => 'Contains invalid characters.',
            'website.max' => 'Your username website is too long.',
            'profile_picture.image' => 'The thumbnail must be an image.',
            'banner.image' => 'The Picture 1 must be an image.',
        ]);
    }
}
