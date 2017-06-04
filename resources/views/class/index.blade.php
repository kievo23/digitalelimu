@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">Classes</div>

    <div class="panel-body">
        Welcome to Digital Elimu
           
        <div class="pull-right">
            @permission('create_class')
            <a href=" {{ url('class/create') }}" class="btn btn-primary">Create Class</a>
            @endpermission
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
                @if($classes)
                    @foreach($classes as $topic)
                        <tr>
                            <td>{{ $topic->name }}</td>
                            <td>{{ $topic->description }}</td>
                            <td>{{ $topic->activate }}</td>
                            <td>
                                @permission('list_book')
                            	<a href="{{ url('book/index',['id'=>$topic->id]) }}"  title="Filter Books"><i class="fa fa-filter" aria-hidden="true"></i></a>
                                @endpermission
                                @permission('create_book')
                                <a href="{{ url('book/create',['id'=>$topic->id]) }}"  title="create book"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                @endpermission
                                @permission('edit_class')
                                <a href="{{ url('class/edit',['id'=>$topic->id]) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                @endpermission
                                @permission('activate_class')
                                <a href="{{ url('class/activate',['id'=>$topic->id]) }}" title="Activate"><i class="fa fa-check-circle" aria-hidden="true"></i></a>
                                @endpermission
                                @permission('delete_class')
                                <a href="{{ url('class/destroy',['id'=>$topic->id]) }}" onclick="return confirm('Are you sure?')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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