<h2>Forums</h2>

@foreach ($errors->all() as $error)
	<p>{{$error}}</p>
@endforeach

<p>{{Session::get('message')}}</p>

<?php

$forum = Forum::find($thread->forum_id);
$board = Board::find($forum->board_id);

// (currently just links to forum index)
$board_link = HTML::link('forum', $board->name);
$forum_link = HTML::link('forum/board/' . $forum->id . '/' . URL::slug($forum->name), $forum->name);

?>

<h3>{{$board_link}} > {{$forum_link}} > {{$thread->title}}</h3>

@foreach ($replies as $reply)
	<div class="reply">
		<h4>{{$reply->author}}</h4> ({{Time::ago((int) strtotime($reply->created_at))}})
		<p>{{$reply->body}}</p>
	</div>
@endforeach

@if (Auth::check())

	<h3>Post a reply</h3>

	{{Form::open('forum/thread_reply')}}

		<input type="hidden" name="thread_id" value="{{$thread->id}}" />

		<p>Message</p>

		<textarea name="body" maxlength="4000">{{Input::old('body')}}</textarea>

		<p><input type="submit" value="Post reply" /></p>

	{{Form::close()}}

@else

	<p>{{HTML::link('user/login', 'Log in')}} to post a reply!</p>

@endif