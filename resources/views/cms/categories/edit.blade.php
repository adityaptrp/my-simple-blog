
@extends('cms.layouts.app')

@section('title', 'Manage Categories')

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
            <h3 class="breadcrumb-header">Edit Category</h3>
        </div>
        {{-- main wrapper --}}
        <div id="main-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-body overflow-auto">
                            <div class="panel-heading clearfix">
                                <h4 class="panel-title">Edit Category {{ $category->name }} :</h4>
                            </div>
                            <form action="{{ route('categories.update', $category->slug) }}" method="post" enctype="multipart/form-data" class="form-horizontal form-category-cms" autocomplete="off">
                            @csrf
                            @method('patch')
                                <div class="flex items-center">
                                    <label for="name" style="min-width: 50px">Name <span class="text-red-500">*</span></label>
                                    <input class="flex-grow border ml-4 mr-5 py-2 px-4 focus:border-green-600" type="text" name="name" id="name" value="{{ $category->name ?? old('name') }}" placeholder="Enter category name." data-l="20">
                                    <button type="submit" class="px-6 py-2 rounded bg-green-500 text-gray-100 hover:bg-green-600 cursor-pointer">Edit</button>
                                </div>
                                @error('name')
                                    <div class="mt-1.5 text-danger text-b_base" style="margin-left: 70px">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </form>
                        </div>
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
@endsection