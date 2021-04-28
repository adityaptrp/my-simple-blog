
{{-- Navbar Top --}}
<div class="nav-top border-b z-10">
    <div class="container flex justify-between px-6 sm:px-0 md:px-8">
        <div class="nav-brand flex items-center py-4">
            <a href="/" class="ml-0.5 lg:ml-0 flex items-center">
                <i class="fab fa-blogger mr-4 md:mr-5"></i>
                @if (request()->is('@*'))
                    <h1 class="title-nav block lg:hidden text-0.5xl pl-4 border-l">{{ $post->user->username }}</h1>
                @endif
            </a>
            <h2 class="hidden lg:block border-l pl-4 md:pl-5 text-lg font-semibold">{{ greet() }}</h2>
        </div>
    </div>
</div>

{{-- Navbar Bottom --}}
<div class="nav-bot border-b box-shadow-sm z-10">
    {{-- menu burger --}}
    <div class="container px-6 sm:px-0 md:px-8 py-4 flex items-center justify-between lg:hidden">
        {{-- Dark Mode Button --}}
        <button type="button" class="btn-darkmode do-darkmode flex items-center focus:outline-none justify-center text-sm w-9 h-9 rounded-full">
            <i class="fas fa-moon"></i>
        </button>
        
        <div class="flex items-center">
            @guest
                {{-- Bookmark --}}
                <a href="{{ route('readingList.saved') }}" class="mx-4 cursor-pointer hover:text-blue-500">
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="currentColor">
                        <path d="M16 6a2 2 0 0 1 2 2v13.66h-.01a.5.5 0 0 1-.12.29.5.5 0 0 1-.7.03l-5.67-4.13-5.66 4.13a.5.5 0 0 1-.7-.03.48.48 0 0 1-.13-.29H5V8c0-1.1.9-2 2-2h9zM6 8v12.64l5.16-3.67a.49.49 0 0 1 .68 0L17 20.64V8a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"></path><path d="M21 5v13.66h-.01a.5.5 0 0 1-.12.29.5.5 0 0 1-.7.03l-.17-.12V5a1 1 0 0 0-1-1h-9a1 1 0 0 0-1 1H8c0-1.1.9-2 2-2h9a2 2 0 0 1 2 2z"></path>
                    </svg>
                </a>
                {{-- notif np --}}
                <div class="nav-notif-np mr-5">
                    <i class="far fa-bell"></i>
                    <span class="nav-bullet-np flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                </div>
            @else
                {{-- Bookmark --}}
                <a href="{{ route('readingList.saved') }}" class="mx-4 cursor-pointer hover:text-blue-500">
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="currentColor">
                        <path d="M16 6a2 2 0 0 1 2 2v13.66h-.01a.5.5 0 0 1-.12.29.5.5 0 0 1-.7.03l-5.67-4.13-5.66 4.13a.5.5 0 0 1-.7-.03.48.48 0 0 1-.13-.29H5V8c0-1.1.9-2 2-2h9zM6 8v12.64l5.16-3.67a.49.49 0 0 1 .68 0L17 20.64V8a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"></path><path d="M21 5v13.66h-.01a.5.5 0 0 1-.12.29.5.5 0 0 1-.7.03l-.17-.12V5a1 1 0 0 0-1-1h-9a1 1 0 0 0-1 1H8c0-1.1.9-2 2-2h9a2 2 0 0 1 2 2z"></path>
                    </svg>
                </a>
                {{-- notif comment UA --}}
                @if (request()->is('@' . Auth::user()->username . '*') || request()->is('/'))
                    <a @if(!request()->is('/')) href="#" @endif class="nav-notif @if(request()->is('@*')) open-nav-notif @endif mr-5">
                        <i class="far fa-bell"></i>
                        @if (sizeOf($commentUnapproved) > 0)
                            <span class="nav-notif-bullet flex">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative flex justify-center items-center rounded-full bg-red-500">{{ sizeOf($commentUnapproved) > 99 ? '99' : $commentUnapproved->count() }}</span>
                            </span>
                        @endif
                    </a>
                @endif
            @endguest
            {{-- Close Button --}}
            <svg class="nav-burger w-6 h-6 cursor-pointer" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path class="block" d="M4 6h16M4 12h16m-7 6h7"></path>
                <path class="hidden" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </div>
    </div>
    {{-- Menu all --}}
    <div class="nav-bot container justify-between items-center px-6 sm:px-0 md:px-8 hidden lg:flex">
        <div class="flex items-center">
            @if (request()->is('@*'))
                <h1 class="title-nav hidden lg:block text-xl mr-8">{{ $post->user->username }}</h1>
            @endif
            <ul class="navbar-links flex text-xs tracking-widest uppercase">
                <li class="mr-6"><a class="inline-block py-6 hover:text-blue-400" href="{{ route('home') }}">Home</a></li>
                <li class="nav-categories mr-6 relative">
                    <a class="nav-title-categories inline-block py-6 pr-2" href="#">Category</a>
                    <i class="fas fa-caret-down cursor-pointer -ml-1 icon-dd"></i>
                    <div class="nav-categories-dropdown absolute flex flex-col w-40 box-shadow-sm rounded-sm z-10">
                        @foreach ($categories as $i=> $category)
                            <a href="{{ route('categories.show', $category->slug) }}" class="w-full py-2 px-4 hover:bg-blue-100 @if($i == 0) rounded-t-sm @endif @if($i == sizeOf($categories)-1) rounded-b-sm @endif">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </li>
                <li class="mr-6"><a class="inline-block py-6 hover:text-blue-400" href="#">About</a></li>
                <li class="mr-6"><a class="inline-block py-6 hover:text-blue-400" href="#">Contact</a></li>
            </ul>
        </div>
        @auth
            <div class="flex items-center">
                {{-- Dark Mode Button --}}
                <button type="button" class="btn-darkmode do-darkmode flex items-center focus:outline-none justify-center mr-4 text-sm w-9 h-9 rounded-full">
                    <i class="fas fa-moon"></i>
                </button>
                {{-- Bookmark --}}
                <a href="{{ route('readingList.saved') }}" class="mr-4 cursor-pointer hover:text-blue-500">
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="currentColor">
                        <path d="M16 6a2 2 0 0 1 2 2v13.66h-.01a.5.5 0 0 1-.12.29.5.5 0 0 1-.7.03l-5.67-4.13-5.66 4.13a.5.5 0 0 1-.7-.03.48.48 0 0 1-.13-.29H5V8c0-1.1.9-2 2-2h9zM6 8v12.64l5.16-3.67a.49.49 0 0 1 .68 0L17 20.64V8a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"></path><path d="M21 5v13.66h-.01a.5.5 0 0 1-.12.29.5.5 0 0 1-.7.03l-.17-.12V5a1 1 0 0 0-1-1h-9a1 1 0 0 0-1 1H8c0-1.1.9-2 2-2h9a2 2 0 0 1 2 2z"></path>
                    </svg>
                </a>
                {{-- notif comment UA --}}
                @if (request()->is('@' . Auth::user()->username . '*') || request()->is('/'))
                    <a @if(request()->is('/')) href="{{ route('comments.index') }}" @endif class="nav-notif @if(request()->is('@*')) open-nav-notif @endif mr-5">
                        <i class="far fa-bell"></i>
                        @if (sizeOf($commentUnapproved) > 0)
                            <span class="nav-notif-bullet flex">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative flex justify-center items-center rounded-full bg-red-500">{{ sizeOf($commentUnapproved) > 99 ? '99' : $commentUnapproved->count() }}</span>
                            </span>
                        @endif
                    </a>
                @endif
                {{-- dropdown --}}
                <div class="nav-profile relative cursor-pointer py-3">
                    <div class="flex items-center">
                        {{ Auth::user()->username }}
                        <i class="fas fa-caret-down ml-2"></i>
                        <img class="ml-3 w-10 h-10 rounded-full" src="{{ Auth::user()->profile_picture != null ? Auth::user()->getProfilePicture() : Auth::user()->gravatar() }}" onerror="this.onerror=null; this.src='{{ asset('/img/no_profile.png') }}'" alt="{{ Auth::user()->name }}">
                    </div>
                    <div class="nav-profile-dropdown absolute flex flex-col box-shadow-sm w-40 text-sm rounded-sm z-10">
                        <a href="{{ route('profile.show', Auth::user()->username) }}" class="w-full py-2 px-4 hover:bg-blue-100 rounded-t-sm">Profile</a>
                        <a href="{{ route('dashboard') }}" class="w-full py-2 px-4 hover:bg-blue-100">Management</a>
                        <a href="{{ route('logout') }}" class="w-full py-2 px-4 text-red-500 hover:bg-blue-100 rounded-b-sm" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="nav-bot-rg flex items-center py-3">
                <a class="nav-row font-bold pr-4 border-r items-center" href="{{ route('login') }}">
                    Log In
                </a>
                {{-- Dark Mode Button --}}
                <button type="button" class="btn-darkmode do-darkmode flex items-center focus:outline-none justify-center ml-4 text-sm w-9 h-9 rounded-full">
                    <i class="fas fa-moon"></i>
                </button>
                {{-- Bookmark --}}
                <a href="{{ route('readingList.saved') }}" class="mx-4 cursor-pointer hover:text-blue-500">
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="currentColor">
                        <path d="M16 6a2 2 0 0 1 2 2v13.66h-.01a.5.5 0 0 1-.12.29.5.5 0 0 1-.7.03l-5.67-4.13-5.66 4.13a.5.5 0 0 1-.7-.03.48.48 0 0 1-.13-.29H5V8c0-1.1.9-2 2-2h9zM6 8v12.64l5.16-3.67a.49.49 0 0 1 .68 0L17 20.64V8a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"></path><path d="M21 5v13.66h-.01a.5.5 0 0 1-.12.29.5.5 0 0 1-.7.03l-.17-.12V5a1 1 0 0 0-1-1h-9a1 1 0 0 0-1 1H8c0-1.1.9-2 2-2h9a2 2 0 0 1 2 2z"></path>
                    </svg>
                </a>
                {{-- Notif np --}}
                <div class="nav-notif-np">
                    <i class="far fa-bell"></i>
                    <span class="nav-bullet-np flex h-3 w-3 rounded-full">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                </div>
            </div>
        @endauth
    </div>
