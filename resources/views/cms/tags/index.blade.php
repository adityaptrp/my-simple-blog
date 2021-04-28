
@extends('cms.layouts.app')

@section('title', 'Manage Tags')

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
            <h3 class="breadcrumb-header">All Tags</h3>
        </div>
        <div id="main-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">Total Tags : {{ $tags->count() }}</h4>
                        </div>
                        @include('cms/layouts/alert')
                        <form id="formMultipleSelect" action="{{ route('tags.multipleDelete') }}" method="post">
                            @csrf
                            @method('delete')
                            <div id="selectedPanel">
                                <div class="flex justify-between items-center border-t border-b py-3 px-8 mb-5 bg-gray-800 text-white">
                                    <div class="flex items-center">
                                        <div class="border-r pr-4">2 items selected</div>
                                        <a class="btn-rm-selected-tags text-b_base px-4 py-2.5 rounded-md bg-red-500 text-white hover:text-white cursor-pointer ml-4" style="transition: background-color .3s">
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
                                                <th>Name</th>
                                                <th>Slug</th>
                                                <th>Created At</th>
                                                <th>Used</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" class="checked-all cursor-pointer" style="margin-top: 1px;">
                                                </th>
                                                <th>Name</th>
                                                <th>Slug</th>
                                                <th>Created At</th>
                                                <th>Used</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody class="body-l-common">
                                            @foreach ($tags as $i => $tag)
                                                <tr>
                                                    <td style="min-width: 5px; width: 5px; max-width: 5px; margin-bottom: 1px !important;">
                                                        <input class="checkboxArray" type="checkbox" name="checked[]" class="cursor-pointer" value="{{ $tag->id }}">
                                                    </td>
                                                    <td class="font-bold">{{ $tag->name }}</td>
                                                    <td>{{ $tag->slug }}</td>
                                                    <td>{{ $tag->created_at->format('d M Y')  }}</td>
                                                    <td>
                                                        <a href="{{ route('tag.posts', $tag->slug) }}" class="text-b_base px-4 py-2.5 rounded-full bg-green-500 hover:bg-green-600 text-gray-100 cursor-pointer inline-block">
                                                            <i class="fas fa-archive"></i>
                                                            <span class="ml-1">: {{ $tag->posts()->count() }}</span>
                                                        </a>
                                                    </td>
                                                    <td class="flex items-center">
                                                        <a class="cms-rm-tags text-b_base px-4 py-2.5 rounded bg-red-500 text-gray-100 hover:bg-red-600 cursor-pointer inline-block">
                                                            <i class="far fa-trash-alt"></i>
                                                            <span class="ml-1">Delete</span>
                                                            @if ($i == 0)
                                                                {{-- isiin form tambahan karena ada error yang hapus form di loop pertama --}}
                                                                <form></form>
                                                            @endif
                                                            <form action="{{ route('tags.destroy', $tag->slug) }}" method="post">
                                                                @csrf
                                                                @method('delete')
                                                            </form>
                                                        </a>
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