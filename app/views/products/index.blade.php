@extends('layout.main')

@section('navigation')
	<li><a href="{{ URL::route('products.create') }}">New Product</a></li>
	<li><a href="{{ URL::route('products.get.pull') }}">Pull</a></li>
	<li><a href="{{ URL::route('products.get.push') }}">Push</a></li>
@stop

@section('content')
	@if(Session::has('message'))
		<div class='alert alert-info'>{{ Session::get('message') }}</div>
	@endif

	<table class='table table-striped table-bordered'>
		<thead>
			<tr>
				<td>id</td>
				<td>title</td>
				<td>sku</td>
				<td>price</td>
				<td>quantity</td>
				<td>actions</td>
			</tr>
		</thead>	
		<tbody>
		@foreach($products as $product)
			<tr>
				<td>{{ $product->id }}</td>
				<td>{{ $product->name }}</td>
				<td>{{ $product->sku }}</td>
				<td>{{ $product->price }}</td>
				<td>{{ $product->quantity }}</td>
				<td>
					<!--a class='btn btn-small btn-success' href="{{ URL::to('products/'.$product->id) }}">Show</a-->
					<a class='btn btn-small btn-info' href="{{ URL::to('products/'.$product->id.'/edit') }}">Edit</a>

					{{ Form::open(array('url' => 'products/'.$product->id, 'class' => 'pull-left')) }}
					{{ Form::hidden('_method', 'DELETE') }}
					{{ Form::submit('Delete', array('class' => 'btn btn-warning')) }}
					{{ Form::close() }}
				</td>	
			</tr>	
		@endforeach
		</tbody>
	</table>
@stop