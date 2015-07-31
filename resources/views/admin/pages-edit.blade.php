<!-- resources/views/auth/register.blade.php -->

@extends('admin.layout')

@section('content')

<div class="row">
    <div class="col-md-12">
                
        <h3>Edit Page</h3>
        
        <form id="formPage" method="POST" action="{{ url('/admin/pages') }}">
            
            {!! csrf_field() !!}
            
            <p class="text-success v-success"></p>
            
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">General</a></li>
                <li role="presentation"><a href="#data" aria-controls="data" role="tab" data-toggle="tab">Data</a></li>
            </ul>
            
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="general">
            
                    <input type="hidden" name="id" value="{{ $page->id }}" />

                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" type="text" 
                                       @if($page->id) readonly @endif
                                       name="name" id="name" value="{{ $page->name }}">
                                <span class="help-block alert-danger v-error-name"></span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Active</label>
                                <div class="form-group">
                                    <label class="radio-inline" title="The page will be reachable">
                                        <input required type="radio" name="active" value="1" 
                                            @if($page->active) checked="checked" @endif> Yes
                                    </label>
                                    <label class="radio-inline" title="The page will not be reachable">
                                        <input type="radio" name="active" value=""
                                            @if(!$page->active) checked="checked" @endif> NO
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="route">Route</label>
                        <input class="form-control" type="text" name="route" id="route" value="{{ $page->route }}">
                        <span class="help-block alert-danger v-error-route"></span>
                    </div>

                    <div class="form-group">
                        <label for="content">View</label>
                        <span class="help-block alert-danger v-error-content"></span>
                        <span class="help-block alert-danger v-error-permissions"></span>
                        <textarea class="form-control" type="text" name="content" rows="15">{{ $content }}</textarea>
                    </div>
                </div>
                
                <div role="tabpanel" class="tab-pane fade" id="data">
                    <div class="form-group">
                        <label for="data">Data</label>
                        <span class="help-block alert-danger v-error-data"></span>
                        <span class="help-block alert-danger v-error-permissions"></span>
                        <textarea class="form-control" type="text" name="data" rows="15">{{ $data }}</textarea>
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
<script type="text/javascript">
    var form = new Form($, '#formPage');
</script>
@stop