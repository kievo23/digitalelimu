@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">Books</div>

    <div class="panel-body">
        Welcome to Digital Elimu (Transactions Edit)         
        <table class="table" id="contents">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Subscription Id</th>
                    <th>Client</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @if($items)
                    @foreach($items as $topic)
                        <tr>
                            <td>{{ $topic->id }}</td>
                            <td>{{ $topic->sub_id }}</td>
                            <td>{{ $topic->client->phone }}</td> 
                            <td>{{ $topic->amount }}</td>                          
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