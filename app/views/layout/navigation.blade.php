<nav class="navbar navbar-inverse">
	<div class='container'>
		<div class="navbar-header">
			<a class="navbar-brand" href="{{ URL::to('products') }}">Stitch Lite</a></li>
		</div>
		<ul class="nav navbar-nav">
			@if(Auth::check())
				<li><a href="{{ URL::to('products') }}">Products</a></li>
				<li><a href="{{ URL::to('stores') }}">Stores</a></li>
				@yield('navigation')
				<li><a href="{{ URL::route('get.logout') }}">Sign Out</a></li>
			@else
				<li><a href="{{ URL::route('users.get.login') }}">Login</a></li>
				<li><a href="{{ URL::route('users.get.create') }}">Create an Account</a>
			@endif			
		</ul>
	</div>
</nav>
