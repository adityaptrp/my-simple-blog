<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Rules\FakeEmail;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Laravel\Ui\Presets\React;

class CommentController extends Controller
{
    public function index()
    {
        $arrPostId = Post::where('user_id', Auth::user()->id)->pluck('id')->toArray();
        $comments = Comment::whereIn('post_id', $arrPostId)->orderBy('created_at', 'DESC')->get();
        return view('cms.comments.index', [
            'comments' => $comments,
        ]);
    }   

    public function store(Request $request) {
        // return $request->email;
        if (!Auth::check()) {
            $check = User::where('email', $request->email)->first();
            if ($check) {
                return response()->json(['errors' => ['email' => ['0' => 'You must be logged in to use this email.']]], 422);
            }
        }
        if (auth()->user()) {
            $user = User::where('id', auth()->user()->id)->first();
            $request['name'] = $user->getShortName();
            $request['email'] = auth()->user()->email;
            if (!$request->user_link) {
                $request['user_link'] = $user->website;
            }
            $request['is_approved'] = 1;
        }
        $request['body'] = strip_tags($request->body);
        $this->validateRequest($request);
        $newComment = Comment::create($request->all());

        $post = Post::where('id', $request->post_id)->first();
        if (!auth()->user()) {
            $username = $post->user->username;
            Cookie::queue('comment_submitted', $newComment->id, 1440, "/@$username/$post->slug");
        }
        $sizeOfComment = Comment::where('post_id', $request->post_id)->where('is_approved', 1)->get();
        $html = view('comments.partials.comment_ajax', [
            'comment' => $newComment,
            'post' => $post,
        ])->render();
        $data = ['html' => $html, 'sizeOfComment' => sizeOf($sizeOfComment)];
        return $data;
    }

    public function likesComment(Request $request) {
        $comment = Comment::where('id', $request->commentId)->first();
        $post = Post::where('id', $comment->post_id)->first();
        $username = $post->user->username;

        if ($request->cookie) {
            $cookie = $request->cookie;
            $value = $cookie . '/' . $comment->id;
            Cookie::queue('comment_clapped', $value, 1440, "/@$username/$post->slug");
        } else {
            $value = $comment->id;
            Cookie::queue('comment_clapped', $comment->id, 1440, "/@$username/$post->slug");
        }

        $comment->increment('counts_like');
        $comment->save();

        $data = [ 
            'clapped' => 
            '<div class="effect-liked-comment text-sm tracking-widest">+1</div>
            <a class="cmnt-clapped flex items-center cursor-pointer h-full">
                <svg class="icon-clicked effect-clicked w-4 h-4 md:w-5 md:h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 285.25 284.04" fill="salmon">
                    <path d="M116.87 39.2l-7.77-7.78a13.43 13.43 0 0 0-20 1.18 13.65 13.65 0 0 0 1.34 18l6.17 6.18a23.91 23.91 0 0 1 2.75 2.08 25 25 0 0 1 5-11.17 25.37 25.37 0 0 1 12.51-8.49zm95.83 39.6l-61.87-61.87a13.41 13.41 0 0 0-20 1.19 13.64 13.64 0 0 0 1.34 18l70.92 70.2.23-8.12a25.23 25.23 0 0 1 9.38-19.39zm70.9 97a5.62 5.62 0 0 0 .29-7.64l-12.28-14.28-12.74-92.47c-.197-7.173-6.07-12.886-13.245-12.886S232.577 54.237 232.38 61.4l-.38 12a25.28 25.28 0 0 1 21.78 24.06l12.22 88.3 3.53 4.1zM28.44 42.85c2.706 1.914 6.45 1.27 8.365-1.435s1.27-6.45-1.435-8.365L20.4 22.4a6 6 0 0 0-9.592 4.297A6 6 0 0 0 13.46 32.2zm28.22-21.78L50.2 3.9A6 6 0 1 0 39 8.11l6.46 17.18a6 6 0 1 0 11.23-4.22zM0 60.66a5.94 5.94 0 0 0 5.88 6l18.47.3a6 6 0 0 0 6-5.93 5.83 5.83 0 0 0-5.88-5.92L6 55.02a5.8 5.8 0 0 0-6 5.64zm83.92 149.92c29.57 29.57 60.5 53.32 87.65 59.23a5.76 5.76 0 0 1 2.27 1.05l15.66 12a5.61 5.61 0 0 0 7.38-.48l69.67-69.56a5.62 5.62 0 0 0 .3-7.64l-12.28-14.28-12.74-92.5a13.25 13.25 0 1 0-26.49 0l-.63 21.82a6.14 6.14 0 0 1-6.19 6 6.05 6.05 0 0 1-4.31-1.82l-70.43-70.43a13.42 13.42 0 0 0-20 1.19 13.66 13.66 0 0 0 1.34 18l48.52 48.52a6.45 6.45 0 0 1 0 9.12h0a6.51 6.51 0 0 1-9.23 0L92.05 68.46a13.42 13.42 0 0 0-20 1.18 13.65 13.65 0 0 0 1.34 18l62.08 62.08a6.55 6.55 0 0 1 0 9.25 6.46 6.46 0 0 1-9.11 0L77.58 110.2a13.41 13.41 0 0 0-20 1.18 13.65 13.65 0 0 0 1.34 18l48.35 48.35a6.69 6.69 0 0 1 0 9.46l-.08.08a6.18 6.18 0 0 1-8.74 0l-30-30a14.09 14.09 0 0 0-9.92-4.13 13 13 0 0 0-8.11 2.79 13.41 13.41 0 0 0-1.18 20z"/>
                </svg>
                <p class="ml-2 text-sm">' . $comment->counts_like . ' <span>claps</span></p>
                <div class="clapped-hover">
                    <p class="text-xs">Already applauded.</p>
                    <div class="triangle-up-cmnt"></div>
                </div>
            </a>',
            'cookie' => $value,
        ];

        return $data;
    }

