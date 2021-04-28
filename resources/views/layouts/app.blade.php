<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'MySimpleBlog')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    {{-- navbrand --}}
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">
    {{-- Deafult --}}
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
    {{-- Title --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    {{-- Quote --}}
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel='stylesheet' href='{{ asset('vendor/nprogress/nprogress.css') }}'/>

    {{-- Check darkmode --}}
    <script src="{{ asset('js/check-darkmode.js') }}"></script>

</head>
<body class="all-content-body" @auth @if (!Auth::user()->password) style="overflow: hidden" @endif @endauth>
    <div id="app">
        @include('layouts.navigation')

        <div id="contentPage">
            @yield('content')
        </div>

        {{-- @include('layouts.footer') --}}

        @include('layouts.scroll_top')
        @include('layouts.modal')
        @if (Auth::user())
            @if (request()->is('@*'))
                @if (Auth::user()->id == $post->user_id)
                    @include('layouts.list_unapproved')
                @endif
            @endif
        @endif
        @guest
            @include('layouts.notif_new_post')
        @endguest
    </div>

    <script src="{{ asset('js/jquery/jquery-3.5.1.js') }}"></script>
    <script src='{{ asset('vendor/nprogress/nprogress.js') }}'></script>

    <script src="{{ asset('js/all.js') }}"></script>
    <script src="{{ asset('js/dark-mode.js') }}"></script>
    <script src="https://kit.fontawesome.com/6eae20eef6.js" crossorigin="anonymous"></script>

    @yield('script_page')
</body>
</html>
