@extends('layouts.app')

@section('content')
            <div class="panel panel-default">
                <div class="panel-heading">Update Book</div>

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
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/book/update',['id'=>$book->id]) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-2 control-label">Name</label>

                            <div class="col-md-10">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $book->name }}" autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('class') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-2 control-label">Class</label>

                            <div class="col-md-10">
                                <?php 
                                    foreach ($classes as $key => $value) {
                                        if($value->id ==  $book->class_id){
                                            $classThis = $value->name;
                                        }
                                    }
                                 ?>
                                <select class="form-control" name="class">
                                <option value="{{$book->class_id}}">{{$classThis}}</option>
                                @if($classes)
                                    @foreach($classes as $main)
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

                        <div class="form-group{{ $errors->has('booktype') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-2 control-label">Book Type</label>

                            <div class="col-md-10">
                                <?php 
                                    $bodyTypeArray = array('','Term Type','Chapter Type');
                                    if($book->booktype){
                                        $bktp = $bodyTypeArray[$book->booktype];
                                    }else{
                                        $bktp = '';
                                    }
                                 ?>
                                <select class="form-control" name="booktype">
                                    <option value="{{$book->booktype}}"><?php echo $bktp; ?></option>
                                    <option value="1">Term Type</option>
                                    <option value="2">Chapter Type</option>
                                </select>
                                @if ($errors->has('booktype'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('booktype') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
                            <label for="week" class="col-md-2 control-label">Photo</label>

                            <div class="col-md-5">
                                <input id="photo" type="file" class="form-control" name="photo" value="{{ old('photo') }}" autofocus>

                                @if ($errors->has('photo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('photo') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-5">
                                {{$book->photo}}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('pdf') ? ' has-error' : '' }}">
                            <label for="pdf" class="col-md-2 control-label">PDF</label>

                            <div class="col-md-5">
                                <input id="pdf" type="file" class="form-control" name="pdf[]" value="{{ old('pdf') }}" autofocus multiple>

                                @if ($errors->has('pdf'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pdf') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-5">
                                {{$book->pdf}}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-2 control-label">Description</label>

                            <div class="col-md-10">
                                <input id="description" type="text" class="form-control" name="description" value="{{ $book->description }}" autofocus>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
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
