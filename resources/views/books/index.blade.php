@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">Books</div>

    <div class="panel-body">
        Welcome to Digital Elimu
        <div class="pull-right">
            @permission('create_book')
            <a href=" {{ url('book/create') }}" class="btn btn-primary">Create Book</a>
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
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Class</th>                    
                    <th>Description</th>
                    <th>Activate</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($books)
                    @foreach($books as $topic)
                        <tr>
                            <td><img src="{{ url('uploads/'.$topic->photo) }}" width="90px"></td>
                            <td>{{ $topic->name }}</td>
                            <td>{{ $topic->category->name }}</td>                            
                            <td>{{ $topic->description }}</td>
                            <td>{{ $topic->activate }}</td>
                            <td>
                                @permission('list_content')
                            	<a href="{{ url('content/index',['id'=>$topic->id]) }}"  title="Filter Contents"><i class="fa fa-filter" aria-hidden="true"></i></a>
                                @endpermission
                                @permission('create_content')
                                <a href="{{ url('content/create',['id'=>$topic->id]) }}"  title="Create Content"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                @endpermission
                                @permission('edit_book')
                                <a href="{{ url('book/edit',['id'=>$topic->id]) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                @endpermission
                                @permission('activate_book')
                                <a href="{{ url('book/activate',['id'=>$topic->id]) }}" title="Activate"><i class="fa fa-check-circle" aria-hidden="true"></i></a>
                                @endpermission
                                @permission('delete_book')
                                <a href="{{ url('book/destroy',['id'=>$topic->id]) }}" onclick="return confirm('Are you sure?')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
} );

@endsection