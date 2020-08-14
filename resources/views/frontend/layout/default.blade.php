<!--<!DOCTYPE html>-->

<html>
<head>
	 <meta name="csrf-token" content="{{ csrf_token() }}">
	@include('frontend.layout.head')
	@yield('css')
</head>
<body class="desktop default">
		@yield('content')
	<footer class="row">
		@include('frontend.layout.footer')
		@yield('script')
	</footer>
</div>
</body>
</html>