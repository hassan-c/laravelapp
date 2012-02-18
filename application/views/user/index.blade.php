<h1>{{$heading}}</h1>

<h2>User profile</h2>

<p>{{Session::get('message')}}</p>

<p>Welcome to your profile, <b>{{$user->user}}</b>!</p>

@if ($user->group == 'admin')

<h3>Administrator actions</h3>

<p><b>Blog:</b> {{HTML::link('admin/entry_manage', 'Manage entries')}}</p>

@endif

<h3>Account information</h3>

<p><b>Username:</b> {{$user->user}}</p>
<p><b>Joined:</b> {{$user->created_at}} ({{Time::ago((int) strtotime($user->created_at))}})
<p><b>Group:</b> {{$user->group}}</p>

<h3>Forum statistics</h3>

<p><b>Threads created:</b> {{Thread::where_author($user->user)->count()}}</p>
<p><b>Replies posted:</b> {{Reply::where_author($user->user)->count()}}