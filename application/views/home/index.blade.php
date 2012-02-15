<!doctype html>
<html>
	<head>
		<meta charset="utf-8">

		<title>{{$title}}</title>

		{{Asset::add('style', 'css/main.css')->styles()}}
	</head>
	<body>
		<div id="main">
			<h1>{{$heading}}</h1>

			<h2>A simple web app</h2>

			{{Session::get('message')}}

			Check out the <a href="blog">Blog</a> instead. It's much better!

		</div>
	</body>
</html>