
@extends('cms.layouts.app')

@section('title', 'All Posts')

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
            <h3 class="breadcrumb-header">
                @isset ($category_posts)
                    All Posts category : {{ $category_posts }}
                @else
                    @isset ($tag_posts)
                        All Posts tag : {{ $tag_posts }}
                    @else
                        All Posts
                    @endif
                @endisset
            </h3>
        </div>
        <div id="main-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">Total Post : {{ $posts->count() }}</h4>
                        </div>
                        @include('cms/layouts/alert')
                        <form id="formMultipleSelect" action="{{ route('posts.multipleDelete') }}" method="post">
                            @csrf
                            @method('delete')
                            <div id="selectedPanel">
                                <div class="flex justify-between items-center border-t border-b py-3 px-8 mb-5 bg-gray-800 text-white">
                                    <div class="flex items-center">
                                        <div class="border-r pr-4">2 items selected</div>
                                        <a class="btn-rm-selected-posts text-b_base px-4 py-2.5 rounded-md bg-red-500 text-white hover:text-white cursor-pointer ml-4" style="transition: background-color .3s">
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
                                <div class="table-responsive pt-5 md:pt-0 pb-5">
                                    <table id="datatable" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" class="checked-all cursor-pointer" style="margin-bottom: -3px !important;">
                                                </th>
                                                <th style="width: 40px;">Thumbnail</th>
                                                <th style="min-width: 20px; width: 10px;">Title</th>
                                                <th style="min-width: 45px;">Author</th>
                                                <th style="min-width: 75px;">Comment</th>
                                                <th style="min-width: 43px;">Likes</th>
                                                <th style="min-width: 50px;">Category</th>
                                                <th style="min-width: 50px;">Tags</th>
                                                <th style="min-width: 80px;">Created At</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" class="checked-all cursor-pointer" style="margin-top: 1px;">
                                                </th>
                                                <th>Thumbnail</th>
                                                <th>Title</th>
                                                <th>Author</th>
                                                <th>Comment</th>
                                                <th>Likes</th>
                                                <th>Category</th>
                                                <th>Tags</th>
                                                <th>Created At</th>
                                            </tr>
                                        </tfoot>
                                        <tbody class="body-l-post">
                                            @foreach ($posts as $i => $post)
                                                <tr>
                                                    <td style="min-width: 5px; width: 5px; max-width: 5px; margin-bottom: 1px !important;">
                                                        <input class="checkboxArray" type="checkbox" name="checked[]" class="cursor-pointer" value="{{ $post->id }}">
                                                    </td>
                                                    <td class="w-30 h-25 flex justify-center items-center">
                                                        <img src="{{ $post->getThumbnail() }}" alt="" class="w-full h-full object-cover object-center">
                                                    </td>
                                                    <td style="min-width: 200px; width: 10px;" class="cms-mp-title relative border-r px-2">
                                                        <p class="text-base font-bold">{{ Str::limit($post->title, 26, '...') }}</p>
                                                        <div class="text-base -mt-1">
                                                            {!! nl2br(e(Str::limit($post->header, 75, '...'))) !!}
                                                        </div>
                                                        <div class="h-cms-mp">
                                                            @if (Auth::user()->id == $post->user_id)
                                                                <a class="text-xl" href="{{ route('posts.edit', $post->slug) }}"><i class="fas fa-pen"></i></a>
                                                            @endif
                                                            <a class="text-2xl @if(Auth::user()->id == $post->user_id) ml-7 @endif" href="{{ route('posts.show', ['user'=>$post->user->username,'post'=>$post->slug]) }}"><i class="fas fa-eye"></i></a>
                                                            <a class="cms-delete-post text-xl ml-7">
                                                                <i class="fas fa-trash"></i>
                                                                @if ($i == 0)
                                                                    {{-- isiin form tambahan karena ada error yang hapus form di loop pertama --}}
                                                                    <form></form>
                                                                @endif
                                                                <form action="{{ route('posts.destroy', $post->slug) }}" method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                </form>
                                                            </a>
                                                            <a class="text-xl ml-7" href="#"><i class="fas fa-comment-alt"></i></a>
                                                        </div>
                                                    </td>
                                                    <td style="min-width: 70px;">{{ $post->user->name }}</td>
                                                    <td>{{ $post->allCommentsApproverd->count() }}</td>
                                                    <td>{{ $post->likes_count }}</td>
                                                    <td>{{ $post->category->name ?? 'Null' }}</td>
                                                    <td>
                                                        @if (sizeOf($post->tags) == 0)
                                                            Null
                                                        @endif
                                                        @foreach ($post->tags->take(4) as $i => $tag)
                                                            @if ($i+1 == 4)
                                                                @if (sizeOf($post->tags) > 4)
                                                                    {{ $tag->name }}...
                                                                @endif
                                                            @else
                                                                @if ($i+1 == sizeOf($post->tags->take(4)) )
                                                                    {{ $tag->name }}
                                                                @else
                                                                    {{ $tag->name }}, <br>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>{{ $post->created_at->format('d M Y')  }}</td>
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
                    'aTargets': [0]
                }]
            } );
        } );
    </script>
@endsection