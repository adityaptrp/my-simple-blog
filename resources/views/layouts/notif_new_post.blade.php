
<div class="notif-n-post close-panel hidden" data-ip="{{ $new_post->id }}">
    <div class="c-notif-np rounded-md">
        {{-- header --}}
        <div class="h-notif-np flex items-center px-4 py-3 border-b rounded-t-md z-10 relative">
            <div class="flex">
                <div class="w-2.5 h-2.5 sm:w-3 sm:h-3 ml-1 sm:ml-2 rounded-full"></div>
                <div class="w-2.5 h-2.5 sm:w-3 sm:h-3 ml-1 sm:ml-2 rounded-full"></div>
                <div class="w-2.5 h-2.5 sm:w-3 sm:h-3 ml-1 sm:ml-2 rounded-full"></div>
            </div>
            <div class="t-np-alert text-xs sm:text-sm mx-3.5 sm:mx-10 flex flex-grow items-center justify-center box-shadow-sm py-2 border rounded-md">The latest post is here!</div>
            <div class="px-1 lg:px-3">
                <svg class="close-notif-np w-5 h-5 cursor-pointer text-gray-600" fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path class="block" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
        </div>
        {{-- Body --}}
        <div class="body-notif-np flex flex-col lg:flex-row z-2">
            {{-- left Content --}}
            <div class="left-notif-np w-100% lg:w-50% h-48 sm:h-40 md:h-48 lg:h-100% relative rounded-bl-md">
                <img class="w-full h-full object-cover object-center lg:rounded-bl-md" src="{{ $new_post->getThumbnail() }}" alt="{{ $new_post->title }}">
                {{-- profile --}}
                <div class="profile-img-np hidden lg:flex justify-between mt-3">
                    <div class="flex items-center">
                        <a href="{{ route('profile.show', $new_post->user->username) }}" class="relative inline-block">
                            <svg class="w-10 h-10 md:w-10 md:h-10 text-green-600" viewBox="0 0 36 36">
                                <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M18 1.87c-6.63 0-12.4 4.14-15.21 10.21L2 11.71C4.94 5.37 11 1 18 1s13.06 4.37 16 10.71l-.79.37C30.4 6.01 24.63 1.88 18 1.88zM2.79 23.92c2.81 6.07 8.58 10.2 15.21 10.2 6.63 0 12.4-4.13 15.21-10.2l.79.37C31.06 30.63 25 35 18 35S4.94 30.63 2 24.29l.79-.37z"></path></svg>
                            <div class="absolute bottom-0 w-full h-full flex justify-center items-center">
                                <img class="show-profile-img rounded-full" src="{{ $new_post->user->profile_picture != null ? $new_post->user->getProfilePicture() : $new_post->user->gravatar() }}" alt="{{ $new_post->user->name }}">
                            </div>
                        </a>
                        <div class="flex flex-col ml-2">
                            <a href="{{ route('profile.show', $new_post->user->username) }}" class="text-gray-400 text-xs xs:text-sm tracking-wide">{{ $new_post->user->name }}</a>
                            <a class="text-xxs xs:text-xs text-gray-500 tracking-wide">{{ $new_post->created_at->format('M d, Y') }} @if ($new_post->checkPopularPost()) &#9733; @endif</a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <p class="mr-2 text-xs text-gray-500">{{ $new_post->likes_count }}</p>
                        <i class="far fa-eye text-gray-500"></i>
                    </div>
                </div>
            </div>
            
            {{-- Right content --}}
            <div class="right-notif-np w-100% lg:w-50% flex flex-col justify-center flex-grow p-5 overflow-auto">
                {{-- title --}}
                <h1 class="title-notif-np text-1.5xl font-black leading-7">{{ Str::limit($new_post->title, 50, '...') }}</h1>
                <hr class="mt-3">
                {{-- profile --}}
                <div class="flex lg:hidden justify-between mt-3">
                    <div class="flex items-center">
                        <a href="{{ route('profile.show', $new_post->user->username) }}" class="relative inline-block">
                            <svg class="w-10 h-10 md:w-10 md:h-10 text-green-600" viewBox="0 0 36 36">
                                <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M18 1.87c-6.63 0-12.4 4.14-15.21 10.21L2 11.71C4.94 5.37 11 1 18 1s13.06 4.37 16 10.71l-.79.37C30.4 6.01 24.63 1.88 18 1.88zM2.79 23.92c2.81 6.07 8.58 10.2 15.21 10.2 6.63 0 12.4-4.13 15.21-10.2l.79.37C31.06 30.63 25 35 18 35S4.94 30.63 2 24.29l.79-.37z"></path></svg>
                            <div class="absolute bottom-0 w-full h-full flex justify-center items-center">
                                <img class="show-profile-img rounded-full" src="{{ $new_post->user->gravatar() }}">
                            </div>
                        </a>
                        <div class="flex flex-col ml-2">
                            <a href="#" class="text-xs xs:text-sm tracking-wide">{{ $new_post->user->name }}</a>
                            <a href="#" class="text-xxs xs:text-xs text-gray-600 tracking-wide">{{ $new_post->created_at->format('M d, Y') }} &#9733;</a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <p class="mr-2 text-xs">{{ $new_post->likes_count }}</p>
                        <i class="far fa-eye text-gray-700"></i>
                    </div>
                </div>
                {{-- body text in LG --}}
                <div class="hidden md:block mt-3 text-sm sm:text-base">
                    {!! Str::limit($new_post->header, 210, '...') !!}
                </div>
                {{-- body text in SM --}}
                <div class="block md:hidden mt-3 text-sm sm:text-base">
                    {!! Str::limit($new_post->header, 170, '...') !!}
                </div>
                {{-- Btn readmore --}}
                <hr class="mt-4">
                <div class="flex items-center justify-between mt-4">
                    <div class="all-icon-p flex">
                        <a href="{{ route('posts.show', ['user'=>$new_post->user->username,'post'=>$new_post->slug]) }}" class="auto-like flex items-center cursor-pointer h-full">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 297.2 297.2" fill="currentColor">
                                <path d="M28.4 43.4c1.1.7 2.3 1.1 3.5 1.1 1.9 0 3.7-.9 4.9-2.5 1.9-2.7 1.3-6.5-1.4-8.4L20.4 23c-2.7-1.9-6.4-1.3-8.4 1.4s-1.3 6.4 1.4 8.4l15 10.6zm28.3-21.7L50.2 4.5C49 1.4 45.6-.2 42.5 1S37.8 5.6 39 8.7l6.5 17.2c.9 2.4 3.2 3.9 5.6 3.9.7 0 1.4-.1 2.1-.4 3.1-1.2 4.6-4.6 3.5-7.7zM0 61.3c-.1 3.3 2.6 6 5.9 6l18.5.3c3.3 0 5.9-2.7 6-5.9.1-3.3-2.6-5.9-5.9-5.9L6 55.6c-3.3 0-5.9 2.4-6 5.7zm33.4 104.3c-.4 7.2 2.3 14.3 7.4 19.4l34.6 34.6c16.4 16.4 32 29.8 46.3 39.8 16.5 11.5 31.9 19 45.9 22.3l14.5 11.2c3.1 2.3 6.9 3.6 10.7 3.6 4.7 0 9.1-1.8 12.4-5.1l69.7-69.6c6-6 6.8-15.3 2.2-22.2l14.8-14.8c6.5-6.5 6.9-17 .9-24l-10-11.6L270.9 61c-.5-13.5-11.6-24.3-25.2-24.3-13.9 0-25.1 11.2-25.2 25l-.2 8.1-61-60.8c-4.8-4.8-11.2-7.4-17.9-7.4h0c-7.8 0-15.1 3.5-19.9 9.6a25.2 25.2 0 0 0-5 11.2c-4.6-4.1-10.5-6.3-16.8-6.3-7.8 0-15.1 3.5-19.9 9.6-6.4 8.1-7 19.1-2.2 27.9-5.8 1.2-11 4.4-14.8 9.1-7 8.8-7.1 21.1-.8 30.3.3.8.7 1.6 1.1 2.3-5.8 1.2-11 4.3-14.8 9.1-8 10.1-7 24.7 2.3 34l2.4 2.4c.2.5.5.9.7 1.4-3.8.8-7.5 2.4-10.6 4.9-5.8 4.5-9.3 11.3-9.7 18.5zm83.5-125.8c-4.9 1.5-9.2 4.4-12.5 8.5a25.2 25.2 0 0 0-5 11.2c-.9-.8-1.8-1.4-2.7-2.1l-6.2-6.2c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l7.7 7.8zm95.8 39.6c-5.7 4.6-9.3 11.6-9.4 19.4l-.2 8.1-70.9-70.2c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l61.8 61.9zm56.8 111.1l-3.5-4.1-12.1-88.3C253.4 85.7 244 75.6 232 74l.3-12c0-7.3 6-13.2 13.2-13.2 7.3 0 13.2 6 13.2 13.2l12.7 92.5 12.3 14.3c1.9 2.2 1.8 5.6-.3 7.6l-13.9 14.1zm-219-33.9c2.4-1.9 5.2-2.8 8.1-2.8a14.01 14.01 0 0 1 9.9 4.1l30 30c1.2 1.2 2.8 1.8 4.4 1.8s3.2-.6 4.4-1.8l.1-.1c2.6-2.6 2.6-6.8 0-9.5L58.9 130c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l48.8 48.8c1.3 1.3 2.9 1.9 4.6 1.9 1.6 0 3.3-.6 4.6-1.9 2.6-2.6 2.6-6.7 0-9.2L73.4 88.3c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l62.4 62.4c1.3 1.3 2.9 1.9 4.6 1.9s3.3-.6 4.6-1.9h0a6.46 6.46 0 0 0 0-9.1l-48.5-48.5c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l70.4 70.4c1.3 1.3 2.8 1.8 4.3 1.8 3.1 0 6.1-2.4 6.2-6l.6-21.8c0-7.3 6-13.2 13.2-13.2 7.3 0 13.2 6 13.2 13.2l12.7 92.5 12.3 14.3c1.9 2.2 1.8 5.6-.3 7.6L196.9 283c-1.1 1.1-2.5 1.6-4 1.6a5.43 5.43 0 0 1-3.4-1.2l-15.7-12c-.7-.5-1.4-.9-2.3-1-27.2-5.9-58.1-29.7-87.7-59.2l-34.6-34.6c-5.5-5.6-5.1-15 1.3-20z"/>
                            </svg>
                            <p class="ml-2 text-sm">{{ $new_post->likes_count }}</p>
                        </a>
                        <a href="{{ route('posts.show', ['user'=>$new_post->user->username,'post'=>$new_post->slug]) }}" class="auto-op-comment flex items-center ml-5">
                            <svg class="w-5 h-5" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 473 473" style="enable-background:new 0 0 473 473;" xml:space="preserve" fill="currentColor">
                                <path d="M403.581,69.3c-44.7-44.7-104-69.3-167.2-69.3s-122.5,24.6-167.2,69.3c-86.4,86.4-92.4,224.7-14.9,318
                                    c-7.6,15.3-19.8,33.1-37.9,42c-8.7,4.3-13.6,13.6-12.1,23.2s8.9,17.1,18.5,18.6c4.5,0.7,10.9,1.4,18.7,1.4
                                    c20.9,0,51.7-4.9,83.2-27.6c35.1,18.9,73.5,28.1,111.6,28.1c61.2,0,121.8-23.7,167.4-69.3c44.7-44.7,69.3-104,69.3-167.2
                                    S448.281,114,403.581,69.3z M384.481,384.6c-67.5,67.5-172,80.9-254.2,32.6c-5.4-3.2-12.1-2.2-16.4,2.1c-0.4,0.2-0.8,0.5-1.1,0.8
                                    c-27.1,21-53.7,25.4-71.3,25.4h-0.1c20.3-14.8,33.1-36.8,40.6-53.9c1.2-2.9,1.4-5.9,0.7-8.7c-0.3-2.7-1.4-5.4-3.3-7.6
                                    c-73.2-82.7-69.4-208.7,8.8-286.9c81.7-81.7,214.6-81.7,296.2,0C466.181,170.1,466.181,302.9,384.481,384.6z"/>
                                <circle cx="236.381" cy="236.5" r="16.6"/>
                                <circle cx="321.981" cy="236.5" r="16.6"/>
                                <circle cx="150.781" cy="236.5" r="16.6"/>
                            </svg>
                            <p class="ml-2 text-sm">{{ sizeOf($new_post->comments) }}</p>
                        </a>
                    </div>
                    <a href="{{ route('posts.show', ['user'=>$new_post->user->username,'post'=>$new_post->slug]) }}" class="btn-notif-np px-4 py-2 rounded text-xs sm:text-sm font-bold">Read more</a>
                </div>
            </div>
        </div>
    </div>
</div>