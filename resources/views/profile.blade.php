

@extends('layouts.app')

@section('title', 'Adityaptrp')

@section('content')
    <div class="all-profile-content container sm:px-0 sm:w-152 md:w-160">
        <div class="top-content-profile sm:border sm:border-t-0">
            <div class="banner-profile relative">
                <div class="banner-img @auth @if(Auth::user()->id == $user->id) p-hover-banner @endif @endauth h-45 md:h-48 w-full bg-center bg-cover" style="{{ $user->banner ? 'background-image: url('.$user->getBanner().');' : 'background: #B2B2B2;'  }} background-position: center; background-size: cover;"></div>
                @auth
                    @if (Auth::user()->id == $user->id)
                        <div class="btn-rm-banner @if(!$user->banner) hidden @endif w-10 h-10 rounded-full text-sm font-semibold cursor-pointer">
                            <svg class="w-6 h-6 cursor-pointer" fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path class="block" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                    @endif
                @endauth
                @auth
                    @if (Auth::user()->id == $user->id)
                        <label for="banner" class="edit-banner-ep rounded-sm z-3">
                            <svg viewBox="0 0 24 24" class="w-4 h-4" fill="currentColor">
                                <path d="M19.708 22H4.292C3.028 22 2 20.972 2 19.708V7.375C2 6.11 3.028 5.083 4.292 5.083h2.146C7.633 3.17 9.722 2 12 2c2.277 0 4.367 1.17 5.562 3.083h2.146C20.972 5.083 22 6.11 22 7.375v12.333C22 20.972 20.972 22 19.708 22zM4.292 6.583c-.437 0-.792.355-.792.792v12.333c0 .437.355.792.792.792h15.416c.437 0 .792-.355.792-.792V7.375c0-.437-.355-.792-.792-.792h-2.45c-.317.05-.632-.095-.782-.382-.88-1.665-2.594-2.7-4.476-2.7-1.883 0-3.598 1.035-4.476 2.702-.16.302-.502.46-.833.38H4.293z"></path><path d="M12 8.167c-2.68 0-4.86 2.18-4.86 4.86s2.18 4.86 4.86 4.86 4.86-2.18 4.86-4.86-2.18-4.86-4.86-4.86zm2 5.583h-1.25V15c0 .414-.336.75-.75.75s-.75-.336-.75-.75v-1.25H10c-.414 0-.75-.336-.75-.75s.336-.75.75-.75h1.25V11c0-.414.336-.75.75-.75s.75.336.75.75v1.25H14c.414 0 .75.336.75.75s-.336.75-.75.75z"></path>
                            </svg>
                            <p class="ml-2 text-0.5sm">Edit Cover</p>
                        </label>
                    @endif
                @endauth
                <form class="form-ep-banner" action="{{ route('profile.updateBanner', $user->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <input type="file" name="banner" id="banner" accept=".jpg,.jpeg,.png,.svg" style="display: none;" />
                    <input type="checkbox" name="remove_banner" id="remove_banner" style="display: none;">
                </form>
            </div>
            {{-- Image and btn profile --}}
            <div class="img-profile-page px-6 flex justify-between">
                <img class="rounded-full w-22 sm:w-24 md:w-28 h-22 sm:h-24 md:h-28" src="{{ $user->profile_picture != null ? $user->getProfilePicture() : $user->gravatar() }}" onerror="this.onerror=null; this.src='{{ asset('/img/no_profile.png') }}'" alt="{{ $user->username }}">
                <div class="btn-menu-profile mt-4 flex justify-end w-full text-green-500 text-md md:text-lg">
                    @auth
                        @if (Auth::user()->id == $user->id)
                            <a class="edit-profile-p px-3 py-1 rounded-full text-sm font-semibold cursor-pointer">Edit profile</a>
                        @else
                            @if (Cookie::get('profile_liked'))
                                <a class="w-9 h-9 rounded-full cursor-pointer text-red-500">
                                    <i class="fas fa-heart"></i>
                                </a>
                            @else
                                <a class="like-profile w-9 h-9 rounded-full cursor-pointer" data-u="{{ myEncrypt($user->id) }}">
                                    <i class="far fa-heart"></i>
                                </a>
                            @endif
                            @if ($user->getURLmessage())
                                <a href="{{ $user->getURLmessage() }}" target="blank" class="w-9 h-9 ml-3 rounded-full"><i class="far fa-envelope"></i></a>
                            @endif
                            <div class="open-dd-post w-9 h-9 ml-3 rounded-full relative text-green-500 cursor-pointer">
                                <i class="fas fa-ellipsis-h"></i>   
                                {{-- dropdown copy --}}
                                <div class="show-dd-post dd-copy-profile rounded-sm text-b_base">
                                    <a class="copy-url flex items-center cursor-pointer" data-url="{{ getURL() }}">
                                        <i class="fas fa-link w-7"></i>
                                        <span class="text-sm w-16">Copy link</span>
                                    </a>
                                    <div class="triangle-copy-profile"></div>
                                </div>
                            </div>
                        @endif
                    @else
                        @if (Cookie::get('profile_liked'))
                            <a class="w-9 h-9 rounded-full cursor-pointer text-red-500">
                                <i class="fas fa-heart"></i>
                            </a>
                        @else
                            <a class="like-profile w-9 h-9 rounded-full cursor-pointer" data-u="{{ myEncrypt($user->id) }}">
                                <i class="far fa-heart"></i>
                            </a>
                        @endif
                        <a href="http://m.me/{{ $user->facebook }}" target="blank" class="w-9 h-9 ml-3 rounded-full"><i class="far fa-envelope"></i></a>
                        <div class="open-dd-post w-9 h-9 ml-3 rounded-full relative text-green-500 cursor-pointer">
                            <i class="fas fa-ellipsis-h"></i>   
                            {{-- dropdown copy --}}
                            <div class="show-dd-post dd-copy-profile rounded-sm text-b_base">
                                <a class="copy-url flex items-center cursor-pointer" data-url="{{ getURL() }}">
                                    <i class="fas fa-link w-7"></i>
                                    <span class="text-sm w-16">Copy link</span>
                                </a>
                                <div class="triangle-copy-profile"></div>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
            {{-- Description --}}
            <div class="desc-profile mt-3 px-6 mb-3" data-u="{{ myEncrypt($user->username) }}">
                <h1 class="font-black text-0.5xl sm:text-xl">{{ $user->name }}</h1>
                <p class="text-sm sm:text-b_base -mt-1">{{ $user->email }}</p>
                @if ($user->bio)
                    <h2 class="text-sm sm:text-b_base mt-2">{{ $user->bio }}</h2>
                @endif
                <div class="text-sm sm:text-b_base mt-2">
                    @if ($user->website)
                        <a href="{{ $user->website }}" class="inline-block mr-3" target="blank">
                            <i class="fas fa-link"></i>
                            <span class="text-green-600 ml-1">{{ Str::limit($user->getYoutubeLink(), 20, '...') }}</span>
                        </a>
                    @endif
                    <span class="inline-block">
                        <i class="far fa-calendar-alt"></i>
                        <span class="ml-1">Joined {{ $user->created_at->format('M Y') }}</span>
                    </span>
                </div>
                <div class="count-pnl flex items-center mt-3 text-sm sm:text-b_base">
                    <p class="font-semibold">{{ $posts_count }}<span class="ml-1 font-normal">Posts</span></p>
                    <p class="profile-c-likes ml-3 font-semibold">{{ $user->count_likes }}<span class="ml-1 font-normal">Likes</span></p>
                    <p class="ml-3 font-semibold">{{ $count_responses }}<span class="ml-1 font-normal">Responses</span></p>
                </div>
            </div>
            {{-- Menu Panel --}}
            <div class="menu-panel-profile flex w-full text-sm sm:text-b_base">
                <a href="{{ route('profile.allPosts', $user->username) }}" class="profile-s-ap font-bold w-20% sm:w-30% text-center py-3 @isset($all_posts) border-b-3 border-green-500 active @endisset" data-u="{{ myEncrypt($user->username) }}">Posts</a>
                <a href="{{ route('profile.mostPopular', $user->username) }}" class="profile-s-pm font-bold w-47% sm:w-37% text-center py-3 @isset($popular_posts) border-b-3 border-green-500 active @endisset" data-u="{{ myEncrypt($user->username) }}">Most Popular Posts</a>
                <a href="{{ route('profile.socialMedia', $user->username) }}" class="profile-s-sm font-bold w-33% text-center py-3 @isset($social_media) border-b-3 border-green-500 active @endisset" data-u="{{ myEncrypt($user->username) }}">Social Media</a>
            </div>
        </div>

        <div class="profile-mc">
            {{-- Content Menu Panel --}}
            @isset($social_media)
                {{-- Social Media --}}
                <div class="profile-sm sm:border-l sm:border-r py-16 flex flex-col justify-center items-center text-b_base">
                    @if (!$user->twitter && !$user->instagram && !$user->facebook && !$user->youtube_link_id)
                        <h1 class="mb-2">There's no social media from {{ $user->username }}.</h1>
                    @else
                        <h1 class="mb-2">You can find me on :</h1>
                        @if ($user->twitter)
                            <a href="https://twitter.com/{{ $user->twitter }}" target="blank">
                                <i class="fab fa-twitter"></i>
                                <span class="ml-1">Twitter</span>
                            </a>
                        @endif
                        @if ($user->instagram)
                            <a href="https://www.instagram.com/{{ $user->instagram }}/" target="blank">
                                <i class="fab fa-instagram"></i>
                                <span class="ml-1">Instagram</span>
                            </a>
                        @endif
                        @if ($user->facebook)    
                            <a href="https://www.facebook.com/{{ $user->facebook }}/" target="blank">
                                <i class="fab fa-facebook"></i>
                                <span class="ml-1">Facebook</span>
                            </a>
                        @endif
                        @if ($user->youtube_link_id)
                            <a href="https://www.youtube.com/channel/{{ $user->youtube_link_id }}" target="blank">
                                <i class="fab fa-youtube"></i>
                                <span class="ml-1">Youtube</span>
                            </a>
                        @endif
                    @endif
                </div>
            @endisset
            {{-- List Post Result --}}
            @if(isset($all_posts) || isset($popular_posts))
                <div class="list-p-all sm:border-l sm:border-r relative @if($posts->lastPage() > 1) pb-25 @endif" data-paginate="{{ $posts->lastPage() }}">
                    @forelse ($posts as $i => $post)
                        <div class="list-post py-7 px-6 border-b">
                            {{-- Published --}}
                            <div class="published-c flex items-center text-sm sm:text-b_base mb-3">
                                <h1>Published by <span class="font-bold text-green-600">{{ $post->user->username }}</span></h1>
                                <p class="point ml-4 text-0.5sm sm:text-sm">{{ $post->created_at->format('M d, Y') }} {!! $post->checkPopularPost() !!}</p>
                            </div>

                            <a href="{{ route('posts.show', ['user'=>$post->user->username,'post'=>$post->slug]) }}" class="title-sp text-1.5xl md:text-2.5xl leading-tight font-black">{{ Str::limit($post->title, 80, '...') }}</a>
                            {{-- img --}}
                            <a href="{{ route('posts.show', ['user'=>$post->user->username,'post'=>$post->slug]) }}">
                                <div class="mt-5 w-full h-48 sm:h-60">
                                    <img class="w-full h-full object-cover object-center" src="{{ $post->getThumbnail() }}" alt="{{ $post->title }}">
                                </div>
                            </a>

                            {{-- body --}}
                            <a href="{{ route('posts.show', ['user'=>$post->user->username,'post'=>$post->slug]) }}">
                                <div class="text-b_base sm:text-md mt-5 text-justify">
                                    {!! Str::limit($post->header, 120, '...') !!}
                                </div>
                                <div class="read-more-l flex items-center text-green-600 font-semibold text-sm sm:text-b_base mt-2">
                                    <p>Read more</p>
                                    <p class="point ml-4
                                    ">{{ $post->estimatedReadingTime() }}</p>
                                </div>
                            </a>
                            {{-- Button --}}
                            <div class="all-icon-p flex justify-between items-center mt-4">
                                <div class="flex">
                                    {{-- like --}}
                                    <a href="{{ route('posts.show', ['user'=>$post->user->username,'post'=>$post->slug]) }}" class="like-hs flex items-center cursor-pointer h-full">
                                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 297.2 297.2" fill="currentColor">
                                            <path d="M28.4 43.4c1.1.7 2.3 1.1 3.5 1.1 1.9 0 3.7-.9 4.9-2.5 1.9-2.7 1.3-6.5-1.4-8.4L20.4 23c-2.7-1.9-6.4-1.3-8.4 1.4s-1.3 6.4 1.4 8.4l15 10.6zm28.3-21.7L50.2 4.5C49 1.4 45.6-.2 42.5 1S37.8 5.6 39 8.7l6.5 17.2c.9 2.4 3.2 3.9 5.6 3.9.7 0 1.4-.1 2.1-.4 3.1-1.2 4.6-4.6 3.5-7.7zM0 61.3c-.1 3.3 2.6 6 5.9 6l18.5.3c3.3 0 5.9-2.7 6-5.9.1-3.3-2.6-5.9-5.9-5.9L6 55.6c-3.3 0-5.9 2.4-6 5.7zm33.4 104.3c-.4 7.2 2.3 14.3 7.4 19.4l34.6 34.6c16.4 16.4 32 29.8 46.3 39.8 16.5 11.5 31.9 19 45.9 22.3l14.5 11.2c3.1 2.3 6.9 3.6 10.7 3.6 4.7 0 9.1-1.8 12.4-5.1l69.7-69.6c6-6 6.8-15.3 2.2-22.2l14.8-14.8c6.5-6.5 6.9-17 .9-24l-10-11.6L270.9 61c-.5-13.5-11.6-24.3-25.2-24.3-13.9 0-25.1 11.2-25.2 25l-.2 8.1-61-60.8c-4.8-4.8-11.2-7.4-17.9-7.4h0c-7.8 0-15.1 3.5-19.9 9.6a25.2 25.2 0 0 0-5 11.2c-4.6-4.1-10.5-6.3-16.8-6.3-7.8 0-15.1 3.5-19.9 9.6-6.4 8.1-7 19.1-2.2 27.9-5.8 1.2-11 4.4-14.8 9.1-7 8.8-7.1 21.1-.8 30.3.3.8.7 1.6 1.1 2.3-5.8 1.2-11 4.3-14.8 9.1-8 10.1-7 24.7 2.3 34l2.4 2.4c.2.5.5.9.7 1.4-3.8.8-7.5 2.4-10.6 4.9-5.8 4.5-9.3 11.3-9.7 18.5zm83.5-125.8c-4.9 1.5-9.2 4.4-12.5 8.5a25.2 25.2 0 0 0-5 11.2c-.9-.8-1.8-1.4-2.7-2.1l-6.2-6.2c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l7.7 7.8zm95.8 39.6c-5.7 4.6-9.3 11.6-9.4 19.4l-.2 8.1-70.9-70.2c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l61.8 61.9zm56.8 111.1l-3.5-4.1-12.1-88.3C253.4 85.7 244 75.6 232 74l.3-12c0-7.3 6-13.2 13.2-13.2 7.3 0 13.2 6 13.2 13.2l12.7 92.5 12.3 14.3c1.9 2.2 1.8 5.6-.3 7.6l-13.9 14.1zm-219-33.9c2.4-1.9 5.2-2.8 8.1-2.8a14.01 14.01 0 0 1 9.9 4.1l30 30c1.2 1.2 2.8 1.8 4.4 1.8s3.2-.6 4.4-1.8l.1-.1c2.6-2.6 2.6-6.8 0-9.5L58.9 130c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l48.8 48.8c1.3 1.3 2.9 1.9 4.6 1.9 1.6 0 3.3-.6 4.6-1.9 2.6-2.6 2.6-6.7 0-9.2L73.4 88.3c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l62.4 62.4c1.3 1.3 2.9 1.9 4.6 1.9s3.3-.6 4.6-1.9h0a6.46 6.46 0 0 0 0-9.1l-48.5-48.5c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l70.4 70.4c1.3 1.3 2.8 1.8 4.3 1.8 3.1 0 6.1-2.4 6.2-6l.6-21.8c0-7.3 6-13.2 13.2-13.2 7.3 0 13.2 6 13.2 13.2l12.7 92.5 12.3 14.3c1.9 2.2 1.8 5.6-.3 7.6L196.9 283c-1.1 1.1-2.5 1.6-4 1.6a5.43 5.43 0 0 1-3.4-1.2l-15.7-12c-.7-.5-1.4-.9-2.3-1-27.2-5.9-58.1-29.7-87.7-59.2l-34.6-34.6c-5.5-5.6-5.1-15 1.3-20z"/>
                                        </svg>
                                        <p class="ml-3 text-sm md:text-base">{{ $post->likes_count }} <span class="hidden sm:inline ml-1">claps</span></p>
                                    </a>
                                    <a href="{{ route('posts.show', ['user'=>$post->user->username,'post'=>$post->slug]) }}" class="comment-ph flex items-center ml-5">
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
                                        <p class="ml-2 text-sm md:text-base">{{ sizeOf($post->comments) }} <span class="hidden sm:inline ml-1">responses</span></p>
                                    </a>
                                </div>
                                {{-- Share Social Media, Bookmark etc --}}
                                <div class="show-social-media text-xl flex items-center mt-4 md:mt-0">
                                    <div class="relative" title="share">
                                        <svg class="open-dd-post cursor-pointer" width="25" height="25" class="r" fill-rule="evenodd" fill="currentColor">
                                            <path d="M15.6 5a.42.42 0 0 0 .17-.3.42.42 0 0 0-.12-.33l-2.8-2.79a.5.5 0 0 0-.7 0l-2.8 2.8a.4.4 0 0 0-.1.32c0 .12.07.23.16.3h.02a.45.45 0 0 0 .57-.04l2-2V10c0 .28.23.5.5.5s.5-.22.5-.5V2.93l2.02 2.02c.08.07.18.12.3.13.11.01.21-.02.3-.08v.01"></path><path d="M18 7h-1.5a.5.5 0 0 0 0 1h1.6c.5 0 .9.4.9.9v10.2c0 .5-.4.9-.9.9H6.9a.9.9 0 0 1-.9-.9V8.9c0-.5.4-.9.9-.9h1.6a.5.5 0 0 0 .35-.15A.5.5 0 0 0 9 7.5a.5.5 0 0 0-.15-.35A.5.5 0 0 0 8.5 7H7a2 2 0 0 0-2 2v10c0 1.1.9 2 2 2h11a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"></path>
                                        </svg>
                                        {{-- dropdown sosmed --}}
                                        <div class="show-dd-post dd-sosmed-atas rounded-sm text-b_base">
                                            <a class="inline-flex items-center" href="https://twitter.com/intent/tweet?text={{ '"' . preg_replace('/#[a-z0-9]+/i', '', $post->title) . '"' }} {{ $post->user->twitter ? '—@'.$post->user->twitter : '—'.$post->user->username }}&url={{ $post->getURL() }}&hashtags={{ $post->allTagsShareTwitter() }}" target="blank">
                                                <i class="fab fa-twitter w-8"></i>
                                                <span class="text-sm">Twitter</span>
                                            </a>
                                            <a class="inline-flex items-center" href="https://www.linkedin.com/sharing/share-offsite/?url={{ $post->getURL() }}" target="blank">
                                                <i class="fab fa-linkedin w-8"></i>
                                                <span class="text-sm">LinkedIn</span>
                                            </a>
                                            <a class="share-to-facebook cursor-pointer inline-flex items-center" data-url="https://www.facebook.com/sharer/sharer.php?u={{ $post->getURL() }}&quote={{ $post->title }}">
                                                <i class="fab fa-facebook-square w-8"></i>
                                                <span class="text-sm">Facebook</span>
                                            </a>
                                            <div class="triangle-sosmed-atas"></div>
                                        </div>
                                    </div>
                                    {{-- BOOKMARK N ARCHIVE --}}
                                    <div class="ml-1">
                                        @if (isset($_COOKIE['archive']))
                                            <?php
                                                $archive = explode('/', $_COOKIE['archive']);
                                            ?>
                                        @endif
                                        {{-- bookmark --}}
                                        @if (isset($_COOKIE['bookmark']))
                                            <?php
                                                $bookmark = explode('/', $_COOKIE['bookmark']);
                                            ?>
                                            @if (in_array($post->id, $bookmark))
                                                <div class="bookmark-post cursor-pointer" data-ip="{{ $post->id }}" title="Unsave post">
                                                    <svg class="bookmarked w-7 h-7" viewBox="0 0 25 25" fill="currentColor">
                                                        <path d="M19 6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14.66h.01c.01.1.05.2.12.28a.5.5 0 0 0 .7.03l5.67-4.12 5.66 4.13c.2.18.52.17.71-.03a.5.5 0 0 0 .12-.29H19V6z"></path>
                                                    </svg>
                                                </div>
                                            @else
                                                @if (isset($_COOKIE['archive']))
                                                    @if (in_array($post->id, $archive))
                                                        <div class="remove-ar-p cursor-pointer" data-ip="{{ $post->id }}" title="Unarchive post">
                                                            <svg class="p-archived" data-ip="{{ $post->id }}" width="25" height="25" viewBox="0 0 25 25" fill="currentColor">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M20.48 7.45H3.46v10.13H16a.47.47 0 1 1 0 .94H3.46c-.54 0-.99-.42-.99-.94V7.45c0-.52.45-.93 1-.93h17c.55 0 1 .41 1 .93v5.57a.5.5 0 0 1-1 0V7.45zM5.47 10.02c0-.28.22-.5.5-.5h9.11a.5.5 0 1 1 0 1H5.97a.5.5 0 0 1-.5-.5zm.51 2.5a.5.5 0 0 0-.51.5c0 .27.23.5.51.5h5.98a.5.5 0 0 0 .51-.5.5.5 0 0 0-.51-.5H5.98zm12.52 3.02c.2-.2.5-.2.7 0l1.77 1.77 1.77-1.77a.5.5 0 1 1 .7.7l-1.76 1.78 1.76 1.76a.5.5 0 1 1-.7.71l-1.77-1.77-1.77 1.77a.5.5 0 0 1-.7-.7l1.76-1.77-1.76-1.77a.5.5 0 0 1 0-.7z"></path>
                                                            </svg>
                                                        </div>
                                                    @else
                                                        <div class="bookmark-post cursor-pointer" data-ip="{{ $post->id }}" title="Save post">
                                                            <svg class="w-7 h-7" viewBox="0 0 25 25" fill="currentColor">
                                                                <path d="M19 6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14.66h.01c.01.1.05.2.12.28a.5.5 0 0 0 .7.03l5.67-4.12 5.66 4.13a.5.5 0 0 0 .71-.03.5.5 0 0 0 .12-.29H19V6zm-6.84 9.97L7 19.64V6a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v13.64l-5.16-3.67a.49.49 0 0 0-.68 0z" fill-rule="evenodd"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="bookmark-post cursor-pointer" data-ip="{{ $post->id }}" title="Save post">
                                                        <svg class="w-7 h-7" viewBox="0 0 25 25" fill="currentColor">
                                                            <path d="M19 6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14.66h.01c.01.1.05.2.12.28a.5.5 0 0 0 .7.03l5.67-4.12 5.66 4.13a.5.5 0 0 0 .71-.03.5.5 0 0 0 .12-.29H19V6zm-6.84 9.97L7 19.64V6a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v13.64l-5.16-3.67a.49.49 0 0 0-.68 0z" fill-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            @endif
                                        @else
                                            @if (isset($_COOKIE['archive']))
                                                @if (in_array($post->id, $archive))
                                                <div class="remove-ar-p cursor-pointer" data-ip="{{ $post->id }}" title="Unarchive post">
                                                    <svg class="p-archived" data-ip="{{ $post->id }}" width="25" height="25" viewBox="0 0 25 25" fill="currentColor">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M20.48 7.45H3.46v10.13H16a.47.47 0 1 1 0 .94H3.46c-.54 0-.99-.42-.99-.94V7.45c0-.52.45-.93 1-.93h17c.55 0 1 .41 1 .93v5.57a.5.5 0 0 1-1 0V7.45zM5.47 10.02c0-.28.22-.5.5-.5h9.11a.5.5 0 1 1 0 1H5.97a.5.5 0 0 1-.5-.5zm.51 2.5a.5.5 0 0 0-.51.5c0 .27.23.5.51.5h5.98a.5.5 0 0 0 .51-.5.5.5 0 0 0-.51-.5H5.98zm12.52 3.02c.2-.2.5-.2.7 0l1.77 1.77 1.77-1.77a.5.5 0 1 1 .7.7l-1.76 1.78 1.76 1.76a.5.5 0 1 1-.7.71l-1.77-1.77-1.77 1.77a.5.5 0 0 1-.7-.7l1.76-1.77-1.76-1.77a.5.5 0 0 1 0-.7z"></path>
                                                    </svg>
                                                </div>
                                                @else
                                                    <div class="bookmark-post cursor-pointer" data-ip="{{ $post->id }}" title="Save post">
                                                        <svg class="w-7 h-7" viewBox="0 0 25 25" fill="currentColor">
                                                            <path d="M19 6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14.66h.01c.01.1.05.2.12.28a.5.5 0 0 0 .7.03l5.67-4.12 5.66 4.13a.5.5 0 0 0 .71-.03.5.5 0 0 0 .12-.29H19V6zm-6.84 9.97L7 19.64V6a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v13.64l-5.16-3.67a.49.49 0 0 0-.68 0z" fill-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="bookmark-post cursor-pointer" data-ip="{{ $post->id }}" title="Save post">
                                                    <svg class="w-7 h-7" viewBox="0 0 25 25" fill="currentColor">
                                                        <path d="M19 6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14.66h.01c.01.1.05.2.12.28a.5.5 0 0 0 .7.03l5.67-4.12 5.66 4.13a.5.5 0 0 0 .71-.03.5.5 0 0 0 .12-.29H19V6zm-6.84 9.97L7 19.64V6a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v13.64l-5.16-3.67a.49.49 0 0 0-.68 0z" fill-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    {{-- Menu setting --}}
                                    <div class="relative" title="setting">
                                        <svg class="open-dd-post ml-1 cursor-pointer" width="25" height="25" fill="currentColor">
                                            <path d="M5 12.5c0 .55.2 1.02.59 1.41.39.4.86.59 1.41.59.55 0 1.02-.2 1.41-.59.4-.39.59-.86.59-1.41 0-.55-.2-1.02-.59-1.41A1.93 1.93 0 0 0 7 10.5c-.55 0-1.02.2-1.41.59-.4.39-.59.86-.59 1.41zm5.62 0c0 .55.2 1.02.58 1.41.4.4.87.59 1.42.59.55 0 1.02-.2 1.41-.59.4-.39.59-.86.59-1.41 0-.55-.2-1.02-.59-1.41a1.93 1.93 0 0 0-1.41-.59c-.55 0-1.03.2-1.42.59-.39.39-.58.86-.58 1.41zm5.6 0c0 .55.2 1.02.58 1.41.4.4.87.59 1.43.59.56 0 1.03-.2 1.42-.59.39-.39.58-.86.58-1.41 0-.55-.2-1.02-.58-1.41a1.93 1.93 0 0 0-1.42-.59c-.56 0-1.04.2-1.43.59-.39.39-.58.86-.58 1.41z" fill-rule="evenodd"></path>
                                        </svg>
                                        {{-- dropdown setting --}}
                                        <div class="show-dd-post dd-setting-atas rounded-sm text-b_base">
                                            @if (Auth::user())
                                                @if (Auth::user()->id == $post->user_id)
                                                    <a class="flex items-center" href="{{ route('posts.edit', $post->slug) }}">
                                                        <i class="fas fa-edit w-7"></i>
                                                        <span class="text-sm w-16">Edit post</span>
                                                    </a>
                                                @endif
                                            @endif
                                            <a class="copy-url flex items-center cursor-pointer" data-url="{{ $post->getURL() }}">
                                                <i class="fas fa-link w-7"></i>
                                                <span class="text-sm w-16">Copy link</span>
                                            </a>
                                            <div class="triangle-setting-atas"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="mt-5 flex flex-col items-center justify-center py-20">
                            <img class=" w-35 h-35 md:w-45 md:h-45" src="{{ asset('img/undraw_blank_canvas.png') }}" alt="">
                            <p class="mt-3">We couldn’t find any posts.</p>
                        </div>
                    @endforelse
                    @if($posts->lastPage() > 1)
                        <div class="btn-loadmore flex justify-center mt-5 pb-9">
                            <p class="text-0.5sm sm:text-sm uppercase">Load more</p>
                        </div>
                        <div class="ajax-load hidden">
                            <div class="spinner">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                        </div>
                    @endif
                </div>
            @endisset
        </div>
    </div>

    {{-- Edit Profile --}}
    @auth
        @if (Auth::user()->id == $user->id)
            <div class="edit-profile-panel z-20 hidden" data-u="{{ myEncrypt($user->username) }}">
                <div class="content-edit-profile flex flex-col w-full sm:w-140 h-full sm:h-auto sm:rounded-md">
                    <form action="{{ route('profile.update', $user->id) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @method('patch')
                        {{-- header --}}
                        <div class="header-ep sticky sm:static top-0 flex justify-between items-center px-6 py-3 border-b z-3 sm:rounded-t-md">
                            <p class="font-bold text-md">Edit profile</p>
                            <svg class="close-e-profile w-5 h-5 cursor-pointer text-green-600" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path class="block" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        {{-- Body --}}
                        <div class="flex flex-col sm:flex-row">
                            {{-- img profile --}}
                            <div class="w-full sm:w-30% flex flex-col items-center py-5">
                                <label for="profile_picture" class="cursor-pointer relative rounded-full">
                                    <img class="w-19 sm:w-22 h-19 sm:h-22 rounded-full" src="{{ $user->profile_picture != null ? $user->getProfilePicture() : $user->gravatar() }}" onerror="this.onerror=null; this.src='{{ asset('/img/no_profile.png') }}'" alt="{{ $user->username }}">
                                    <div class="edit-p-img-h absolute w-full h-full rounded-full bottom-0 flex items-center justify-center">
                                        <svg viewBox="0 0 24 24" class="w-25% h-25%" fill="currentColor">
                                            <path d="M19.708 22H4.292C3.028 22 2 20.972 2 19.708V7.375C2 6.11 3.028 5.083 4.292 5.083h2.146C7.633 3.17 9.722 2 12 2c2.277 0 4.367 1.17 5.562 3.083h2.146C20.972 5.083 22 6.11 22 7.375v12.333C22 20.972 20.972 22 19.708 22zM4.292 6.583c-.437 0-.792.355-.792.792v12.333c0 .437.355.792.792.792h15.416c.437 0 .792-.355.792-.792V7.375c0-.437-.355-.792-.792-.792h-2.45c-.317.05-.632-.095-.782-.382-.88-1.665-2.594-2.7-4.476-2.7-1.883 0-3.598 1.035-4.476 2.702-.16.302-.502.46-.833.38H4.293z"></path><path d="M12 8.167c-2.68 0-4.86 2.18-4.86 4.86s2.18 4.86 4.86 4.86 4.86-2.18 4.86-4.86-2.18-4.86-4.86-4.86zm2 5.583h-1.25V15c0 .414-.336.75-.75.75s-.75-.336-.75-.75v-1.25H10c-.414 0-.75-.336-.75-.75s.336-.75.75-.75h1.25V11c0-.414.336-.75.75-.75s.75.336.75.75v1.25H14c.414 0 .75.336.75.75s-.336.75-.75.75z"></path>
                                        </svg>
                                    </div>
                                </label>
                                <span class="ml-1 text-center text-0.5sm w-70% mt-3">You joined about {{ $user->created_at->format('M Y') }}</span>
                                <div class="like-ep mt-2 font-semibold text-0.5sm border px-3 py-0.5 rounded-md">
                                    <span class="text-red-500 text-xs"><i class="fas fa-heart"></i></span>
                                    <span class="ml-0.5">{{ $user->count_likes }}</span>
                                    <span class="font-normal">Likes</span>
                                </div>
                            </div>
                            {{-- form profile --}}
                            <div class="form-e-profile w-full sm:w-70% py-5 sm:pr-6 px-5 sm:px-0">
                                <input type="file" name="profile_picture" id="profile_picture" accept=".jpg,.jpeg,.png,.svg" style="display: none;" />
                                <div class="flex flex-col">
                                    <label for="name" class="cursor-pointer flex items-center justify-between">
                                        <h1>Name :</h1>
                                        <h2><span>{{ strlen($user->name) }}</span>/50</h2>
                                    </label>
                                    <input type="text" name="name" id="name" class="border mt-1 text-sm focus:border-green-600" placeholder="Input your name." value="{{ old('name') ?? $user->name }}" data-l="50">
                                    @error('name')
                                        <div class="error-msg-p text-0.5sm mt-1 text-red-500 -mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="flex flex-col mt-3">
                                    <label for="username" class="cursor-pointer flex items-center justify-between">
                                        <h1>Username :</h1>
                                        <h2><span>{{ strlen($user->username) }}</span>/15</h2>
                                    </label>
                                    <input type="text" name="username" id="username" class="border mt-1 text-sm focus:border-green-600" placeholder="Input your username." value="{{ old('username') ?? $user->username }}" data-l="15">
                                    @error('username')
                                        <div class="error-msg-p text-0.5sm mt-1 ml-1 text-red-500 -mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="flex flex-col mt-3">
                                    <label for="bio" class="cursor-pointer flex items-center justify-between">
                                        <h1>Bio :</h1>
                                        <h2><span>{{ strlen($user->bio) }}</span>/160</h2>
                                    </label>
                                    <input type="text" name="bio" id="bio" class="border mt-1 text-sm focus:border-green-600" placeholder="Input your bio." value="{{ old('bio') ?? $user->bio }}" data-l="160">
                                    @error('bio')
                                        <div class="error-msg-p text-0.5sm mt-1 ml-1 text-red-500 -mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="flex flex-col mt-3">
                                    <label for="website" class="cursor-pointer flex items-center justify-between">
                                        <h1>Website :</h1>
                                        <h2><span>{{ strlen($user->website) }}</span>/100</h2>
                                    </label>
                                    <input type="text" name="website" id="website" class="border mt-1 text-sm focus:border-green-600" placeholder="Input your website." value="{{ old('website') ?? $user->website }}" data-l="100">
                                    @error('website')
                                        <div class="error-msg-p text-0.5sm mt-1 ml-1 text-red-500 -mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="grid gap-4 grid-cols-2 mt-3">
                                    <div class="flex flex-col">
                                        <label for="instagram" class="cursor-pointer flex items-center justify-between">
                                            <h1>Instagram :</h1>
                                            <h2><span>{{ strlen($user->instagram) }}</span>/30</h2>
                                        </label>
                                        <input type="text" name="instagram" id="instagram" class="border mt-1 text-sm focus:border-green-600" placeholder="Username IG." value="{{ old('instagram') ?? $user->instagram }}" data-l="30">
                                        @error('instagram')
                                            <div class="error-msg-p text-0.5sm mt-1 ml-1 text-red-500 -mb-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col">
                                        <label for="twitter" class="cursor-pointer flex items-center justify-between">
                                            <h1>Twitter :</h1>
                                            <h2><span>{{ strlen($user->twitter) }}</span>/30</h2>
                                        </label>
                                        <input type="text" name="twitter" id="twitter" class="border mt-1 text-sm focus:border-green-600" placeholder="Username Twitter." value="{{ old('twitter') ?? $user->twitter }}" data-l="30">
                                        @error('twitter')
                                            <div class="error-msg-p text-0.5sm mt-1 ml-1 text-red-500 -mb-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="grid gap-4 grid-cols-2 mt-3">
                                    <div class="flex flex-col">
                                        <label for="facebook" class="cursor-pointer flex items-center justify-between">
                                            <h1>Facebook :</h1>
                                            <h2><span>{{ strlen($user->facebook) }}</span>/50</h2>
                                        </label>
                                        <input type="text" name="facebook" id="facebook" class="border mt-1 text-sm focus:border-green-600" placeholder="Username facebook." value="{{ old('facebook') ?? $user->facebook }}" data-l="50">
                                        @error('facebook')
                                            <div class="error-msg-p text-0.5sm mt-1 ml-1 text-red-500 -mb-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col">
                                        <label for="youtube_link_id" class="cursor-pointer flex items-center justify-between">
                                            <h1>Youtube :</h1>
                                            <h2><span>{{ strlen($user->youtube_link_id) }}</span>/35</h2>
                                        </label>
                                        <input type="text" name="youtube_link_id" id="youtube_link_id" class="border mt-1 text-sm focus:border-green-600" placeholder="Youtube Id." value="{{ old('youtube_link_id') ?? $user->youtube_link_id }}" data-l="35">
                                        @error('youtube_link_id')
                                            <div class="error-msg-p text-0.5sm mt-1 ml-1 text-red-500 -mb-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                @if ($user->profile_picture)
                                    <label class="use-gravatar inline-flex items-center mt-3 cursor-pointer">
                                        <input type="checkbox" name="use_gravater" id="use_gravater" class="cursor-pointer">
                                        <span class="ml-2 text-gray-700 text-sm cursor-pointer">Use <a href="https://en.gravatar.com/" class="text-blue-500 hover:underline" target="blank">gravatar</a> to profile picture</span>
                                    </label>
                                @endif
                                <p class="note-ep mt-3 text-xs">Note: Facebook username will be used for the main message url on the profile view, and if the Facebook column is empty then the Twitter column will be used as a backup.</p>
                            </div>
                        </div>
                        {{-- Footer --}}
                        <div class="footer-ep sticky sm:static bottom-0 px-8 py-3 border-t flex sm:rounded-b-md">
                            <div class="submit-form-profile cursor-pointer">
                                <button type="submit" class="btn-save-ep bg-green-500 hover:bg-green-600 px-5 py-1 rounded-full text-sm text-white">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endauth
