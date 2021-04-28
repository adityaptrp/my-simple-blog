
@extends('cms.layouts.app')

@section('title', 'Your Account | Adityaptrp')

@section('content')
    <!-- Page Inner -->
    <div class="page-inner">
        {{-- Desc page --}}
        <h3 class="text-2.5xl text-gray-700">Your Account</h3>
        <div class="flex flex-col sm:w-136">
            <span>You can update settings about your account, change your password, or learn about deactivation options for your account</span>
        </div>

        {{-- Main Content --}}
        <div class="all-accordions flex flex-col mt-7">
            @include('cms/layouts/alert')
            {{-- Go setting profile --}}
            <div id="accordion1" class="accordions-btn flex items-center p-5 border rounded cursor-pointer" onclick="window.location.href = this.dataset.cb; localStorage.setItem('active_edit_profile', true);" data-cb="{{ route('profile.show', Auth::user()->username) }}">
                <div class="ac-menu-icon w-12 h-12 flex items-center justify-center">
                    <i class="fas fa-user"></i>
                </div>
                <div class="t-accordions mx-5 flex-grow">
                    <div class="text-lg"><span>Account Setting</span></div>
                    <div>You can update settings about your account like your username and profile picture, bio and others here.</div>
                </div>
                <div class="icon-open w-12 h-12 flex justify-center items-center text-gray-800">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>

            {{-- Change password --}}
            <div id="accordion2" class="accordions-btn @if ($errors->has('password') || $errors->has('current_password')) active @endif flex items-center p-5 border border-t-0 rounded cursor-pointer">
                <div class="ac-menu-icon @if ($errors->has('password') || $errors->has('current_password')) active @endif w-12 h-12 flex items-center justify-center">
                    <i class="fas fa-key"></i>
                </div>
                <div class="t-accordions mx-5 flex-grow">
                    <div class="text-lg"><span>Change Your Password</span></div>
                    <div>Change your password at any time.</div>
                </div>
                <div class="icon-open @if ($errors->has('password') || $errors->has('current_password')) active @endif w-12 h-12 flex justify-center items-center text-gray-800">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
            <div class="accordions-content @if ($errors->has('password') || $errors->has('current_password')) active border border-t-0 @endif rounded">
                <form action="{{ route('password.update') }}" method="post" class="flex flex-col pb-7 pt-2 px-7 sm:px-10">
                @csrf
                @method('patch')
                    <div class="mt-3 text-blue-500">
                        <span>Strong passwords include numbers, letters, and punctuation marks.</span>
                    </div>
                    <div class="input-group mt-3">
                        <label for="current_password">
                            Current Password : 
                            <span class="text-sm text-red-500">
                                *
                                @error('current_password')
                                    {{ $message }}
                                @enderror
                            </span>
                        </label>
                        <input class="focus:border-green-500" type="password" id="current_password" name="current_password" placeholder="Enter your current password.">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-5 mt-3">
                        <div class="input-group">
                            <label for="Password">New Password :</label>
                            <input class="focus:border-green-500" type="password" id="password" name="password" placeholder="Enter your new password">
                        </div>
                        <div class="input-group">
                            <label for="password_confirmation">Confirm Password :</label>
                            <input class="focus:border-green-500" type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password">
                        </div>
                    </div>
                    @error('password')
                        <div class="text-sm mt-2 text-red-500">
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="flex mt-5 justify-end">
                        <button type="submit" class="text-b_base px-5 py-2.5 rounded bg-green-500 text-gray-100 hover:bg-green-600 cursor-pointer focus:outline-none">
                            <span>Confirm</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Change Email --}}
            <div id="accordion3" class="accordions-btn @if ($errors->has('email')) active @endif flex items-center p-5 border border-t-0 rounded cursor-pointer">
                <div class="ac-menu-icon @if ($errors->has('email')) active @endif w-12 h-12 flex items-center justify-center">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="t-accordions mx-5 flex-grow">
                    <div class="text-lg"><span>Change your email</span></div>
                    <div>Change your email at any time.</div>
                </div>
                <div class="icon-open @if ($errors->has('email')) active @endif w-12 h-12 flex justify-center items-center text-gray-800">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
            <div class="accordions-content @if ($errors->has('email')) active border border-t-0 @endif rounded">
                <form action="{{ route('email.update') }}" method="post" class="flex flex-col pb-7 pt-2 px-7 sm:px-10">
                @csrf
                @method('patch')
                    <div class="mt-3 text-blue-500">
                        <span>If you change your email, you will get an email verification link to your new email.</span>
                    </div>
                    <div class="input-group mt-3">
                        <label>
                            Current E-mail : 
                        </label>
                        <input class="focus:border-green-500" type="text" placeholder="Enter your current password." value="{{ Auth::user()->email }}" disabled>
                    </div>
                    <div class="input-group mt-3">
                        <label for="email">
                            New Email : 
                            <span class="text-sm text-red-500">
                                *
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </span>
                        </label>
                        <input class="focus:border-green-500" type="text" id="email" name="email" placeholder="Enter your current password.">
                    </div>
                    <div class="flex mt-5 justify-end">
                        <button type="submit" class="text-b_base px-5 py-2.5 rounded bg-green-500 text-gray-100 hover:bg-green-600 cursor-pointer focus:outline-none">
                            <span>Confirm</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Delete Account --}}
            <div id="accordion4" class="accordions-btn @if ($errors->has('deactive_account')) active @endif flex items-center p-5 border border-t-0 rounded cursor-pointer">
                <div class="ac-menu-icon @if ($errors->has('deactive_account')) active @endif w-12 h-12 flex items-center justify-center">
                    <i class="fas fa-user-alt-slash"></i>
                </div>
                <div class="t-accordions mx-5 flex-grow">
                    <div class="text-lg"><span>Deactivate Account</span></div>
                    <div>Find out how to deactive your account.</div>
                </div>
                <div class="icon-open @if ($errors->has('deactive_account')) active @endif w-12 h-12 flex justify-center items-center text-gray-800">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
            <div class="accordions-content @if ($errors->has('deactive_account')) active border border-t-0 @endif rounded">
                <form action="{{ route('account.delete') }}" method="post" class="flex flex-col pb-7 pt-2 px-7 sm:px-10">
                @csrf
                @method('delete')
                    <div class="mt-3 text-blue-500">
                        <span>You’re about to start the process of deleting your account. Once you delete your account, there is no going back. Please be certain.</span>
                    </div>
                    <div class="input-group mt-3">
                        <label for="deactive_account">
                            Enter "DELETE_ACCOUNT" to verify the process : 
                            <span class="text-sm text-red-500">*</span>
                        </label>
                        <input class="focus:border-green-500 mt-1" type="text" id="deactive_account" name="deactive_account" placeholder="Enter your current password.">
                    </div>
                    @error('deactive_account')
                        <div class="text-sm mt-2 text-red-500">
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="flex mt-5 justify-end">
                        <button type="submit" class="text-b_base px-5 py-2.5 rounded bg-red-500 text-gray-100 hover:bg-red-600 cursor-pointer focus:outline-none">
                            <span>Delete Account</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /Page Inner -->
@endsection

@section('page_scripts')
    
@endsection