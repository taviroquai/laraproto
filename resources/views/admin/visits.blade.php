
@extends('admin/layout')

@section('style')
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Visits</h1>

        <table id="example" class="display table-striped" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="col-md-2">Date</th>
                    <th class="col-md-2">IP</th>
                    <th>Path</th>
                    <th>Content</th>
                    <th class="col-md-2">User</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>Date</th>
                    <th>IP</th>
                    <th>Path</th>
                    <th>User</th>
                    <th>Content</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@stop

@section('script')
<script src=" {{ asset('assets/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    
    $('#example').dataTable({
        "ajax": "{{ url('admin/visits') }}",
        "columns": [
            { "data": "created_at" },
            { "data": "ip" },
            { "data": "http_path" },
            {
                "render": function ( data, type, full, meta ) {
                    return full.content ? full.content.title : '';
                }
            },
            {
                "render": function ( data, type, full, meta ) {
                    return full.user ? full.user.name : 'Anonymous';
                }
            }
        ]
    });


</script>
@stop
