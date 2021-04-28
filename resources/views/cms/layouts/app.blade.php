
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    
    <!-- Title -->
    <title>@yield('title')</title>

    <!-- Custom Style -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <link href="{{ asset('cms/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('cms/plugins/icomoon/style.css') }}" rel="stylesheet">
    <link href="{{ asset('cms/plugins/uniform/css/default.css') }}" rel="stylesheet"/>
    <link href="{{ asset('cms/plugins/switchery/switchery.min.css') }}" rel="stylesheet"/>

    @yield('require_style')

    <!-- Theme Styles -->
    <link href="{{ asset('cms/css/space.css') }}" rel="stylesheet">
    <link href="{{ asset('cms/css/custom.css') }}" rel="stylesheet">
    <link rel='stylesheet' href='{{ asset('vendor/nprogress/nprogress.css') }}'/>

    @yield('page_style')
</head>
<body class="page-header-fixed">

    <div class="page-container">
        {{-- sidebar --}}
        @include('cms.layouts.sidebar')

        {{-- Page Content --}}
        <div class="page-content">
            {{-- Header --}}
            @include('cms.layouts.header')

            {{-- Page Inner --}}
            @yield('content')
        </div>
    </div>
    @include('cms.layouts.modal')

    <!-- Javascripts -->
    <script src="{{ asset('cms/plugins/jquery/jquery-3.1.0.min.js') }}"></script>
    <script src="{{ asset('cms/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('cms/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('cms/plugins/uniform/js/jquery.uniform.standalone.js') }}"></script>
    <script src="{{ asset('cms/plugins/switchery/switchery.min.js') }}"></script>
    <script src='{{ asset('vendor/nprogress/nprogress.js') }}'></script>
    <script>
        // Nprogress Run
        NProgress.start();
        NProgress.configure({ minimum: 0.1 });
        NProgress.configure({ easing: 'ease', speed: 800 });
        NProgress.configure({ trickleSpeed: 500 });
        $(window).on('load', function(){
            NProgress.done();
        });
    </script>
    
    @yield('require_scripts')
    
    <script src="{{ asset('cms/js/space.js') }}"></script>
    <script src="{{ asset('cms/js/custom.js') }}"></script>
    <script src="https://kit.fontawesome.com/6eae20eef6.js" crossorigin="anonymous"></script>

    @yield('page_scripts')
</body>
</html>