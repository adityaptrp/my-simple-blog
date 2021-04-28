<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class SearchController extends Controller
{
    public function __construct() {
        // Sharing is caring
        view()->share([
            'new_post' => Post::latest()->first(),
            'categories' => Category::first()->get(),
            'tags' => Tag::first()->get(),
        ]);
    }

    public function searchPost() {
        if (request('s') == '') {
            $all_posts = true;
            // return redirect()->route('search.all_post');
        } else {
            $all_posts = false;
        }
        $query = request('s');
        $posts = Post::where("title" , "like", "%$query%")
                    ->orWhere("body" , "like", "%$query%")
                    ->orWhere("created_at" , "like", "%$query%")
                    ->orWhereHas('category', function ($posts) {
                        $query = request('s');
                        return $posts->where('name', "like", "%$query%");
                    })
                    ->orWhereHas('tags', function ($posts) {
                        $query = request('s');
                        return $posts->where('name', "like", "%$query%");
                    })
                    ->orWhereHas('tags', function ($posts) {
                        $query = request('s');
                        return $posts->where('name', "like", "%$query%");
                    })
                    ->orWhereHas('user', function ($posts) {
                        $query = request('s');
                        return $posts->where('username', "like", "%$query%");
                    })
                    ->orWhereHas('user', function ($posts) {
                        $query = request('s');
                        return $posts->where('name', "like", "%$query%");
                    })
                    ->latest()->paginate(4, ['*'], 'postSearch');
                    $posts->appends(Request::all())->links();
        return view('search', [
            'posts' => $posts,
            'request' => $query,
            'all_posts' => $all_posts
            ]);
    }

    public function allPosts() {
        $posts = Post::latest()->paginate(4, ['*'], 'postSearch');
        return view('search', [
            'posts' => $posts,
            'all_posts' => true
            ]);
    }

    public function popularPosts() {
        $posts = Post::orderBy('views_count', 'DESC')->latest()->paginate(4, ['*'], 'postSearch');
        return view('search', [
            'posts' => $posts,
            'popular_posts' => true
            ]);
    }

    public function popularCategoriesTags() {
        $popular_tags = DB::table('post_tag')
                ->join('tags','tags.id','=','tag_id')
                ->select(DB::raw('count(tag_id) as repetition, tag_id'), 'tags.name as name', 'tags.slug as slug')
                ->groupBy('tag_id', 'name', 'slug')
                ->orderBy('repetition', 'desc')
                ->get();
        $popular_categories = DB::table('posts')
                ->join('categories','categories.id','=','category_id')
                ->select(DB::raw('count(category_id) as repetition, category_id'), 'categories.name as name', 'categories.slug as slug')
                ->groupBy('category_id', 'name', 'slug')
                ->orderBy('repetition', 'desc')
                ->get();
        return view('search', [
            'popular_tags' => $popular_tags->take(10),
            'popular_categories' => $popular_categories->take(10),
            ]);
    }
}
