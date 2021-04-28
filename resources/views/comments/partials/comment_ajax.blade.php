

{{-- comment Display --}}
{{-- <div> --}}
    <div class="{{ Auth::user() ? '' : 'list-comment-new mt-5' }} @if(!$comment->parent_id) new-c-hr @endif py-5 -mx-6 px-6  @if($comment->parent_id != null) replies-comment-parent -mr-6 @endif" data-comment-id="{{ $comment->id }}">
        {{-- profile --}}
        <div class="flex justify-between">
            <div class="flex items-center">
                <a @if ($comment->user_link) href="{{ $comment->user_link }}" target="blank" @endif class="relative inline-block">
                    <svg class="w-10 h-10 md:w-10 md:h-10 text-green-600" viewBox="0 0 36 36">
                        <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M18 1.87c-6.63 0-12.4 4.14-15.21 10.21L2 11.71C4.94 5.37 11 1 18 1s13.06 4.37 16 10.71l-.79.37C30.4 6.01 24.63 1.88 18 1.88zM2.79 23.92c2.81 6.07 8.58 10.2 15.21 10.2 6.63 0 12.4-4.13 15.21-10.2l.79.37C31.06 30.63 25 35 18 35S4.94 30.63 2 24.29l.79-.37z"></path></svg>
                    <div class="absolute bottom-0 w-full h-full flex justify-center items-center">
                        <img class="show-profile-img rounded-full" src="{{ $comment->gravatar() }}">
                    </div>
                </a>
                <div class="txt-profile-comment flex flex-col text-sm ml-2">
                    <div class="flex items-center">
                        <a class="font-bold {{ $comment->user_link ? 'text-green-500' : '' }}" @if ($comment->user_link) href="{{ $comment->user_link }}" target="blank" @endif>{{ $comment->name }}</a>
                        @if ($comment->email == $post->user->email)
                            <span class="status ml-1 author rounded-sm">Author</span>
                        @else
                            <span class="status ml-1 you rounded-sm">You</span>
                        @endif
                        <span class="text-0.5sm ml-1">Says :</span>
                    </div>
                    <h2 class="text-0.5sm">{{ $comment->created_at->format('d M Y') }} at {{ $comment->created_at->format('h:i a') }}</h2>
                </div>
            </div>
            <div class="dd-delete text-lg cursor-pointer">
                <i class="fas fa-ellipsis-h"></i>
                <div>
                    <p class="btn-delete hover:text-red-500" data-comment-id="{{ Crypt::encryptString($comment->id) }}">Delete</p>
                </div>
            </div>
        </div>
        {{-- body --}}
        @if ($comment->is_approved == 0)
            <div class="message-unapproved mt-4 -mb-2 text-0.5sm text-gray-500 italic">
                <p>Your comment is awaiting moderation. This is a preview, your comment will be visible after it has been approved.</p>
            </div>
        @endif
        {{-- selected text --}}
        @if ($comment->selected_text)
            <div class="selected-txt-cmt ajax-cmnt show-text-selected border mt-5 mb-3 py-3 px-3.5 rounded">
                <span class="text-base">{{ $comment->selected_text }}</span>
                <input type="hidden" name="selected_text" value="">
            </div>
        @endif
        <div class="text-b_base mt-4">
            <?php 
                $keyword = stristr($comment->body, 'http://') ?: stristr($comment->body, 'https://') ?: stristr($comment->body, 'www.');
                $body = str_replace($keyword,'<a href="'. $keyword .'" class="text-blue-500 inline" target="blank">'. $keyword .'</a>',$comment->body);
            ?>
            <p>{!! nl2br($body) !!}</p>
        </div>
        {{-- footer --}}
        <div class="mt-4 flex items-center relative">
            {{-- like --}}
            @if (isset($dataCookie))
                <?php $arr = array_unique(explode('/', $dataCookie)); ?>
            @else
                <?php $arr = array_unique(explode('/', Cookie::get('comment_clapped'))); ?>
            @endif
            @if (in_array($comment->id, $arr))
                <a class="cmnt-clapped flex items-center cursor-pointer h-full">
                    <svg class="w-4 h-4 md:w-5 md:h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 285.25 284.04" fill="salmon">
                        <path d="M116.87 39.2l-7.77-7.78a13.43 13.43 0 0 0-20 1.18 13.65 13.65 0 0 0 1.34 18l6.17 6.18a23.91 23.91 0 0 1 2.75 2.08 25 25 0 0 1 5-11.17 25.37 25.37 0 0 1 12.51-8.49zm95.83 39.6l-61.87-61.87a13.41 13.41 0 0 0-20 1.19 13.64 13.64 0 0 0 1.34 18l70.92 70.2.23-8.12a25.23 25.23 0 0 1 9.38-19.39zm70.9 97a5.62 5.62 0 0 0 .29-7.64l-12.28-14.28-12.74-92.47c-.197-7.173-6.07-12.886-13.245-12.886S232.577 54.237 232.38 61.4l-.38 12a25.28 25.28 0 0 1 21.78 24.06l12.22 88.3 3.53 4.1zM28.44 42.85c2.706 1.914 6.45 1.27 8.365-1.435s1.27-6.45-1.435-8.365L20.4 22.4a6 6 0 0 0-9.592 4.297A6 6 0 0 0 13.46 32.2zm28.22-21.78L50.2 3.9A6 6 0 1 0 39 8.11l6.46 17.18a6 6 0 1 0 11.23-4.22zM0 60.66a5.94 5.94 0 0 0 5.88 6l18.47.3a6 6 0 0 0 6-5.93 5.83 5.83 0 0 0-5.88-5.92L6 55.02a5.8 5.8 0 0 0-6 5.64zm83.92 149.92c29.57 29.57 60.5 53.32 87.65 59.23a5.76 5.76 0 0 1 2.27 1.05l15.66 12a5.61 5.61 0 0 0 7.38-.48l69.67-69.56a5.62 5.62 0 0 0 .3-7.64l-12.28-14.28-12.74-92.5a13.25 13.25 0 1 0-26.49 0l-.63 21.82a6.14 6.14 0 0 1-6.19 6 6.05 6.05 0 0 1-4.31-1.82l-70.43-70.43a13.42 13.42 0 0 0-20 1.19 13.66 13.66 0 0 0 1.34 18l48.52 48.52a6.45 6.45 0 0 1 0 9.12h0a6.51 6.51 0 0 1-9.23 0L92.05 68.46a13.42 13.42 0 0 0-20 1.18 13.65 13.65 0 0 0 1.34 18l62.08 62.08a6.55 6.55 0 0 1 0 9.25 6.46 6.46 0 0 1-9.11 0L77.58 110.2a13.41 13.41 0 0 0-20 1.18 13.65 13.65 0 0 0 1.34 18l48.35 48.35a6.69 6.69 0 0 1 0 9.46l-.08.08a6.18 6.18 0 0 1-8.74 0l-30-30a14.09 14.09 0 0 0-9.92-4.13 13 13 0 0 0-8.11 2.79 13.41 13.41 0 0 0-1.18 20z"/>
                    </svg>
                    <p class="ml-2 text-sm">{{ $comment->counts_like }} <span>claps</span></p>
                    <div class="clapped-hover">
                        <p class="text-xs font-semibold">Already applauded.</p>
                        <div class="triangle-up-cmnt"></div>
                    </div>
                </a>
            @else
                <a class="clap-comment flex items-center cursor-pointer h-full">
                    <svg class="w-3.5 h-3.5 md:w-4.5 md:h-4.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 297.2 297.2" fill="currentColor">
                        <path d="M28.4 43.4c1.1.7 2.3 1.1 3.5 1.1 1.9 0 3.7-.9 4.9-2.5 1.9-2.7 1.3-6.5-1.4-8.4L20.4 23c-2.7-1.9-6.4-1.3-8.4 1.4s-1.3 6.4 1.4 8.4l15 10.6zm28.3-21.7L50.2 4.5C49 1.4 45.6-.2 42.5 1S37.8 5.6 39 8.7l6.5 17.2c.9 2.4 3.2 3.9 5.6 3.9.7 0 1.4-.1 2.1-.4 3.1-1.2 4.6-4.6 3.5-7.7zM0 61.3c-.1 3.3 2.6 6 5.9 6l18.5.3c3.3 0 5.9-2.7 6-5.9.1-3.3-2.6-5.9-5.9-5.9L6 55.6c-3.3 0-5.9 2.4-6 5.7zm33.4 104.3c-.4 7.2 2.3 14.3 7.4 19.4l34.6 34.6c16.4 16.4 32 29.8 46.3 39.8 16.5 11.5 31.9 19 45.9 22.3l14.5 11.2c3.1 2.3 6.9 3.6 10.7 3.6 4.7 0 9.1-1.8 12.4-5.1l69.7-69.6c6-6 6.8-15.3 2.2-22.2l14.8-14.8c6.5-6.5 6.9-17 .9-24l-10-11.6L270.9 61c-.5-13.5-11.6-24.3-25.2-24.3-13.9 0-25.1 11.2-25.2 25l-.2 8.1-61-60.8c-4.8-4.8-11.2-7.4-17.9-7.4h0c-7.8 0-15.1 3.5-19.9 9.6a25.2 25.2 0 0 0-5 11.2c-4.6-4.1-10.5-6.3-16.8-6.3-7.8 0-15.1 3.5-19.9 9.6-6.4 8.1-7 19.1-2.2 27.9-5.8 1.2-11 4.4-14.8 9.1-7 8.8-7.1 21.1-.8 30.3.3.8.7 1.6 1.1 2.3-5.8 1.2-11 4.3-14.8 9.1-8 10.1-7 24.7 2.3 34l2.4 2.4c.2.5.5.9.7 1.4-3.8.8-7.5 2.4-10.6 4.9-5.8 4.5-9.3 11.3-9.7 18.5zm83.5-125.8c-4.9 1.5-9.2 4.4-12.5 8.5a25.2 25.2 0 0 0-5 11.2c-.9-.8-1.8-1.4-2.7-2.1l-6.2-6.2c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l7.7 7.8zm95.8 39.6c-5.7 4.6-9.3 11.6-9.4 19.4l-.2 8.1-70.9-70.2c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l61.8 61.9zm56.8 111.1l-3.5-4.1-12.1-88.3C253.4 85.7 244 75.6 232 74l.3-12c0-7.3 6-13.2 13.2-13.2 7.3 0 13.2 6 13.2 13.2l12.7 92.5 12.3 14.3c1.9 2.2 1.8 5.6-.3 7.6l-13.9 14.1zm-219-33.9c2.4-1.9 5.2-2.8 8.1-2.8a14.01 14.01 0 0 1 9.9 4.1l30 30c1.2 1.2 2.8 1.8 4.4 1.8s3.2-.6 4.4-1.8l.1-.1c2.6-2.6 2.6-6.8 0-9.5L58.9 130c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l48.8 48.8c1.3 1.3 2.9 1.9 4.6 1.9 1.6 0 3.3-.6 4.6-1.9 2.6-2.6 2.6-6.7 0-9.2L73.4 88.3c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l62.4 62.4c1.3 1.3 2.9 1.9 4.6 1.9s3.3-.6 4.6-1.9h0a6.46 6.46 0 0 0 0-9.1l-48.5-48.5c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l70.4 70.4c1.3 1.3 2.8 1.8 4.3 1.8 3.1 0 6.1-2.4 6.2-6l.6-21.8c0-7.3 6-13.2 13.2-13.2 7.3 0 13.2 6 13.2 13.2l12.7 92.5 12.3 14.3c1.9 2.2 1.8 5.6-.3 7.6L196.9 283c-1.1 1.1-2.5 1.6-4 1.6a5.43 5.43 0 0 1-3.4-1.2l-15.7-12c-.7-.5-1.4-.9-2.3-1-27.2-5.9-58.1-29.7-87.7-59.2l-34.6-34.6c-5.5-5.6-5.1-15 1.3-20z"/>
                    </svg>
                    <p class="ml-2 text-sm">{{ $comment->counts_like }} <span>Claps</span></p>
                </a>
            @endif
            @if (Auth::user())
                <a class="show-form-reply flex items-center ml-3 text-sm cursor-pointer">
                    <i class="fas fa-reply"></i>
                    <p class="ml-2 text-reply-comment">Reply</p>
                </a>
            @else
                <a class="reset-reply-txt text-gray-500 flex items-center ml-3 text-sm cursor-not-allowed">
                    <i class="fas fa-reply"></i>
                    <p class="ml-2">Reply</p>
                </a>
            @endif
        </div>
    
        {{-- Form reply --}}
        <form class="form-reply-comment hidden mt-4 text-sm bg-white" autocomplete="off">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <div class="{{ Auth::user() ? '' : 'form-header-reply' }}">
                <div class="flex items-center">
                    <img class="w-9 h-9 rounded-full" src="https://www.gravatar.com/avatar/{{ md5( strtolower( trim( 'qwertyuiop1234@gmail.com' ) ) ) }}?d=mp&s=150" alt="">
                    <div class="flex flex-col text-0.5sm w-full pr-5">
                        <input class="w-full ml-2 flex-grow outline-none @if(Auth::user()) bg-white @endif" type="text" name="name" id="name" placeholder="Your Name" @if(Auth::user()) value="{{Auth::user()->getShortName()}}" disabled @endif>
                        <input class="w-full ml-2 flex-grow outline-none @if(Auth::user()) bg-white @endif" type="text" name="email" id="email" placeholder="example@gmail.com" @if(Auth::user()) value="{{Auth::user()->email}}" disabled @endif>
                    </div>
                    <div class="btn-add-link w-6 h-6 cursor-pointer text-sm">
                        <i class="fas fa-plus"></i>
                        <span class="font-semibold">Add your website</span>
                    </div>
                </div>
            {{-- </div> --}}
            <textarea class="input-comment-reply mt-6 text-sm" name="body" rows="1" placeholder="What are your thought ?"></textarea>
            <input class="input-user-link hidden w-full outline-none" type="text" name="user_link" placeholder="www.example.com">
            <div class="btn-reply mt-5">
                <div class="w-full flex justify-end items-center text-sm">
                    <button type="submit" name="">Submit</button>
                </div>
            </div>
        </form>
        {{-- Error message --}}
        {{-- Error message reply langsung dari javascript gara2 ada error gajelas --}}
    </div>
{{-- </div> --}}

