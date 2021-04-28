@extends('auth.layouts.auth')

@section('form_content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="asd" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="asd" type="asd" class="form-control @error('asd') is-invalid @enderror" name="asd" value="{{ $asd ?? old('asd') }}" required autocomplete="asd" autofocus>

                                @error('asd')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="psswrd" class="col-md-4 col-form-label text-md-right">{{ __('psswrd') }}</label>

                            <div class="col-md-6">
                                <input id="psswrd" type="psswrd" class="form-control @error('psswrd') is-invalid @enderror" name="psswrd" required autocomplete="new-psswrd">

                                @error('psswrd')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}


    <a class="flex items-center text-blue-500 hover:text-blue-600 focus:outline-none" href="{{ route('login') }}">
        <svg fill="none" height="9" viewBox="0 0 14 9" width="14" xmlns="http://www.w3.org/2000/svg"><path d="m4.76895 7.72698c0-.08244-.03156-.16488-.09436-.22768l-2.67711-2.67711h11.46012c.1781 0 .322-.14395.322-.32204s-.1439-.32204-.322-.32204h-11.46012l2.66391-2.66391c.12591-.12592.12591-.32945 0-.45537-.12592-.125913-.32945-.125913-.45537 0l-3.213305 3.21331c-.02995.02963-.053459.06538-.069883.10531-.032526.07858-.032526.16714 0 .24604.016424.03961.040255.07536.069883.10498l3.226515 3.22619c.12591.12592.32944.12592.45536 0 .06312-.06279.09436-.14524.09436-.22768z" fill="#2880ce"/></svg>
        <p class="ml-2">Back to Login</p>
    </a>

    <img class="rounded-full w-20 h-20 mt-6" src="{{ asset('img/login-3.jpg') }}" alt="logo-img">

    <h4 class="mt-4 text-xl text-gray-800">Reset Password</h4>
    <p class="text-gray-600 text-sm mt-2">Use a strong password to protect your account. Strong passwords include numbers, letters, and punctuation marks.</p>

    <form action="{{ route('password.update') }}" method="POST" class="mt-5" autocomplete="off">
        @csrf

        {{-- Token harus ada --}}
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="relative @error('email') error-input @enderror">
            <label class="label-auth" for="email">Email :</label>
            <input class="input-auth" type="text" name="email" id="email" placeholder="Input email" value="{{ $email ?? old('email') }}">
        </div>
        <div class="flex mb-3">
            <div class="w-1/2 relative @error('password') error-input @enderror">
                <label class="label-auth" for="password">New Password :</label>
                <input class="input-auth border-t-0" type="password" name="password" id="password" placeholder="Input password">
            </div>
            <div class="w-1/2 relative @error('password') error-input @enderror">
                <label class="label-auth" for="password_confirmation">Confirm Password :</label>
                <input class="input-auth border-t-0" type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm password">
            </div>
        </div>

        @error('email')
            <span class="text-xs text-red-500 block">{{ $message }}</span>
        @enderror
        @error('password')
            <span class="text-xs text-red-500 block">{{ $message }}</span>
        @enderror

        <div class="mt-5 flex justify-end items-center">
            <button class="btn btn-indigo" type="submit" name= "submit">Reset Password</button>
        </div>
    </form>

    <p class="text-xxs xs:text-xs mt-20 text-center text-gray-600">Copyright © Adityaptrp</p>
    <div class="flex justify-center mt-2 text-xxs xs:text-xs">
        <a href="" class="text-blue-500">Privacy Policy</a>
        <div class="bullet-lr">
            <a href="" class="text-blue-500 ml-1">Terms of Service</a>
        </div>
    </div>
@endsection
