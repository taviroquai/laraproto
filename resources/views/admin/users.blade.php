
@extends('admin/layout')

@section('style')
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        
        <h1>Users</h1>
        
        <p class="clearfix">
            <a class="btn btn-success pull-right" href="{{ url('admin/users/form') }}"><i class="fa fa-user"></i> Create User</a>
        </p>

        <table id="example" class="display table-striped" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th class="col-md-2">Options</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
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
            "ajax": "{{ url('admin/users') }}",
            "columns": [
                { "data": "name" },
                { "data": "email" },
                {
                    "orderable": false,
                    "searchable": false,
                    "render": function ( data, type, full, meta ) {
                        console.log(full);
                        return '<a class="btn btn-info btn-xs" href="' + "{{ url('admin/users/form') }}/" + full.id + '"><i class="fa fa-pencil"></i></a>'
                            + '&nbsp;<a class="btn btn-danger btn-xs" href="' + "{{ url('admin/users/delete') }}/" + full.id + '"><i class="fa fa-trash"></i></a>'
                    }
                }
            ]
        });
    });
</script>
@stop
