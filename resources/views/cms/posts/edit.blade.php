

@extends('cms.layouts.app')

@section('title', 'Manage Post - Update Post')

@section('require_style')
    <link href="{{ asset('cms/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css"/>
    <script src="https://cdn.tiny.cloud/1/yf74mwf3z981ghh4vqy9x9kwcsjqcmst3f9whesgrv4mplx5/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endsection

@section('page_style')
    <style>
        .tox-notifications-container {
            display: none !important;
        }
    </style>
@endsection

@section('content')
    <!-- Page Inner -->
    <div class="page-inner">
        <div class="page-title">
            <h3 class="breadcrumb-header">Update Post</h3>
        </div>
        {{-- main wrapper --}}
        <div id="main-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-body">
                            <form action="{{ route('posts.update', $post->slug) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                            @csrf
                            @method('patch')
                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label cursor-pointer">Title <span class="text-red-500">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Input post title." value="{{ old('title') ?? $post->title }}">
                                        @error('title')
                                            <div class="mt-1 ml-1 text-danger text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="subtitle" class="col-sm-2 control-label cursor-pointer">Subtitle</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Input post subtitle." value="{{ old('subtitle') ?? $post->subtitle }}">
                                        @error('subtitle')
                                            <div class="mt-1 ml-1 text-danger text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Header <span class="text-red-500">*</span></label>
                                    <div class="col-sm-10">
                                        <textarea class="w-full border border-gray-400 px-3 py-2 h-45" name="header">{{ old('header') ?? $post->header }}</textarea>
                                        @error('header')
                                            <div class="mt-1 ml-1 text-danger text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Body</label>
                                    <div class="col-sm-10">
                                        <textarea class="tinymce" name="body">{{ old('body') ?? $post->body }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Footer</label>
                                    <div class="col-sm-10">
                                        <textarea class="tinymce" name="footer">{{ old('footer') ?? $post->footer }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="quote" class="col-sm-2 control-label cursor-pointer">Quote</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="quote" name="quote" placeholder="Input a quote." value="{{ old('quote') ?? $post->quote }}">
                                        @error('quote')
                                            <div class="mt-1 ml-1 text-danger text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="quote_author" class="col-sm-2 control-label cursor-pointer">Author Quote</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="quote_author" name="quote_author" placeholder="Input quote author." value="{{ old('quote_author') ?? $post->quote_author }}">
                                        @error('quote_author')
                                            <div class="mt-1 ml-1 text-danger text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="youtube_link" class="col-sm-2 control-label cursor-pointer">Youtube Link</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="youtube_link" name="youtube_link" placeholder="Input youtube link video." value="{{ old('youtube_link') ?? $post->youtube_link }}">
                                        @error('youtube_link')
                                            <div class="mt-1 ml-1 text-danger text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="category_id" class="col-sm-2 control-label cursor-pointer">Category <span class="text-red-500">*</span></label>
                                    <div class="col-sm-10">
                                        <select name="category_id" id="category_id" class="form-control">
                                            <option value="" selected hidden disabled>Choose one!</option>
                                            @foreach ($categories as $category)
                                                <option {{ old('category_id') == $category->id || $post->category_id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="mt-1 ml-1 text-danger text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group overflow-auto">
                                    <label class="col-sm-2 control-label">Tags <span class="text-red-500">*</span></label>
                                    <?php 
                                        $arrTags = [];
                                        foreach ($tags as $i => $tag) {
                                            array_push($arrTags, $tag->name);
                                        }
                                        $arrTagAll = implode(',', $arrTags);
                                    ?>
                                    <div class="col-sm-10">
                                        <input type="text" name="tags" value="{{ old('tags') ?? $arrTagAll }}" data-role="tagsinput" class="form-control">
                                        @error('tags')
                                            <div class="mt-1 ml-1 text-danger text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- thumbnail --}}
                                <div class="form-group mt-6">
                                    <label class="col-sm-2 control-label">
                                        Thumbnail
                                    </label>
                                    <div class="col-sm-10">
                                        <?php 
                                            $ex_thumb = explode('/', $post->thumbnail);
                                            $thumb = end($ex_thumb);
                                        ?>
                                        <label for="thumbnail" class="custom-file-upload {{ $post->thumbnail ? 'ac' : '' }}" id="thumbnail-label" title="{{ strlen($thumb) == 0 ? 'No thumbnail is selected.' : $thumb }}">
                                            {{ strlen($thumb) == 0 ? 'No thumbnail is selected' : $thumb }}
                                        </label>
                                        <input data-old="{{ strlen($thumb) == 0 ? '' : $thumb }}" name="thumbnail" type="file" id="thumbnail" 
                                        accept=".jpg,.jpeg,.png,.svg" style="display: none;" />
            
                                        @if (strlen($thumb) != 0)    
                                            <div class="flex items-center">
                                                <input type="checkbox" name="thumb_null" id="thumb_null" class="form-checkbox cursor-pointer h-3 w-3" {{ old('thumb_null') ? 'checked' : '' }}>
                                                <label class="text-blue-500 hover:text-blue-600 cursor-pointer outline-none ml-1" style="margin-bottom: -2.3px" for="thumb_null">Remove thumbnail</label>
                                            </div>
                                        @endif
                                        @error('thumbnail')
                                            <div class="mt-1 ml-1 text-danger text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        Sub Thumbnail 1
                                    </label>
                                    <div class="col-sm-10">
                                        <?php 
                                            $ex_sub_thumb_one = explode('/', $post->sub_thumbnail1);
                                            $sub_thumb_one = end($ex_sub_thumb_one);
                                        ?>
                                        <label for="sub_thumbnail1" class="custom-file-upload {{ $post->sub_thumbnail1 ? 'ac' : '' }}" title="{{ strlen($sub_thumb_one) == 0 ? 'No sub thumbnail one is selected.' : $sub_thumb_one }}">
                                            {{ strlen($sub_thumb_one) == 0 ? 'No sub thumbnail one is selected' : $sub_thumb_one }}
                                        </label>
            
                                        <input data-old="{{ strlen($sub_thumb_one) == 0 ? '' : $sub_thumb_one }}" @if($post->sub_thumbnail1) data-value="1" @endif name="sub_thumbnail1" type="file" id="sub_thumbnail1" 
                                        accept=".jpg,.jpeg,.png,.svg" style="display: none;" />
            
                                        @if (strlen($sub_thumb_one) != 0)
                                            <div class="flex items-center">
                                                <input type="checkbox" name="thumb_one_null" id="thumb_one_null" class="form-checkbox cursor-pointer h-3 w-3" {{ old('thumb_one_null') ? 'checked' : '' }}>
                                                <label class="text-blue-500 hover:text-blue-600 cursor-pointer outline-none ml-1" style="margin-bottom: -2.3px" for="thumb_one_null">Remove sub thumbnail one</label>
                                            </div>
                                        @endif
                                        @error('sub_thumbnail1')
                                            <div class="mt-1 ml-1 text-danger text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        @if (!$post->sub_thumbnail1 && $post->sub_thumbnail2)
                                            <p class="sub_thumbnail1_warning -mt-2 text-warning" style="margin-bottom:0;">You must include sub thumbnail one in order to be seen in the post view<br> (Remove sub thumbnail two for clear this warning)</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        Sub Thumbnail 2
                                    </label>
                                    <div class="col-sm-10">
                                        <?php 
                                            $ex_sub_thumb_two = explode('/', $post->sub_thumbnail2);
                                            $sub_thumb_two = end($ex_sub_thumb_two);
                                        ?>
                                        <label for="sub_thumbnail2" class="custom-file-upload {{ $post->sub_thumbnail2 ? 'ac' : '' }}" title="{{ strlen($sub_thumb_two) == 0 ? 'No sub thumbnail two is selected' : $sub_thumb_two }}">
                                            {{ strlen($sub_thumb_two) == 0 ? 'No sub thumbnail two is selected' : $sub_thumb_two }}
                                        </label>
            
                                        <input data-old="{{ strlen($sub_thumb_two) == 0 ? '' : $sub_thumb_two }}" @if($post->sub_thumbnail2) data-value="1" @endif name="sub_thumbnail2" type="file" id="sub_thumbnail2" 
                                        accept=".jpg,.jpeg,.png,.svg" style="display: none;" />
            
                                        @if (strlen($sub_thumb_two) != 0)    
                                            <div class="flex items-center">
                                                <input type="checkbox" name="thumb_two_null" id="thumb_two_null" class="form-checkbox cursor-pointer h-3 w-3" {{ old('thumb_two_null') ? 'checked' : '' }}>
                                                <label class="text-blue-500 hover:text-blue-600 cursor-pointer outline-none ml-1" style="margin-bottom: -2.3px" for="thumb_two_null">Remove sub thumbnail two</label>
                                            </div>
                                        @endif
                                        @error('sub_thumbnail2')
                                            <div class="mt-1 ml-1 text-danger text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        @if (!$post->sub_thumbnail2 && $post->sub_thumbnail1)
                                            <p class="sub_thumbnail2_warning -mt-2 text-warning" style="margin-bottom:0;">You must include sub thumbnail two in order to be seen in the post view<br> (Remove sub thumbnail one for clear this warning)</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10 text-right -mt-5 sm:mt-0">
                                        <hr>
                                        <button type="submit" class="btn btn-success">Update Post</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- Row -->
        </div><!-- Main Wrapper -->
    </div><!-- /Page Inner -->
@endsection

@section('require_scripts')
    <script src="{{ asset('cms/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
@endsection

@section('page_scripts')
    <script>
        tinymce.init({
            selector: 'textarea.tinymce',
            height: 300,
            font_formats:
                "Quicksand=Quicksand; Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
            fontsize_formats: "8pt 9pt 10pt 11pt 12pt 13pt 14pt 18pt 24pt 30pt 36pt 48pt 60pt 72pt 96pt",
            plugins: 'print preview powerpaste searchreplace autolink directionality advcode code visualblocks visualchars fullscreen image link media codesample table charmap hr anchor toc insertdatetime advlist lists wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker textpattern',
            default_link_target: '_blank',
            lineheight_formats: "8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 36pt 40pt",
            toolbar1: 'formatselect | bold italic forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            placeholder: 'Please input this field.',
        });
    </script>
@endsection