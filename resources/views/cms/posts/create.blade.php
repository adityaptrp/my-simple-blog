
@extends('cms.layouts.app')

@section('title', 'Create Post')

@section('require_style')
    <link href="{{ asset('cms/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css"/>
    <script src="https://cdn.tiny.cloud/1/yf74mwf3z981ghh4vqy9x9kwcsjqcmst3f9whesgrv4mplx5/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endsection

@section('page_style')
    
@endsection

@section('content')
    <!-- Page Inner -->
    <div class="page-inner">
        <div class="page-title">
            <h3 class="breadcrumb-header">Form Create Post</h3>
        </div>
        {{-- main wrapper --}}
        <div id="main-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-body">
                            <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                            @csrf
                            @method('post')
                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label cursor-pointer">Title <span class="text-red-500">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Input post title." value="{{ old('title') }}">
                                        @error('title')
                                            <div class="mt-1 ml-1 text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="subtitle" class="col-sm-2 control-label cursor-pointer">Subtitle</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Input post subtitle." value="{{ old('subtitle') }}">
                                        @error('subtitle')
                                            <div class="mt-1 ml-1 text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Header <span class="text-red-500">*</span></label>
                                    <div class="col-sm-10">
                                        <textarea class="w-full border border-gray-400 px-3 py-2 h-45" name="header">{{ old('header') }}</textarea>
                                        @error('header')
                                            <div class="mt-1 ml-1 text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Body</label>
                                    <div class="col-sm-10">
                                        <textarea class="tinymce" name="body">{{ old('body') }}</textarea>
                                        @error('body')
                                            <div class="mt-1 ml-1 text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Footer</label>
                                    <div class="col-sm-10">
                                        <textarea class="tinymce" name="footer">{{ old('footer') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="quote" class="col-sm-2 control-label cursor-pointer">Quote</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="quote" name="quote" placeholder="Input a quote." value="{{ old('quote') }}">
                                        @error('quote')
                                            <div class="mt-1 ml-1 text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="quote_author" class="col-sm-2 control-label cursor-pointer">Author Quote</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="quote_author" name="quote_author" placeholder="Input quote author." value="{{ old('quote_author') }}">
                                        @error('quote_author')
                                            <div class="mt-1 ml-1 text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="youtube_link" class="col-sm-2 control-label cursor-pointer">Youtube Link</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="youtube_link" name="youtube_link" placeholder="Input youtube link video." value="{{ old('youtube_link') }}">
                                        @error('youtube_link')
                                            <div class="mt-1 ml-1 text-danger">
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
                                                <option {{ old('category_id') == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="mt-1 ml-1 text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group overflow-auto">
                                    <label class="col-sm-2 control-label">Tags <span class="text-red-500">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="tags" value="{{ old('tags') }}" data-role="tagsinput" class="form-control">
                                        @error('tags')
                                            <div class="-mt-2 ml-1 text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- Thumbnail --}}
                                <div class="form-group">
                                    <label for="thumbnail" class="col-sm-2 control-label cursor-pointer">Thumbnail</label>
                                    <div class="col-sm-10">
                                        <label for="thumbnail" class="custom-file-upload" id="thumbnail-label" title="{{ old('thumbnail') ?? 'No thumbnail is selected.' }}">
                                            No thumbnail is selected.
                                        </label>
                                        <input name="thumbnail" type="file" id="thumbnail" 
                                        accept=".jpg,.jpeg,.png,.svg" style="display: none;" />
                                        @error('thumbnail')
                                            <div class="mt-1 ml-1 text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sub_thumbnail1" class="col-sm-2 control-label cursor-pointer">Sub Thumbnail 1</label>
                                    <div class="col-sm-10">
                                        <label for="sub_thumbnail1" class="custom-file-upload" title="No sub thumbnail one is selected.">
                                            No sub thumbnail one is selected.
                                        </label>
            
                                        <input name="sub_thumbnail1" type="file" id="sub_thumbnail1" 
                                        accept=".jpg,.jpeg,.png,.svg" style="display: none;" />
                                        @error('sub_thumbnail1')
                                            <div class="mt-1 ml-1 text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sub_thumbnail2" class="col-sm-2 control-label cursor-pointer">Sub Thumbnail 2</label>
                                    <div class="col-sm-10">
                                        <label for="sub_thumbnail2" class="custom-file-upload" title="No sub thumbnail two is selected.">
                                            No sub thumbnail two is selected.
                                        </label>
            
                                        <input name="sub_thumbnail2" type="file" id="sub_thumbnail2" 
                                        accept=".jpg,.jpeg,.png,.svg" style="display: none;" />
                                        @error('sub_thumbnail2')
                                            <div class="mt-1 ml-1 text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10 text-right -mt-5 sm:mt-0">
                                        <hr>
                                        <button type="submit" class="btn btn-success">Create Post</button>
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