@extends('layouts.app')

@section('content')
            <div class="panel panel-default">
                <div class="panel-heading">Create Topic</div>

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
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/category/store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-2 control-label">Topic</label>

                            <div class="col-md-10">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-2 control-label">Description</label>

                            <div class="col-md-10">
                                <input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}" autofocus>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('activate') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-2 control-label">Activated</label>

                            <div class="col-md-10">
                                <select class="form-control" name="activate">
                                <option id="activate" value="{{ old('activate') }}">--select--</option>
                                <option id="activate" value="0">Not Active</option>
                                <option id="activate" value="1">Active</option>
                                </select>
                                @if ($errors->has('activate'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('activate') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
                            <label for="week" class="col-md-2 control-label">Photo</label>

                            <div class="col-md-10">
                                <input id="photo" type="file" class="form-control" name="photo" value="{{ old('photo') }}" autofocus>

                                @if ($errors->has('photo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('photo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Post
                                </button>
                            </div>
                        </div>
                    </form>                    
                </div>
            </div>
@endsection