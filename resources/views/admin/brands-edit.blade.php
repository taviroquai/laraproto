<!-- resources/views/auth/register.blade.php -->

@extends('admin.layout')

@section('style')
<link href="{{ asset('assets/css/fileinput.min.css') }}" rel="stylesheet">
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
                
        <h3>Edit Brand</h3>
        
        <form id="formContent" method="POST" action="{{ url('/admin/brands') }}" enctype="mutipart/form-data">
            
            {!! csrf_field() !!}
            
            <p class="text-success v-success"></p>
            
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">General</a></li>
                <li role="presentation"><a href="#style" aria-controls="style" role="tab" data-toggle="tab">Style</a></li>
            </ul>
            
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="general">

                    <input type="hidden" name="id" value="{{ $brand->id }}" />
                    
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" type="text" name="name" id="name" value="{{ $brand->name }}">
                                <span class="help-block alert-danger v-error-name"></span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="name">Active?</label>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="active" value="1"
                                       @if($brand->active) checked @endif> Active
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="slogan">Slogan</label>
                        <input class="form-control" type="text" name="slogan" id="slogan" value="{{ $brand->slogan }}">
                        <span class="help-block alert-danger v-error-slogan"></span>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <input class="form-control" type="text" name="description" id="description" value="{{ $brand->description }}">
                        <span class="help-block alert-danger v-error-description"></span>
                    </div>

                    <div class="form-group">
                        <label for="keywords">Keywords</label>
                        <input class="form-control" type="text" name="keywords" id="keywords" value="{{ $brand->keywords }}">
                        <span class="help-block alert-danger v-error-keywords"></span>
                    </div>

                    <div class="form-group">
                        <label for="author">Author</label>
                        <input class="form-control" type="text" name="author" id="author" value="{{ $brand->author }}">
                        <span class="help-block alert-danger v-error-author"></span>
                    </div>
                </div>
                
                <div role="tabpanel" class="tab-pane fade" id="style">
                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <input class="form-control" type="file" name="logo" id="logo" value="">
                        <span class="help-block alert-danger v-error-logo"></span>
                    </div>
                    <div class="form-group">
                        <label for="content">CSS</label>
                        <span class="help-block alert-danger v-error-css"></span>
                        <textarea class="form-control" type="text" name="css" rows="15">{{ $brand->css }}</textarea>
                    </div>
                </div>
            </div>  

            <div class="form-group">
                <button class="btn btn-primary" type="submit">Save</button>
                <a href="javascript: window.history.back()" class="btn btn-danger">Cancel</a>
            </div>
        </form>

    </div>
</div>

@stop

@section('script')
<script src=" {{ asset('assets/js/fileinput.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $("#logo").fileinput({
        @if ($brand->hasPicture())
        initialPreview: [
            "<img src=\"{{ $brand->getPictureUrl() }}\" class=\"file-preview-image\" alt=\"{{ $brand->name }}\" title=\"{{ $brand->name }}\">"
        ],
        @endif
        showCaption: false,
        overwriteInitial: true,
        showUpload: false,
        showRemove: false,
		maxFileCount: 1,
    });
    
    var form = new Form($, '#formContent', {files: '#logo'});
    
</script>
@stop