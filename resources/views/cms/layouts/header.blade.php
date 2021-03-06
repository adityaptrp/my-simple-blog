
<!-- Page Header -->
<div class="page-header">
    <div class="search-form">
        <form action="#" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control search-input" placeholder="Type something...">
                <span class="input-group-btn">
                    <button class="btn btn-default" id="close-search" type="button"><i class="icon-close"></i></button>
                </span>
            </div>
        </form>
    </div>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <div class="logo-sm">
                    <a href="javascript:void(0)" id="sidebar-toggle-button"><i class="fa fa-bars"></i></a>
                    <a class="logo-box" href="index.html"><span>Space</span></a>
                </div>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <i class="fa fa-angle-down"></i>
                </button>
            </div>
        
            <!-- Collect the nav links, forms, and other content for toggling -->
        
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="javascript:void(0)" id="collapsed-sidebar-toggle-button"><i class="fa fa-bars"></i></a></li>
                    <li><a href="javascript:void(0)" id="toggle-fullscreen"><i class="fa fa-expand"></i></a></li>
                    <li><a href="javascript:void(0)" id="search-button"><i class="fa fa-search"></i></a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="javascript:void(0)" class="right-sidebar-toggle" data-sidebar-id="main-right-sidebar"><i class="fa fa-envelope"></i></a></li>
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell"></i></a>
                        <ul class="dropdown-menu dropdown-lg dropdown-content">
                            <li class="drop-title">Notifications<a href="#" class="drop-title-link"><i class="fa fa-angle-right"></i></a></li>
                            <li class="slimscroll dropdown-notifications">
                                <ul class="list-unstyled dropdown-oc">
                                    <li>
                                        <a href="#"><span class="notification-badge bg-primary"><i class="fa fa-photo"></i></span>
                                            <span class="notification-info">Finished uploading photos to gallery <b>"South Africa"</b>.
                                                <small class="notification-date">20:00</small>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="#"><span class="notification-badge bg-primary"><i class="fa fa-at"></i></span>
                                            <span class="notification-info"><b>John Doe</b> mentioned you in a post "Update v1.5".
                                                <small class="notification-date">06:07</small>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="#"><span class="notification-badge bg-danger"><i class="fa fa-bolt"></i></span>
                                            <span class="notification-info">4 new special offers from the apps you follow!
                                                <small class="notification-date">Yesterday</small>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="#"><span class="notification-badge bg-success"><i class="fa fa-bullhorn"></i></span>
                                            <span class="notification-info">There is a meeting with <b>Ethan</b> in 15 minutes!
                                                <small class="notification-date">Yesterday</small>
                                            </span></a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="{{ Auth::user()->gravatar() }}" alt="" class="img-circle"></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('profile.show', Auth::user()->username) }}">Profile</a></li>
                            <li><a href="#">Calendar</a></li>
                            <li><a href="#"><span class="badge pull-right badge-danger">42</span>Messages</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Account Settings</a></li>
                            <li>
                                <a href="{{ route('logout') }}" class="text-danger" style="color: #f56565" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div><!-- /Page Header -->

{{-- Header Sidebar Right --}}
<div class="page-right-sidebar" id="main-right-sidebar">
    <div class="page-right-sidebar-inner">
        <div class="right-sidebar-top">
            <div class="right-sidebar-tabs">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active" id="chat-tab"><a href="#chat" aria-controls="chat" role="tab" data-toggle="tab">chat</a></li>
                    <li role="presentation" id="settings-tab"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">settings</a></li>
                </ul>
            </div>
            <a href="javascript:void(0)" class="right-sidebar-toggle right-sidebar-close" data-sidebar-id="main-right-sidebar"><i class="icon-close"></i></a>
        </div>
        <div class="right-sidebar-content">
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="chat">
                    <div class="chat-list">
                        <span class="chat-title">Recent</span>
                        <a href="javascript:void(0);" class="right-sidebar-toggle chat-item unread" data-sidebar-id="chat-right-sidebar">
                            <div class="user-avatar">
                                <img src="http://via.placeholder.com/40x40" alt="">
                            </div>
                            <div class="chat-info">
                                <span class="chat-author">David</span>
                                <span class="chat-text">where u at?</span>
                                <span class="chat-time">08:50</span>
                            </div>
                        </a>
                        <a href="javascript:void(0);" class="right-sidebar-toggle chat-item unread active-user" data-sidebar-id="chat-right-sidebar">
                            <div class="user-avatar">
                                <img src="http://via.placeholder.com/40x40" alt="">
                            </div>
                            <div class="chat-info">
                                <span class="chat-author">Daisy</span>
                                <span class="chat-text">Daisy sent a photo.</span>
                                <span class="chat-time">11:34</span>
                            </div>
                        </a>
                    </div>
                    <div class="chat-list">
                        <span class="chat-title">Older</span>
                        <a href="javascript:void(0);" class="right-sidebar-toggle chat-item" data-sidebar-id="chat-right-sidebar">
                            <div class="user-avatar">
                                <img src="http://via.placeholder.com/40x40" alt="">
                            </div>
                            <div class="chat-info">
                                <span class="chat-author">Tom</span>
                                <span class="chat-text">You: ok</span>
                                <span class="chat-time">2d</span>
                            </div>
                        </a>
                        <a href="javascript:void(0);" class="right-sidebar-toggle chat-item active-user" data-sidebar-id="chat-right-sidebar">
                            <div class="user-avatar">
                                <img src="http://via.placeholder.com/40x40" alt="">
                            </div>
                            <div class="chat-info">
                                <span class="chat-author">Anna</span>
                                <span class="chat-text">asdasdasd</span>
                                <span class="chat-time">4d</span>
                            </div>
                        </a>
                        <a href="javascript:void(0);" class="right-sidebar-toggle chat-item active-user" data-sidebar-id="chat-right-sidebar">
                            <div class="user-avatar">
                                <img src="http://via.placeholder.com/40x40" alt="">
                            </div>
                            <div class="chat-info">
                                <span class="chat-author">Liza</span>
                                <span class="chat-text">asdasdasd</span>
                                <span class="chat-time">&nbsp;</span>
                            </div>
                        </a>
                        <a href="javascript:void(0);" class="load-more-messages"  data-toggle="tooltip" data-placement="bottom" title="Load More">&bull;&bull;&bull;</a>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="settings">
                    <div class="right-sidebar-settings">
                        <span class="settings-title">General Settings</span>
                        <ul class="sidebar-setting-list list-unstyled">
                            <li>
                                <span class="settings-option">Notifications</span><input type="checkbox" class="js-switch" checked />
                            </li>
                            <li>
                                <span class="settings-option">Activity log</span><input type="checkbox" class="js-switch" checked />
                            </li>
                            <li>
                                <span class="settings-option">Automatic updates</span><input type="checkbox" class="js-switch" />
                            </li>
                            <li>
                                <span class="settings-option">Allow backups</span><input type="checkbox" class="js-switch" />
                            </li>
                        </ul>
                        <span class="settings-title">Account Settings</span>
                        <ul class="sidebar-setting-list list-unstyled">
                            <li>
                                <span class="settings-option">Chat</span><input type="checkbox" class="js-switch" checked />
                            </li>
                            <li>
                                <span class="settings-option">Incognito mode</span><input type="checkbox" class="js-switch" />
                            </li>
                            <li>
                                <span class="settings-option">Public profile</span><input type="checkbox" class="js-switch" />
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-right-sidebar" id="chat-right-sidebar">
    <div class="page-right-sidebar-inner">
        <div class="right-sidebar-top">
            <div class="chat-top-info">
                <span class="chat-name">Noah</span>
                <span class="chat-state">2h ago</span>
            </div>
            <a href="javascript:void(0)" class="right-sidebar-toggle chat-sidebar-close pull-right" data-sidebar-id="chat-right-sidebar"><i class="icon-keyboard_arrow_right"></i></a>
        </div>
        <div class="right-sidebar-content">
            <div class="right-sidebar-chat slimscroll">
                <div class="chat-bubbles">
                <div class="chat-start-date">02/06/2017 5:58PM</div>
                    <div class="chat-bubble them">
                        <div class="chat-bubble-img-container">
                            <img src="http://via.placeholder.com/38x38" alt="">
                        </div>
                        <div class="chat-bubble-text-container">
                            <span class="chat-bubble-text">Hello</span>
                        </div>
                    </div>
                    <div class="chat-bubble me">
                        <div class="chat-bubble-text-container">
                            <span class="chat-bubble-text">Hello!</span>
                        </div>
                    </div>
                <div class="chat-start-date">03/06/2017 4:22AM</div>
                    <div class="chat-bubble me">
                        <div class="chat-bubble-text-container">
                            <span class="chat-bubble-text">lorem</span>
                        </div>
                    </div>
                    <div class="chat-bubble them">
                        <div class="chat-bubble-img-container">
                            <img src="http://via.placeholder.com/38x38" alt="">
                        </div>
                        <div class="chat-bubble-text-container">
                            <span class="chat-bubble-text">ipsum dolor sit amet</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="chat-write">
                <form class="form-horizontal" action="javascript:void(0);">
                    <input type="text" class="form-control" placeholder="Say something">
                </form>
            </div>
        </div>
    </div>
</div>