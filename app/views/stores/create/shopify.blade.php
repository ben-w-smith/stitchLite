	<div id='shopify'>
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
	</div>