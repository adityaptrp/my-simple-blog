
<!-- Page Sidebar -->
<div class="page-sidebar">
    <a class="logo-box" href="{{ route('dashboard') }}">
        <span>Space</span>
        <i class="icon-radio_button_unchecked" id="fixed-sidebar-toggle-button"></i>
        <i class="icon-close" id="sidebar-toggle-button-close"></i>
    </a>
    <div class="page-sidebar-inner">
        <div class="page-sidebar-menu">
            <ul class="accordion-menu">
                <li @if(request()->is('dashboard')) class="active-page" @endif>
                    <a href="{{ route('dashboard') }}">
                        <i class="menu-icon icon-stats-bars"></i><span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}">
                        <i class="menu-icon icon-home4"></i><span>Home</span>
                    </a>
                </li>
                <li @if(request()->is('posts*')) class="active-page" @endif>
                    <a href="javascript:void(0);">
                        <i class="menu-icon icon-layers"></i><span>Posts</span><i class="accordion-icon fa fa-angle-left"></i>
                    </a>
                    <ul class="sub-menu">
                        @if (Auth::user()->is_admin)
                            <li @if(request()->is('posts/all-posts')) class="active-page" @endif><a href="{{ route('posts.allPosts') }}">All Posts</a></li>
                        @endif
                        <li @if(request()->is('posts')) class="active-page" @endif><a href="{{ route('posts.index') }}">Manage Posts</a></li>
                        <li @if(request()->is('posts/create')) class="active-page" @endif><a href="{{ route('posts.create') }}">Create Post</a></li>
                    </ul>
                </li>
                @if (Auth::user()->is_admin)
                    <li @if(request()->is('categories*')) class="active-page" @endif>
                        <a href="javascript:void(0);">
                            <i class="menu-icon icon-star-full"></i><span>Categories</span><i class="accordion-icon fa fa-angle-left"></i>
                        </a>
                        <ul class="sub-menu">
                            <li @if(request()->is('categories')) class="active-page" @endif><a href="{{ route('categories.index') }}">Manage Categories</a></li>
                            <li @if(request()->is('categories/create')) class="active-page" @endif><a href="{{ route('categories.create') }}">Create Category</a></li>
                        </ul>
                    </li>
                    <li @if(request()->is('tags*')) class="active-page" @endif>
                        <a href="{{ route('tags.index') }}">
                            <i class="menu-icon icon-beenhere"></i><span>Tags</span>
                        </a>
                    </li>
                @endif
                <li @if(request()->is('comments*')) class="active-page" @endif>
                    <a href="{{ route('comments.index') }}">
                        <i class="menu-icon icon-comment"></i><span>Comments</span>
                    </a>
                </li>
                <li class="menu-divider"></li>
                <li @if(request()->is('settings*')) class="active-page" @endif>
                    <a href="javascript:void(0);">
                        <i class="menu-icon icon-settings"></i><span>Settings</span><i class="accordion-icon fa fa-angle-left"></i>
                    </a>
                    <ul class="sub-menu">
                        <li @if(request()->is('settings/account/*')) class="active-page" @endif><a href="{{ route('settings.account', Auth::user()->username) }}">Your Account</a></li>
                        @if (Auth::user()->is_admin)
                            <li @if(request()->is('settings/application')) class="active-page" @endif><a href="{{ route('settings.application') }}">Application</a></li>
                        @endif
                    </ul>
                </li>
                <li>
                    <a href="index.html">
                        <i class="menu-icon icon-help_outline"></i><span>Documentation</span>
                    </a>
                </li>
                <li>
                    <a href="index.html">
                        <i class="menu-icon icon-public"></i><span>Changelog</span><span class="label label-danger">1.0</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div><!-- /Page Sidebar -->