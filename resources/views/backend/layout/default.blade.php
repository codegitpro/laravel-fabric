<!doctype html>
<html>
<head>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	@include('backend.layout.head')
</head>
<body class="desktop default">
	<header class="row">
		@include('backend.layout.sidenavbar')
		@include('backend.layout.header')
	</header>

	<div>
		@yield('content')
	</div>

	<footer class="row">
		@include('backend.layout.footer')
		@yield('script')
	</footer>
</body>
</html>
