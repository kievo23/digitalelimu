@extends('layouts.content')
@section('content')

<form class="form-horizontal" style="position:fixed;top:0px;right: 0px;">
	<div class="form-group">
		<label for="font" class="col-sm-3 col-md-3 control-label">Choose Font</label>
		<div class="col-sm-9 col-md-9">
			<select name="font" id="font-size" class="form-control">
				<option value="100">Normal</option>
				<option value="120">Large</option>
				<option value="140">XLarge</option>
				<option value="160">XXLarge</option>
			</select>
		</div>		
	</div>
</form>
<div style="padding-top:40px">
	{!! $content !!}	
</div>
@endsection

@section('js')

    $('#font-size').change(function(){
    	$font = $("#font-size").find(":selected").attr('value');
    	$('.row').css('font-size', $(this).val() + '%');
    });

@endsection