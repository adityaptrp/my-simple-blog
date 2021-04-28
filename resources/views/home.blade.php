@extends('layouts.app')

@section('title', 'Adityaptrp')

@section('content')
    {{-- <div class="home-header relative z-3 flex justify-center">
        <img class="w-full object-cover object-center" src="{{ asset('img/banner.jpg') }}" alt="Header">
        <a href="https://unsplash.com/@tianshu" class="content-home-header flex items-center justify-center" target="blank">
            <img class="rounded-full" src="{{ asset('img/profile-img-header.jpg') }}" alt="Profile">
            <p class="ml-4 text-white text-sm md:text-base">pict by <span class="font-bold">Tianshu Liu</span></p>
        </a>
        <div class="absolute flex flex-col justify-center items-center bottom-0 w-full h-full text-xl text-white">
            <p class="w-70vw sm:w-60vw md:w-50vw lg:w-40vw text-sm md:text-xl text-center">There is a way out of every box, a solution to every puzzle, it’s just a matter of finding it.</p>
            <p class="text-xs md:text-sm mt-2">- JEAN-LUC PICARD</p>
        </div>
    </div> --}}

    <div class="all-home-content container w-full flex justify-center px-6 md:px-10 xl:px-26">
        {{-- Main Content --}}
        <div class="home-main-content flex flex-col w-full lg:w-9/12 py-12 sm:py-16 lg:pr-8">
            {{-- Search Engine --}}
            <div class="search mb-5">
                <form action="{{ route('search.posts') }}" method="get" class="w-full" autocomplete="off">
                    <input type="text" name="s" class="search-input" placeholder="Search an article">
                    <button class="btn-search" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>

            {{-- highlight post --}}
            <div class="home-highlight flex flex-col">
                <a href="{{ route('posts.show', ['user'=>$highlight_post->user->username,'post'=>$highlight_post->slug]) }}" class="title-post text-2.5xl sm:text-3xl md:text-4xl leading-tight font-black">{{ $highlight_post->title }}</a>
                @if ($highlight_post->subtitle)
                    <a href="{{ route('posts.show', ['user'=>$highlight_post->user->username,'post'=>$highlight_post->slug]) }}" class="subtitle-p text-md md:text-lg lg:text-xl mt-2">{{ $highlight_post->subtitle }}</a>
                @endif
                {{-- profile highlight --}} 
                <div class="flex flex-col md:flex-row md:justify-between mt-5">
                    <div class="flex items-center">
                        <a href="{{ route('profile.show', $highlight_post->user->username) }}" class="relative inline-block">
                            <svg class="w-11 h-11 md:w-12 md:h-12 text-green-500" viewBox="0 0 36 36">
                                <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M18 1.87c-6.63 0-12.4 4.14-15.21 10.21L2 11.71C4.94 5.37 11 1 18 1s13.06 4.37 16 10.71l-.79.37C30.4 6.01 24.63 1.88 18 1.88zM2.79 23.92c2.81 6.07 8.58 10.2 15.21 10.2 6.63 0 12.4-4.13 15.21-10.2l.79.37C31.06 30.63 25 35 18 35S4.94 30.63 2 24.29l.79-.37z"></path></svg>
                            <div class="absolute bottom-0 w-full h-full flex justify-center items-center">
                                <img class="highlight-profile-img rounded-full" src="{{ $highlight_post->user->profile_picture != null ? $highlight_post->user->getProfilePicture() : $highlight_post->user->gravatar() }}" onerror="this.onerror=null; this.src='{{ asset('/img/no_profile.png') }}'" alt="{{ $highlight_post->user->name }}">
                            </div>
                        </a>
                        <div class="flex flex-col ml-2">
                            <div class="flex items-center">
                                <a href="{{ route('profile.show', $highlight_post->user->username) }}" class="text-0.5sm md:text-b_base font-bold text-green-600">{{ $highlight_post->user->username }}</a>
                                @if ($highlight_post->user->instagram)
                                    <a class="btn-p-follow ml-2 text-xs" href="https://www.instagram.com/{{ $highlight_post->user->instagram }}/" target="blank">Follow</a>
                                @endif
                            </div>
                            <p class="tgl-post-view text-0.5sm">{{ $highlight_post->created_at->format('M d, Y') }}  &bull;  {{ $highlight_post->views_count > 1000 ? '1.000+' : $highlight_post->views_count }} times read {!! $highlight_post->checkPopularPost() !!}</p>
                        </div>
                    </div>
                    {{-- Share Social Media, Bookmark etc --}}
                    <div class="show-social-media text-xl flex items-center mt-4 md:mt-0">
                        <div class="relative" title="share">
                            <svg class="open-dd-post cursor-pointer" width="25" height="25" class="r" fill-rule="evenodd" fill="currentColor">
                                <path d="M15.6 5a.42.42 0 0 0 .17-.3.42.42 0 0 0-.12-.33l-2.8-2.79a.5.5 0 0 0-.7 0l-2.8 2.8a.4.4 0 0 0-.1.32c0 .12.07.23.16.3h.02a.45.45 0 0 0 .57-.04l2-2V10c0 .28.23.5.5.5s.5-.22.5-.5V2.93l2.02 2.02c.08.07.18.12.3.13.11.01.21-.02.3-.08v.01"></path><path d="M18 7h-1.5a.5.5 0 0 0 0 1h1.6c.5 0 .9.4.9.9v10.2c0 .5-.4.9-.9.9H6.9a.9.9 0 0 1-.9-.9V8.9c0-.5.4-.9.9-.9h1.6a.5.5 0 0 0 .35-.15A.5.5 0 0 0 9 7.5a.5.5 0 0 0-.15-.35A.5.5 0 0 0 8.5 7H7a2 2 0 0 0-2 2v10c0 1.1.9 2 2 2h11a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"></path>
                            </svg>
                            {{-- dropdown sosmed --}}
                            <div class="show-dd-post dd-sosmed-atas rounded-sm text-b_base">
                                <a class="inline-flex items-center" href="https://twitter.com/intent/tweet?text={{ '"' . preg_replace('/#[a-z0-9]+/i', '', $highlight_post->title) . '"' }} {{ $highlight_post->user->twitter ? '—@'.$highlight_post->user->twitter : '—'.$highlight_post->user->username }}&url={{ $highlight_post->getURL() }}&hashtags={{ $highlight_post->allTagsShareTwitter() }}" target="blank">
                                    <i class="fab fa-twitter w-8"></i>
                                    <span class="text-sm">Twitter</span>
                                </a>
                                <a class="inline-flex items-center" href="https://www.linkedin.com/sharing/share-offsite/?url={{ $highlight_post->getURL() }}" target="blank">
                                    <i class="fab fa-linkedin w-8"></i>
                                    <span class="text-sm">LinkedIn</span>
                                </a>
                                <a class="share-to-facebook cursor-pointer inline-flex items-center" data-url="https://www.facebook.com/sharer/sharer.php?u={{ $highlight_post->getURL() }}&quote={{ $highlight_post->title }}">
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
                                @if (in_array($highlight_post->id, $bookmark))
                                    <div class="bookmark-post cursor-pointer" data-ip="{{ $highlight_post->id }}" title="Unsave post">
                                        <svg class="bookmarked w-7 h-7" viewBox="0 0 25 25" fill="currentColor">
                                            <path d="M19 6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14.66h.01c.01.1.05.2.12.28a.5.5 0 0 0 .7.03l5.67-4.12 5.66 4.13c.2.18.52.17.71-.03a.5.5 0 0 0 .12-.29H19V6z"></path>
                                        </svg>
                                    </div>
                                @else
                                    @if (isset($_COOKIE['archive']))
                                        @if (in_array($highlight_post->id, $archive))
                                            <div class="remove-ar-p cursor-pointer" data-ip="{{ $highlight_post->id }}" title="Unarchive post">
                                                <svg class="p-archived" data-ip="{{ $highlight_post->id }}" width="25" height="25" viewBox="0 0 25 25" fill="currentColor">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20.48 7.45H3.46v10.13H16a.47.47 0 1 1 0 .94H3.46c-.54 0-.99-.42-.99-.94V7.45c0-.52.45-.93 1-.93h17c.55 0 1 .41 1 .93v5.57a.5.5 0 0 1-1 0V7.45zM5.47 10.02c0-.28.22-.5.5-.5h9.11a.5.5 0 1 1 0 1H5.97a.5.5 0 0 1-.5-.5zm.51 2.5a.5.5 0 0 0-.51.5c0 .27.23.5.51.5h5.98a.5.5 0 0 0 .51-.5.5.5 0 0 0-.51-.5H5.98zm12.52 3.02c.2-.2.5-.2.7 0l1.77 1.77 1.77-1.77a.5.5 0 1 1 .7.7l-1.76 1.78 1.76 1.76a.5.5 0 1 1-.7.71l-1.77-1.77-1.77 1.77a.5.5 0 0 1-.7-.7l1.76-1.77-1.76-1.77a.5.5 0 0 1 0-.7z"></path>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="bookmark-post cursor-pointer" data-ip="{{ $highlight_post->id }}" title="Save post">
                                                <svg class="w-7 h-7" viewBox="0 0 25 25" fill="currentColor">
                                                    <path d="M19 6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14.66h.01c.01.1.05.2.12.28a.5.5 0 0 0 .7.03l5.67-4.12 5.66 4.13a.5.5 0 0 0 .71-.03.5.5 0 0 0 .12-.29H19V6zm-6.84 9.97L7 19.64V6a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v13.64l-5.16-3.67a.49.49 0 0 0-.68 0z" fill-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    @else
                                        <div class="bookmark-post cursor-pointer" data-ip="{{ $highlight_post->id }}" title="Save post">
                                            <svg class="w-7 h-7" viewBox="0 0 25 25" fill="currentColor">
                                                <path d="M19 6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14.66h.01c.01.1.05.2.12.28a.5.5 0 0 0 .7.03l5.67-4.12 5.66 4.13a.5.5 0 0 0 .71-.03.5.5 0 0 0 .12-.29H19V6zm-6.84 9.97L7 19.64V6a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v13.64l-5.16-3.67a.49.49 0 0 0-.68 0z" fill-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @endif
                                @endif
                            @else
                                @if (isset($_COOKIE['archive']))
                                    @if (in_array($highlight_post->id, $archive))
                                    <div class="remove-ar-p cursor-pointer" data-ip="{{ $highlight_post->id }}" title="Unarchive post">
                                        <svg class="p-archived" data-ip="{{ $highlight_post->id }}" width="25" height="25" viewBox="0 0 25 25" fill="currentColor">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M20.48 7.45H3.46v10.13H16a.47.47 0 1 1 0 .94H3.46c-.54 0-.99-.42-.99-.94V7.45c0-.52.45-.93 1-.93h17c.55 0 1 .41 1 .93v5.57a.5.5 0 0 1-1 0V7.45zM5.47 10.02c0-.28.22-.5.5-.5h9.11a.5.5 0 1 1 0 1H5.97a.5.5 0 0 1-.5-.5zm.51 2.5a.5.5 0 0 0-.51.5c0 .27.23.5.51.5h5.98a.5.5 0 0 0 .51-.5.5.5 0 0 0-.51-.5H5.98zm12.52 3.02c.2-.2.5-.2.7 0l1.77 1.77 1.77-1.77a.5.5 0 1 1 .7.7l-1.76 1.78 1.76 1.76a.5.5 0 1 1-.7.71l-1.77-1.77-1.77 1.77a.5.5 0 0 1-.7-.7l1.76-1.77-1.76-1.77a.5.5 0 0 1 0-.7z"></path>
                                        </svg>
                                    </div>
                                    @else
                                        <div class="bookmark-post cursor-pointer" data-ip="{{ $highlight_post->id }}" title="Save post">
                                            <svg class="w-7 h-7" viewBox="0 0 25 25" fill="currentColor">
                                                <path d="M19 6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14.66h.01c.01.1.05.2.12.28a.5.5 0 0 0 .7.03l5.67-4.12 5.66 4.13a.5.5 0 0 0 .71-.03.5.5 0 0 0 .12-.29H19V6zm-6.84 9.97L7 19.64V6a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v13.64l-5.16-3.67a.49.49 0 0 0-.68 0z" fill-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @endif
                                @else
                                    <div class="bookmark-post cursor-pointer" data-ip="{{ $highlight_post->id }}" title="Save post">
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
                                    @if (Auth::user()->id == $highlight_post->user_id)
                                        <a class="flex items-center" href="{{ route('posts.edit', $highlight_post->slug) }}">
                                            <i class="fas fa-edit w-7"></i>
                                            <span class="text-sm w-16">Edit post</span>
                                        </a>
                                    @endif
                                @endif
                                <a class="copy-url flex items-center cursor-pointer" data-url="{{ $highlight_post->getURL() }}">
                                    <i class="fas fa-link w-7"></i>
                                    <span class="text-sm w-16">Copy link</span>
                                </a>
                                <div class="triangle-setting-atas"></div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- img highlight --}}
                @if ($highlight_post->youtube_link)
                    <a id="homeImgHighlight" href="{{ route('posts.show', ['user'=>$highlight_post->user->username,'post'=>$highlight_post->slug]) }}" class="show-post-img mt-5 relative cursor-pointer">
                        <img class="w-full h-50 sm:h-72 md:h-96 object-cover object-center" src="{{ $highlight_post->getThumbnail() }}" alt="">
                        <div class="show-post-title-img flex items-center absolute">
                            <i class="fas fa-exclamation-circle"></i>
                            <div class="ml-2"><p class="text-white text-sm">Play documentation video</p></div>
                        </div>
                        <div class="cover-icon-play absolute bottom-0 w-full h-full flex justify-center items-center">
                            <div class="show-post-icon-play w-full h-full flex justify-center items-center">
                                <i class="fab fa-youtube"></i>
                            </div>
                        </div>
                    </a>
                @endif
                @if ($highlight_post->thumbnail && !$highlight_post->youtube_link)
                    <a href="{{ route('posts.show', ['user'=>$highlight_post->user->username,'post'=>$highlight_post->slug]) }}" class="mt-7 relative">
                        <img class="w-full h-60 sm:h-72 md:h-96 object-cover object-center" src="{{ $highlight_post->getThumbnail() }}" alt="{{ $highlight_post->title }}">
                    </a>
                @endif
                {{-- body highlight --}}
                <a href="{{ route('posts.show', ['user'=>$highlight_post->user->username,'post'=>$highlight_post->slug]) }}">
                    <p class="mt-3 text-base sm:text-md text-justify">{!! nl2br(e(Str::limit($highlight_post->header, 150, '...'))) !!}</p>
                    <p class="text-green-600 font-semibold text-sm sm:text-b_base mt-2">Read more...</p>
                </a>
                <div class="flex justify-between items-center mt-5 px-2">
                    <div class="all-icon-p flex">
                        <a href="{{ route('posts.show', ['user'=>$highlight_post->user->username,'post'=>$highlight_post->slug]) }}" class="like-hs flex items-center cursor-pointer h-full">
                            <svg class="w-6 h-6 md:w-7 md:h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 297.2 297.2" fill="currentColor">
                                <path d="M28.4 43.4c1.1.7 2.3 1.1 3.5 1.1 1.9 0 3.7-.9 4.9-2.5 1.9-2.7 1.3-6.5-1.4-8.4L20.4 23c-2.7-1.9-6.4-1.3-8.4 1.4s-1.3 6.4 1.4 8.4l15 10.6zm28.3-21.7L50.2 4.5C49 1.4 45.6-.2 42.5 1S37.8 5.6 39 8.7l6.5 17.2c.9 2.4 3.2 3.9 5.6 3.9.7 0 1.4-.1 2.1-.4 3.1-1.2 4.6-4.6 3.5-7.7zM0 61.3c-.1 3.3 2.6 6 5.9 6l18.5.3c3.3 0 5.9-2.7 6-5.9.1-3.3-2.6-5.9-5.9-5.9L6 55.6c-3.3 0-5.9 2.4-6 5.7zm33.4 104.3c-.4 7.2 2.3 14.3 7.4 19.4l34.6 34.6c16.4 16.4 32 29.8 46.3 39.8 16.5 11.5 31.9 19 45.9 22.3l14.5 11.2c3.1 2.3 6.9 3.6 10.7 3.6 4.7 0 9.1-1.8 12.4-5.1l69.7-69.6c6-6 6.8-15.3 2.2-22.2l14.8-14.8c6.5-6.5 6.9-17 .9-24l-10-11.6L270.9 61c-.5-13.5-11.6-24.3-25.2-24.3-13.9 0-25.1 11.2-25.2 25l-.2 8.1-61-60.8c-4.8-4.8-11.2-7.4-17.9-7.4h0c-7.8 0-15.1 3.5-19.9 9.6a25.2 25.2 0 0 0-5 11.2c-4.6-4.1-10.5-6.3-16.8-6.3-7.8 0-15.1 3.5-19.9 9.6-6.4 8.1-7 19.1-2.2 27.9-5.8 1.2-11 4.4-14.8 9.1-7 8.8-7.1 21.1-.8 30.3.3.8.7 1.6 1.1 2.3-5.8 1.2-11 4.3-14.8 9.1-8 10.1-7 24.7 2.3 34l2.4 2.4c.2.5.5.9.7 1.4-3.8.8-7.5 2.4-10.6 4.9-5.8 4.5-9.3 11.3-9.7 18.5zm83.5-125.8c-4.9 1.5-9.2 4.4-12.5 8.5a25.2 25.2 0 0 0-5 11.2c-.9-.8-1.8-1.4-2.7-2.1l-6.2-6.2c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l7.7 7.8zm95.8 39.6c-5.7 4.6-9.3 11.6-9.4 19.4l-.2 8.1-70.9-70.2c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l61.8 61.9zm56.8 111.1l-3.5-4.1-12.1-88.3C253.4 85.7 244 75.6 232 74l.3-12c0-7.3 6-13.2 13.2-13.2 7.3 0 13.2 6 13.2 13.2l12.7 92.5 12.3 14.3c1.9 2.2 1.8 5.6-.3 7.6l-13.9 14.1zm-219-33.9c2.4-1.9 5.2-2.8 8.1-2.8a14.01 14.01 0 0 1 9.9 4.1l30 30c1.2 1.2 2.8 1.8 4.4 1.8s3.2-.6 4.4-1.8l.1-.1c2.6-2.6 2.6-6.8 0-9.5L58.9 130c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l48.8 48.8c1.3 1.3 2.9 1.9 4.6 1.9 1.6 0 3.3-.6 4.6-1.9 2.6-2.6 2.6-6.7 0-9.2L73.4 88.3c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l62.4 62.4c1.3 1.3 2.9 1.9 4.6 1.9s3.3-.6 4.6-1.9h0a6.46 6.46 0 0 0 0-9.1l-48.5-48.5c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l70.4 70.4c1.3 1.3 2.8 1.8 4.3 1.8 3.1 0 6.1-2.4 6.2-6l.6-21.8c0-7.3 6-13.2 13.2-13.2 7.3 0 13.2 6 13.2 13.2l12.7 92.5 12.3 14.3c1.9 2.2 1.8 5.6-.3 7.6L196.9 283c-1.1 1.1-2.5 1.6-4 1.6a5.43 5.43 0 0 1-3.4-1.2l-15.7-12c-.7-.5-1.4-.9-2.3-1-27.2-5.9-58.1-29.7-87.7-59.2l-34.6-34.6c-5.5-5.6-5.1-15 1.3-20z"/>
                            </svg>
                            <p class="ml-3 text-sm md:text-base">{{ $highlight_post->likes_count }} <span class="hidden sm:inline ml-1">claps</span></p>
                        </a>
                        <a href="{{ route('posts.show', ['user'=>$highlight_post->user->username,'post'=>$highlight_post->slug]) }}" class="comment-ph flex items-center ml-5">
                            <svg class="w-5 h-5 md:w-6 md:h-6" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 473 473" style="enable-background:new 0 0 473 473;" xml:space="preserve" fill="currentColor">
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
                            <p class="ml-2 text-sm md:text-base">{{ sizeOf($highlight_post->comments) }} <span class="hidden sm:inline ml-1">responses</span></p>
                        </a>
                    </div>
                    {{-- Share Social Media, Bookmark etc --}}
                    <div class="show-social-media text-xl flex items-center">
                        <div class="relative" title="share">
                            <svg class="open-dd-post cursor-pointer" width="25" height="25" class="r" fill-rule="evenodd" fill="currentColor">
                                <path d="M15.6 5a.42.42 0 0 0 .17-.3.42.42 0 0 0-.12-.33l-2.8-2.79a.5.5 0 0 0-.7 0l-2.8 2.8a.4.4 0 0 0-.1.32c0 .12.07.23.16.3h.02a.45.45 0 0 0 .57-.04l2-2V10c0 .28.23.5.5.5s.5-.22.5-.5V2.93l2.02 2.02c.08.07.18.12.3.13.11.01.21-.02.3-.08v.01"></path><path d="M18 7h-1.5a.5.5 0 0 0 0 1h1.6c.5 0 .9.4.9.9v10.2c0 .5-.4.9-.9.9H6.9a.9.9 0 0 1-.9-.9V8.9c0-.5.4-.9.9-.9h1.6a.5.5 0 0 0 .35-.15A.5.5 0 0 0 9 7.5a.5.5 0 0 0-.15-.35A.5.5 0 0 0 8.5 7H7a2 2 0 0 0-2 2v10c0 1.1.9 2 2 2h11a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"></path>
                            </svg>
                            {{-- dropdown sosmed --}}
                            <div class="show-dd-post dd-sosmed-bawah rounded-sm text-b_base">
                                <a class="inline-flex items-center" href="https://twitter.com/intent/tweet?text={{ '"' . preg_replace('/#[a-z0-9]+/i', '', $highlight_post->title) . '"' }} {{ $highlight_post->user->twitter ? '—@'.$highlight_post->user->twitter : '—'.$highlight_post->user->username }}&url={{ $highlight_post->getURL() }}&hashtags={{ $highlight_post->allTagsShareTwitter() }}" target="blank">
                                    <i class="fab fa-twitter w-7"></i>
                                    <span class="text-sm">Twitter</span>
                                </a>
                                <a class="inline-flex items-center" href="https://www.linkedin.com/sharing/share-offsite/?url={{ $highlight_post->getURL() }}" target="blank">
                                    <i class="fab fa-linkedin w-7"></i>
                                    <span class="text-sm">LinkedIn</span>
                                </a>
                                <a class="share-to-facebook cursor-pointer inline-flex items-center" data-url="https://www.facebook.com/sharer/sharer.php?u={{ $highlight_post->getURL() }}&quote={{ $highlight_post->title }}" target="blank">
                                    <i class="fab fa-facebook-square w-7"></i>
                                    <span class="text-sm">Facebook</span>
                                </a>
                                <div class="triangle-sosmed-bawah"></div>
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
                                @if (in_array($highlight_post->id, $bookmark))
                                    <div class="bookmark-post cursor-pointer" data-ip="{{ $highlight_post->id }}" title="Unsave post">
                                        <svg class="bookmarked w-7 h-7" viewBox="0 0 25 25" fill="currentColor">
                                            <path d="M19 6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14.66h.01c.01.1.05.2.12.28a.5.5 0 0 0 .7.03l5.67-4.12 5.66 4.13c.2.18.52.17.71-.03a.5.5 0 0 0 .12-.29H19V6z"></path>
                                        </svg>
                                    </div>
                                @else
                                    @if (isset($_COOKIE['archive']))
                                        @if (in_array($highlight_post->id, $archive))
                                            <div class="remove-ar-p cursor-pointer" data-ip="{{ $highlight_post->id }}" title="Unarchive post">
                                                <svg class="p-archived" data-ip="{{ $highlight_post->id }}" width="25" height="25" viewBox="0 0 25 25" fill="currentColor">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20.48 7.45H3.46v10.13H16a.47.47 0 1 1 0 .94H3.46c-.54 0-.99-.42-.99-.94V7.45c0-.52.45-.93 1-.93h17c.55 0 1 .41 1 .93v5.57a.5.5 0 0 1-1 0V7.45zM5.47 10.02c0-.28.22-.5.5-.5h9.11a.5.5 0 1 1 0 1H5.97a.5.5 0 0 1-.5-.5zm.51 2.5a.5.5 0 0 0-.51.5c0 .27.23.5.51.5h5.98a.5.5 0 0 0 .51-.5.5.5 0 0 0-.51-.5H5.98zm12.52 3.02c.2-.2.5-.2.7 0l1.77 1.77 1.77-1.77a.5.5 0 1 1 .7.7l-1.76 1.78 1.76 1.76a.5.5 0 1 1-.7.71l-1.77-1.77-1.77 1.77a.5.5 0 0 1-.7-.7l1.76-1.77-1.76-1.77a.5.5 0 0 1 0-.7z"></path>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="bookmark-post cursor-pointer" data-ip="{{ $highlight_post->id }}" title="Save post">
                                                <svg class="w-7 h-7" viewBox="0 0 25 25" fill="currentColor">
                                                    <path d="M19 6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14.66h.01c.01.1.05.2.12.28a.5.5 0 0 0 .7.03l5.67-4.12 5.66 4.13a.5.5 0 0 0 .71-.03.5.5 0 0 0 .12-.29H19V6zm-6.84 9.97L7 19.64V6a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v13.64l-5.16-3.67a.49.49 0 0 0-.68 0z" fill-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    @else
                                        <div class="bookmark-post cursor-pointer" data-ip="{{ $highlight_post->id }}" title="Save post">
                                            <svg class="w-7 h-7" viewBox="0 0 25 25" fill="currentColor">
                                                <path d="M19 6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14.66h.01c.01.1.05.2.12.28a.5.5 0 0 0 .7.03l5.67-4.12 5.66 4.13a.5.5 0 0 0 .71-.03.5.5 0 0 0 .12-.29H19V6zm-6.84 9.97L7 19.64V6a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v13.64l-5.16-3.67a.49.49 0 0 0-.68 0z" fill-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @endif
                                @endif
                            @else
                                @if (isset($_COOKIE['archive']))
                                    @if (in_array($highlight_post->id, $archive))
                                    <div class="remove-ar-p cursor-pointer" data-ip="{{ $highlight_post->id }}" title="Unarchive post">
                                        <svg class="p-archived" data-ip="{{ $highlight_post->id }}" width="25" height="25" viewBox="0 0 25 25" fill="currentColor">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M20.48 7.45H3.46v10.13H16a.47.47 0 1 1 0 .94H3.46c-.54 0-.99-.42-.99-.94V7.45c0-.52.45-.93 1-.93h17c.55 0 1 .41 1 .93v5.57a.5.5 0 0 1-1 0V7.45zM5.47 10.02c0-.28.22-.5.5-.5h9.11a.5.5 0 1 1 0 1H5.97a.5.5 0 0 1-.5-.5zm.51 2.5a.5.5 0 0 0-.51.5c0 .27.23.5.51.5h5.98a.5.5 0 0 0 .51-.5.5.5 0 0 0-.51-.5H5.98zm12.52 3.02c.2-.2.5-.2.7 0l1.77 1.77 1.77-1.77a.5.5 0 1 1 .7.7l-1.76 1.78 1.76 1.76a.5.5 0 1 1-.7.71l-1.77-1.77-1.77 1.77a.5.5 0 0 1-.7-.7l1.76-1.77-1.76-1.77a.5.5 0 0 1 0-.7z"></path>
                                        </svg>
                                    </div>
                                    @else
                                        <div class="bookmark-post cursor-pointer" data-ip="{{ $highlight_post->id }}" title="Save post">
                                            <svg class="w-7 h-7" viewBox="0 0 25 25" fill="currentColor">
                                                <path d="M19 6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14.66h.01c.01.1.05.2.12.28a.5.5 0 0 0 .7.03l5.67-4.12 5.66 4.13a.5.5 0 0 0 .71-.03.5.5 0 0 0 .12-.29H19V6zm-6.84 9.97L7 19.64V6a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v13.64l-5.16-3.67a.49.49 0 0 0-.68 0z" fill-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @endif
                                @else
                                    <div class="bookmark-post cursor-pointer" data-ip="{{ $highlight_post->id }}" title="Save post">
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
                            <div class="show-dd-post dd-setting-bawah rounded-sm text-b_base">
                                @if (Auth::user())
                                    @if (Auth::user()->id == $highlight_post->user_id)
                                        <a class="flex items-center" href="{{ route('posts.edit', $highlight_post->slug) }}">
                                            <i class="fas fa-edit w-7"></i>
                                            <span class="text-sm w-16">Edit post</span>
                                        </a>
                                    @endif
                                @endif
                                <a class="copy-url flex items-center cursor-pointer" data-url="{{ $highlight_post->getURL() }}">
                                    <i class="fas fa-link w-7"></i>
                                    <span class="text-sm w-16">Copy link</span>
                                </a>
                                <div class="triangle-setting-bawah"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Small device side Content in mid --}}
            <div class="block lg:hidden">
                <hr class="mt-5">
                <p class="t-side-ch text-sm sm:text-b_base font-semibold mt-5 uppercase">Find the category that suits you</p>
                <div class="sidebar-categories-tag-list mt-3">
                    @foreach ($categories as $category)
                        <a class="mt-2 text-sm" href="{{ route('categories.show', $category->slug) }}">{{ $category->name }}</a>
                    @endforeach
                </div>
                <div class="t-side-ch text-sm sm:text-b_base font-semibold mt-5 block hover:text-green-300 cursor-pointer uppercase">See all Tags</div>
                <div class="sidebar-categories-tag-list mt-3">
                    @foreach ($tags as $tag)
                    <a class="mt-2 text-sm" href="{{ route('tags.show', $tag->slug) }}">{{ $tag->name }}</a>
                    @endforeach
                </div>
            </div>
            
            {{-- List Post --}}
            <div class="see-more-txt flex justify-center items-center mt-8 mb-4">
                <h3 class="px-2 font-semibold text-sm sm:text-base uppercase text-center">See More</h3>
            </div>
            <div class="list-p-all flex flex-col relative pb-18" data-paginate="{{ $posts->lastPage() }}">
                @forelse ($posts as $i => $post)
                    <div class="list-post flex items-center py-5 sm:py-10 border-b">
                        {{-- img --}}
                        <a href="{{ route('posts.show', ['user'=>$post->user->username,'post'=>$post->slug]) }}">
                            <div class="w-16 xs:w-24 sm:w-48 md:w-56 h-16 xs:h-24 sm:h-48 md:h-56">
                                <img class="w-full h-full object-cover object-center" src="{{ $post->getThumbnail() }}" alt="{{ $post->title }}">
                            </div>
                        </a>
                        {{-- body --}}
                        <div class="home-post-list-txt flex flex-col flex-grow ml-5">
                            <a href="{{ route('categories.show', $post->category->slug) }}" class="flex items-center">
                                <p class="uppercase text-xs md:text-sm text-red-500">{{ $post->category->name }}</p>
                                <p class="time-readlist ml-2 text-xs italic">&#8212; {{ $post->estimatedReadingTime() }}</p>
                            </a>
                            <a href="{{ route('posts.show', ['user'=>$post->user->username,'post'=>$post->slug]) }}">
                                <h2 class="t-listpost mt-1 font-semibold text-sm xs:text-b_base sm:text-0.5xl md:text-1.5xl leading-5 sm:leading-6 md:leading-7">{{ Str::limit($post->title, 45, '...') }}</h2>
                                <h4 class="hidden mt-1 sm:mt-2 sm:block text-b_base lg:text-base text-justify">{!! nl2br(e(Str::limit($post->header, 130, '...'))) !!}</h4>
                            </a>
                            <div class="flex justify-between items-center mt-1 sm:mt-2">
                                {{-- profile --}}
                                <div class="flex items-center">
                                    <a href="{{ route('profile.show', $post->user->username) }}" class="relative inline-block">
                                        <svg class="w-5 h-5 sm:w-8 sm:h-8 text-green-500" viewBox="0 0 36 36">
                                            <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M18 1.87c-6.63 0-12.4 4.14-15.21 10.21L2 11.71C4.94 5.37 11 1 18 1s13.06 4.37 16 10.71l-.79.37C30.4 6.01 24.63 1.88 18 1.88zM2.79 23.92c2.81 6.07 8.58 10.2 15.21 10.2 6.63 0 12.4-4.13 15.21-10.2l.79.37C31.06 30.63 25 35 18 35S4.94 30.63 2 24.29l.79-.37z"></path></svg>
                                        <div class="absolute bottom-0 w-full h-full flex justify-center items-center">
                                            <img class="home-post-list-profile-img rounded-full" src="{{ $post->user->profile_picture != null ? $post->user->getProfilePicture() : $post->user->gravatar() }}" onerror="this.onerror=null; this.src='{{ asset('/img/no_profile.png') }}'" alt="{{ $post->user->name }}">
                                        </div>
                                    </a>
                                    <div class="flex items-center text-xxs sm:text-0.5sm ml-2">by <a href="{{ route('profile.show', $post->user->username) }}" class="text-b_base font-bold text-green-600 ml-1">{{ $post->user->username }}</a></div>
                                </div>
                                <div class="listp-date text-xxs sm:text-xs">
                                    <p class="ml-2 text-gray-00">&#8212; {{ $post->created_at->format('d M, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    There are no post.
                @endforelse
                @if ($posts->lastPage() > 1)
                    <div class="btn-loadmore flex justify-center sm:justify-end mt-5">
                        <p class="text-xs xs:text-0.5sm sm:text-sm uppercase">Load more</p>
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
        </div>

        {{-- Right Side Content --}}
        <div class="pl-6 hidden w-0 lg:w-4/12 lg:flex lg:flex-col">
            <div class="sticky top-0 py-16">
                <p class="t-side-ch text-sm sm:text-b_base font-semibold uppercase">Find the category that suits you</p>
                <hr class="mt-3">
                <div class="sidebar-categories-tag-list mt-3">
                    @foreach ($categories as $category)
                        <a class="mt-2" href="{{ route('categories.show', $category->slug) }}">{{ $category->name }}</a>
                    @endforeach
                </div>
                <a href="#" class="t-side-ch text-sm sm:text-b_base font-semibold mt-5 block hover:text-green-300 uppercase">See all Tags</a>
                <hr class="mt-3">
                <div class="sidebar-categories-tag-list mt-3">
                    @foreach ($tags as $tag)
                        <a class="mt-2" href="{{ route('tags.show', $tag->slug) }}">{{ $tag->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Open Youtube Video --}}
    @if ($highlight_post->youtube_link)
        <div class="open-yt flex items-center justify-center fixed top-0 w-full h-full">
            <div class="open-yt-content">
                <div class="flex justify-between mb-3">
                    <h1 class="text-white text-sm mr-2">{{ Str::limit($highlight_post->title, 35, '...') }}</h1>
                    <div class="close-content-yt flex items-center cursor-pointer">
                        <div class="txt-close-yt flex items-center mr-3">
                            <h2 class="text-white text-sm">Close</h2>
                        </div>
                        <div class="icon-close-yt">
                            <svg class="w-4 h-4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path class="block" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <iframe id="openYTHome" width="560" height="315" src="https://www.youtube.com/embed/{{ $highlight_post->youtubeLink() }}?enablejsapi=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <div class="fade-effect-yt"></div>
        </div>
    @endif

    {{-- Set Password For user login with provider --}}
    @auth
        @if (!Auth::user()->password)
            <div class="set-password-panel on z-20">
                <div class="content-spassword @if($errors->get('password') || $errors->get('email')) calmdown @else effectJoin @endif flex flex-col w-full sm:w-136 h-full sm:h-auto sm:rounded-md">
                    {{-- header --}}
                    <div class="header-spu sticky sm:static top-0 flex justify-between items-center px-6 py-3 border-b z-3 sm:rounded-t-md">
                        <p class="font-bold text-md">Set Your Password</p>
                        <div class="info-spu relative cursor-pointer">
                            <svg class="w-5 h-4.5" aria-hidden="true" focusable="false" data-prefix="far" data-icon="info-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor" d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 448c-110.532 0-200-89.431-200-200 0-110.495 89.472-200 200-200 110.491 0 200 89.471 200 200 0 110.53-89.431 200-200 200zm0-338c23.196 0 42 18.804 42 42s-18.804 42-42 42-42-18.804-42-42 18.804-42 42-42zm56 254c0 6.627-5.373 12-12 12h-88c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h12v-64h-12c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h64c6.627 0 12 5.373 12 12v100h12c6.627 0 12 5.373 12 12v24z"></path>
                            </svg>
                            <div class="h-info-spu">
                                <p class="text-0.5sm py-2 px-3" style="color: white">You have to set your password, because you have registered with {{ Auth::user()->provider }}.</p>
                                <div class="triangle"></div>
                            </div>
                        </div>
                    </div>
                    {{-- Body --}}
                    <div class="flex flex-col sm:flex-row pt-6 sm:pt-0">
                        {{-- img --}}
                        <div class="w-full sm:w-70% pl-2 pt-2 flex justify-center sm:hidden">
                            @include('layouts.svg.setPasswordSM')
                        </div>
                        {{-- form set password --}}
                        <div class="form-setpassword w-full sm:w-70% py-5 pl-6 pr-6 sm:pr-0">
                            <div class="desc-cpu flex justify-center sm:justify-start text-center sm:text-left text-sm mb-3">
                                <p class="w-64 sm:w-full">Almost done! Before you get started, please set your password.</p>
                            </div>
                            <form action="{{ route('passwords.setPassword', Auth::user()->email) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            @method('patch')
                                <div class="flex flex-col">
                                    <label for="email" class="text-0.5sm cursor-pointer flex items-center justify-between">
                                        <h1 class="font-semibold">E-mail :</h1>
                                        <h2><span>{{ strlen(Auth::user()->email) }}</span>/50</h2>
                                    </label>
                                    <input type="text" name="email" id="email" class="border mt-1 text-sm focus:border-green-600" placeholder="Input your email." value="{{ Auth::user()->email }}" data-l="50" disabled>
                                </div>
                                <div class="flex flex-col mt-3">
                                    <label for="password" class="text-0.5sm cursor-pointer flex items-center justify-between">
                                        <h1 class="font-semibold">Password :</h1>
                                        <h2><span>{{ strlen(Auth::user()->password) }}</span>/50</h2>
                                    </label>
                                    <input type="password" name="password" id="password" class="border mt-1 text-sm focus:border-green-600" placeholder="Input your password." value="" data-l="50">
                                </div>
                                <div class="flex flex-col mt-3">
                                    <label for="password_confirmation" class="text-0.5sm cursor-pointer flex items-center justify-between">
                                        <h1 class="font-semibold">Confirm Password :</h1>
                                        <h2><span>{{ strlen(Auth::user()->password) }}</span>/50</h2>
                                    </label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="border mt-1 text-sm focus:border-green-600" placeholder="Input your name." value="" data-l="50">
                                    @error('password')
                                        <div class="error-msg-p text-0.5sm mt-2 text-red-500 -mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </form>
                        </div>
                        {{-- img --}}
                        <div class="hidden w-full sm:w-70% pt-5 pl-2 sm:flex justify-center" style="height: inherit">
                            @include('layouts.svg.setPasswordLG')
                        </div>
                    </div>
                    {{-- Footer --}}
                    <div class="footer-ep px-8 pt-0 pb-10 sm:py-3.5 border-t-0 sm:border-t flex sm:rounded-b-md justify-end sm:justify-start">
                        <div class="submit-form-profile cursor-pointer">
                            <div class="btn-save-spu bg-green-500 hover:bg-green-600 px-5 py-1 rounded-full text-sm text-white">Save</div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endauth
@endsection

@section('script_page')
    <script src="{{ asset('js/home.js') }}"></script>
@endsection