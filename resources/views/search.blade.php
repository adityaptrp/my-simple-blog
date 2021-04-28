
@extends('layouts.app')

@section('title', 'Search and find - Adityaptrp')

@section('content')
    <div class="search-c-all container mt-12 px-6 md:px-20 xl:px-40">
        {{-- Search Engine --}}
        <div class="search-c mb-5">
            <input type="text" name="s" class="search-i" placeholder="Search an article" value="{{ $request ?? '' }}" autocomplete="off">
            <div class="search-b"><i class="fas fa-search"></i></div>
        </div>

        {{-- Menu panel --}}
        <div class="nav-search text-sm sm:text-b_base mt-9">
            <a href="{{ route('search.all_post') }}" class="search-ap mr-4 cursor-pointer @isset($all_posts) font-bold submenu-s-active @endisset">All Post</a>
            <a href="{{ route('search.popular_posts') }}" class="search-pp mr-4 cursor-pointer @isset($popular_posts) font-bold submenu-s-active @endisset">Popular Post</a>
            <a href="{{ route('search.pop_categories_tags') }}" class="search-pct mr-4 cursor-pointer @isset($popular_tags) font-bold submenu-s-active @endisset">Popular Categories and Tags</a>
        </div>
        {{-- Content Search --}}
        <div class="flex">
            {{-- Main Content --}}
            <div class="search-mc w-full lg:w-9/12 pr-0 lg:pr-12">
                <hr class="mt-5">
                {{-- title result --}}
                @isset ($category)
                    <h1 class="title-result-s mt-5 text-lg md:text-xl">Category : {{ $category->name }}</h1>
                @endisset

                @isset ($tag)
                    <h1 class="title-result-s mt-5 text-lg md:text-xl">Tag : {{ $tag->name }}</h1>
                @endisset

                @if (!isset($tag) && !isset($category))
                    @isset($request)
                        <h1 class="title-result-s mt-5 text-lg md:text-xl">Result : {{ $request }}</h1>
                    @endisset
                @endif

                {{-- List Post Result --}}
                @isset($posts)
                    <div class="list-p-all relative pb-30" data-paginate="{{ $posts->lastPage() }}">
                        @forelse ($posts as $i => $post)
                            <div class="list-post mt-7 pb-7 border-b">
                                {{-- profile --}}
                                <div class="flex items-center mb-5">
                                    <a href="{{ route('profile.show', $post->user->username) }}" class="relative inline-block">
                                        <svg class="w-11 h-11 md:w-12 md:h-12 text-green-600" viewBox="0 0 36 36">
                                            <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M18 1.87c-6.63 0-12.4 4.14-15.21 10.21L2 11.71C4.94 5.37 11 1 18 1s13.06 4.37 16 10.71l-.79.37C30.4 6.01 24.63 1.88 18 1.88zM2.79 23.92c2.81 6.07 8.58 10.2 15.21 10.2 6.63 0 12.4-4.13 15.21-10.2l.79.37C31.06 30.63 25 35 18 35S4.94 30.63 2 24.29l.79-.37z"></path></svg>
                                        <div class="absolute bottom-0 w-full h-full flex justify-center items-center">
                                            <img class="show-profile-img rounded-full" src="{{ $post->user->profile_picture != null ? $post->user->getProfilePicture() : $post->user->gravatar() }}" onerror="this.onerror=null; this.src='{{ asset('/img/no_profile.png') }}'" alt="{{ $post->user->name }}">
                                        </div>
                                    </a>
                                    <div class="tgl-post-view flex flex-col ml-2">
                                        <p class="written-by text-0.5sm md:text-sm">Written by <a href="{{ route('profile.show', $post->user->username) }}" class="tracking-wide font-bold text-green-600">{{ $post->user->username }}</a></p>
                                        <p class="tgl-profile-post text-0.5sm tracking-wide">{{ $post->created_at->format('M d, Y') }}  &bull;  {{ $post->views_count > 1000 ? '1.000+' : $post->views_count }} times read {!! $post->checkPopularPost() !!}</p>
                                    </div>
                                </div>

                                {{-- Post Title and Img --}}
                                <a href="{{ route('posts.show', ['user'=>$post->user->username,'post'=>$post->slug]) }}" class="title-sp text-1.5xl md:text-2.5xl leading-tight font-black">{{ Str::limit($post->title, 80, '...') }}</a>
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
                                    <p class="text-green-600 font-semibold text-sm sm:text-b_base mt-2">Read more...</p>
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
                                    {{-- BOOKMARK N ARCHIVE --}}
                                    <div class="btn-bookmark-search">
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
                                                            <svg class="p-archived" data-ip="{{ $post->id }}" width="25" height="25" viewBox="0 0 25 25" fill="#757575">
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
                                                    <svg class="p-archived" data-ip="{{ $post->id }}" width="25" height="25" viewBox="0 0 25 25" fill="#757575">
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
                                </div>
                            </div>
                        @empty
                            <div class="mt-5">
                                We couldn’t find any posts.
                            </div>
                        @endforelse
                        <div class="ajax-load hidden">
                            <div class="spinner">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                        </div>
                    </div>
                @endisset

                {{-- List Popular Tags --}}
                @isset($popular_tags)
                    <div class="sidebar-categories-tag-list mt-5">
                        <h1 class="categoris-tag-title-search my-2">Tags</h1>
                        @foreach ($popular_tags as $p_tag)
                            <a href="{{ route('tags.show', $p_tag->slug) }}" class="s-posttag-v mt-2 cursor-pointer" data-tag-s="{{ $p_tag->slug }}">{{ $p_tag->name }}</a>
                        @endforeach
                    </div>
                    <div class="sidebar-categories-tag-list mt-5">
                        <h1 class="categoris-tag-title-search my-2">Categories</h1>
                        @foreach ($popular_categories as $p_category)
                            <a href="{{ route('categories.show', $p_category->slug) }}" class="s-category-v mt-2 cursor-pointer" data-category-s="{{ $p_category->slug }}">{{ $p_category->name }}</a>
                        @endforeach
                    </div>
                @endisset
            </div>

            {{-- Side Content --}}
            <div class="hidden lg:block w-0 lg:w-4/12">
                <hr class="mt-5">
                <div class="my-5">
                    <p class="categoris-tag-title-search font-bold uppercase text-sm">Categories</p>
                    <div class="sidebar-categories-tag-list mt-3">
                        @foreach ($categories as $category)
                            <a href="{{ route('categories.show', $category->slug) }}" class="s-category-v mt-2 cursor-pointer" data-category-s="{{ $category->slug }}">{{ $category->name }}</a>
                        @endforeach
                    </div>
                    <div class="categoris-tag-title-search font-bold mt-5 block hover:text-green-300 uppercase text-sm">Tags</div>
                    <div class="sidebar-categories-tag-list mt-3">
                        @foreach ($tags as $tag)
                            <a href="{{ route('tags.show', $tag->slug) }}" class="s-posttag-v mt-2 cursor-pointer" data-tag-s="{{ $tag->slug }}">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script_page')
    <script src="{{ asset('js/search.js') }}"></script>
@endsection