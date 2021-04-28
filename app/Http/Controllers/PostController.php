<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\SessionLike;
use App\Models\SessionView;
use App\Models\Tag;
use App\Models\User;
use App\Rules\CheckYoutubeLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index() {
        return view('cms.posts.index', [
            'posts' => Post::where('user_id', Auth::user()->id)->latest()->get(),
        ]);
    }
    
    public function allPosts() {
        return view('cms.posts.all_posts', [
            'posts' => Post::latest()->get(),
        ]);
    }

    public function show(User $user, Post $post) {
        if(!Cookie::get('views_count')) {
            $post->increment('views_count');
            $post->save();
            Cookie::queue('views_count', true, 1440, "/@$user->username/$post->slug");

            // add session view
            SessionView::create([
                'user_id' => $post->user_id,
            ]);
        }
        return view('post', [
            'post' => $post,
            'new_post' => Post::latest()->first(),
            'sizeOfComment' => Comment::where('post_id', $post->id)->where('is_approved', 1)->get(),
            'commentUnapproved' => Comment::where('post_id', $post->id)->where('is_approved', 0)->orderBy('created_at', 'DESC')->get(),
            'list_posts' => Post::where('user_id', $post->user_id)->where("id", '!=', "$post->id")->latest()->paginate(2, ['*'], 'postList'),
            'categories' => Category::first()->get()
        ]);
    }

    public function create() {
        if (!Auth::user()->is_admin) {
            $sizeOfPost = Post::where('user_id', Auth::user()->id)->count();
            if ($sizeOfPost > 5) {
                return abort(403, 'Your posts get the maximum limit.');
            }
        }
        return view('cms.posts.create', [
            'categories' => Category::get(),
            'tags' => Tag::get(),
        ]);
    }

    public function store(Request $request) {
        // Validate
        $this->validateRequest($request);

        $attr = $request->all();
        $slug = Str::slug(request('title') . '-' . Str::random(12));
        $attr['slug'] = $slug;
        $attr['user_id'] = Auth::user()->id;

        $thumbnail = request()->file('thumbnail') ? request()->file('thumbnail')->store("images/posts") : null;
        $sub_thumbnail1 = request()->file('sub_thumbnail1') ? request()->file('sub_thumbnail1')->store("images/posts") : null;
        $sub_thumbnail2 = request()->file('sub_thumbnail2') ? request()->file('sub_thumbnail2')->store("images/posts") : null;
        
        $attr['thumbnail'] = $thumbnail;
        $attr['sub_thumbnail1'] = $sub_thumbnail1;
        $attr['sub_thumbnail2'] = $sub_thumbnail2;
        $post = Post::create($attr);

        // Attach Tags
        if ($request->tags) {
            $tags = explode(',', $request->tags);
            $tagsDB = Tag::get();

            foreach($tags as $tag) {
                $tagSlug = Str::slug($tag);
                foreach($tagsDB as $i => $tagDB) {
                    if($tagSlug == $tagDB->slug) {
                        $post->tags()->attach($tagDB->id);
                        break;
                    } else {
                        if($i+1 == sizeOf($tagsDB)) {
                            $save = [];
                            $save['name'] = $tag;
                            $save['slug'] = Str::slug($tag);
                            $newTag = Tag::create($save);
            
                            $post->tags()->attach($newTag->id);
                        }
                    }
                }
            }
        }

        session()->flash('success', 'You have successfully created the post!');
        return redirect('posts');
    }

    public function edit(Post $post) {
        // POLICY
        $this->authorize('editOrUpdate', $post);
        return view('cms.posts.edit', [
            'post' => $post,
            'categories' => Category::get(),
            'tags' => $post->tags()->get(),
        ]);
    }

    public function update(Request $request, Post $post)
    {
        // POLICY
        $this->authorize('editOrUpdate', $post);
        // validate
        $this->validateRequest($request);

        if ($request->thumb_null) {
            Storage::delete($post->thumbnail);
            $thumbnail = null;
        } else {
            if (request()->file('thumbnail')) {
                Storage::delete($post->thumbnail);
                $thumbnail = request()->file('thumbnail')->store("images/posts");
            } else {
                $thumbnail = $post->thumbnail;
            }
        }

        if ($request->thumb_one_null) {
            Storage::delete($post->sub_thumbnail1);
            $sub_thumbnail1 = null;
        } else {
            if (request()->file('sub_thumbnail1')) {
                Storage::delete($post->sub_thumbnail1);
                $sub_thumbnail1 = request()->file('sub_thumbnail1')->store("images/posts");
            } else {
                $sub_thumbnail1 = $post->sub_thumbnail1;
            }
        }

        if ($request->thumb_two_null) {
            Storage::delete($post->sub_thumbnail2);
            $sub_thumbnail2 = null;
        } else {
            if (request()->file('sub_thumbnail2')) {
                Storage::delete($post->sub_thumbnail2);
                $sub_thumbnail2 = request()->file('sub_thumbnail2')->store("images/posts");
            } else {
                $sub_thumbnail2 = $post->sub_thumbnail2;
            }
        }

        $attr = $request->all();
        $attr['thumbnail'] = $thumbnail;
        $attr['sub_thumbnail1'] = $sub_thumbnail1;
        $attr['sub_thumbnail2'] = $sub_thumbnail2;

        $post->update($attr);

        // Sync Tags
        $arrId =[];
        if ($request->tags) {
            $tags = explode(',', $request->tags);
            $tagsDB = Tag::get();

            foreach($tags as $tag) {
                $tagSlug = Str::slug($tag);
                foreach($tagsDB as $i => $tagDB) {
                    if($tagSlug == $tagDB->slug) {
                        array_push($arrId, $tagDB->id);
                        break;
                    } else {
                        if($i+1 == sizeOf($tagsDB)) {
                            $save = [];
                            $save['name'] = $tag;
                            $save['slug'] = Str::slug($tag);
                            $newTag = Tag::create($save);
                            array_push($arrId, $newTag->id);
                        }
                    }
                }
            }
        }
        $post->tags()->sync($arrId);

        session()->flash('success', 'You have successfully updated the post!');
        return redirect('posts');
    }

    public function destroy(Post $post)
    {
        if (!Auth::user()->is_admin) {
            // policy
            $this->authorize('delete', $post);
        }
        Storage::delete($post->thumbnail);
        Storage::delete($post->sub_thumbnail1);
        Storage::delete($post->sub_thumbnail2);
        $post->tags()->detach();
        // delete comments
        $post->allComments()->delete();
        $post->delete();
        session()->flash('success', 'You have successfully deleted the post!');
        return redirect('posts');
    }
    
    public function multipleDelete(Request $request)
    {
        $checked = $request->input('checked',[]);
        $posts = Post::whereIn('id', $checked)->get();
        foreach ($posts as $post) {
            Storage::delete($post->thumbnail);
            Storage::delete($post->sub_thumbnail1);
            Storage::delete($post->sub_thumbnail2);
            $post->tags()->detach();
            // delete comments
            $post->allComments()->delete();
            $post->delete();
        }
        return redirect()->back()->with('success', 'You have successfully deleted the selected posts!');
    }

    public function postLiked(Post $post) {
        $username = $post->user->username;
        Cookie::queue('post_clapped', true, 1440, "/@$username/$post->slug");

        $post->increment('likes_count');
        $post->save();

        // add session like
        SessionLike::create([
            'user_id' => $post->user_id,
        ]);

        $html = [
            'likeSide' => 
                    '<div class="effect-liked-post text-sm">+1</div>
                    <div class="all-icon-p s-likepost flex relative items-center h-full cursor-pointer">
                        <svg class="w-5 h-5 md:w-6 md:h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 285.25 284.04" fill="salmon">
                            <path d="M116.87 39.2l-7.77-7.78a13.43 13.43 0 0 0-20 1.18 13.65 13.65 0 0 0 1.34 18l6.17 6.18a23.91 23.91 0 0 1 2.75 2.08 25 25 0 0 1 5-11.17 25.37 25.37 0 0 1 12.51-8.49zm95.83 39.6l-61.87-61.87a13.41 13.41 0 0 0-20 1.19 13.64 13.64 0 0 0 1.34 18l70.92 70.2.23-8.12a25.23 25.23 0 0 1 9.38-19.39zm70.9 97a5.62 5.62 0 0 0 .29-7.64l-12.28-14.28-12.74-92.47c-.197-7.173-6.07-12.886-13.245-12.886S232.577 54.237 232.38 61.4l-.38 12a25.28 25.28 0 0 1 21.78 24.06l12.22 88.3 3.53 4.1zM28.44 42.85c2.706 1.914 6.45 1.27 8.365-1.435s1.27-6.45-1.435-8.365L20.4 22.4a6 6 0 0 0-9.592 4.297A6 6 0 0 0 13.46 32.2zm28.22-21.78L50.2 3.9A6 6 0 1 0 39 8.11l6.46 17.18a6 6 0 1 0 11.23-4.22zM0 60.66a5.94 5.94 0 0 0 5.88 6l18.47.3a6 6 0 0 0 6-5.93 5.83 5.83 0 0 0-5.88-5.92L6 55.02a5.8 5.8 0 0 0-6 5.64zm83.92 149.92c29.57 29.57 60.5 53.32 87.65 59.23a5.76 5.76 0 0 1 2.27 1.05l15.66 12a5.61 5.61 0 0 0 7.38-.48l69.67-69.56a5.62 5.62 0 0 0 .3-7.64l-12.28-14.28-12.74-92.5a13.25 13.25 0 1 0-26.49 0l-.63 21.82a6.14 6.14 0 0 1-6.19 6 6.05 6.05 0 0 1-4.31-1.82l-70.43-70.43a13.42 13.42 0 0 0-20 1.19 13.66 13.66 0 0 0 1.34 18l48.52 48.52a6.45 6.45 0 0 1 0 9.12h0a6.51 6.51 0 0 1-9.23 0L92.05 68.46a13.42 13.42 0 0 0-20 1.18 13.65 13.65 0 0 0 1.34 18l62.08 62.08a6.55 6.55 0 0 1 0 9.25 6.46 6.46 0 0 1-9.11 0L77.58 110.2a13.41 13.41 0 0 0-20 1.18 13.65 13.65 0 0 0 1.34 18l48.35 48.35a6.69 6.69 0 0 1 0 9.46l-.08.08a6.18 6.18 0 0 1-8.74 0l-30-30a14.09 14.09 0 0 0-9.92-4.13 13 13 0 0 0-8.11 2.79 13.41 13.41 0 0 0-1.18 20z"/>
                        </svg>
                        <p class="ml-3 text-sm">'. $post->likes_count .'</p>
                        <div class="s-hover-lp">
                            <p class="text-xs">Already applauded.</p>
                            <div class="triangle-left-lps"></div>
                        </div>
                    </div>',
            'likeMain' => 
                    '<div class="effect-liked-post text-sm">+1</div>
                    <div class="all-icon-p m-likepost flex relative items-center cursor-pointer h-full">
                        <svg class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 285.25 284.04" fill="salmon">
                            <path d="M116.87 39.2l-7.77-7.78a13.43 13.43 0 0 0-20 1.18 13.65 13.65 0 0 0 1.34 18l6.17 6.18a23.91 23.91 0 0 1 2.75 2.08 25 25 0 0 1 5-11.17 25.37 25.37 0 0 1 12.51-8.49zm95.83 39.6l-61.87-61.87a13.41 13.41 0 0 0-20 1.19 13.64 13.64 0 0 0 1.34 18l70.92 70.2.23-8.12a25.23 25.23 0 0 1 9.38-19.39zm70.9 97a5.62 5.62 0 0 0 .29-7.64l-12.28-14.28-12.74-92.47c-.197-7.173-6.07-12.886-13.245-12.886S232.577 54.237 232.38 61.4l-.38 12a25.28 25.28 0 0 1 21.78 24.06l12.22 88.3 3.53 4.1zM28.44 42.85c2.706 1.914 6.45 1.27 8.365-1.435s1.27-6.45-1.435-8.365L20.4 22.4a6 6 0 0 0-9.592 4.297A6 6 0 0 0 13.46 32.2zm28.22-21.78L50.2 3.9A6 6 0 1 0 39 8.11l6.46 17.18a6 6 0 1 0 11.23-4.22zM0 60.66a5.94 5.94 0 0 0 5.88 6l18.47.3a6 6 0 0 0 6-5.93 5.83 5.83 0 0 0-5.88-5.92L6 55.02a5.8 5.8 0 0 0-6 5.64zm83.92 149.92c29.57 29.57 60.5 53.32 87.65 59.23a5.76 5.76 0 0 1 2.27 1.05l15.66 12a5.61 5.61 0 0 0 7.38-.48l69.67-69.56a5.62 5.62 0 0 0 .3-7.64l-12.28-14.28-12.74-92.5a13.25 13.25 0 1 0-26.49 0l-.63 21.82a6.14 6.14 0 0 1-6.19 6 6.05 6.05 0 0 1-4.31-1.82l-70.43-70.43a13.42 13.42 0 0 0-20 1.19 13.66 13.66 0 0 0 1.34 18l48.52 48.52a6.45 6.45 0 0 1 0 9.12h0a6.51 6.51 0 0 1-9.23 0L92.05 68.46a13.42 13.42 0 0 0-20 1.18 13.65 13.65 0 0 0 1.34 18l62.08 62.08a6.55 6.55 0 0 1 0 9.25 6.46 6.46 0 0 1-9.11 0L77.58 110.2a13.41 13.41 0 0 0-20 1.18 13.65 13.65 0 0 0 1.34 18l48.35 48.35a6.69 6.69 0 0 1 0 9.46l-.08.08a6.18 6.18 0 0 1-8.74 0l-30-30a14.09 14.09 0 0 0-9.92-4.13 13 13 0 0 0-8.11 2.79 13.41 13.41 0 0 0-1.18 20z"/>
                        </svg>
                        <p class="ml-3 sm:ml-3 text-sm md:text-base">'. $post->likes_count .' <span class="hidden sm:inline">claps</span></p>
                        <div class="m-hover-lp">
                            <p class="text-xs">Already applauded.</p>
                            <div class="triangle-down-lpm"></div>
                        </div>
                    </div>'
        ];
        return $html;
    }

    private function validateRequest(Request $request) {
        $request->validate([
            'title' => 'required|min:3|max:191',
            'subtitle' => 'nullable|max:191',
            'header' => 'required',
            'body' => 'required',
            'quote' => 'max:191',
            'quote_author' => 'max:100',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'sub_thumbnail1' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'sub_thumbnail2' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'youtube_link' => ['nullable', 'url', 'max:100', new CheckYoutubeLink]
        ], [
            // Membuat rules message alert
            'title.required' => 'Please enter post title.',
            'title.max' => 'Post title is too long.',
            'subtitle.max' => 'Post subtitle is too long.',
            'header.required' => 'Please enter post header.',
            'body.required' => 'Please enter post header.',
            'quote.max' => 'Quote is too long.',
            'quote_author.max' => 'Quote author is too long.',
            'thumbnail.image' => 'The thumbnail must be an image.',
            'sub_thumbnail1.image' => 'The Picture 1 must be an image.',
            'sub_thumbnail2.image' => 'The Picture 2 must be an image.',
            'youtube_link.url' => 'The link must be from youtube share link.',
            'youtube_link.max' => 'The link must be from youtube share link.',
        ]);
    }
}
