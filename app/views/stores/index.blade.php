@extends('layout.main')

@section('navigation')
	<li><a href="{{ URL::route('stores.create') }}">Create a Store</a></li>
@stop

@section('content')
	<h1>All Stores</h1>

	@if(Session::has('message'))
		<div class='alert alert-info'>{{ Session::get('message') }}</div>
	@endif

	<table class='table table-striped table-bordered'>
		<thead>
			<tr>
				<td>ID</td>
				<td>Name</td>
				<td>Actions</td>
			</tr>
		</thead>
		<tbody>
			@foreach($stores as $store)
				<tr>
					<td>{{ $store->id }}</td>
					<td>{{ $store->type }}</td>
					<td>
						<!-- Actions -->
						<a class='btn btn-small btn-info' href="{{ URL::to('stores/'.$store->id.'/edit') }}">Edit</a>

						{{ Form::open(array('url' => 'stores/'.$store->id, 'class' => 'pull-left')) }}
						{{ Form::hidden('_method', 'DELETE') }}
						{{ Form::submit('Delete', array('class' => 'btn btn-warning')) }}
						{{ Form::close() }}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop