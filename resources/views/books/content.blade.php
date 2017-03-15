@extends('layouts.content')
@section('content')

<select name="font" id="font-size" class="form-control">
	<option value="100">Normal</option>
	<option value="120">Large</option>
	<option value="140">XLarge</option>
	<option value="160">XXLarge</option>
</select>

{!! $content !!}

@endsection

@section('js')

    $('#font-size').change(function(){
    	$font = $("#font-size").find(":selected").attr('value');
    	$('.row').css('font-size', $(this).val() + '%');
    });

@endsection