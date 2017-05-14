@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">Clients</div>

    <div class="panel-body">
        Welcome to Digital Elimu
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif                            
        <table class="table">
            <thead>
                <tr>
                    <th>Phone</th>
                    <th>Password</th>
                </tr>
            </thead>
            <tbody>
                @if($topics)
                    @foreach($topics as $topic)
                        <tr>
                            <td>{{ $topic->phone }}</td>
                            <td>{{ $topic->password }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection