@extends('layouts.app')

@section('content')
            <div class="panel panel-default">
                <div class="panel-heading">Create Class</div>

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
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/content/store') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-2 control-label">Name</label>

                            <div class="col-md-10">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('book') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-2 control-label">Book</label>

                            <div class="col-md-10">
                                <select class="form-control" name="book">
                                @if($books)
                                    @foreach($books as $book)
                                    <option value="{{$book->id}}">{{$book->name}}</option>
                                    @endforeach
                                @endif
                                </select>
                                @if ($errors->has('book'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('book') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('term') ? ' has-error' : '' }}">
                            <label for="term" class="col-md-2 control-label">Term</label>

                            <div class="col-md-10">
                                <input id="term" type="text" class="form-control" name="term" value="{{ old('term') }}" autofocus>

                                @if ($errors->has('term'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('term') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('week') ? ' has-error' : '' }}">
                            <label for="week" class="col-md-2 control-label">Week</label>

                            <div class="col-md-10">
                                <input id="week" type="text" class="form-control" name="week" value="{{ old('week') }}" autofocus>

                                @if ($errors->has('week'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('week') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('lesson') ? ' has-error' : '' }}">
                            <label for="lesson" class="col-md-2 control-label">Lesson</label>

                            <div class="col-md-10">
                                <input id="lesson" type="text" class="form-control" name="lesson" value="{{ old('lesson') }}" autofocus>

                                @if ($errors->has('lesson'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lesson') }}</strong>
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

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="details" class="col-md-2 control-label">Content</label>

                            <div class="col-md-10">
                                <textarea id="details" type="text" class="form-control" name="details" autofocus>
                                    {{ old('details') }}
                                </textarea>

                                @if ($errors->has('details'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('details') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div id="details"></div>
                        

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

@section('js')
@endsection