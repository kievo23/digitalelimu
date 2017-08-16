@extends('layouts.pdf')
@section('content')

<iframe src="https://docs.google.com/viewer?url={{ url('pdf/'.$pdf) }}&embedded=true" style="width:100%; height:900px;" frameborder="0"></iframe>

@endsection