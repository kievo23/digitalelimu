@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">Create Content</div>

    <div class="panel-body">
        Welcome to Digital Elimu
        <div class="pull-right">
            @permission('create_content')
            <a href=" {{ url('content/create') }}" class="btn btn-primary">Create Content</a>
            @endpermission
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif   

        <table class="table" id="contents-server">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Book</th>
                    <th>Term</th>
                    <th>Week</th>
                    <th>Lesson</th>
                    <th>Description</th>
                    <th>Audio</th>
                    <th>Video</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection


@section('js')

$(document).ready( function () {
    $('#contents').DataTable({
        responsive: true
    });

    $('#contents-server').DataTable( {
        "responsive": true,
        "ajax": "/api/datatable",
        "columns": [
            { "data": "name" },
            { "data": "book",
                render: function(data, type, row){
                    return data.name;
                }
            },
            { "data": "term" },
            { "data": "week" },
            { "data": "lesson" },
            { "data": "description"},
            { "data": "audio"},
            { "data": "video"},
            { "data": "id",
                render: function(data, type, row){
                    return '<a href="/content/edit/'+row.id+'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>\
                    <a href="/content/destroy/'+row.id+'" onclick="return confirm(\'Are you sure?\')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
                }
            }
        ]
    });
});

@endsection