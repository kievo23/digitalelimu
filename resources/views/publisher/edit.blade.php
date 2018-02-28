@extends('layouts.app')

@section('content')
            <div class="panel panel-default">
                <div class="panel-heading">Update Publisher</div>

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
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/publisher/update',['id'=>$publisher->id]) }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-2 control-label">Name</label>

                            <div class="col-md-10">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $publisher->publisher }}" autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="Update" class="btn btn-primary">
                                    Create
                                </button>
                            </div>
                        </div>
                    </form>                    
                </div>
            </div>
@endsection