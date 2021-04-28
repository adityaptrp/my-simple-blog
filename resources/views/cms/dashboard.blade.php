
@extends('cms.layouts.app')

@section('title', 'Dashboard')

@section('require_style')
    
@endsection

@section('page_style')
    
@endsection
        
@section('content')
    <!-- Page Inner -->
    <div class="page-inner">
        <div class="page-title">
            <h3 class="breadcrumb-header">Dashboard</h3>
        </div>
        <div id="main-wrapper">
            {{-- Section Up down Profile --}}
            <div class="row cms-ud-menu">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-white stats-widget">
                        <div class="panel-body">
                            <div class="pull-left">
                                <span class="stats-number leading-6">
                                    {{ short_num($posts->count()) }}
                                    @if ($statusPosts > 0)
                                        <span class="text-green-500 inline-block text-2xl pr-10">+{{ $statusPosts }}</span>
                                    @endif
                                </span>
                                <p class="stats-info text-md" style="margin-top: 5px">Total Posts</p>
                                <div class="@if($statusPosts > 0) text-green-500 @endif text-sm"><span>+{{ $statusPosts }} {{$statusPosts > 1 ?'posts' : 'post'}} in {{ $subdays }} days</span></div>
                            </div>
                            @if ($statusPosts > 0)
                                <div class="pull-right">
                                    <i class="icon-arrow_upward stats-icon"></i>
                                </div>
                            @endif
                            @if ($statusPosts == 0)
                                <div class="pull-right text-gray-400" style="transform: rotate(90deg)">
                                    <i class="icon-pause3 stats-icon"></i>
                                </div>
                            @endif
                            @if ($statusPosts < 0)
                                <div class="pull-right text-gray-400" style="transform: rotate(90deg)">
                                    <i class="icon-arrow_downward stats-icon"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-white stats-widget">
                        <div class="panel-body">
                            <div class="pull-left">
                                <span class="stats-number leading-6">
                                    {{ short_num($comments->count()) }}
                                    @if ($statusComments > 0)
                                        <span class="text-green-500 inline-block text-2xl pr-10">+{{ $statusComments }}</span>
                                    @endif
                                </span>
                                <p class="stats-info text-md" style="margin-top: 5px">Total Comments</p>
                                <div class="@if($statusComments > 0) text-green-500 @endif text-sm"><span>+{{ $statusComments }} {{$statusComments > 1 ?'comments' : 'comment'}} in {{ $subdays }} days</span></div>
                            </div>
                            @if ($statusComments > 0)
                                <div class="pull-right">
                                    <i class="icon-arrow_upward stats-icon"></i>
                                </div>
                            @endif
                            @if ($statusComments == 0)
                                <div class="pull-right text-gray-400" style="transform: rotate(90deg)">
                                    <i class="icon-pause3 stats-icon"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-white stats-widget">
                        <div class="panel-body">
                            <div class="pull-left">
                                <span class="stats-number leading-6">
                                    {{ short_num($allViews) }}
                                    @if ($statusViews > 0)
                                        <span class="text-green-500 inline-block text-2xl pr-10">+{{ $statusViews }}</span>
                                    @endif
                                </span>
                                <p class="stats-info text-md" style="margin-top: 5px">Total Views</p>
                                <div class="@if($statusViews > 0) text-green-500 @endif text-sm"><span>+{{ $statusViews }} {{$statusViews > 1 ?'views' : 'view'}} in {{ $subdays }} days</span></div>
                            </div>
                            @if ($statusViews > 0)
                                <div class="pull-right">
                                    <i class="icon-arrow_upward stats-icon"></i>
                                </div>
                            @endif
                            @if ($statusViews == 0)
                                <div class="pull-right text-gray-400" style="transform: rotate(90deg)">
                                    <i class="icon-pause3 stats-icon"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-white stats-widget">
                        <div class="panel-body">
                            <div class="pull-left">
                                <span class="stats-number leading-6">
                                    {{ short_num($allLikes) }}
                                    @if ($statusLikes > 0)
                                        <span class="text-green-500 inline-block text-2xl pr-10">+{{ $statusLikes }}</span>
                                    @endif
                                </span>
                                <p class="stats-info text-md" style="margin-top: 5px">Total Post Likes</p>
                                <div class="@if($statusLikes > 0) text-green-500 @endif text-sm"><span>+{{ $statusLikes }} {{$statusLikes > 1 ?'likes' : 'like'}} in {{ $subdays }} days</span></div>
                            </div>
                            @if ($statusLikes > 0)
                                <div class="pull-right">
                                    <i class="icon-arrow_upward stats-icon"></i>
                                </div>
                            @endif
                            @if ($statusLikes == 0)
                                <div class="pull-right text-gray-400" style="transform: rotate(90deg)">
                                    <i class="icon-pause3 stats-icon"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div><!-- Row -->
            <div class="row">
                <div class="col-lg-5 col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">Projects</h4>
                        </div>
                        <div class="panel-body">
                            <div class="project-stats">
                                <ul class="list-unstyled">
                                    <li>Alpha - Admin Template<span class="label label-default pull-right">85%</span></li>
                                    <li>Meteor - Landing Page<span class="label label-success pull-right">Finished</span></li>
                                    <li>Modern - Corporate Website<span class="label label-success pull-right">Finished</span></li>
                                    <li>Space - Admin Template<span class="label label-danger pull-right">Rejected</span></li>
                                    <li>Backend UI<span class="label label-default pull-right">27%</span></li>
                                    <li>Personal Blog<span class="label label-default pull-right">48%</span></li>
                                    <li>E-mail Templates<span class="label label-default pull-right">Pending</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">New Comments in {{ $subdays }} days</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive invoice-table">
                                <table class="table">
                                    <tbody>
                                        @foreach ($insightComments as $comment)
                                            <tr class="cursor-pointer" onclick="window.location.href = this.dataset.cb; localStorage.setItem('viewCU', this.dataset.d);" data-d="{{ $comment->id }}" data-cb="{{ route('posts.show', ['user'=>$comment->post->user->username,'post'=>$comment->post->slug]) }}">
                                                <td>{{ $comment->email }}</td>
                                                <td>Themeforest</td>
                                                @if ($comment->is_approved)
                                                    <td><span class="label label-success">Approved</span></td>
                                                @else
                                                    <td><span class="label label-warning">Unapproved</span></td>
                                                @endif
                                                <td>$427</td>
                                            </tr>
                                        @endforeach
                                        {{-- <tr>
                                            <td>Darrell Price</td>
                                            <td>Twitter</td>
                                            <td><span class="label label-success">Finished</span></td>
                                            <td>$1714</td>
                                        </tr>
                                        <tr>
                                            <td>Richard Lunsford</td>
                                            <td>Facebook</td>
                                            <td><span class="label label-danger">Denied</span></td>
                                            <td>$685</td>
                                        </tr>
                                        <tr>
                                            <td>Amy Walker</td>
                                            <td>Youtube</td>
                                            <td><span class="label label-warning">Pending</span></td>
                                            <td>$9900</td>
                                        </tr>
                                        <tr>
                                            <td>Kathy Olson</td>
                                            <td>Youtube</td>
                                            <td><span class="label label-default">Upcoming</span></td>
                                            <td>$1250</td>
                                        </tr>
                                        <tr>
                                            <td>Susan Mabry</td>
                                            <td>Instagram</td>
                                            <td><span class="label label-default">Upcoming</span></td>
                                            <td>$399</td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- Row -->
        </div><!-- Main Wrapper -->
    </div><!-- /Page Inner -->
@endsection

@section('require_scripts')
    
@endsection

@section('page-scripts')
    
@endsection