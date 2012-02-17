<h1>{{$heading}}</h1>

<h2>Forums</h2>

<p>{{Session::get('message')}}</p>

<h3>{{$forum->name}}</h3>

@if (Auth::check())

	<p>{{HTML::link('forum/thread_new/' . $forum->id, 'Create new thread')}}</p>

@else

	<p>{{HTML::link('user/login', 'Log in')}} to create a new thread.</p>

@endif

@foreach ($threads as $thread)

<div class="thread">
	<h4>{{HTML::link('forum/thread/' . $thread->id . '/' . URL::slug($thread->title), $thread->title)}}</h4>

	by <i>{{$thread->author}}</i> |
	
	last post by <i>{{$thread->last_poster}}</i>,
	{{Time::ago((int) strtotime($thread->updated_at))}} |

	replies: {{Reply::where_thread_id($thread->id)->count()}}, views: {{$thread->views}}
</div>

@endforeach