@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">Main Paper Category</div>

    <div class="panel-body">
        Welcome to Digital Elimu
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
                    <th>Activate</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($topics)
                    @foreach($topics as $topic)
                        <tr>
                            <td>{{ $topic->name }}</td>
                            <td>{{ $topic->description }}</td>
                            <td>{{ $topic->activate }}</td>
                            <td><img src="{{ url('uploads/'.$topic->photo) }}" width="90px"></td>
                            <td>
                            	<a href="{{ url('class/index',['id'=>$topic->id]) }}"  title="Filter Classes"><i class="fa fa-filter" aria-hidden="true"></i></a>
                                <a href="{{ url('class/create',['id'=>$topic->id]) }}"  title="create Classes"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a href="{{ url('category/edit',['id'=>$topic->id]) }}" title="Edit record"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a href="{{ url('category/activate',['id'=>$topic->id]) }}" title="Activate"><i class="fa fa-check-circle" aria-hidden="true"></i></a>
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