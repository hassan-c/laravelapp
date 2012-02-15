<h1>{{$heading}}</h1>

<h2>Forums</h2>

<p>{{Session::get('message')}}</p>

<h3>{{$board}}</h3>

@if (Auth::check())

{{HTML::link('forum/thread_new', 'Create new thread')}}

@else

{{HTML::link('user/login', 'Log in')}} to create new threads.

@endif

@foreach ($threads as $thread)

<div class="thread">
	<h4>{{HTML::link('forum/thread/' . $thread->id . '/' . URL::slug($thread->title), $thread->title)}}</h4>

	by <i>{{$thread->author}}</i> |
	last post by <i>{{$thread->last_poster}}</i>,
	{{Time::ago((int) strtotime($thread->updated_at))}}
</div>

@endforeach