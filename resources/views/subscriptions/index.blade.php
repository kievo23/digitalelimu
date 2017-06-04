@extends('layouts.app')

@section('content')
            <div class="panel panel-default">
                <div class="panel-heading">Subscriptions</div>

                <div class="panel-body">
                    <form class="form-inline" role="form" method="POST" action="{{ url('/subscriptions/index') }}">
                        <div class="form-group">
                            <label for="book">Book</label>
                            <select name="book" class="form-control">
                                <option value="">--Select--</option>
                                @if (count($books) > 0)
                                    @foreach($books as $book)
                                        <option value="{{ $book->id }}">{{ $book->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-primary">Filter</button>                       
                    </form><hr>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif  
                    <table class="table" id="subscriptions">
                    <thead>
                    	<th>Id</th>
                    	<th>Book Name</th>
                        <th>Book Code</th>
                        <th>Subscription</th>
                    	<th>Client</th>
                    	<th>Amount</th>
                    	<th>Created At</th>
                    	<th>Actions</th>
                    </thead>
                    <tbody>
                            @if($items)
                                <?php $n=1;?>
                                @foreach($items as $item)
                                	<tr>
                                	<td>{{ $n }}</td>
                                	<td>{{ $item->book->name }}</td>
                                    <td>{{ $item->book->id }}.elimu</td>
                                    <td>{{ $item->category }}</td>
                                	<td>{{ $item->client->phone }}</td>
                                	<td>{{ $item->amount }}</td>
                                	<td>{{ $item->created_at }}</td>
                                	<td>
                                        @permission('edit_subscriptions')
		                                <a href="{{ url('subscriptions/edit',['id'=>$item->id]) }}" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        @endpermission
                                        @permission('list_edits')
		                                <a href="{{ url('/edits/index',['id'=>$item->id]) }}" title="See edits"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        @endpermission
		                            </td>
                                	</tr>
                                	<?php $n++;?>
                                @endforeach
                            @endif
                    </table>                               
                </div>
            </div>
@endsection

@section('js')

$(document).ready( function () {
    $('#subscriptions').DataTable();
} );

@endsection