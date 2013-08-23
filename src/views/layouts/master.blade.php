<html>
<head>
	<title>@yield('title')</title>
	<meta name="description" content="@yield('meta_description')">
	<meta name="keywords" content="@yield('meta_keywords')">
</head>
<body>
	<div id="content">
		@yield('content')
	</div>
	<div id="sidebar">
		@yield('sidebar')
	</div>
</body>
</html>