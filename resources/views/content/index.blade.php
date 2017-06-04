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
        <table class="table" id="contents">
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
            <tbody>
                @if($contents)
                    @foreach($contents as $content)
                        <tr>
                            <td>{{ $content->name }}</td>
                            <td>{{ $content->book->name }}</td>
                            <td>{{ $content->term }}</td>
                            <td>{{ $content->week }}</td>
                            <td>{{ $content->lesson }}</td>
                            <td>{{ $content->description }}</td>
                            <td>{{ $content->audio }}</td>
                            <td>{{ $content->video }}</td>
                            <td>
                                @permission('edit_content')
                                <a href="{{ url('content/edit',['id'=>$content->id]) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                @endpermission
                                @permission('delete_content')
                                <a href="{{ url('content/destroy',['id'=>$content->id]) }}" onclick="return confirm('Are you sure?')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                @endpermission
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection


@section('js')

$(document).ready( function () {
    $('#contents').DataTable({
        responsive: true
    });
});

@endsection