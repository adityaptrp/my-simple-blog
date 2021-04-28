<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $popular_post = Post::orderBy('views_count', 'DESC')->first();
        $posts = Post::where('id', '!=', $popular_post->id)->orderBy('views_count', 'DESC')->paginate(3, ['*'], 'postList');

        $popular_tags = DB::table('post_tag')
                ->join('tags','tags.id','=','tag_id')
                ->select(DB::raw('count(tag_id) as repetition, tag_id'), 'tags.name as name', 'tags.slug as slug')
                ->groupBy('tag_id', 'name', 'slug')
                ->orderBy('repetition', 'desc')
                ->get();
        $commentUnapproved = [];
        if (Auth::user()) {
            $arrPostId = Post::where('user_id', Auth::user()->id)->pluck('id')->toArray();
            $commentUnapproved = Comment::whereIn('post_id', $arrPostId)->where('is_approved', 0)->orderBy('created_at', 'DESC')->get();
        }
        return view('home', [
            'posts' => $posts,
            'new_post' => Post::latest()->first(),
            'categories' => Category::first()->get(),
            'tags' => $popular_tags->take(10),
            'commentUnapproved' => $commentUnapproved, // emng harus ngirim untuk liat berapa jumlah CU 
            'highlight_post' => Post::orderBy('views_count', 'DESC')->orderBy('likes_count', 'DESC')->first()
        ]);
    }
}
