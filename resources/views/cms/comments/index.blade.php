

@extends('cms.layouts.app')

@section('title', 'Manage Comments')

@section('require_style')
    <link href="{{ asset('cms/plugins/datatables/css/jquery.datatables.min.css') }}" rel="stylesheet" type="text/css"/>	
    <link href="{{ asset('cms/plugins/datatables/css/jquery.datatables_themeroller.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('cms/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('page_style')
    
@endsection

@section('content')
    <!-- Page Inner -->
    <div class="page-inner">
        <div class="page-title">
            <h3 class="breadcrumb-header">All Comments Unapproved</h3>
        </div>
        <div id="main-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">Total Comments : {{ $comments->count() }}</h4>
                        </div>
                        @include('cms/layouts/alert')
                        <form id="formMultipleSelect" action="{{ route('comments.multipleDelete') }}" method="post">
                            @csrf
                            @method('delete')
                            <div id="selectedPanel">
                                <div class="flex justify-between items-center border-t border-b py-3 px-8 mb-5 bg-gray-800 text-white">
                                    <div class="flex items-center">
                                        <div class="border-r pr-4">2 items selected</div>
                                        <a class="btn-rm-selected-comments text-b_base px-4 py-2.5 rounded-md bg-red-500 text-white hover:text-white cursor-pointer ml-4" style="transition: background-color .3s">
                                            <i class="far fa-trash-alt"></i>
                                            <span class="ml-1">Delete selected</span>
                                        </a>
                                    </div>
                                    <svg class="close-multiple-select w-6 h-6 cursor-pointer" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path class="block" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive py-5 md:py-0">
                                    <table id="datatable" class="display table" style="min-width:650px; cellspacing: 0;">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" class="checked-all cursor-pointer" style="margin-bottom: -3px !important;">
                                                </th>
                                                <th>Post</th>
                                                <th>Name</th>
                                                <th>Message</th>
                                                <th>Selected Text</th>
                                                <th>Website</th>
                                                <th>Like</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" class="checked-all cursor-pointer" style="margin-top: 1px;">
                                                </th>
                                                <th>Post</th>
                                                <th>Name</th>
                                                <th>Message</th>
                                                <th>Selected Text</th>
                                                <th>Website</th>
                                                <th>Like</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody class="body-l-common">
                                            @foreach ($comments as $i => $comment)
                                                <tr>
                                                    <td style="min-width: 5px; width: 5px; max-width: 5px; margin-bottom: 1px !important;">
                                                        <input class="checkboxArray" type="checkbox" name="checked[]" class="cursor-pointer" value="{{ $comment->id }}">
                                                    </td>
                                                    <td style="min-width:100px; width:5px;" class="overflow-auto cursor-default">
                                                        <span title="{{ $comment->post->title }}">{{ Str::limit($comment->post->title, 45, '...') }}</span>
                                                    </td>
                                                    <td class="overflow-auto cursor-default" style="min-width: 80px; max-width:80px;" title="{{ $comment->name.' - '.$comment->email }}">
                                                        <div>{{ $comment->name }}</div>
                                                        <div>({{ $comment->email }})</div>
                                                    </td>
                                                    <td style="min-width: 135px; width: 5px;" class="font-bold cursor-default" title="{{ $comment->body }}">{{ Str::limit($comment->body, 70, '...') }}</td>
                                                    <td class="cursor-default" style="min-width: 110px; width: 5px;" title="{{ $comment->selected_text }}">{{ $comment->selected_text ? Str::limit($comment->selected_text, 40, '...') : 'Null' }}</td>
                                                    <td class="overflow-auto" style="min-width: 70px; max-width:70px;" title="{{ $comment->user_link }}">
                                                        @if ($comment->user_link)
                                                            <a href="{{ $comment->user_link }}" style="color: #4299e1;" target="blank">{{ $comment->user_link }}</a>
                                                        @else
                                                            <div class="cursor-default">Null</div>
                                                        @endif
                                                    </td>
                                                    <td style="min-width: 40px; width: 5px;">{{ $comment->counts_like }}</td>
                                                    <td style="min-width: 100px; width: 5px;">
                                                        @if ($comment->is_approved)
                                                            <a class="mt-2 text-b_base px-3 py-2 rounded-full bg-green-500 text-gray-100 inline-block cursor-default">
                                                                <span class="text-b_base">Approved</span>
                                                            </a>
                                                        @else
                                                            <a class="mt-2 text-b_base px-3 py-2 rounded-full bg-yellow-500 text-gray-100 inline-block cursor-default">
                                                                <span class="text-b_base">Unapproved</span>
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td style="min-width: 100px; width: 5px;">
                                                        <a class="cms-rm-comment text-b_base px-4 py-2.5 rounded bg-red-500 text-gray-100 hover:bg-red-600 cursor-pointer inline-block">
                                                            <i class="far fa-trash-alt"></i>
                                                            <span class="ml-1">Delete</span>
                                                            @if ($i == 0)
                                                                {{-- isiin form tambahan karena ada error yang hapus form di loop pertama --}}
                                                                <form></form>
                                                            @endif
                                                            <form action="{{ route('comments.cmsDelete', $comment->id) }}" method="post">
                                                                @csrf
                                                                @method('delete')
                                                            </form>
                                                        </a>
                                                        @if ($comment->is_approved)
                                                            <a href="{{ route('posts.show', ['user'=>$comment->post->user->username,'post'=>$comment->post->slug]) }}" class="open-comment mt-2 text-b_base px-4 py-2.5 rounded bg-indigo-500 text-gray-100 hover:bg-indigo-600 cursor-pointer inline-block">
                                                                <i class="fas fa-eye"></i>
                                                                <span class="ml-1">Show</span>
                                                            </a>
                                                        @else
                                                            <a href="{{ route('posts.show', ['user'=>$comment->post->user->username,'post'=>$comment->post->slug]) }}" class="goViewCU mt-2 text-b_base px-4 py-2.5 rounded bg-indigo-500 text-gray-100 hover:bg-indigo-600 cursor-pointer inline-block" data-comment-id="{{ $comment->id }}">
                                                                <i class="fas fa-eye"></i>
                                                                <span class="ml-1">Show</span>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- Row -->
        </div><!-- Main Wrapper -->
    </div><!-- /Page Inner -->
@endsection


@section('require_scripts')
    <script src="{{ asset('cms/plugins/datatables/js/jquery.datatables.min.js') }}"></script>
    <script src="{{ asset('cms/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
@endsection

@section('page_scripts')
    <script src="{{ asset('cms/js/pages/table-data.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable( {
                "order": [],
                'aoColumnDefs': [{
                    'bSortable': false,
                    'aTargets': [0, -1]
                }],
            } );
        } );
    </script>
@endsection