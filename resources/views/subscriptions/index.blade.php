@extends('layouts.app')

@section('content')
            <div class="panel panel-default">
                <div class="panel-heading">Subscriptions</div>

                <div class="panel-body">
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