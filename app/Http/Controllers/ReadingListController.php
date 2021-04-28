<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReadingListController extends Controller
{
    public function bookmarkedPost()
    {
        // Get post with cookie
        $posts = [];
        if (isset($_COOKIE['bookmark'])) {
            $allPostId = explode('/', $_COOKIE['bookmark']);
            $implodeArr = implode(',', $allPostId);
            $posts = Post::whereIn('id', $allPostId)->orderByRaw("FIELD(id, $implodeArr)")->get();
        }
        // Get size of archive
        $countAr = 0;
        if (isset($_COOKIE['archive'])) {
            $arrArchive = explode('/', $_COOKIE['archive']);
            $implodeArr = implode(',', $arrArchive);
            $countAr = sizeOf(Post::whereIn('id', $arrArchive)->orderByRaw("FIELD(id, $implodeArr)")->get());
        }
        return view('reading_list', [
            'new_post' => Post::latest()->first(),
            'categories' => Category::first()->get(),
            'posts' => $posts,
            'bookmark' => true,
            'sizeOfBookmark' => sizeof($posts),
            'sizeOfArchive' => $countAr
        ]);
    }

    public function archivedPost()
    {
        // Get post with cookie
        $posts = [];
        if (isset($_COOKIE['archive'])) {
            $allPostId = explode('/', $_COOKIE['archive']);
            $implodeArr = implode(',', $allPostId);
            $posts = Post::whereIn('id', $allPostId)->orderByRaw("FIELD(id, $implodeArr)")->get();
        }
        // Get size of bookmark
        $countBm = 0;
        if (isset($_COOKIE['bookmark'])) {
            $arrBookmark = explode('/', $_COOKIE['bookmark']);
            $implodeArr = implode(',', $arrBookmark);
            $countBm = sizeOf(Post::whereIn('id', $arrBookmark)->orderByRaw("FIELD(id, $implodeArr)")->get());
        }
        return view('reading_list', [
            'new_post' => Post::latest()->first(),
            'categories' => Category::first()->get(),
            'posts' => $posts,
            'archive' => true,
            'sizeOfBookmark' => $countBm,
            'sizeOfArchive' => sizeof($posts)
        ]);
    }
}
