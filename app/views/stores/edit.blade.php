@extends('layout.main')

@section('navigation')
	<li><a href="{{ URL::route('stores.create') }}">Create a Store</a></li>
@stop

@section('content')
	{{ Form::open(array('route' => array('stores.update', $store->id), 'method' => 'PUT')) }}
		@foreach($inputs as $input)
			<div class='form-group'>
				{{ Form::label($input->key, ucfirst($input->key)) }}	
				{{ Form::text($input->key, $input->value, array('class' => 'form-control')) }}
			</div>
		@endforeach
		{{ Form::submit('Edit Store', array('class' => 'btn btn-primary')) }}
	{{ Form::close() }}
@stop