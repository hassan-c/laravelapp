<h1>{{$heading}}</h1>

<h2>User profile</h2>

<p>{{Session::get('message')}}</p>

<p>
	Welcome to your profile, <b>{{$user->user}}</b>!
	@if ($user->group == 'admin')
		{{HTML::link('admin', 'ACP')}}
	@endif
</p>

{{Form::open('user/logout')}}
<input type="submit" value="Log out" />
{{Form::close()}}

<h3>Account information</h3>

<p><b>Username:</b> {{$user->user}}</p>
<p><b>Joined:</b> {{$user->created_at}} ({{Time::ago((int) strtotime($user->created_at))}})
<p><b>Group:</b> {{$user->group}}</p>

<hr />