</div>

<div class="navigation-menu block items-center lg:hidden z-10">
    <div class="px-8 py-6 md:px-16">
        <h4 class="font-semibold text-sm uppercase">Menu</h4>
        <ul class="flex flex-col">
            <li class="nav-menu-link"><a href="{{ route('home') }}">
                <i class="fas fa-home w-7"></i>
                <span>Home</span>
            </a></li>
            <li class="nav-menu-link">
                <ul class="dropdown-nav-s flex justify-between items-center">
                    <div class="inline-block">
                        <i class="fas fa-clipboard-list w-7"></i>
                        <span>Category</span>
                    </div>
                    <i class="fas fa-angle-left"></i>
                </ul>
            </li>
            <li class="nav-menu-link"><a href="#">
                <i class="fas fa-user-circle w-7"></i>
                <span>About</span>
            </a></li>
            <li class="nav-menu-link"><a href="#">
                <i class="fas fa-address-book w-7"></i>
                <span>Contact</span>
            </a></li>
        </ul>
        <h4 class="mt-4 font-semibold text-sm uppercase">User</h4>
        <ul class="flex flex-col">
            @guest
                <li class="nav-menu-link"><a href="{{ route('login') }}" class="nav-profile">
                    <i class="fas fa-sign-in-alt w-7"></i>
                    <span>Log In</span>
                </a></li>
            @else
                <li class="nav-menu-link"><a href="{{ route('profile.show', Auth::user()->username) }}" class="nav-profile">
                    <i class="fas fa-user w-7"></i>
                    <span>Profile</span>
                </a></li>
                <li class="nav-menu-link"><a href="{{ route('dashboard') }}" class="nav-profile">
                    <i class="fas fa-file-alt w-7"></i>
                    <span>Management</span>
                </a></li>
                <li class="nav-menu-link">
                    <a href="#" class="nav-logout hover:text-red-500" onclick="event.preventDefault(); document.getElementById('logout-form2').submit();">
                        <i class="fas fa-sign-out-alt w-7"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form2" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</div>