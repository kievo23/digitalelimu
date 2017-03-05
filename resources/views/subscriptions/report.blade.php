@extends('layouts.app')

@section('css')
<link href="/css/daterangepicker.css" rel="stylesheet">
@endsection

@section('content')
            <div class="panel panel-default">
                <div class="panel-heading">Reports</div>
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
                    <form method="POST" action="{{ url('reports/index') }}" class="form-horizontal">
                        <input type="text" name="daterange" class="form-control" placeholder="Custom Date or Range"><br>
                        <input type="submit" name="submit" class="btn btn-primary form-control">
                        {!! csrf_field() !!}
                    </form><hr>
                    @if($items)
                                <?php $total=0?>
                                @foreach($items as $item)
                                <?php $total += $item->amount;?>
                                 @endforeach
                    @endif
                    <div class="text-center alert alert-warning" role="alert"><h2><strong>
                    @if($date)
                    <p>
                        {{ $date }}
                    </p>                    
                    @endif
                     Total Sales: {{ $total }} KsH</strong></h2> </div>
                    <table class="table" id="subscriptions">
                        <thead>
                        	<th>Id</th>
                        	<th>Book Name</th>
                        	<th>Client</th>
                        	<th>Amount</th>
                        	<th>Created At</th>
                        </thead>
                        <tbody>
                            @if($items)
                                <?php $n=1; ?>
                                @foreach($items as $item)
                                	<tr>
                                	<td>{{ $n }}</td>
                                	<td>{{ $item->book->name }}</td>
                                	<td>{{ $item->client->phone }}</td>
                                	<td>{{ $item->amount }}</td>
                                	<td>{{ $item->created_at }}</td> 
                                	</tr>
                                	<?php $n++;?>
                                @endforeach
                            @endif
                        </tbody>
                    </table>    
                                           
                </div>
            </div>
@endsection

@section('js')

$(document).ready( function () {
    $('#subscriptions').DataTable();

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('input[name="daterange"]').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);
} );

@endsection