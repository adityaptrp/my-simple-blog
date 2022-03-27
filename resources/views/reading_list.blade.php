
@extends('layouts.app')

@section('title', 'Simple Blog | Reading List')

@section('content')
    <div class="all-content-rl container py-12 px-6 md:px-0 md:w-70vw lg:w-55vw">
        {{-- Title --}}
        <h1 class="title-rl text-2xl md:text-3xl font-medium tracking-normal">Reading List</h1>

        {{-- Submenu --}}
        <div class="submenu-readlist flex mt-8 text-b_base md:text-base">
            <a href="{{ route('readingList.saved') }}" class="show-bm-rl mr-4 pb-4 @isset($bookmark) font-bold border-b submenu-readlist-active @endisset">Saved {{ $sizeOfBookmark != 0 ? "($sizeOfBookmark)" : '' }}</a>
            <a href="{{ route('readingList.archived') }}" class="show-ar-rl mr-4 pb-4 @isset($archive) font-bold border-b submenu-readlist-active @endisset">Archived {{ $sizeOfArchive != 0 ? "($sizeOfArchive)" : '' }}</a>
        </div>
        <hr class="mb-8">

        {{-- List Post --}}
        @forelse ($posts as $i => $post)
            <div class="post-rl">
                <div class="flex">
                    {{-- text content --}}
                    <div class="md:pr-7">
                        {{-- title lg --}}
                        <a href="{{ route('posts.show', ['user'=>$post->user->username,'post'=>$post->slug]) }}" class="hidden md:block title-p-rl text-xl font-bold">{{ Str::limit($post->title, 50, '...') }}</a>
                        {{-- title sm --}}
                        <a href="{{ route('posts.show', ['user'=>$post->user->username,'post'=>$post->slug]) }}" class="block md:hidden title-p-rl text-0.5xl font-bold leading-7">{{ $post->title }}</a>
                        <div class="profile-rl flex items-center mt-2 text-b_base">
                            <a href="{{ route('categories.show', $post->category->slug) }}" class="mr-6 text-red-600 uppercase">{{ $post->category->name }}</a>
                            <div class="point written-by">by <a href="{{ route('profile.show', $post->user->username) }}" class="font-semibold text-green-600">{{ $post->user->username }}</a></div>
                        </div>
                        <a href="{{ route('posts.show', ['user'=>$post->user->username,'post'=>$post->slug]) }}" class="text-readlist text-b_base md:text-base text-justify">{!! Str::limit($post->header, 140, '...') !!}</a>
                    </div>
                    {{-- Img --}}
                    <a href="{{ route('posts.show', ['user'=>$post->user->username,'post'=>$post->slug]) }}" class="hidden md:block">
                        <div class="md:w-40 lg:w-33 md:h-32 lg:h-27">
                            <img class="w-full h-full object-cover object-center" src="{{ $post->getThumbnail() }}" alt="">
                        </div>
                    </a>
                </div>
                <div class="footer-rl flex items-center justify-between md:justify-start mt-2 text-0.5sm md:text-sm">
                    <div class="readlist-tgl-p flex items-center">
                        <p class="mr-2">{{ $post->created_at->format('M d, Y') }}</p>
                        <p class="pr-2.5 md:border-r md:border-gray-700">— {{ $post->estimatedReadingTime() }}</p>
                    </div>
                    <div class="remove-archive-readlist-btn flex items-center md:ml-2.5">
                        {{-- Btn Remove --}}
                        <div class="@if(isset($archive)) remove-archive @else remove-bookmark @endif flex items-center cursor-pointer mr-3" data-ip="{{ $post->id }}">
                            <svg width="25" height="25" viewBox="0 0 25 25" fill="currentColor">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M20.48 7.45H3.46v10.13H16a.47.47 0 1 1 0 .94H3.46c-.54 0-.99-.42-.99-.94V7.45c0-.52.45-.93 1-.93h17c.55 0 1 .41 1 .93v5.57a.5.5 0 0 1-1 0V7.45zM5.47 10.02c0-.28.22-.5.5-.5h9.11a.5.5 0 1 1 0 1H5.97a.5.5 0 0 1-.5-.5zm.51 2.5a.5.5 0 0 0-.51.5c0 .27.23.5.51.5h5.98a.5.5 0 0 0 .51-.5.5.5 0 0 0-.51-.5H5.98zm12.52 3.02c.2-.2.5-.2.7 0l1.77 1.77 1.77-1.77a.5.5 0 1 1 .7.7l-1.76 1.78 1.76 1.76a.5.5 0 1 1-.7.71l-1.77-1.77-1.77 1.77a.5.5 0 0 1-.7-.7l1.76-1.77-1.76-1.77a.5.5 0 0 1 0-.7z"></path>
                            </svg>
                            <p class="hidden md:block ml-1 md:ml-2">Remove</p>
                        </div>
                        @if (!isset($archive))
                            {{-- Btn Archive --}}
                            <div class="archive-rl flex items-center cursor-pointer" data-ip="{{ $post->id }}">
                                <svg width="25" height="25" viewBox="0 1 25 25" fill="currentColor">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.47 9.95h17v-3h-17v3zm16 1h1a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-17a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h1v9a1 1 0 0 0 1 1h13a1 1 0 0 0 1-1v-9zm-1 0h-13v9h13v-9z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M9.47 12.45c0-.28.21-.5.48-.5h6.04c.27 0 .48.22.48.5 0 .27-.21.5-.48.5H9.95a.49.49 0 0 1-.48-.5z"></path>
                                </svg>
                                <p class="hidden md:block ml-1 md:ml-2">Archive</p>
                            </div>
                        @endif
                    </div>
                </div>
                <hr class="my-5">
            </div>
        @empty
            <div class="empty-rl flex flex-col md:flex-row items-center rounded-sm text-sm md:text-base py-5 px-3 xs:px-5 md:px-13">
                @if (isset($archive))
                    <img class="w-25 h-25 mr-0 md:mr-10" src="{{ asset('img/undraw_blank_canvas.png') }}" alt="">
                    <div class="mt-4 md:mt-0">
                        <p class="text-center md:text-left">After you’re finished with a saved story,</p>
                        <div class="flex justify-center md:inline-block text-center md:text-left">
                            <span>Tap the</span> 
                            <svg class="inline-block w-5 md:w-6 h-5 md:h-6 mx-1" viewBox="0 1 25 25" fill="#757575">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.47 9.95h17v-3h-17v3zm16 1h1a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-17a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h1v9a1 1 0 0 0 1 1h13a1 1 0 0 0 1-1v-9zm-1 0h-13v9h13v-9z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M9.47 12.45c0-.28.21-.5.48-.5h6.04c.27 0 .48.22.48.5 0 .27-.21.5-.48.5H9.95a.49.49 0 0 1-.48-.5z"></path>
                            </svg>
                            <span>icon to store it here.</span>
                        </div>
                    </div>
                @else
                    <img class="w-25 h-25 mr-0 md:mr-10" src="{{ asset('img/undraw_empty.png') }}" alt="">
                    <div class="mt-4 md:mt-0">
                        <p class="text-center md:text-left">You haven’t saved anything yet.</p>
                        <div class="inline-block text-center md:text-left">
                            <span>Tap the</span> 
                            <svg class="inline-block w-5 md:w-6 h-5 md:h-6" viewBox="0 0 25 25" fill="currentColor">
                                <path d="M19 6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14.66h.01c.01.1.05.2.12.28a.5.5 0 0 0 .7.03l5.67-4.12 5.66 4.13a.5.5 0 0 0 .71-.03.5.5 0 0 0 .12-.29H19V6zm-6.84 9.97L7 19.64V6a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v13.64l-5.16-3.67a.49.49 0 0 0-.68 0z" fill-rule="evenodd"></path>
                            </svg>
                            <span>icon on posts to save them for later.</span>
                        </div>
                    </div>
                @endif
            </div>
        @endforelse
    </div>
@endsection

@section('script_page')
    <script src="{{ asset('js/read-list.js') }}"></script>
@endsection