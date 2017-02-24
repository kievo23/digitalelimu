@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">Main Paper Category</div>

    <div class="panel-body">
        Welcome to Macmillan Publishers
        <div class="pull-right">
            <a href=" {{ url('category/create') }}" class="btn btn-primary">Create Category</a>
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif                            
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($topics)
                    @foreach($topics as $topic)
                        <tr>
                            <td>{{ $topic->name }}</td>
                            <td>{{ $topic->description }}</td>
                            <td>
                            	<a href="{{ url('class/index',['id'=>$topic->id]) }}"  title="Classes"><i class="fa fa-filter" aria-hidden="true"></i></a>
                                <a href="{{ url('category/edit',['id'=>$topic->id]) }}" title="Edit record"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a href="{{ url('category/destroy',['id'=>$topic->id]) }}"  title="Delete record" onclick="return confirm('Are you sure?')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection