@extends('layouts.content')
@section('content')

	<form method="post" class="form-horizontal" action="{{ url('/api/pesapalPost') }}">
		<input type="text" name="first_name" value="" placeholder="first name" class="form-control" >	
		<input type="text" name="last_name" value="" placeholder="last Name" class="form-control" >
		<input type="hidden" name="description" value="Book subscription on Digital Elimu" readonly="readonly">
		<input type="hidden" name="reference" value="<?php $id ?>" readonly="readonly">
		<input type="text" name="email" placeholder="email" class="form-control" >
		<input type="hidden" name="type" value="MERCHANT" readonly="readonly" />
		<input type="text" name="amount" placeholder="amount" class="form-control" >
		<input type="submit" name="submit" value="Buy" class="form-control" >
	</form>
	<iframe src="<?php echo $iframe_src;?>" width="100%" height="700px"  scrolling="no" frameBorder="0">
		<p>Browser unable to load iFrame</p>
	</iframe>

@endsection
