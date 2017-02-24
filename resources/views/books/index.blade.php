@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">Books</div>

    <div class="panel-body">
        Welcome to Macmillan Publishers
        <div class="pull-right">
            <a href=" {{ url('book/create') }}" class="btn btn-primary">Create Book</a>
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
                            <td>
                            	<a href="{{ url('content/index',['id'=>$topic->id]) }}"  title="Contents"><i class="fa fa-filter" aria-hidden="true"></i></a>
                                <a href="{{ url('book/edit',['id'=>$topic->id]) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a href="{{ url('book/destroy',['id'=>$topic->id]) }}" onclick="return confirm('Are you sure?')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
    $('#contents').DataTable();
} );

@endsection