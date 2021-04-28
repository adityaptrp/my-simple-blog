

{{-- Comment --}}
<div class="comment-post fixed top-0 right-0 overflow-auto">
    <div class="px-6 pt-5 h-full">
        <div class="flex justify-between items-center">
            <h1 class="responses-comment text-lg font-bold">Responses ({{ sizeOf($sizeOfComment) }})</h1>
            <svg class="btn-close-comment w-5 h-5 cursor-pointer" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path class="block" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </div>
        <form class="form-comment mt-5 text-sm mb-5" autocomplete="off">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <div class="form-header-comment {{ Auth::user() ? '' : 'reset-val-main-form' }} hidden mb-6">
                <div class="flex">
                    <img class="w-9 h-9 rounded-full" src="https://www.gravatar.com/avatar/{{ md5( strtolower( trim( 'qwertyuiop1234@gmail.com' ) ) ) }}?d=mp&s=150" alt="">
                    <div class="flex flex-col text-0.5sm w-full pr-10">
                        <input class="w-full ml-2 flex-grow outline-none @if(Auth::user()) bg-white @endif" type="text" name="name" id="name" placeholder="Your Name" @if(Auth::user()) value="{{Auth::user()->getShortName()}}" disabled @endif>
                        <input class="w-full ml-2 flex-grow outline-none @if(Auth::user()) bg-white @endif" type="text" name="email" id="email" placeholder="example@gmail.com" @if(Auth::user()) value="{{Auth::user()->email}}" disabled @endif>
                    </div>
                    <div class="btn-add-link w-6 h-6 cursor-pointer text-xs">
                        <i class="fas fa-plus"></i>
                        <span class="font-semibold">Add your website</span>
                    </div>
                </div>
            </div>
            <textarea class="input-comment text-sm" name="body" rows="1" placeholder="What are your thought ?"></textarea>
            <input class="input-user-link hidden w-full outline-none mt-1" type="text" name="user_link" placeholder="www.example.com">
            <div class="btn-comment hidden">
                <div class="w-full flex justify-end items-center text-sm mt-5">
                    <p class="btn-cancel-comment mr-3 cursor-pointer">Cancel</p>
                    <button type="submit">Submit</button>
                </div>
            </div>
        </form>

        {{-- Error message --}}
        {{-- Error message reply langsung dari javascript gara2 ada error gajelas --}}
    
        <div class="all-comment">
            {{-- List Comments --}}
            @include('comments.partials.comments_display', ['comments' => $post->comments, 'post_id' => $post->id])
        </div>

        {{-- message no comment --}}
        <div class="empty-comment hidden h-75% text-sm text-center">
            <svg class="mb-6 w-16 h-16" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 172 172">
                <g fill="currentColor"><path d="M150.5 63.156L86 40.313 21.5 63.156v80.625L86 166.625l64.5-22.844z"/><path d="M150.5 63.156L86 40.313 21.5 63.156v80.625L86 166.625l64.5-22.844z"/><path d="M21.5 63.156L5.375 90.03l64.5 22.844L86 86zm129 0L86 40.313"/></g><g fill="#5d6574"><path d="M86 90.03c-1.612 0-3.225-1.075-3.763-2.687-.806-2.15.403-4.434 2.42-5.106l64.5-22.844c2.15-.806 4.434.403 5.106 2.42.806 2.15-.403 4.434-2.42 5.106l-64.5 22.844c-.403.134-.94.27-1.344.27z"/><path d="M86 170.656c-.806 0-1.612-.27-2.284-.672-1.075-.806-1.747-2.016-1.747-3.36v-38.028c0-2.284 1.747-4.03 4.03-4.03s4.03 1.747 4.03 4.03v32.384l56.438-20.022V63.156c0-2.284 1.747-4.03 4.03-4.03s4.03 1.747 4.03 4.03v80.625c0 1.747-1.075 3.225-2.687 3.762l-64.5 22.844c-.403.134-.94.27-1.344.27z"/></g><path d="M150.5 63.156L86 40.313m64.5 22.844L86 40.313M86 86L21.5 63.156" fill="currentColor"/><path d="M17.47 143.78c0 1.747 1.075 3.225 2.688 3.762l64.5 22.844c.403.134.94.27 1.344.27 1.612 0 3.225-1.075 3.763-2.687.806-2.15-.403-4.434-2.42-5.106L25.53 140.96V97.153L17.47 94.33z" fill="#5d6574"/><path d="M166.625 90.03l-64.5 22.844L86 86l64.5-22.844z" fill="currentColor"/><path d="M170.12 88.016L153.994 61.14l-.134-.134c0-.134-.134-.134-.134-.27-.134-.134-.134-.27-.27-.27l-.27-.27c-.134-.134-.27-.134-.403-.27-.134 0-.134-.134-.27-.134-.27-.134-.403-.27-.672-.27h0l-64.5-22.844c-.27-.134-.537-.134-.806-.134h-1.075c-.27 0-.537.134-.806.134l-64.5 22.844s-.134 0-.134.134h0c-.134.134-.403.134-.538.27h0c-.27.134-.538.403-.806.672h0l-.134.134c-.134.134-.134.27-.27.27h0l-.134.134L2.016 88.016c-.672.94-.806 2.284-.403 3.36s1.344 2.016 2.42 2.42l64.5 22.844c.403.134.94.27 1.344.27 1.344 0 2.688-.672 3.494-2.016L86 93.794l12.63 21.097c.806 1.344 2.15 2.016 3.494 2.016.403 0 .94-.134 1.344-.27l64.5-22.844c1.075-.403 2.016-1.344 2.42-2.42s.27-2.42-.27-3.36zM90.03 45.956l48.375 17.2-48.375 17.2zm-21.903 62.08L11.422 87.88l11.96-19.888L80.088 88.15zm35.744 0L91.913 88.15l56.706-20.156 11.96 19.888z" fill="#5d6574"/>
            </svg>
            <p>There are currently no responses for this story.</p>
            <p>Be the first to respond.</p>
        </div>
    </div>
</div>
<div class="fade-effect-comment"></div>
<input id="dataCookie" type="hidden" data-cookie="{{Cookie::get('comment_clapped')}}">