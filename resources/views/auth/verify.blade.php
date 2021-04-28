<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Verify Your Email')</title>

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
<body>
    <div class="relative w-100% h-100vh px-6 md:px-0 flex justify-center items-center">
        <div class="message-verify sm:w-171 flex flex-col items-center justify-center">
            <h1 class="font-bold text-1.5xl md:text-2.5xl">Verify your email</h1>
            @if (session('resent'))
                <span class="mt-2 text-center font-semibold text-sm xs:text-b_base md:text-base text-green-500">A fresh verification link has been sent to your email address</span>
            @else
                <h2 class="mt-2 text-center font-semibold text-sm xs:text-b_base md:text-base">You will need to verify your email to complate registration</h2>
            @endif
            @include('layouts.svg.verifyImg')
            <p class="text-center text-sm xs:text-b_base md:text-base">An email has been sent to <span class="font-bold text-black">{{ Auth::user()->email }}</span> with a link to verify your account. If you have not recieved the email after a few minutes, please check your spam folder.</p>
            <div class="btn-verify mt-6 flex text-xs xs:text-sm">
                <button type="button" class="verify-resend-email focus:outline-none">Resend Email</button>
                <button type="button" class="verify-contact-supp ml-3 xs:ml-5 sm:ml-7 focus:outline-none" data-e="{{ $setting->email }}">Contact Support</button>
            </div>
            <form class="form-verify-resend hidden" method="POST" action="{{ route('verification.resend') }}">
                @csrf
            </form>
        </div>
        <div class="verify-back-btn flex items-center focus:outline-none cursor-pointer" onclick="if(this.dataset.cb == true){window.history.go(-2)}else{window.location.href = this.dataset.cb;}" data-cb="{{ url()->previous() == url()->current() ? true : url()->previous() }}">
            <svg class="w-6 xs:w-7 h-6 xs:h-7" viewBox="0 0 24 24" fill="currentColor"><g><path d="M20 11H7.414l4.293-4.293c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0l-6 6c-.39.39-.39 1.023 0 1.414l6 6c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L7.414 13H20c.553 0 1-.447 1-1s-.447-1-1-1z"></path></g></svg>
        </div>
    </div>

    <script src="{{ asset('js/jquery/jquery-3.5.1.js') }}"></script>
    <script src='{{ asset('vendor/nprogress/nprogress.js') }}'></script>
    <script src="{{ asset('js/verify.js') }}"></script>
</body>
</html>
