<!doctype html>
<html>
	<head>
		<meta charset="utf-8">

		<title>{{$title}}</title>

		{{Asset::styles()}}
	</head>
	<body>
		<div id="main">
		
		<p>
			Welcome, {{$user->user ? HTML::link('user', $user->user) : 'Guest'}}

			@if (Auth::check())
				({{HTML::link('user/logout', 'Logout')}}).
			@else
				{{HTML::link('user/login', 'Log in')}}
				{{HTML::link('user/register', 'Register')}} |
			@endif

			{{HTML::link('home', 'Home')}}
			{{HTML::link('blog', 'Blog')}}
			{{HTML::link('forum', 'Forums')}}
		</p>