    public function readMore(Comment $comment) {
        return nl2br(e($comment->body));
    }

    public function cmsDelete(Comment $comment)
    {
        $thisComment = Comment::where('id', $comment->id)->first();

        if ($thisComment->replies()) {
            $replies = $thisComment->replies()->get();
        }

        if($replies){
            foreach($replies as $r) {
                if($r->replies()){
                    $this->checkReplies($r);
                }
                $r->delete();
            }
        }
        $thisComment->delete();
        return redirect()->route('comments.index')->with('success', 'You have successfully deleted the comment!');
    }

    public function multipleDelete(Request $request)
    {
        $checked = $request->input('checked',[]);
        $comments = Comment::whereIn('id', $checked)->get();
        foreach ($comments as $comment) {
            if ($comment->replies()) {
                $replies = $comment->replies()->get();
            }
    
            if($replies){
                foreach($replies as $r) {
                    if($r->replies()){
                        $this->checkReplies($r);
                    }
                    $r->delete();
                }
            }
            $comment->delete();
        }
        return redirect()->route('comments.index')->with('success', 'You have successfully deleted the selected comments!');
    }

    public function delete(Request $request) {
        $commentId = Crypt::decryptString($request->commentId);
        $thisComment = Comment::where('id', $commentId)->first();

        if ($thisComment->replies()) {
            $replies = $thisComment->replies()->get();
        }

        if($replies){
            foreach($replies as $r) {
                if($r->replies()){
                    $this->checkReplies($r);
                }
                $r->delete();
            }
        }
        $thisComment->delete();

        $sizeOfCA = Comment::where('post_id', $thisComment->post_id)->where('is_approved', 1)->get();
        // refresh list comment unapproved
        $viewListCU = view('layouts.list_unapproved', [
            'commentUnapproved' => Comment::where('post_id', $thisComment->post_id)->where('is_approved', 0)->orderBy('created_at', 'DESC')->get(),
        ])->render();
        // refresh list comment approved
        $post = Post::where('id', $thisComment->post_id)->first();
        $viewListCA = view('comments.partials.comments_display', [
            'comments' => $post->comments,
            'dataCookie' => $request->dataCookie,
            'post' => $post
        ])->render();
        if ($request->isHome == 'true') {
            $arrPostId = Post::where('user_id', Auth::user()->id)->pluck('id')->toArray();
            $sizeOfAllCU = Comment::whereIn('post_id', $arrPostId)->where('is_approved', 0)->orderBy('created_at', 'DESC')->get();
        } else {
            $sizeOfAllCU = Comment::where('post_id', $post->id)->where('is_approved', 0)->orderBy('created_at', 'DESC')->get();
        }
        $data = ['sizeOfCA' => sizeOf($sizeOfCA), 'sizeOfAllCU' => sizeOf($sizeOfAllCU), 'viewListCU' => $viewListCU, 'viewListCA' => $viewListCA];
        return $data;
    }