@endsection

@section('script_page')
    @auth
        <script>
            let BASE_CSS_BG;
            let BASE_URL_IMG;
            if ($('.banner-img').css('background-image') == 'none') {
                BASE_CSS_BG = $('.banner-img').css('background');
            } else {
                BASE_URL_IMG = $('.banner-img').css('background-image');
            }
        </script>
    @endauth
    <script src="{{ asset('js/profile.js') }}"></script>


    {{-- Tambahan --}}
    @auth
        @if ($errors->any())
            <script>
                $('.edit-profile-panel').toggle();
                $('.content-edit-profile').addClass('errors');
            </script>
        @endif

        @if (session()->has('alert'))
            <script>
                $(window).ready(function () {
                    $('#app').append(`
                    <div class="flash-message">
                        <span>{{ session()->get('alert') }}</span>
                        <div class="close-flash-message ml-3.5 -mr-1 cursor-pointer">
                            <svg class="nav-burger w-4 h-4 cursor-pointer" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path class="block" d="M6 18L18 6M6 6l12 12" style="pointer-events: none"></path>
                            </svg>
                        </div>
                    </div>
                    `);
                    setTimeout(() => {
                        $('.flash-message').remove();
                    }, 2000);
                })
            </script>
        @endif
    @endauth
@endsection