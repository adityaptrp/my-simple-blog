
@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="all-showpost-content container flex items-center justify-center px-6 sm:px-7 md:px-0 py-10">
        {{-- leftside --}}
        <div class="hidden xl:flex lg:flex-col w-3/12">
            <div class="show-post-left-content fixed top-0 w-50 flex flex-col justify-center px-7 h-100vh">
                {{-- profile --}}
                <a href="{{ route('profile.show', $post->user->username) }}" class="sp-side-username text-lg font-bold whitespace-no-wrap overflow-hidden" style="text-overflow: ellipsis">{{ $post->user->username }}</a>
                @if($post->user->bio)
                    <h2 class="text-sm mt-1">{{ $post->user->bio }}</h2>
                @endif
                @auth
                    @if (!$post->user->bio || !$post->user->youtube_link_id)
                        @if(Auth::user()->id == $post->user->id)
                            <a href="{{ route('profile.show', $post->user->username) }}" class="shortcut-ep font-semibold mt-2 px-4 py-2 text-center border rounded-sm text-0.5sm">Edit your profile.</a>
                        @endif
                    @endif
                @endauth
                    {{-- yt content --}}
                @if($post->user->youtube_link_id)
                    <div class="embed-subscribe-yt mt-4">
                        <div class="g-ytsubscribe" data-channelid="{{ $post->user->youtube_link_id }}" data-layout="full" data-count="hidden"></div>
                    </div>
                @endif
                <hr class="my-6">
                {{-- comment n like --}}
                <div class="all-icon-p like-s flex items-center relative">
                    @if (Cookie::get('post_clapped'))
                        <div class="s-likepost flex relative items-center h-full cursor-pointer">
                            <svg class="w-5 h-5 md:w-6 md:h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 285.25 284.04" fill="salmon" fill="currentColor">
                                <path d="M116.87 39.2l-7.77-7.78a13.43 13.43 0 0 0-20 1.18 13.65 13.65 0 0 0 1.34 18l6.17 6.18a23.91 23.91 0 0 1 2.75 2.08 25 25 0 0 1 5-11.17 25.37 25.37 0 0 1 12.51-8.49zm95.83 39.6l-61.87-61.87a13.41 13.41 0 0 0-20 1.19 13.64 13.64 0 0 0 1.34 18l70.92 70.2.23-8.12a25.23 25.23 0 0 1 9.38-19.39zm70.9 97a5.62 5.62 0 0 0 .29-7.64l-12.28-14.28-12.74-92.47c-.197-7.173-6.07-12.886-13.245-12.886S232.577 54.237 232.38 61.4l-.38 12a25.28 25.28 0 0 1 21.78 24.06l12.22 88.3 3.53 4.1zM28.44 42.85c2.706 1.914 6.45 1.27 8.365-1.435s1.27-6.45-1.435-8.365L20.4 22.4a6 6 0 0 0-9.592 4.297A6 6 0 0 0 13.46 32.2zm28.22-21.78L50.2 3.9A6 6 0 1 0 39 8.11l6.46 17.18a6 6 0 1 0 11.23-4.22zM0 60.66a5.94 5.94 0 0 0 5.88 6l18.47.3a6 6 0 0 0 6-5.93 5.83 5.83 0 0 0-5.88-5.92L6 55.02a5.8 5.8 0 0 0-6 5.64zm83.92 149.92c29.57 29.57 60.5 53.32 87.65 59.23a5.76 5.76 0 0 1 2.27 1.05l15.66 12a5.61 5.61 0 0 0 7.38-.48l69.67-69.56a5.62 5.62 0 0 0 .3-7.64l-12.28-14.28-12.74-92.5a13.25 13.25 0 1 0-26.49 0l-.63 21.82a6.14 6.14 0 0 1-6.19 6 6.05 6.05 0 0 1-4.31-1.82l-70.43-70.43a13.42 13.42 0 0 0-20 1.19 13.66 13.66 0 0 0 1.34 18l48.52 48.52a6.45 6.45 0 0 1 0 9.12h0a6.51 6.51 0 0 1-9.23 0L92.05 68.46a13.42 13.42 0 0 0-20 1.18 13.65 13.65 0 0 0 1.34 18l62.08 62.08a6.55 6.55 0 0 1 0 9.25 6.46 6.46 0 0 1-9.11 0L77.58 110.2a13.41 13.41 0 0 0-20 1.18 13.65 13.65 0 0 0 1.34 18l48.35 48.35a6.69 6.69 0 0 1 0 9.46l-.08.08a6.18 6.18 0 0 1-8.74 0l-30-30a14.09 14.09 0 0 0-9.92-4.13 13 13 0 0 0-8.11 2.79 13.41 13.41 0 0 0-1.18 20z"/>
                            </svg>
                            <p class="ml-3 text-sm">{{ $post->likes_count }}</p>
                            <div class="s-hover-lp">
                                <p class="text-xs font-semibold">Already applauded.</p>
                                <div class="triangle-left-lps"></div>
                            </div>
                        </div>
                    @else
                        <div class="post-like-side flex items-center h-full cursor-pointer" data-postid="{{ $post->id }}">
                            <svg class="w-5 h-5 md:w-6 md:h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 297.2 297.2" fill="currentColor">
                                <path d="M28.4 43.4c1.1.7 2.3 1.1 3.5 1.1 1.9 0 3.7-.9 4.9-2.5 1.9-2.7 1.3-6.5-1.4-8.4L20.4 23c-2.7-1.9-6.4-1.3-8.4 1.4s-1.3 6.4 1.4 8.4l15 10.6zm28.3-21.7L50.2 4.5C49 1.4 45.6-.2 42.5 1S37.8 5.6 39 8.7l6.5 17.2c.9 2.4 3.2 3.9 5.6 3.9.7 0 1.4-.1 2.1-.4 3.1-1.2 4.6-4.6 3.5-7.7zM0 61.3c-.1 3.3 2.6 6 5.9 6l18.5.3c3.3 0 5.9-2.7 6-5.9.1-3.3-2.6-5.9-5.9-5.9L6 55.6c-3.3 0-5.9 2.4-6 5.7zm33.4 104.3c-.4 7.2 2.3 14.3 7.4 19.4l34.6 34.6c16.4 16.4 32 29.8 46.3 39.8 16.5 11.5 31.9 19 45.9 22.3l14.5 11.2c3.1 2.3 6.9 3.6 10.7 3.6 4.7 0 9.1-1.8 12.4-5.1l69.7-69.6c6-6 6.8-15.3 2.2-22.2l14.8-14.8c6.5-6.5 6.9-17 .9-24l-10-11.6L270.9 61c-.5-13.5-11.6-24.3-25.2-24.3-13.9 0-25.1 11.2-25.2 25l-.2 8.1-61-60.8c-4.8-4.8-11.2-7.4-17.9-7.4h0c-7.8 0-15.1 3.5-19.9 9.6a25.2 25.2 0 0 0-5 11.2c-4.6-4.1-10.5-6.3-16.8-6.3-7.8 0-15.1 3.5-19.9 9.6-6.4 8.1-7 19.1-2.2 27.9-5.8 1.2-11 4.4-14.8 9.1-7 8.8-7.1 21.1-.8 30.3.3.8.7 1.6 1.1 2.3-5.8 1.2-11 4.3-14.8 9.1-8 10.1-7 24.7 2.3 34l2.4 2.4c.2.5.5.9.7 1.4-3.8.8-7.5 2.4-10.6 4.9-5.8 4.5-9.3 11.3-9.7 18.5zm83.5-125.8c-4.9 1.5-9.2 4.4-12.5 8.5a25.2 25.2 0 0 0-5 11.2c-.9-.8-1.8-1.4-2.7-2.1l-6.2-6.2c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l7.7 7.8zm95.8 39.6c-5.7 4.6-9.3 11.6-9.4 19.4l-.2 8.1-70.9-70.2c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l61.8 61.9zm56.8 111.1l-3.5-4.1-12.1-88.3C253.4 85.7 244 75.6 232 74l.3-12c0-7.3 6-13.2 13.2-13.2 7.3 0 13.2 6 13.2 13.2l12.7 92.5 12.3 14.3c1.9 2.2 1.8 5.6-.3 7.6l-13.9 14.1zm-219-33.9c2.4-1.9 5.2-2.8 8.1-2.8a14.01 14.01 0 0 1 9.9 4.1l30 30c1.2 1.2 2.8 1.8 4.4 1.8s3.2-.6 4.4-1.8l.1-.1c2.6-2.6 2.6-6.8 0-9.5L58.9 130c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l48.8 48.8c1.3 1.3 2.9 1.9 4.6 1.9 1.6 0 3.3-.6 4.6-1.9 2.6-2.6 2.6-6.7 0-9.2L73.4 88.3c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l62.4 62.4c1.3 1.3 2.9 1.9 4.6 1.9s3.3-.6 4.6-1.9h0a6.46 6.46 0 0 0 0-9.1l-48.5-48.5c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l70.4 70.4c1.3 1.3 2.8 1.8 4.3 1.8 3.1 0 6.1-2.4 6.2-6l.6-21.8c0-7.3 6-13.2 13.2-13.2 7.3 0 13.2 6 13.2 13.2l12.7 92.5 12.3 14.3c1.9 2.2 1.8 5.6-.3 7.6L196.9 283c-1.1 1.1-2.5 1.6-4 1.6a5.43 5.43 0 0 1-3.4-1.2l-15.7-12c-.7-.5-1.4-.9-2.3-1-27.2-5.9-58.1-29.7-87.7-59.2l-34.6-34.6c-5.5-5.6-5.1-15 1.3-20z"/>
                            </svg>
                            <p class="ml-3 text-sm">{{ $post->likes_count }}</p>
                        </div>
                    @endif
                </div>
                <div class="all-icon-p flex items-center">
                    <div class="btn-open-comment flex items-center mt-6 ml-1 cursor-pointer h-full">
                        <svg class="w-4 h-4 md:w-5 md:h-5" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 473 473" style="enable-background:new 0 0 473 473;" xml:space="preserve" fill="currentColor">
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
                        <p class="content-responses ml-3 text-sm">{{ sizeOf($sizeOfComment) }}</p>
                    </div>
                </div>
                {{-- BOOKMARK N ARCHIVE --}}
                <div class="mt-6 flex items-center all-icon-p">
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
            </div>
        </div>

        {{-- Main Side --}}
        <div class="show-main-content w-full md:w-10/12 lg:w-8/12">
            {{-- Search Engine --}}
            <div class="search mb-5">
                <form action="{{ route('search.posts') }}" method="get" class="w-full" autocomplete="off">
                    <input type="text" name="s" class="search-input" placeholder="Search an article">
                    <button class="btn-search" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            
            <h1 class="title-post text-2.5xl sm:text-3xl md:text-4xl leading-tight font-black">{{ $post->title }}</h1>
            @if ($post->subtitle)
                <h2 class="subtitle-p text-md md:text-lg lg:text-xl mt-2">{{ $post->subtitle }}</h2>
            @endif
            <div class="flex flex-col md:flex-row md:justify-between mt-5">
                {{-- profile --}}
                <div id="showPostProfile" class="flex items-center">
                    <a href="{{ route('profile.show', $post->user->username) }}" class="relative inline-block">
                        <svg class="w-11 h-11 md:w-12 md:h-12 text-green-500" viewBox="0 0 36 36">
                            <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M18 1.87c-6.63 0-12.4 4.14-15.21 10.21L2 11.71C4.94 5.37 11 1 18 1s13.06 4.37 16 10.71l-.79.37C30.4 6.01 24.63 1.88 18 1.88zM2.79 23.92c2.81 6.07 8.58 10.2 15.21 10.2 6.63 0 12.4-4.13 15.21-10.2l.79.37C31.06 30.63 25 35 18 35S4.94 30.63 2 24.29l.79-.37z"></path></svg>
                        <div class="absolute bottom-0 w-full h-full flex justify-center items-center">
                            <img class="show-profile-img rounded-full" src="{{ $post->user->profile_picture != null ? $post->user->getProfilePicture() : $post->user->gravatar() }}" onerror="this.onerror=null; this.src='{{ asset('/img/no_profile.png') }}'" alt="{{ $post->user->name }}">
                        </div>
                    </a>
                    <div class="flex flex-col ml-2">
                        <div class="flex items-center">
                            <a href="{{ route('profile.show', $post->user->username) }}" class="text-0.5sm md:text-b_base font-bold text-green-600">{{ $post->user->username }}</a>
                            @if ($post->user->instagram)
                                <a class="btn-p-follow ml-2 text-xs" href="https://www.instagram.com/{{ $post->user->instagram }}/" target="blank">Follow</a>
                            @endif
                        </div>
                        <p class="tgl-post-view text-0.5sm">{{ $post->created_at->format('M d, Y') }}  &bull;  {{ $post->views_count > 1000 ? '1.000+' : $post->views_count }} times read {!! $post->checkPopularPost() !!}</p>
                    </div>
                </div>
                {{-- Share Social Media, Bookmark etc --}}
                <div class="show-social-media text-xl flex items-center mt-4 md:mt-0">
                    <div class="relative" title="share">
                        <svg class="open-dd-post cursor-pointer" width="25" height="25" class="r" fill-rule="evenodd" fill="currentColor">
                            <path d="M15.6 5a.42.42 0 0 0 .17-.3.42.42 0 0 0-.12-.33l-2.8-2.79a.5.5 0 0 0-.7 0l-2.8 2.8a.4.4 0 0 0-.1.32c0 .12.07.23.16.3h.02a.45.45 0 0 0 .57-.04l2-2V10c0 .28.23.5.5.5s.5-.22.5-.5V2.93l2.02 2.02c.08.07.18.12.3.13.11.01.21-.02.3-.08v.01"></path><path d="M18 7h-1.5a.5.5 0 0 0 0 1h1.6c.5 0 .9.4.9.9v10.2c0 .5-.4.9-.9.9H6.9a.9.9 0 0 1-.9-.9V8.9c0-.5.4-.9.9-.9h1.6a.5.5 0 0 0 .35-.15A.5.5 0 0 0 9 7.5a.5.5 0 0 0-.15-.35A.5.5 0 0 0 8.5 7H7a2 2 0 0 0-2 2v10c0 1.1.9 2 2 2h11a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"></path>
                        </svg>
                        {{-- dropdown sosmed --}}
                        <div class="show-dd-post dd-sosmed-atas rounded text-b_base">
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
                        <div class="show-dd-post dd-setting-atas rounded text-b_base">
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

            {{-- img --}}
            @if ($post->youtube_link)
                <div class="show-post-img mt-7 relative cursor-pointer">
                    <img class="w-full h-50 sm:h-72 md:h-96 object-cover object-center" src="{{ $post->getThumbnail() }}" alt="{{ $post->title }}">
                    <div class="show-post-title-img flex items-center absolute">
                        <i class="fas fa-exclamation-circle"></i>
                        <div class="ml-2"><p class="text-white text-sm">Play documentation video</p></div>
                    </div>
                    <div class="cover-icon-play absolute bottom-0 w-full h-full flex justify-center items-center">
                        <div class="show-post-icon-play w-full h-full flex justify-center items-center">
                            <i class="fab fa-youtube"></i>
                        </div>
                    </div>
                </div>
            @endif
            @if ($post->thumbnail && !$post->youtube_link)
                <div class="mt-7 relative">
                    <img class="w-full h-50 sm:h-72 md:h-96 object-cover object-center" src="{{ $post->getThumbnail() }}" alt="{{ $post->title }}">
                </div>
            @endif
            
            {{-- body --}}
            <div class="show-post-body flex flex-col">
                {{-- header --}}
                <div class="selectable-text-area mt-7 text-justify text-base sm:text-lg leading-6 sm:leading-7">
                    {!! nl2br(e($post->header)) !!}
                </div>
                {{-- quote --}}
                @if ($post->quote)
                    <div class="selectable-text-area show-post-quote flex flex-col mt-6">
                        <h1 class="text-lg sm:text-xl md:text-0.5xl mt-1">{{ $post->quote }}</h1>
                        <p class="text-xs sm:text-sm mt-1">&#8212; {{ $post->quote_author }}</p>
                    </div>
                @endif
                {{-- Body --}}
                <div class="selectable-text-area mt-7 text-justify text-base sm:text-lg leading-6 sm:leading-7">
                    {!! $post->body !!}
                </div>
                {{-- Thumbnail --}}
                @if ($post->sub_thumbnail1 && $post->sub_thumbnail2)
                    <div class="flex gap-5 mt-5">
                        <div class="w-1/2 flex justify-center items-center">
                            <img class="w-full h-32 sm:h-48 object-cover object-center" src="{{ $post->getSubThumbnail1() }}" alt="">
                        </div>
                        <div class="w-1/2 flex justify-center items-center">
                            <img class="w-full h-32 sm:h-48 object-cover object-center" src="{{ $post->getSubThumbnail2() }}" alt="">
                        </div>
                    </div>
                @endif
                {{-- footer --}}
                @if ($post->footer)
                    <div class="selectable-text-area mt-7 text-justify text-base sm:text-lg leading-6 sm:leading-7">
                        {!! $post->footer !!}
                    </div>
                @endif

                {{-- Button Share Text Selected --}}
                <div id="btn-share-txt">
                    <div id="all-btn-share-txt" class="text-lg">
                        <button id="btn-s-twitter" data-tags="{{ $post->allTagsShareTwitter() }}" data-user="{{ $post->user->twitter ? '—@'.$post->user->twitter : '—'.$post->user->username }}"><i class="fab fa-twitter"></i></button>
                        <button class="hidden sm:block" id="btn-s-comment"><i class="fas fa-comment"></i></button>
                        <button id="btn-s-facebook"><i class="fab fa-facebook-square"></i></button>
                        <div class="triangle-down-txt-share"></div>
                    </div>
                </div>
            </div>

            {{-- category tag --}}
            <div class="flex flex-col mt-5">
                <div class="show-post-category-tag">
                    <p class="inline-block text-b_base sm:text-base">Category :</p>
                    <a class="inline-block ml-2" href="{{ route('categories.show', $post->category->slug) }}">{{ $post->category->name }}</a>
                </div>
                <div class="show-post-category-tag mt-1">
                    @if (sizeOf($post->tags) != 0)
                        <p class="inline-block text-b_base sm:text-base">Tags :</p>
                        @foreach ($post->tags as $tag)
                            <a class="inline-block ml-1 mt-2" href="{{ route('tags.show', $tag->slug) }}">{{ $tag->name }}</a>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- button like n comment --}}
            <div class="flex justify-between items-center mt-7 px-2">
                <div class="like-m flex items-center relative">
                    @if (Cookie::get('post_clapped'))
                        <div class="all-icon-p m-likepost flex relative items-center cursor-pointer h-full">
                            <svg class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 285.25 284.04" fill="salmon" fill="currentColor">
                                <path d="M116.87 39.2l-7.77-7.78a13.43 13.43 0 0 0-20 1.18 13.65 13.65 0 0 0 1.34 18l6.17 6.18a23.91 23.91 0 0 1 2.75 2.08 25 25 0 0 1 5-11.17 25.37 25.37 0 0 1 12.51-8.49zm95.83 39.6l-61.87-61.87a13.41 13.41 0 0 0-20 1.19 13.64 13.64 0 0 0 1.34 18l70.92 70.2.23-8.12a25.23 25.23 0 0 1 9.38-19.39zm70.9 97a5.62 5.62 0 0 0 .29-7.64l-12.28-14.28-12.74-92.47c-.197-7.173-6.07-12.886-13.245-12.886S232.577 54.237 232.38 61.4l-.38 12a25.28 25.28 0 0 1 21.78 24.06l12.22 88.3 3.53 4.1zM28.44 42.85c2.706 1.914 6.45 1.27 8.365-1.435s1.27-6.45-1.435-8.365L20.4 22.4a6 6 0 0 0-9.592 4.297A6 6 0 0 0 13.46 32.2zm28.22-21.78L50.2 3.9A6 6 0 1 0 39 8.11l6.46 17.18a6 6 0 1 0 11.23-4.22zM0 60.66a5.94 5.94 0 0 0 5.88 6l18.47.3a6 6 0 0 0 6-5.93 5.83 5.83 0 0 0-5.88-5.92L6 55.02a5.8 5.8 0 0 0-6 5.64zm83.92 149.92c29.57 29.57 60.5 53.32 87.65 59.23a5.76 5.76 0 0 1 2.27 1.05l15.66 12a5.61 5.61 0 0 0 7.38-.48l69.67-69.56a5.62 5.62 0 0 0 .3-7.64l-12.28-14.28-12.74-92.5a13.25 13.25 0 1 0-26.49 0l-.63 21.82a6.14 6.14 0 0 1-6.19 6 6.05 6.05 0 0 1-4.31-1.82l-70.43-70.43a13.42 13.42 0 0 0-20 1.19 13.66 13.66 0 0 0 1.34 18l48.52 48.52a6.45 6.45 0 0 1 0 9.12h0a6.51 6.51 0 0 1-9.23 0L92.05 68.46a13.42 13.42 0 0 0-20 1.18 13.65 13.65 0 0 0 1.34 18l62.08 62.08a6.55 6.55 0 0 1 0 9.25 6.46 6.46 0 0 1-9.11 0L77.58 110.2a13.41 13.41 0 0 0-20 1.18 13.65 13.65 0 0 0 1.34 18l48.35 48.35a6.69 6.69 0 0 1 0 9.46l-.08.08a6.18 6.18 0 0 1-8.74 0l-30-30a14.09 14.09 0 0 0-9.92-4.13 13 13 0 0 0-8.11 2.79 13.41 13.41 0 0 0-1.18 20z"/>
                            </svg>
                            <p class="ml-3 sm:ml-3 text-sm md:text-base">{{ $post->likes_count }} <span class="hidden sm:inline">claps</span></p>
                            <div class="m-hover-lp">
                                <p class="text-xs font-semibold">Already applauded.</p>
                                <div class="triangle-down-lpm"></div>
                            </div>
                        </div>
                    @else
                        <div class="all-icon-p post-like-main flex items-center cursor-pointer h-full" data-postid="{{ $post->id }}">
                            <svg class="w-6 h-6 md:w-7 md:h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 297.2 297.2" fill="currentColor">
                                <path d="M28.4 43.4c1.1.7 2.3 1.1 3.5 1.1 1.9 0 3.7-.9 4.9-2.5 1.9-2.7 1.3-6.5-1.4-8.4L20.4 23c-2.7-1.9-6.4-1.3-8.4 1.4s-1.3 6.4 1.4 8.4l15 10.6zm28.3-21.7L50.2 4.5C49 1.4 45.6-.2 42.5 1S37.8 5.6 39 8.7l6.5 17.2c.9 2.4 3.2 3.9 5.6 3.9.7 0 1.4-.1 2.1-.4 3.1-1.2 4.6-4.6 3.5-7.7zM0 61.3c-.1 3.3 2.6 6 5.9 6l18.5.3c3.3 0 5.9-2.7 6-5.9.1-3.3-2.6-5.9-5.9-5.9L6 55.6c-3.3 0-5.9 2.4-6 5.7zm33.4 104.3c-.4 7.2 2.3 14.3 7.4 19.4l34.6 34.6c16.4 16.4 32 29.8 46.3 39.8 16.5 11.5 31.9 19 45.9 22.3l14.5 11.2c3.1 2.3 6.9 3.6 10.7 3.6 4.7 0 9.1-1.8 12.4-5.1l69.7-69.6c6-6 6.8-15.3 2.2-22.2l14.8-14.8c6.5-6.5 6.9-17 .9-24l-10-11.6L270.9 61c-.5-13.5-11.6-24.3-25.2-24.3-13.9 0-25.1 11.2-25.2 25l-.2 8.1-61-60.8c-4.8-4.8-11.2-7.4-17.9-7.4h0c-7.8 0-15.1 3.5-19.9 9.6a25.2 25.2 0 0 0-5 11.2c-4.6-4.1-10.5-6.3-16.8-6.3-7.8 0-15.1 3.5-19.9 9.6-6.4 8.1-7 19.1-2.2 27.9-5.8 1.2-11 4.4-14.8 9.1-7 8.8-7.1 21.1-.8 30.3.3.8.7 1.6 1.1 2.3-5.8 1.2-11 4.3-14.8 9.1-8 10.1-7 24.7 2.3 34l2.4 2.4c.2.5.5.9.7 1.4-3.8.8-7.5 2.4-10.6 4.9-5.8 4.5-9.3 11.3-9.7 18.5zm83.5-125.8c-4.9 1.5-9.2 4.4-12.5 8.5a25.2 25.2 0 0 0-5 11.2c-.9-.8-1.8-1.4-2.7-2.1l-6.2-6.2c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l7.7 7.8zm95.8 39.6c-5.7 4.6-9.3 11.6-9.4 19.4l-.2 8.1-70.9-70.2c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l61.8 61.9zm56.8 111.1l-3.5-4.1-12.1-88.3C253.4 85.7 244 75.6 232 74l.3-12c0-7.3 6-13.2 13.2-13.2 7.3 0 13.2 6 13.2 13.2l12.7 92.5 12.3 14.3c1.9 2.2 1.8 5.6-.3 7.6l-13.9 14.1zm-219-33.9c2.4-1.9 5.2-2.8 8.1-2.8a14.01 14.01 0 0 1 9.9 4.1l30 30c1.2 1.2 2.8 1.8 4.4 1.8s3.2-.6 4.4-1.8l.1-.1c2.6-2.6 2.6-6.8 0-9.5L58.9 130c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l48.8 48.8c1.3 1.3 2.9 1.9 4.6 1.9 1.6 0 3.3-.6 4.6-1.9 2.6-2.6 2.6-6.7 0-9.2L73.4 88.3c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l62.4 62.4c1.3 1.3 2.9 1.9 4.6 1.9s3.3-.6 4.6-1.9h0a6.46 6.46 0 0 0 0-9.1l-48.5-48.5c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l70.4 70.4c1.3 1.3 2.8 1.8 4.3 1.8 3.1 0 6.1-2.4 6.2-6l.6-21.8c0-7.3 6-13.2 13.2-13.2 7.3 0 13.2 6 13.2 13.2l12.7 92.5 12.3 14.3c1.9 2.2 1.8 5.6-.3 7.6L196.9 283c-1.1 1.1-2.5 1.6-4 1.6a5.43 5.43 0 0 1-3.4-1.2l-15.7-12c-.7-.5-1.4-.9-2.3-1-27.2-5.9-58.1-29.7-87.7-59.2l-34.6-34.6c-5.5-5.6-5.1-15 1.3-20z"/>
                            </svg>
                            <p class="ml-3 text-sm md:text-base">{{ $post->likes_count }} <span class="hidden sm:inline">claps</span></p>
                        </div>
                    @endif
                    <div class="all-icon-p btn-open-comment flex items-center ml-5 cursor-pointer">
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
                        <p class="content-responses ml-3 text-sm md:text-base">{{ sizeOf($sizeOfComment) }}</p>
                        <span class="ml-1 hidden sm:inline">responses</span>
                    </div>
                </div>
                {{-- Share Social Media, Bookmark etc --}}
                <div class="show-social-media text-xl flex items-center">
                    <div class="relative" title="share">
                        <svg class="open-dd-post cursor-pointer" width="25" height="25" class="r" fill-rule="evenodd" fill="currentColor">
                            <path d="M15.6 5a.42.42 0 0 0 .17-.3.42.42 0 0 0-.12-.33l-2.8-2.79a.5.5 0 0 0-.7 0l-2.8 2.8a.4.4 0 0 0-.1.32c0 .12.07.23.16.3h.02a.45.45 0 0 0 .57-.04l2-2V10c0 .28.23.5.5.5s.5-.22.5-.5V2.93l2.02 2.02c.08.07.18.12.3.13.11.01.21-.02.3-.08v.01"></path><path d="M18 7h-1.5a.5.5 0 0 0 0 1h1.6c.5 0 .9.4.9.9v10.2c0 .5-.4.9-.9.9H6.9a.9.9 0 0 1-.9-.9V8.9c0-.5.4-.9.9-.9h1.6a.5.5 0 0 0 .35-.15A.5.5 0 0 0 9 7.5a.5.5 0 0 0-.15-.35A.5.5 0 0 0 8.5 7H7a2 2 0 0 0-2 2v10c0 1.1.9 2 2 2h11a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"></path>
                        </svg>
                        {{-- dropdown sosmed --}}
                        <div class="show-dd-post dd-sosmed-bawah rounded text-b_base">
                            <a class="inline-flex items-center" href="https://twitter.com/intent/tweet?text={{ '"' . preg_replace('/#[a-z0-9]+/i', '', $post->title) . '"' }} {{ $post->user->twitter ? '—@'.$post->user->twitter : '—'.$post->user->username }}&url={{ $post->getURL() }}&hashtags={{ $post->allTagsShareTwitter() }}" target="blank">
                                <i class="fab fa-twitter w-7"></i>
                                <span class="text-sm">Twitter</span>
                            </a>
                            <a class="inline-flex items-center" href="https://www.linkedin.com/sharing/share-offsite/?url={{ $post->getURL() }}" target="blank">
                                <i class="fab fa-linkedin w-7"></i>
                                <span class="text-sm">LinkedIn</span>
                            </a>
                            <a class="share-to-facebook cursor-pointer inline-flex items-center" data-url="https://www.facebook.com/sharer/sharer.php?u={{ $post->getURL() }}&quote={{ $post->title }}" target="blank">
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
                        <div class="show-dd-post dd-setting-bawah rounded text-b_base">
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
                            <div class="triangle-setting-bawah"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- list Post --}}
            <div class="see-more-txt flex justify-center items-center mt-8">
                <h3 class="px-2 font-semibold text-sm sm:text-base uppercase text-center">More From {{ $post->user->username }}</h3>
            </div>
            <div class="list-p-all flex flex-col mt-2" data-paginate="{{ $list_posts->lastPage() }}">
                @forelse ($list_posts as $i => $latest_post)
                    <div class="list-post flex flex-col sm:flex-row sm:items-center py-8 sm:py-10 border-b">
                        <a href="{{ route('posts.show', ['user'=>$latest_post->user->username,'post'=>$latest_post->slug]) }}">
                            <div class="w-full h-40 xs:h-48 sm:w-48 sm:h-48 md:w-56 md:h-56">
                                <img class="w-full h-full object-cover object-center" src="{{ $latest_post->getThumbnail() }}" alt="{{ $latest_post->title }}">
                            </div>
                        </a>
                        <div class="home-post-list-txt flex flex-col flex-grow mt-5 ml-0 sm:ml-5 sm:mt-0">
                            <a href="{{ route('categories.show', $latest_post->category->slug) }}" class="flex items-center">
                                <p class="uppercase text-sm sm:text-xs md:text-sm text-red-500">{{ $latest_post->category->name }}</p>
                                <p class="time-readlist ml-2 text-xs italic">&#8212; {{ $latest_post->estimatedReadingTime() }}</p>
                            </a>
                            <a href="{{ route('posts.show', ['user'=>$latest_post->user->username,'post'=>$latest_post->slug]) }}">
                                <h2 class="t-listpost mt-1 font-semibold text-lg sm:text-lg md:text-2xl leading-6 md:leading-7">{{ Str::limit($latest_post->title, 55, '...') }}</h2>
                                <div class="mt-2 sm:block text-sm sm:text-sm md:text-base text-justify">{!! nl2br(e(Str::limit($latest_post->header, 145, '...'))) !!}</div>
                            </a>
                            <div class="flex justify-between items-center mt-3 sm:mt-2">
                                {{-- profile --}}
                                <div class="flex items-center">
                                    <a href="{{ route('profile.show', $latest_post->user->username) }}" class="relative inline-block">
                                        <svg class="w-9 h-9 text-green-500" viewBox="0 0 36 36">
                                            <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M18 1.87c-6.63 0-12.4 4.14-15.21 10.21L2 11.71C4.94 5.37 11 1 18 1s13.06 4.37 16 10.71l-.79.37C30.4 6.01 24.63 1.88 18 1.88zM2.79 23.92c2.81 6.07 8.58 10.2 15.21 10.2 6.63 0 12.4-4.13 15.21-10.2l.79.37C31.06 30.63 25 35 18 35S4.94 30.63 2 24.29l.79-.37z"></path></svg>
                                        <div class="absolute bottom-0 w-full h-full flex justify-center items-center">
                                            <img class="home-post-list-profile-img rounded-full" src="{{ $latest_post->user->profile_picture != null ? $latest_post->user->getProfilePicture() : $latest_post->user->gravatar() }}" onerror="this.onerror=null; this.src='{{ asset('/img/no_profile.png') }}'" alt="{{ $latest_post->user->name }}">
                                        </div>
                                    </a>
                                    <div class="text-0.5sm ml-2">by <a href="{{ route('profile.show', $latest_post->user->username) }}" class="font-bold text-b_base ml-0.5 text-green-600">{{ $latest_post->user->username }}</a></div>
                                </div>

                                {{-- Claps and comment --}}
                                <div class="flex">
                                    <a href="{{ route('posts.show', ['user'=>$latest_post->user->username,'post'=>$latest_post->slug]) }}" class="like-hs flex items-center cursor-pointer h-full">
                                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 297.2 297.2" fill="currentColor">
                                            <path d="M28.4 43.4c1.1.7 2.3 1.1 3.5 1.1 1.9 0 3.7-.9 4.9-2.5 1.9-2.7 1.3-6.5-1.4-8.4L20.4 23c-2.7-1.9-6.4-1.3-8.4 1.4s-1.3 6.4 1.4 8.4l15 10.6zm28.3-21.7L50.2 4.5C49 1.4 45.6-.2 42.5 1S37.8 5.6 39 8.7l6.5 17.2c.9 2.4 3.2 3.9 5.6 3.9.7 0 1.4-.1 2.1-.4 3.1-1.2 4.6-4.6 3.5-7.7zM0 61.3c-.1 3.3 2.6 6 5.9 6l18.5.3c3.3 0 5.9-2.7 6-5.9.1-3.3-2.6-5.9-5.9-5.9L6 55.6c-3.3 0-5.9 2.4-6 5.7zm33.4 104.3c-.4 7.2 2.3 14.3 7.4 19.4l34.6 34.6c16.4 16.4 32 29.8 46.3 39.8 16.5 11.5 31.9 19 45.9 22.3l14.5 11.2c3.1 2.3 6.9 3.6 10.7 3.6 4.7 0 9.1-1.8 12.4-5.1l69.7-69.6c6-6 6.8-15.3 2.2-22.2l14.8-14.8c6.5-6.5 6.9-17 .9-24l-10-11.6L270.9 61c-.5-13.5-11.6-24.3-25.2-24.3-13.9 0-25.1 11.2-25.2 25l-.2 8.1-61-60.8c-4.8-4.8-11.2-7.4-17.9-7.4h0c-7.8 0-15.1 3.5-19.9 9.6a25.2 25.2 0 0 0-5 11.2c-4.6-4.1-10.5-6.3-16.8-6.3-7.8 0-15.1 3.5-19.9 9.6-6.4 8.1-7 19.1-2.2 27.9-5.8 1.2-11 4.4-14.8 9.1-7 8.8-7.1 21.1-.8 30.3.3.8.7 1.6 1.1 2.3-5.8 1.2-11 4.3-14.8 9.1-8 10.1-7 24.7 2.3 34l2.4 2.4c.2.5.5.9.7 1.4-3.8.8-7.5 2.4-10.6 4.9-5.8 4.5-9.3 11.3-9.7 18.5zm83.5-125.8c-4.9 1.5-9.2 4.4-12.5 8.5a25.2 25.2 0 0 0-5 11.2c-.9-.8-1.8-1.4-2.7-2.1l-6.2-6.2c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l7.7 7.8zm95.8 39.6c-5.7 4.6-9.3 11.6-9.4 19.4l-.2 8.1-70.9-70.2c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l61.8 61.9zm56.8 111.1l-3.5-4.1-12.1-88.3C253.4 85.7 244 75.6 232 74l.3-12c0-7.3 6-13.2 13.2-13.2 7.3 0 13.2 6 13.2 13.2l12.7 92.5 12.3 14.3c1.9 2.2 1.8 5.6-.3 7.6l-13.9 14.1zm-219-33.9c2.4-1.9 5.2-2.8 8.1-2.8a14.01 14.01 0 0 1 9.9 4.1l30 30c1.2 1.2 2.8 1.8 4.4 1.8s3.2-.6 4.4-1.8l.1-.1c2.6-2.6 2.6-6.8 0-9.5L58.9 130c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l48.8 48.8c1.3 1.3 2.9 1.9 4.6 1.9 1.6 0 3.3-.6 4.6-1.9 2.6-2.6 2.6-6.7 0-9.2L73.4 88.3c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l62.4 62.4c1.3 1.3 2.9 1.9 4.6 1.9s3.3-.6 4.6-1.9h0a6.46 6.46 0 0 0 0-9.1l-48.5-48.5c-4.8-4.8-5.6-12.7-1.3-18a13.34 13.34 0 0 1 10.5-5.1c3.4 0 6.9 1.3 9.5 3.9l70.4 70.4c1.3 1.3 2.8 1.8 4.3 1.8 3.1 0 6.1-2.4 6.2-6l.6-21.8c0-7.3 6-13.2 13.2-13.2 7.3 0 13.2 6 13.2 13.2l12.7 92.5 12.3 14.3c1.9 2.2 1.8 5.6-.3 7.6L196.9 283c-1.1 1.1-2.5 1.6-4 1.6a5.43 5.43 0 0 1-3.4-1.2l-15.7-12c-.7-.5-1.4-.9-2.3-1-27.2-5.9-58.1-29.7-87.7-59.2l-34.6-34.6c-5.5-5.6-5.1-15 1.3-20z"/>
                                        </svg>
                                        <p class="ml-3 text-sm md:text-base">{{ $latest_post->likes_count }}</p>
                                    </a>
                                    <a href="{{ route('posts.show', ['user'=>$latest_post->user->username,'post'=>$latest_post->slug]) }}" class="comment-ph flex items-center ml-5">
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
                                        <p class="ml-2 text-sm md:text-base">{{ sizeOf($latest_post->comments) }}</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-p-list mt-5 px-10 py-7 rounded-sm flex flex-col sm:flex-row items-center">
                        <img class="h-17" src="{{ asset('img/undraw_not_found.png') }}" alt="empty_post">
                        <p class="mt-5 sm:mt-0 ml-0 sm:ml-5 text-b_base sm:text-base">There are currently no more posts from {{ $post->user->username }}.</p>
                    </div>
                @endforelse
            </div>
            <div class="paginate-links-panel mt-10">
            {{ $list_posts->onEachSide(0)->links() }}
            </div>
        </div>

        {{-- right side --}}
        <div class="hidden xl:block w-3/12"></div>
    </div>

    

    {{-- Open Youtube Video --}}
    @if ($post->youtube_link)
        <div class="open-yt flex items-center justify-center fixed top-0 w-full h-full">
            <div class="open-yt-content">
                <div class="flex justify-between mb-3">
                    <h1 class="text-white text-sm mr-2">{{ Str::limit($post->title, 35, '...') }}</h1>
                    <div class="close-content-yt flex items-center cursor-pointer">
                        <div class="txt-close-yt hidden sm:flex items-center mr-3">
                            <h2 class="text-white text-sm">Close</h2>
                        </div>
                        <div class="icon-close-yt">
                            <svg class="w-4 h-4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path class="block" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $post->youtubeLink() }}?enablejsapi=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <div class="fade-effect-yt"></div>
        </div>
    @endif

    @include('comments.comments')
@endsection

@section('script_page')
    <script src="{{ asset('js/post.js') }}"></script>
    {{-- btn subscribe yt embed --}}
    <script src="https://apis.google.com/js/platform.js"></script>
@endsection