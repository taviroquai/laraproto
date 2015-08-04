
@extends('admin/layout')

@section('style')
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        
        <h1>Pages</h1>
        
        <div class="alert alert-danger">
            <p><strong>Warning!</strong> This feature opens a big security breach in your application.</p>
            <p>By default only admin users are allowed to use this feature but remove the Pages menu if you do not want to take risks.</p>
        </div>
        
        <p class="clearfix">
            <a class="btn btn-success pull-right" href="{{ url('admin/pages/form') }}"><i class="fa fa-newspaper-o"></i> Create Page</a>
        </p>

        <table id="example" class="display table-striped" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="col-md-2">Options</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Options</th>
                </tr>
            </tfoot>
        </table>

    </div>
</div>

@stop

@section('script')
<script src=" {{ asset('assets/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example').dataTable({
            "ajax": "{{ url('admin/pages') }}",
            "columns": [
                { "data": "name" },
                {
                    "orderable": false,
                    "searchable": false,
                    "render": function ( data, type, full, meta ) {
                        return '<a class="btn btn-info btn-xs" href="' + "{{ url('admin/pages/form') }}/" + full.id + '"><i class="fa fa-pencil"></i></a>'
                            + '&nbsp;<a class="btn btn-danger btn-xs" href="' + "{{ url('admin/pages/delete') }}/" + full.id + '"><i class="fa fa-trash"></i></a>'
                    }
                }
            ]
        });
    });
</script>
@stop
