
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- Google font --}}
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">

    {{-- Nprogress --}}
    <link rel='stylesheet' href='{{ asset('vendor/nprogress/nprogress.css') }}'/>

</head>
<body class="login-page">
    <div id="app" class="flex">
        <div class="w-full sm:w-6/12 lg:w-5/12 xl:w-2/6 py-6 px-8 md:py-10 md:px-12">
            @yield('form_content')
        </div>
        <div id="wallpaper-auth" class="hidden sm:block w-0 sm:w-6/12 lg:w-8/12 xl:w-4/6 login-img text-gray-100" style="background-image: url('{{ $setting->auth_wallpaper ? $setting->getAuthWallpaper() : asset('img/david-marcu-nature.jpg') }}');">
            <span class="login-img-item absolute">
                <p class="text-3xl">{{ $setting->auth_caption }}</p>
                <div class="-mt-0.5">
                    Photo by <a href="{{ $setting->getURLOwnerPictAuth() }}" target="__blank">{{ $setting->auth_owner_name }}</a> on <a href="https://unsplash.com" target="blank">Unsplash</a>
                </div>
            </span>
            @auth
                @if (Auth::user()->is_admin)
                    {{-- Btn Edit setting auth --}}
                    <div class="all-btn-auth text-sm">
                        <div class="edit-txt-auth">
                            <i class="fas fa-pen"></i>
                        </div>
                        <label class="edit-img-auth ml-2">
                            <i class="fas fa-camera"></i>
                            {{-- Form Edit Text auth --}}
                            <form class="form-auth-img" action="{{ route('auth.updateWallpaper') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <input type="file" name="auth_wallpaper" id="auth_wallpaper" accept=".jpg,.jpeg,.png,.svg" style="display: none;" />
                            </form>
                        </label>
                    </div>
                    {{-- Edit Setting Panel --}}
                    <div class="fade-ef-auth hidden">
                        <div class="panel-e-auth w-80 bg-white text-gray-800 rounded">
                            {{-- header --}}
                            <div class="header-ep sticky sm:static top-0 flex justify-between items-center px-4 py-1.5 border-b z-3 sm:rounded-t-md">
                                <p class="font-semibold text-md">Setting</p>
                                <svg class="close-auth-setting w-5 h-5 cursor-pointer text-green-600" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path class="block" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            {{-- Body Form --}}
                            <div class="flex flex-col px-5 py-4">
                                <form class="form-auth-setting" action="{{ route('auth.updateSetting') }}" method="post" autocomplete="off">
                                    @csrf
                                    @method('patch')
                                    <div class="flex flex-col">
                                        <label for="auth_caption" class="cursor-pointer flex items-center justify-between">
                                            <h1>Caption :</h1>
                                            <h2><span>{{ strlen($setting->auth_caption) }}</span>/30</h2>
                                        </label>
                                        <input type="text" name="auth_caption" id="auth_caption" class="border mt-1 text-sm focus:border-green-600" placeholder="Enter caption." value="{{ old('auth_caption') ?? $setting->auth_caption }}" data-l="30">
                                        @error('auth_caption')
                                            <div class="error-msg-p text-0.5sm text-red-500 mt-0.5 -mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col mt-2">
                                        <label for="auth_owner_name" class="cursor-pointer flex items-center justify-between">
                                            <h1>Owner Name :</h1>
                                            <h2><span>{{ strlen($setting->auth_owner_name) }}</span>/30</h2>
                                        </label>
                                        <input type="text" name="auth_owner_name" id="auth_owner_name" class="border mt-1 text-sm focus:border-green-600" placeholder="Enter owner name." value="{{ old('auth_owner_name') ?? $setting->auth_owner_name }}" data-l="30">
                                        @error('auth_owner_name')
                                            <div class="error-msg-p text-0.5sm text-red-500 mt-0.5 -mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col mt-2">
                                        <label for="auth_unsplash_username" class="cursor-pointer flex items-center justify-between">
                                            <h1>Username unsplash :</h1>
                                            <h2><span>{{ strlen($setting->auth_unsplash_username) }}</span>/30</h2>
                                        </label>
                                        <input type="text" name="auth_unsplash_username" id="auth_unsplash_username" class="border mt-1 text-sm focus:border-green-600" placeholder="https://unsplash.com/@username." value="{{ old('auth_unsplash_username') ?? $setting->auth_unsplash_username }}" data-l="30">
                                        @error('auth_unsplash_username')
                                            <div class="error-msg-p text-0.5sm text-red-500 mt-0.5 -mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </form>
                            </div>
                            {{-- Footer --}}
                            <div class="footer-ep sticky sm:static bottom-0 px-5 py-2 border-t flex justify-end sm:rounded-b-md">
                                <div class="submit-auth-setting cursor-pointer">
                                    <div class="btn-save-ep bg-green-500 hover:bg-green-600 px-4 py-1 rounded-full text-0.5sm text-white">Save</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    </div>

    <script src="{{ asset('js/jquery/jquery-3.5.1.js') }}"></script>
    <script src='{{ asset('vendor/nprogress/nprogress.js') }}'></script>
    <script src="https://kit.fontawesome.com/6eae20eef6.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/all.js') }}"></script>
    <script>
        const BASE_URL_IMG_FOR_CSS = $('#wallpaper-auth').css('background-image');
        const BASE_URL_IMG_ASSET = '{{ $setting->getAuthWallpaper() }}';
    </script>
    <script src="{{ asset('js/auth.js') }}"></script>

    @auth
        @if (Auth::user()->is_admin)
            @if ($errors->has('auth_caption') || $errors->has('auth_owner_name') || $errors->has('auth_unsplash_username') )
                <script>
                    $('.fade-ef-auth').toggle();
                    $('.panel-e-auth').addClass('errors');
                </script>
            @endif
            @if (session()->has('successUpdateSetting'))
                <script>
                    $(window).ready(function () {
                        $('#app').append(`
                        <div class="flash-message-auth">
                            <span>{{ session()->get('successUpdateSetting') }}</span>
                            <div class="close-flash-message ml-2.5 -mr-1 cursor-pointer">
                                <svg class="nav-burger w-4 h-4 cursor-pointer" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path class="block" d="M6 18L18 6M6 6l12 12" style="pointer-events: none"></path>
                                </svg>
                            </div>
                        </div>
                        `);
                        setTimeout(() => {
                            $('.flash-message-auth').remove();
                        }, 3000);
                    })
                </script>
            @endif
        @endif
    @endauth

    @error('attempts')
        <script>
            function startTimer(time, display) {
                let timer = time;
                var x = setInterval(function () {
                    minutes = parseInt(timer / 60, 10);
                    seconds = parseInt(timer % 60, 10);

                    minutes = minutes;
                    seconds = seconds-1;

                    display.text(seconds);

                    if (--timer < 0) {
                        $('#alert_attempts').remove();
                        clearInterval(x);
                    }
                }, 1000);
            }

            if ($('#alert_attempts').length != 0) {
                let time = $('#alert_time_attempts').text();
                let display = $('#alert_time_attempts');
                startTimer(time, display);
            }
        </script>
    @enderror
</body>
</html>