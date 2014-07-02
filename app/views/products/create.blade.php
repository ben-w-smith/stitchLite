@extends('layout.main')

@section('navigation')
@stop

@section('content')
	<h1>Create Product</h1>

	{{ HTML::ul($errors->all()) }}

	{{ Form::open(array('url' => 'products')) }}
		<div class='form-group'>
			{{ Form::text('sku', Input::old('sku'), array('placeholder' => 'SKU', 'class' => 'form-control')) }}
		</div>
		<div class='form-group'>
			{{ Form::text('name', Input::old('name'), array('placeholder' => 'Name', 'class' => 'form-control')) }}
		</div>
		<div class='form-group'>
			{{ Form::text('price', Input::old('price'), array('placeholder' => 'Price', 'class' => 'form-control')) }}
		</div>
		<div class='form-group'>
			{{ Form::text('quantity', Input::old('quantity'), array('placeholder' => 'Quantity', 'class' => 'form-control')) }}
		</div>
		{{ Form::submit('Create the Product', array('class' => 'btn btn-primary')) }}
	{{ Form::close() }}
@stop