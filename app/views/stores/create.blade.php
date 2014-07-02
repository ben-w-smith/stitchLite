@extends('layout.main')

@section('navigation')
@stop

@section('content')
	<h1>Create Store</h1>

	{{ HTML::ul($errors->all()) }}

	@if(Session::has('message'))
		<div class='alert alert-info'>{{ Session::get('message') }}</div>
	@endif

	<!-- 
		how to load stores from enum?
		how to only load needed stores?
			-forces user to edit a store if they've already made it
		A: send the data from the controller?
	-->
	{{ Form::open() }}
		<div class='form-group' id='store_type'>
			{{ Form::select('store', $stores, null, array('class' => 'form-control')) }}
		</div>
	{{ Form::close() }}

	<div class='form-group store_form'></div>

	<!--div id='shopify'>
		<h3>Create Shopify</h3>
		{{ Form::open(array('url' => 'stores')) }}
			<div class='form-group'>
				{{ Form::text('store', 'Shopify', array('value' => 'Shopify', 'hidden')) }}
			</div>
			<div class='form-group'>
				{{ Form::text('apiKey', Input::old('apiKey'), array('placeholder' => 'API Key', 'class' => 'form-control')) }}	
			</div>
			<div class='form-group'>
				{{ Form::text('domain', Input::old('domain'), array('placeholder' => 'Domain', 'class' => 'form-control')) }}	
			</div>
			<div class='form-group'>
				{{ Form::text('password', Input::old('password'), array('placeholder' => 'Password', 'class' => 'form-control')) }}	
			</div>
			{{ Form::submit('Create Shopify', array('class' => 'btn btn-primary')) }}
		{{ Form::close() }}
	</div-->

@stop

@section('script')
	<script>
	$(document).ready(function() {
		$('#store_type').change(function() {
			var store = $('#store_type :selected').text();
			if(store == '') {
				store = 'none';
			}
			var route = "<?php echo URL::to('stores/create/"+store.toLowerCase()+"'); ?>";
			$.ajax({
				url: route,
				type: 'GET',
				data: {name: store },
				dataType: 'html'
			}).done(function(data) {
				$('.store_form').html(data);
			});
		});
	});
	</script>
@stop