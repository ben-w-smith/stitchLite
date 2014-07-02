<!DOCTYPE html>
<html>
<head>
	<title>Stitch Lite!</title>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>	

</head>
<body>
	<div class="container">

		@include('layout.navigation')

		@yield('content')

	</div>

	@yield('script')
</body>
</html>