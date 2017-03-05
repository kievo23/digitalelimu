@extends('layouts.app')

@section('content')
            <div class="panel panel-default">
                <div class="panel-heading">Subscriptions</div>

                <div class="panel-body">
                    <form class="form-inline" role="form" method="POST" action="{{ url('/subscriptions/index') }}">
                        <div class="form-group">
                            <label for="clas">Class</label>
                            <select name="clas" class="form-control">
                                @if (count($classes) > 0)
                                    @foreach($classes as $clas)
                                        <option value="{{ $clas->id }}">{{ $clas->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div> 
                        <div class="form-group">
                            <label for="book">Book</label>
                            <select name="book" class="form-control">
                                @if (count($books) > 0)
                                    @foreach($books as $book)
                                        <option value="{{ $clas->id }}">{{ $book->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-primary">Filter</button>                       
                    </form>
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
                                    <td>{{ $item->id }}.elimu</td>
                                    <td>{{ $item->category }}</td>
                                	<td>{{ $item->client->phone }}</td>
                                	<td>{{ $item->amount }}</td>
                                	<td>{{ $item->created_at }}</td>
                                	<td>
		                                <a href="{{ url('subscriptions/edit',['id'=>$item->id]) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
		                                
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