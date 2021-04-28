@extends('auth.layouts.auth')

@section('form_content')
    {{-- header --}}
    <a class="flex items-center text-blue-500 hover:text-blue-600 focus:outline-none" href="{{ route('login') }}">
        <svg fill="none" height="9" viewBox="0 0 14 9" width="14" xmlns="http://www.w3.org/2000/svg"><path d="m4.76895 7.72698c0-.08244-.03156-.16488-.09436-.22768l-2.67711-2.67711h11.46012c.1781 0 .322-.14395.322-.32204s-.1439-.32204-.322-.32204h-11.46012l2.66391-2.66391c.12591-.12592.12591-.32945 0-.45537-.12592-.125913-.32945-.125913-.45537 0l-3.213305 3.21331c-.02995.02963-.053459.06538-.069883.10531-.032526.07858-.032526.16714 0 .24604.016424.03961.040255.07536.069883.10498l3.226515 3.22619c.12591.12592.32944.12592.45536 0 .06312-.06279.09436-.14524.09436-.22768z" fill="#2880ce"/></svg>
        <p class="ml-2">Back to Login</p>
    </a>

    <img class="rounded-full w-20 h-20 mt-6" src="{{ asset('img/login-3.jpg') }}" alt="logo-img">

    <h4 class="mt-4 text-xl text-gray-800"><span class="fd">Reset Password</span></h4>
    <p class="text-gray-600 text-sm mt-2">To reset your password, you will need to enter your email address and get a password reset link</p>

    {{-- form --}}
    <form action="{{ route('password.email') }}" method="POST" class="mt-5" autocomplete="off">
        @csrf
        @if (session('status'))
            <div class="text-xs bg-green-100 text-green-700 px-3 py-2 mb-4 rounded border-1.5 border-green-200" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="relative @error('email') error-input @enderror">
            <label class="label-auth" for="email">E-mail :</label>
            <input class="input-auth" type="text" name="email" id="email" placeholder="Enter email" value="{{ old('email') ?? '' }}">
        </div>

        @error('email')
            <span class="text-xs text-red-500 block mt-2">{{ $message }}</span>
        @enderror

        <div class="mt-5 flex justify-end items-center">
            <button class="btn btn-indigo" type="submit" name= "submit">Send Link</button>
        </div>
    </form>

    {{-- footer --}}
    <p class="text-xxs xs:text-xs mt-30 text-center text-gray-600">Copyright © Adityaptrp</p>
    <div class="flex justify-center mt-2 text-xxs xs:text-xs">
        <a href="" class="text-blue-500">Privacy Policy</a>
        <div class="bullet-lr">
            <a href="" class="text-blue-500 ml-1">Terms of Service</a>
        </div>
    </div>
@endsection
