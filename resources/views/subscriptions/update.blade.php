@extends('layouts.app')

@section('content')
<div class="panel panel-default">
                <div class="panel-heading">Update Book Subscription for: <strong>{{ $trans->client->phone}}</strong></div>

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
                    @if (session('status'))
		            <div class="alert alert-success">
		                {{ session('status') }}
		            </div>
		        @endif 
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/subscriptions/update',['id'=>$trans->id]) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}


                        <div class="form-group{{ $errors->has('class') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-2 control-label">Book</label>

                            <div class="col-md-10">
                                <select class="form-control" name="book">
                                @if($books)

                                    @foreach($books as $main)
                                    <option value="{{$main->id}}">{{$main->name}}</option>
                                    @endforeach
                                @endif
                                </select>
                                @if($errors->has('class'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('class') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Edit
                                </button>
                            </div>
                        </div>
                    </form>                    
                </div>
            </div>
@endsection