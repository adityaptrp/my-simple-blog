

@extends('auth.layouts.auth')

@section('title', 'Login')

@section('form_content')
    {{-- header --}}
    <a class="flex items-center text-blue-500 hover:text-blue-600 focus:outline-none" href="/">
        <svg fill="none" height="9" viewBox="0 0 14 9" width="14" xmlns="http://www.w3.org/2000/svg"><path d="m4.76895 7.72698c0-.08244-.03156-.16488-.09436-.22768l-2.67711-2.67711h11.46012c.1781 0 .322-.14395.322-.32204s-.1439-.32204-.322-.32204h-11.46012l2.66391-2.66391c.12591-.12592.12591-.32945 0-.45537-.12592-.125913-.32945-.125913-.45537 0l-3.213305 3.21331c-.02995.02963-.053459.06538-.069883.10531-.032526.07858-.032526.16714 0 .24604.016424.03961.040255.07536.069883.10498l3.226515 3.22619c.12591.12592.32944.12592.45536 0 .06312-.06279.09436-.14524.09436-.22768z" fill="#2880ce"/></svg>
        <p class="ml-2">Back to home</p>
    </a>

    <img class="rounded-full w-20 h-20 mt-6" src="{{ asset('img/login-3.jpg') }}" alt="logo-img">

    <h4 class="mt-4 text-xl text-gray-800">Welcome to <span class="font-bold">My Blog</span></h4>
    <p class="text-gray-600 text-sm mt-2">Before you get started, you must login or register if you don't already have an account.</p>

    {{-- form --}}
    <form action="{{ route('login') }}" method="POST" class="mt-5" autocomplete="off">
        @csrf
        @if (session('success'))
            <div class="text-xs bg-green-100 text-green-700 px-3 py-2 mb-4 rounded border-1.5 border-green-200 flex justify-between items-center" role="alert">
                <div>{{ session('success') }}</div>
                <svg id="closeAlertAuth" class="w-3.5 h-3.5 cursor-pointer" fill="currenColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path class="block" d="M6 18L18 6M6 6l12 12" style="pointer-events: none"></path>
                </svg>
            </div>
        @endif
        @if (session('error'))
            <div class="text-xs bg-red-100 text-red-700 px-3 py-2 mb-4 rounded border-1.5 border-red-200 flex justify-between items-center" role="alert">
                <div>{{ session('error') }}</div>
                <svg id="closeAlertAuth" class="w-3.5 h-3.5 cursor-pointer" fill="currenColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path class="block" d="M6 18L18 6M6 6l12 12" style="pointer-events: none"></path>
                </svg>
            </div>
        @endif
        <div class="relative @error('username') error-input @enderror">
            <label class="label-auth" for="username">Username :</label>
            <input class="input-auth" type="text" name="username" id="username" placeholder="Input username" value="{{ old('username') ?? '' }}">
        </div>
        <div class="relative mb-3 @error('password') error-input @enderror">
            <label class="label-auth" for="password">Password :</label>
            <input class="input-auth border-t-0" type="password" name="password" id="password" placeholder="Input password">
        </div>

        @error('attempts')
                <span id="alert_attempts" class="text-xs text-red-500 block">Too many attempts. Please try again in <span id="alert_time_attempts">{{ $message }}</span> seconds.</span>
        @enderror
        @error('username')
                <span class="text-xs text-red-500 block">{{ $message }}</span>
        @enderror
        @error('password')
                <span class="text-xs text-red-500 block">{{ $message }}</span>
        @enderror
        
        <div>
            <label class="inline-flex items-center mt-3 cursor-pointer">
                <input type="checkbox" name="remember" id="remember" class="cursor-pointer">
                <span class="ml-2 text-gray-700 text-sm" {{ old('remember') ? 'checked' : '' }}>Remember me</span>
            </label>
        </div>

        <div class="mt-5 flex justify-between items-center">
            <a class="text-xs md:text-sm text-blue-500 hover:text-blue-600 focus:outline-none" href="{{ route('password.request') }}">Forgot your password ?</a>
            <button class="btn btn-indigo" type="submit" name= "submit">Login</button>
        </div>
    </form>

    {{-- Social Login --}}
    <div class="socialite-auth flex flex-col items-center mt-10">
        <p class="text-gray-600 text-sm">Or login with</p>
        <div class="flex mt-5">
            <a href="{{ route('social.oauth', 'google') }}" class="text-0.5sm bg-red-500 hover:bg-red-600">
                <i class="fab fa-google text-sm"></i>
                <span class="ml-1">Google</span>
            </a>
            <a href="{{ route('social.oauth', 'facebook') }}" class="text-0.5sm bg-indigo-800 hover:bg-indigo-900 ml-2">
                <i class="fab fa-facebook-f text-sm"></i>
                <span class="ml-1">Facebook</span>
            </a>
            <a href="{{ route('social.oauth', 'twitter') }}" class="text-sm bg-blue-500 hover:bg-blue-600 ml-2">
                <i class="fab fa-twitter text-sm"></i>
                <span class="ml-1">Twitter</span>
            </a>
        </div>
    </div>

    {{-- Register path --}}
    <div class="flex items-center justify-center mt-8 text-sm">
        <p class="text-gray-600">Don't have an account ?</p>
        <a href="{{ route('register') }}" class="ml-1 text-blue-500 font-semibold">Sign Up</a>
    </div>

    {{-- footer --}}
    <p class="text-xxs xs:text-xs mt-12 text-center text-gray-600">Copyright © Adityaptrp</p>
    <div class="flex justify-center mt-2 text-xxs xs:text-xs">
        <a href="" class="text-blue-500">Privacy Policy</a>
        <div class="bullet-lr">
            <a href="" class="text-blue-500 ml-1">Terms of Service</a>
        </div>
    </div>
@endsection
