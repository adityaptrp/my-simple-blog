
@extends('cms.layouts.app')

@section('title', 'Your Account | Adityaptrp')

@section('content')
    <!-- Page Inner -->
    <div class="page-inner">
        {{-- Desc page --}}
        <div class="page-title">
            <h3 class="breadcrumb-header">Confirm Your Password</h3>
        </div>

        {{-- Main Content --}}
        <div id="main-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-white flex flex-col sm:w-160">
                        <div class="panel-heading clearfix">
                            <div class="text-gray-600">Please confirm your password in order to get your request page.</div>
                        </div>
                        <form action="{{ route('password.confirm') }}" method="post">
                            @csrf
                            @method('post')
                            <div class="input-group my-3">
                                <label for="password">
                                    Enter your password : 
                                    <span class="text-sm text-red-500">
                                        *
                                        @error('password')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </label>
                                <input class="focus:border-green-500 mt-1" type="password" id="password" name="password" placeholder="Enter your current password.">
                            </div>
                            @if (Route::has('password.request'))
                                <a class="text-blue-500" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            @endif
                            <div class="flex mt-5 justify-end">
                                <button type="submit" class="text-b_base px-5 py-2.5 rounded bg-green-500 text-gray-100 hover:bg-green-600 cursor-pointer focus:outline-none">
                                    <span>Confirm</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- Row -->
        </div><!-- Main Wrapper -->
    </div><!-- /Page Inner -->
@endsection

@section('page_scripts')
    
@endsection