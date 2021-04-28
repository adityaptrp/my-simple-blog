<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CmsController extends Controller
{
    public function show() {
        $user = User::where('id', Auth::user()->id)->first();
        $subdays = 7;
        return view('cms.dashboard', [
            // posts
            'posts' => $user->posts()->get(),
            'statusPosts' => $user->getInsightPosts()->get()->count(),
            'insightPosts' => $user->getInsightPosts()->get(),
            // views
            'allViews' => $user->posts->sum('views_count'),
            'statusViews' => $user->getInsightViews()->get()->count(),
            // likes
            'allLikes' => $user->posts->sum('likes_count'),
            'statusLikes' => $user->getInsightLikes()->get()->count(),
            // comments
            'comments' => $user->allComments()->where('is_approved', 1)->get(),
            'statusComments' => $user->getInsightComments()->where('is_approved', 1)->get()->count(),
            'insightComments' => $user->getInsightComments()->where('email', '!=', $user->email)->limit(6)->get(),
            'subdays' => $subdays,
        ]);
    }
}