    // check replies and delete
    public function checkReplies($r) {
        $replies = $r->replies()->get();
        foreach($replies as $r) {
            if($r->replies()){
                $this->checkReplies($r);
            }
            $r->delete();
        }
    }

    public function viewCUnapproved(Comment $comment, Request $request) {
        $post = Post::where('id', $comment->post_id)->first();
        $viewComment = view('comments.partials.comments_display', [
            'viewCU' => $comment->id,
            'comments' => $post->comments,
            'dataCookie' => $request->dataCookie,
            'post' => $post
        ])->render();
        $data = ['viewComment' => $viewComment];
        return $data;
    }

    public function approveComment(Request $request) {
        // enkripsi commentID
        $commentId = Crypt::decryptString($request->commentId);
        // select comment update is approved
        $comment = Comment::where('id', $commentId)->first();
        $comment->update(['is_approved' => true]);
        if ($request->withoutLink) {
            $comment->update(['user_link' => NULL]);
        }
        // tangkap post untuk view comment
        $post = Post::where('id', $comment->post_id)->first();
        $viewComment = view('comments.partials.comments_display', [
            'comments' => $post->comments,
            'dataCookie' => $request->dataCookie,
            'post' => $post
        ])->render();
        // data size comment CA & CU
        if ($request->isHome == 'true') {
            $arrPostId = Post::where('user_id', Auth::user()->id)->pluck('id')->toArray();
            $sizeOfAllCU = Comment::whereIn('post_id', $arrPostId)->where('is_approved', 0)->orderBy('created_at', 'DESC')->get();
        } else {
            $sizeOfAllCU = Comment::where('post_id', $post->id)->where('is_approved', 0)->orderBy('created_at', 'DESC')->get();
        }
        $sizeOfAllCA = Comment::where('post_id', $comment->post_id)->where('is_approved', 1)->get();
        // view comment approved
        $viewAjax = view('comments.partials.comment_ajax', [
            'comment' => $comment,
            'post_id' => $comment->post_id,
        ])->render();
        // refresh view list comment unapproved
        $viewListCU = view('layouts.list_unapproved', [
            'commentUnapproved' => Comment::where('post_id', $comment->post_id)->where('is_approved', 0)->orderBy('created_at', 'DESC')->get(),
        ])->render();

        $data = ['viewComment' => $viewComment, 'sizeOfAllCU' => sizeof($sizeOfAllCU), 'viewAjax' => $viewAjax, 'viewListCU' => $viewListCU, 'sizeOfAllCA' => sizeof($sizeOfAllCA)];
        return $data;
    }

    // function validation
    private function validateRequest(Request $request) {
        if ($request->user_link) {
            $request->validate([
                'user_link' => 'url'
            ], [
                'user_link.url' => 'The link format is invalid!',
            ]);
        }
        $request->validate([
            'name' => 'required|max:20|regex:/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/',
            'email' => ['required', 'string', 'email', 'max:255', new FakeEmail],
            'body' => 'required',
        ], [
            // Membuat rules message alert
            'name.required' => 'Please enter your name.',
            'name.max' => 'Your name is too long.',
            'name.regex' => 'Please enter your name with letters and numbers only.',
            'email.required' => 'Please enter your email.',
            'email.email' => 'Please enter a valid email address.',
            'body.required' => 'Please enter your comment.',
        ]);
    }
}
