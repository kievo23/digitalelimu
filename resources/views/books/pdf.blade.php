@extends('layouts.pdf')
@section('content')

<?php
print_r($book->pdf);
?>
<iframe src="https://docs.google.com/viewer?url={{ url('pdf/'.$book->pdf) }}&embedded=true" style="width:100%; height:900px;" frameborder="0"></iframe>

@endsection