@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <h2>Sales Breakdown</h2><hr>
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Sales Today:</h3>
                                </div>
                              <div class="panel-body">
                                {{$daily}} Ksh
                              </div>                              
                            </div> 
                        </div>
                        <div class="col-md-3 col-sm-6 ">
                          <div class="panel panel-success"> 
                            <div class="panel-heading"> 
                                <h3 class="panel-title">Sales Yesterday</h3> 
                            </div> 
                            <div class="panel-body"> {{$yesterday}} Ksh </div> 
                          </div>
                        </div>
                        <div class="col-md-3 col-sm-6 ">
                          <div class="panel panel-info"> 
                            <div class="panel-heading"> 
                                <h3 class="panel-title">Sales This Week</h3> 
                            </div> 
                            <div class="panel-body"> {{$thisWeek}} Ksh </div> 
                          </div>
                        </div>
                        <div class="col-md-3 col-sm-6 ">
                          <div class="panel panel-warning"> 
                            <div class="panel-heading"> 
                                <h3 class="panel-title">Sales Last Seven Days</h3> 
                            </div> 
                            <div class="panel-body"> {{$lastSevenDaysSales}} Ksh </div> 
                          </div>
                        </div>
                        <div class="col-md-3 col-sm-6 ">
                          <div class="panel panel-danger"> 
                            <div class="panel-heading"> 
                                <h3 class="panel-title">Sales This Month</h3> 
                            </div> 
                            <div class="panel-body"> {{$salesThisMonth}} Ksh </div> 
                          </div>
                        </div>
                        <div class="col-md-3 col-sm-6 ">
                          <div class="panel panel-info"> 
                            <div class="panel-heading"> 
                                <h3 class="panel-title">Sales This Year</h3> 
                            </div> 
                            <div class="panel-body"> {{$salesThisYear}} Ksh </div> 
                          </div>
                        </div>
                        <div class="col-md-3 col-sm-6 ">
                          <div class="panel panel-info"> 
                            <div class="panel-heading"> 
                                <h3 class="panel-title">Sales Last Year</h3> 
                            </div> 
                            <div class="panel-body"> {{$salesLastYear}} Ksh </div> 
                          </div>
                        </div>
                        <div class="col-md-3 col-sm-6 ">
                          <div class="panel panel-info"> 
                            <div class="panel-heading"> 
                                <h3 class="panel-title">Sales Last Month</h3> 
                            </div> 
                            <div class="panel-body"> {{$salesLastMonth}} Ksh </div> 
                          </div>
                        </div>
                    </div>    
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h2>Best Selling Books This Year</h2></div>
                            <div class="panel-body">
                                <table class="table" id="contents">
                                    <thead>
                                        <tr>
                                            <th>Book Id</th>
                                            <th>Book Name</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($bestSellingBooks)
                                            @foreach($bestSellingBooks as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->name }}</td> 
                                                    <td>{{ $item->amount }}</td>                          
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                    </div>

                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h2>Best Clients This Year</h2></div>
                            <div class="panel-body">
                                <table class="table" id="contents">
                                    <thead>
                                        <tr>
                                            <th>Book Id</th>
                                            <th>Book Name</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($bestClients)
                                            @foreach($bestClients as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->phone }}</td> 
                                                    <td>{{ $item->amount }}</td>                          
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                    </div>                

                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h2>Clients with many Edits</h2></div>
                            <div class="panel-body">
                                <table class="table" id="contents">
                                    <thead>
                                        <tr>
                                            <th>Subscription Id</th>
                                            <th>Phone Number</th>
                                            <th>Number of Edits</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($blainers)
                                            @foreach($blainers as $item)
                                                <tr>
                                                    <td>{{ $item->sub_id }}</td>
                                                    <td>{{ $item->phone }}</td> 
                                                    <td>{{ $item->number }}</td>                          
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                    </div>                

                </div>
            </div>
        </div>
    </div>
@endsection
