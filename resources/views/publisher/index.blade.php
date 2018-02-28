@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">Publishers</div>

    <div class="panel-body">
        Welcome to Digital Elimu
        <div class="pull-right">
            <a href=" {{ url('publisher/create') }}" class="btn btn-primary">Create Publisher</a>
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif                            
        <table class="table">
            <thead>
                <tr>
                    <th>Publisher</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($publishers)
                    @foreach($publishers as $publisher)
                        <tr>
                            <td>{{ $publisher->publisher }}</td>
                            <td>
                                <a href="{{ url('publisher/edit',['id'=>$publisher->id]) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection