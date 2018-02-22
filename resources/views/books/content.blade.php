@extends('layouts.content')
@section('content')

<!--
	<input type="range" min="80" max="180" id="slider"  value="110" style="position:fixed;top:10px;"/>
	-->
<div style="padding:10px">
	
	<?php
	if($content == null){
		echo "<h3>Dear customer, you have reached the end of this week. Kindly click on <font style='color:red;'>home button</font> below to select another week</h3>";
	}else{
		?>
		{!! $content !!}
		<?php
	}
	?>	
</div>


@endsection
@section('js')

    $('#slider').on('change',function(){
    	$('.row').css('font-size', $(this).val() + '%');
    });

@endsection