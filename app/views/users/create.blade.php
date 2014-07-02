@extends('layout.main')

@section('content')
	@if(Session::has('message'))
		<div class='alert alert-info'>{{ Session::get('message') }}</div>
	@endif

	<div class='col-md-4'></div>
	<div class='col-md-4'>
		<h2>Create an Account</h2>

		{{ HTML::ul($errors->all()) }}

		{{ Form::open(array('route' => 'users.post.create')) }}
			<div class='form-group'>
				{{ Form::text('email', Input::old('email'), array('placeholder' => 'Email', 'class' => 'form-control')) }}
			</div>
			<div class='form-group'>
				{{ Form::password('password', array('placeholder' => 'Password', 'class' => 'form-control')) }}
			</div>
			<div class='form-group'>
				{{ Form::password('password_again', array('placeholder' => 'Password again', 'class' => 'form-control')) }}
			</div>

			{{ Form::submit('Create Account!', array('class' => 'btn btn-primary')) }}
			{{ Form::token() }}
		{{ Form::close() }}
	</div>
	<div class='col-md-4'></div>
@stop