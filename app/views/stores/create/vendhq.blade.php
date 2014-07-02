<div id='vendhq'>
	<h3>Create Vendhq</h3>
	{{ Form::open(array('url' => 'stores')) }}
		<div class='form-group'>
			{{ Form::text('store', 'Vendhq', array('value' => 'Vendhq', 'hidden')) }}
		</div>
		<div class='form-group'>
			{{ Form::text('username', Input::old('username'), array('placeholder' => 'Username', 'class' => 'form-control')) }}
		</div>
		<div class='form-group'>
			{{ Form::text('password', Input::old('password'), array('placeholder' => 'Password', 'class' => 'form-control')) }}
		</div>
		<div class='form-group'>
			{{ Form::text('domain', Input::old('domain'), array('placeholder' => 'Domain', 'class' => 'form-control')) }}
		</div>
		{{ Form::submit('Create Vendhq', array('class' => 'btn btn-primary')) }}
	{{ Form::close() }}
</div>