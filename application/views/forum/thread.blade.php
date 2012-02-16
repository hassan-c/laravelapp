<h1>{{$heading}}</h1>

<h2>Forums</h2>

@foreach ($errors->all() as $error)
	<p>{{$error}}</p>
@endforeach

<p>{{Session::get('message')}}</p>

<?php

$id = URI::segment(3, 0);
$thread = Thread::find($id);
$forum = Forum::find($thread->forum_id);
$board = Board::find($forum->board_id);

$forum_link = HTML::link('forum/board/' . $forum->id . '/' . URL::slug($forum->name), $forum->name);
$thread_link = HTML::link('forum/thread/' . $thread->id . '/' . URL::slug($thread->title), $thread->title);

?>

<h3>{{$board->name}} > {{$forum_link}} > {{$thread_link}}</h3>

@foreach ($replies as $reply)
	<div class="reply">
		<h4>{{$reply->author}}</h4> ({{Time::ago((int) strtotime($reply->created_at))}})
		<p>{{$reply->body}}</p>
	</div>
@endforeach

@if (Auth::check())

	<h3>Post a reply</h3>

	{{Form::open('forum/thread_reply')}}

	<input type="hidden" name="thread_id" value="{{URI::segment(3, 0)}}" />

	<p>Message</p>

	<textarea name="body" maxlength="4000">{{Input::old('body')}}</textarea>

	<p><input type="submit" value="Post reply" /></p>

	{{Form::close()}}

@else

	<p>{{HTML::link('user/login', 'Log in')}} to post a reply!</p>

@endif