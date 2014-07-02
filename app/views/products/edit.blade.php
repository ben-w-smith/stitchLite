@extends('layout.main')

@section('navigation')
	<li><a href="{{ URL::route('products.create') }}">New Product</a></li>
@stop

@section('content')
	{{ HTML::UL($errors->all()) }}

	{{ Form::model($product, array('route' => array('products.update', $product->id), 'method' => 'PUT')) }}
		<div class='form-group'>
			{{ Form::label('sku', 'Sku') }}
			{{ Form::text('sku', null, array('class' => 'form-control')) }}
		</div>
		<div class='form-group'>
			{{ Form::label('name', 'Name') }}
			{{ Form::text('name', null, array('class' => 'form-control')) }}
		</div>
		<div class='form-group'>
			{{ Form::label('price', 'Price') }}
			{{ Form::text('price', null, array('class' => 'form-control')) }}
		</div>
		<div class='form-group'>
			{{ Form::label('quantity', 'Quantity') }}
			{{ Form::text('quantity', null, array('class' => 'form-control')) }}
		</div>
		{{ Form::submit('Edit Product', array('class' => 'btn btn-primary')) }}
	{{ Form::close() }}
@stop