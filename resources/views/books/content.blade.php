@extends('layouts.content')
@section('content')

	<input type="range" min="80" max="180" id="slider"  value="110" style="position:fixed;top:0px;"/>
<div style="padding-top:40px">
	{!! $content !!}	
</div>

@endsection
@section('js')

    $('#slider').on('change',function(){
    	$('.row').css('font-size', $(this).val() + '%');
    });

@endsection