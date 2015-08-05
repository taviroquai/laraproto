<!-- resources/views/auth/register.blade.php -->

@extends('admin.layout')

@section('style')
<link href="{{ asset('assets/css/datepicker3.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/summernote.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/summernote-bs3.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/fileinput.min.css') }}" rel="stylesheet">
<style type="text/css">
    #map img, #mapCanvas img {
        max-width: none !important;
        box-shadow: none !important;
    }
</style>
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
                
        <h3>Edit Content</h3>
        
        <form id="formContent" method="POST" action="{{ url('/admin/contents') }}" enctype="mutipart/form-data">
            
            {!! csrf_field() !!}
            
            <!-- Set this param to resize images on server when uploading to prevent display unedited huge files -->
            <input type="hidden" name="image_max_width" value="1024" />
            
            <p class="text-success v-success"></p>
            
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">General</a></li>
                <li role="presentation"><a href="#seo" aria-controls="seo" role="tab" data-toggle="tab">SEO</a></li>
                <li role="presentation"><a href="#gallery" aria-controls="gallery" role="tab" data-toggle="tab">Gallery</a></li>
                <li role="presentation"><a href="#event" aria-controls="event" role="tab" data-toggle="tab">Event</a></li>
                <li role="presentation"><a href="#location" aria-controls="location" role="tab" data-toggle="tab">Location</a></li>
                <li role="presentation"><a href="#permission" aria-controls="permission" role="tab" data-toggle="tab">Permission</a></li>
            </ul>
            
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="general">
            
                    <input type="hidden" name="id" value="{{ $content->id }}" />
                    
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input class="form-control" type="text" name="title" id="title" 
                                       value="{{ $content->title }}">
                                <span class="help-block alert-danger v-error-title"></span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="title">Idiom</label>
                                <select class="form-control" name="lang">
                                    @foreach($content->getAvailableLanguages() as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    
                    
                    <div class="form-group">
                        <label for="publish_start">Publish Start</label>
                        <input class="form-control" type="text" name="publish_start" id="publish_start" 
                               value="{{ $content->publish_start }}">
                        <span class="help-block alert-danger v-error-publish_start"></span>
                    </div>

                    <div class="form-group">
                        <label for="publish_end">Publish End</label>
                        <input class="form-control" type="text" name="publish_end" id="publish_end" 
                               value="{{ $content->publish_end }}">
                        <span class="help-block alert-danger v-error-publish_end"></span>
                    </div>

                    <div class="form-group">
                        <label for="content">Content</label>
                        <span class="help-block alert-danger v-error-content"></span>
                        <div id="summernote">{!! $content->content !!}</div>
                        <input type="hidden" name="content" id="content" rows="10" value="{!! $content->content !!}" />
                    </div>
                </div>
                    
                <div role="tabpanel" class="tab-pane fade" id="seo">
                    
                    <div class="form-group">
                        <label for="seo_slug">URI Slug</label>
                        <input class="form-control" type="text" name="seo_slug" id="seo_slug" 
                               value="{{ $content->seo_slug }}">
                        <span class="help-block alert-danger v-error-seo_slug"></span>
                    </div>
            
                    <div class="form-group">
                        <label for="seo_title">Title</label>
                        <input class="form-control" type="text" name="seo_title" id="seo_title" 
                               value="{{ $content->seo_title }}">
                        <span class="help-block alert-danger v-error-seo_title"></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="seo_description">Description</label>
                        <input class="form-control" type="text" name="seo_description" id="seo_description" 
                               value="{{ $content->seo_description }}">
                        <span class="help-block alert-danger v-error-seo_description"></span>
                    </div>

                    <div class="form-group">
                        <label for="seo_author">Author</label>
                        <input class="form-control" type="text" name="seo_author" id="seo_author" 
                               value="{{ $content->seo_author }}">
                        <span class="help-block alert-danger v-error-seo_author"></span>
                    </div>

                    <div class="form-group">
                        <label for="seo_keywords">Keywords</label>
                        <input class="form-control" type="text" name="seo_keywords" id="seo_keywords" 
                               value="{{ $content->meta_keywords }}">
                        <span class="help-block alert-danger v-error-seo_keywords"></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="seo_image">Image</label>
                        <input class="form-control" type="file" name="seo_image" id="seo_image" value="">
                        <span class="help-block alert-danger v-error-seo_image"></span>
                    </div>
                </div>
            
                <div role="tabpanel" class="tab-pane fade" id="gallery">
                    
                    <h4>Current Images</h4>
                    <div class="row">
                        @foreach($content->getGalleryImages() as $item)
                        <div class="col-md-2">
                            <img class="col-md-12 thumbnail" src="{{ $content->getGalleryImageUrl($item) }}" />
                            <a class="btn btn-danger delete-image" data-item="{{ $content->getGalleryImageUrl($item) }}"
                                title="Click to delete">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="form-group">
                        <label for="image_uploader">New Images</label>
                        <input class="form-control" type="file" name="image_uploader" id="image_uploader" value="">
                    </div>
                    
                </div>
                
                <div role="tabpanel" class="tab-pane fade" id="event">
            
                    <div class="form-group">
                        <label for="event_start">Event Start</label>
                        <input class="form-control" type="text" name="event[start]" id="event_start" 
                               value="{{ $content->event ? $content->event->start : '' }}">
                        <span class="help-block alert-danger v-error-event_start"></span>
                    </div>

                    <div class="form-group">
                        <label for="event_end">Event End</label>
                        <input class="form-control" type="text" name="event[end]" id="event_end"
                               value="{{ $content->event ? $content->event->end : '' }}">
                        <span class="help-block alert-danger v-error-event_end"></span>
                    </div>
                </div>
                
                
                
                <div role="tabpanel" class="tab-pane fade" id="location">
                    
                    <input type="hidden" name="location[lat]" 
                           value="{{ $content->location ? $content->location->lat : '' }}" />
                    <input type="hidden" name="location[lon]" 
                           value="{{ $content->location ? $content->location->lon : '' }}" />
                    <input type="hidden" name="location[zoom]" 
                           value="{{ $content->location ? $content->location->zoom : ''}}" />
                    
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="address">Search</label>
                                <input class="form-control" type="text" placeholder="Enter address..." name="location[address]" 
                                       value="{{ $content->location? $content->location->address : '' }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="reset">Remove</label>
                                <div class="clearfix"></div>
                                <a class="btn btn-danger delete-location">Remove</a>
                            </div>
                        </div>
                    </div>
                    
                    <div id="map" style="width: 100%; height: 380px;"></div>
                    
                </div>
                
                <div role="tabpanel" class="tab-pane fade" id="permission">
                    <label>User Permission</label>
                    <div class="form-group">
                        <label class="radio-inline" title="Any user can edir this content">
                            <input required type="radio" name="role_permission" value="NONE" 
                                @if($content->isRolePermission('NONE')) checked="checked" @endif> NONE
                        </label>
                        <label class="radio-inline" title="Only users in the same roles of the owner can edit this content">
                            <input type="radio" name="role_permission" value="ROLE"
                                @if($content->isRolePermission('ROLE')) checked="checked" @endif> ROLE
                        </label>
                        <label class="radio-inline" title="Only the owner can edit this content">
                            <input type="radio" name="role_permission" value="USER"
                                @if($content->isRolePermission('USER')) checked="checked" @endif> USER
                        </label>
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
<script src="{{ asset('assets/js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/summernote.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/fileinput.min.js') }}" type="text/javascript"></script>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script type="text/javascript">
    var date_options = {
        format: 'yyyy-mm-dd',
        autoclose: true
    };
    $('[name="publish_start"]').datepicker(date_options);
    $('[name="publish_end"]').datepicker(date_options);
    $('[name="event[start]"]').datepicker(date_options);
    $('[name="event[end]"]').datepicker(date_options);
    
    $('#summernote').summernote({
        direction: 'ltr',
        height: 300,
        onChange: function(contents) {
            contents = strip_tags(contents, '<div><p><span><a><hr><br><img><ol><ul><li><br><table><thead><tbody><tr><th><td>');
            $('#content').val(contents);
        }
    });
    
    $("#seo_image").fileinput({
        @if ($content->hasPicture())
        initialPreview: [
            "<img src=\"{{ $content->getPictureUrl() }}\" class=\"file-preview-image\" alt=\"The Moon\" title=\"The Moon\">"
        ],
        @endif
        showCaption: false,
        overwriteInitial: true,
        showUpload: false,
        showRemove: false,
		maxFileCount: 1,
    });
    
    var uploader = $("#image_uploader").fileinput({
        language: "pt",
        uploadUrl: "{{ url('admin/contents/upload/'.$content->id) }}",
        allowedFileExtensions: ["jpg", "png", "gif"],
        minImageWidth: 50,
        minImageHeight: 50,
        maxFileSize: 2000,
        showCaption: false,
        overwriteInitial: true,
        showUpload: false,
        showRemove: false,
        uploadExtraData: function() {
            return {
                '_token': $('[name="_token"]').val(),
                'image_max_width': $('[name="image_max_width"]').val()
            };
        }
    });
    uploader.on('filebatchselected', function(event, files) {
        uploader.fileinput('upload');
    });

    $('#gallery .delete-image').on('click', function() {
        var me = $(this);
        var resp = confirm('Destroy image?');
        if (resp) {
            $.get("{{ url('admin/contents/'.$content->id.'/delete') }}/" + $(this).data('item').split(/[\\/]/).pop(), function (resp) {
                if (resp.success) {
                    me.parent().remove();
                } else {
                    alert('Could not destroy image!');
                }
            });
        }
    });
    
    var map, mapMarker, geocoder;
    $('#location .delete-location').on('click', function() {
        var me = $(this);
        var resp = confirm('Remove location?');
        if (resp) {
            $('[name="location[zoom]"]').val('');
            $('[name="location[lat]"]').val('');
            $('[name="location[lon]"]').val('');
            $('[name="location[address]"]').val('');
            map.setCenter(new google.maps.LatLng(0, 0));
            map.setZoom(1);
            mapMarker.setMap(null);
        }
    });
    function initMap() {
        geocoder = new google.maps.Geocoder();
        mapMarker = new google.maps.Marker({
            @if($content->location && $content->location->lat)
                position: new google.maps.LatLng({{ $content->location->lat }}, {{ $content->location->lon }}),
            @else
                position: new google.maps.LatLng(0, 0),
            @endif
            title: "{{ $content->title }}",
            draggable: true
        });
        
        var mapOptions = {
            @if($content->location && $content->location->zoom)
                zoom: {{ $content->location->zoom }},
            @else
                zoom: 1,    
            @endif
            center: mapMarker.position,
            mapTypeId: google.maps.MapTypeId.SATELLITE,
            style: google.maps.ZoomControlStyle.LARGE
        };
        map = new google.maps.Map(document.getElementById("map"), mapOptions);
        mapMarker.setMap(map);
        
        google.maps.event.addListener(map, 'zoom_changed', function() {
            $('[name="location[zoom]"]').val(this.getZoom());
        });
        
        google.maps.event.addListener(mapMarker, 'dragend', function(event) {
            $('[name="location[lat]"]').val(this.position.lat());
            $('[name="location[lon]"]').val(this.position.lng());
        });
        
        $('[name="location[address]"]').on('blur', function () {
            var me = $(this);
            geocoder.geocode( { 'address': me.val() }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    console.log(results[0]);
                    map.setCenter(results[0].geometry.location);
                    mapMarker.setPosition(results[0].geometry.location);
                    me.val(results[0].formatted_address);
                    $('[name="location[zoom]"]').val(map.getZoom());
                    $('[name="location[lat]"]').val(mapMarker.position.lat());
                    $('[name="location[lon]"]').val(mapMarker.position.lng());
                } else {
                    alert("Geocode was not successful for the following reason: " + status);
                }
            });
        });
    }
    
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        if ($(e.target).attr('href') === '#location' && typeof map === 'undefined') {
            initMap();
        }
    });
    
    var form = new Form($, '#formContent', {files: '#seo_image'});
    
</script>
@stop