<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function show(Tag $tag) {
        $posts = $tag->posts()->latest()->paginate(4);
        return view('search', [
            'posts' => $posts,
            'new_post' => Post::latest()->first(),
            'categories' => Category::first()->get(),
            'tags' => Tag::first()->get(),
            'tag' => $tag
            ]);
    }

    public function index() {
        return view('cms.tags.index', [
            'tags' => Tag::orderBy('created_at', 'DESC')->get(),
        ]);
    }

    public function tagPosts(Tag $tag)
    {
        return view('cms.posts.all_posts', [
            'posts' => $tag->posts,
            'tag_posts' => $tag->name
        ]);
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->back()->with('success', 'You have successfully deleted the tag!');
    }

    public function multipleDelete(Request $request)
    {
        $checked = $request->input('checked',[]);
        $tags = Tag::whereIn('id', $checked)->get();
        foreach ($tags as $tag) {
            $tag->delete();
        }
        return redirect()->back()->with('success', 'You have successfully deleted the selected tags!');
    }
}
