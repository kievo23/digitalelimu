@extends('layouts.pdf')
@section('content')

<?php
print_r($book->pdf);
?>
{{ url('pdf/'.$book->pdf) }}
<iframe src="http://docs.google.com/gview?url=http://139.59.187.229/{{ url('pdf/'.$book->pdf) }}&embedded=true" style="width:100%; height:900px;" frameborder="0"></iframe>

@endsection