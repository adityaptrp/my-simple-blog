
<div class="c-list-unapproved hidden">
    <div class="c-content-lu">
        <div class="content-lu w-90vw sm:w-128 rounded-md">
            {{-- title --}}
            <div class="title-cu flex items-center justify-between px-6 py-3 rounded-t-md">
                <div class="flex items-center text-white text-xs xs:text-sm sm:text-b_base">
                    <i class="fas fa-comment-dots"></i>
                    <h1 class="t-cu-size font-bold ml-2">{{ request()->is('/') || request()->is('reading-list') ? 'All Comment Unapproved' : 'Comment Unapproved This Post' }} ({{ sizeOf($commentUnapproved) }})</h1>
                </div>
                <svg class="close-cu w-5 h-5 cursor-pointer text-white" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path class="block" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>

            {{-- List comment --}}
            <div class="all-list-cu rounded-b-md">
                @foreach ($commentUnapproved as $i => $cu)
                    <div class="list-cu flex items-center px-6 py-3 @if ($i < $commentUnapproved->count()-1) border-b @endif  @if ($i == $commentUnapproved->count()-1) rounded-b-md @endif">
                        {{-- img --}}
                        <a href="{{ route('posts.show', ['user'=>$cu->post->user->username,'post'=>$cu->post->slug]) }}" class="goViewCU" data-comment-id="{{ $cu->id }}">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 relative">
                                <img class="w-full h-full rounded-full" src="{{ "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $cu->email ) ) ) . "?d=monsterid&s=150" }}">
                                <div class="img-cu-ab text-xxs sm:text-xs"><i class="far fa-comment-dots"></i></div>
                            </div>
                        </a>
                        {{-- text content --}}
                        <div class="flex flex-col flex-grow ml-6">
                            <div class="title-lcu sm:flex sm:items-center text-sm sm:text-b_base">
                                <a @if ($cu->user_link) href="{{ $cu->user_link }}" target="blank" @endif class="inline-block font-semibold mr-2" @if($cu->user_link)  style="color: #48bb78;" @endif>{{ $cu->name }}</a>
                                <h3 class="inline-block text-xxs sm:text-xs font-semibold italic">&#8212; {{ $cu->created_at->diffForHumans(null, true) }}</h3>
                            </div>
                            <h2 class="email-cu-dark text-xxs sm:text-xs font-semibold">{{ $cu->email }}</h2>
                            {{-- body --}}
                            <a href="{{ route('posts.show', ['user'=>$cu->post->user->username,'post'=>$cu->post->slug]) }}" class="goViewCU text-xs sm:text-sm" data-comment-id="{{ $cu->id }}">{!! Str::limit($cu->body, 100, '...') !!}</a>
                            <div class="font-semibold text-xxs sm:text-xs mt-1">
                                <div class="approve-comment-l cursor-pointer inline-block mr-2 text-blue-500" data-comment-id="{{ Crypt::encryptString($cu->id) }}" @if (request()->is('/')) data-is-home="true" @endif>Aprrove</div>
                                @if ($cu->user_link)
                                    <div class="approve-cwl-l cursor-pointer inline-block mr-2 text-yellow-500" data-comment-id="{{ Crypt::encryptString($cu->id) }}">Without Link</div>
                                @endif
                                <div class="delete-cu cursor-pointer inline-block mr-2 text-red-500" data-comment-id="{{ Crypt::encryptString($cu->id) }}" @if (request()->is('/')) data-is-home="true" @endif>Delete</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="empty-cu hidden flex-col justify-center items-center h-60vh text-sm text-center text-gray-600">
                <svg class="mb-6 w-16 h-16 text-gray-100" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 172 172">
                    <g fill="currentColor"><path d="M150.5 63.156L86 40.313 21.5 63.156v80.625L86 166.625l64.5-22.844z"/><path d="M150.5 63.156L86 40.313 21.5 63.156v80.625L86 166.625l64.5-22.844z"/><path d="M21.5 63.156L5.375 90.03l64.5 22.844L86 86zm129 0L86 40.313"/></g><g fill="#5d6574"><path d="M86 90.03c-1.612 0-3.225-1.075-3.763-2.687-.806-2.15.403-4.434 2.42-5.106l64.5-22.844c2.15-.806 4.434.403 5.106 2.42.806 2.15-.403 4.434-2.42 5.106l-64.5 22.844c-.403.134-.94.27-1.344.27z"/><path d="M86 170.656c-.806 0-1.612-.27-2.284-.672-1.075-.806-1.747-2.016-1.747-3.36v-38.028c0-2.284 1.747-4.03 4.03-4.03s4.03 1.747 4.03 4.03v32.384l56.438-20.022V63.156c0-2.284 1.747-4.03 4.03-4.03s4.03 1.747 4.03 4.03v80.625c0 1.747-1.075 3.225-2.687 3.762l-64.5 22.844c-.403.134-.94.27-1.344.27z"/></g><path d="M150.5 63.156L86 40.313m64.5 22.844L86 40.313M86 86L21.5 63.156" fill="currentColor"/><path d="M17.47 143.78c0 1.747 1.075 3.225 2.688 3.762l64.5 22.844c.403.134.94.27 1.344.27 1.612 0 3.225-1.075 3.763-2.687.806-2.15-.403-4.434-2.42-5.106L25.53 140.96V97.153L17.47 94.33z" fill="#5d6574"/><path d="M166.625 90.03l-64.5 22.844L86 86l64.5-22.844z" fill="currentColor"/><path d="M170.12 88.016L153.994 61.14l-.134-.134c0-.134-.134-.134-.134-.27-.134-.134-.134-.27-.27-.27l-.27-.27c-.134-.134-.27-.134-.403-.27-.134 0-.134-.134-.27-.134-.27-.134-.403-.27-.672-.27h0l-64.5-22.844c-.27-.134-.537-.134-.806-.134h-1.075c-.27 0-.537.134-.806.134l-64.5 22.844s-.134 0-.134.134h0c-.134.134-.403.134-.538.27h0c-.27.134-.538.403-.806.672h0l-.134.134c-.134.134-.134.27-.27.27h0l-.134.134L2.016 88.016c-.672.94-.806 2.284-.403 3.36s1.344 2.016 2.42 2.42l64.5 22.844c.403.134.94.27 1.344.27 1.344 0 2.688-.672 3.494-2.016L86 93.794l12.63 21.097c.806 1.344 2.15 2.016 3.494 2.016.403 0 .94-.134 1.344-.27l64.5-22.844c1.075-.403 2.016-1.344 2.42-2.42s.27-2.42-.27-3.36zM90.03 45.956l48.375 17.2-48.375 17.2zm-21.903 62.08L11.422 87.88l11.96-19.888L80.088 88.15zm35.744 0L91.913 88.15l56.706-20.156 11.96 19.888z" fill="#5d6574"/>
                </svg>
                <p>There are currently no unapproved</p>
                <p>responses for all stories.</p>
            </div>
        </div>
    </div>
    <div class="fade-list-unapproved"></div>
</div>