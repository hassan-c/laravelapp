<h1>{{$heading}}</h1>

<h2>Forums</h2>

<p>{{Session::get('message')}}</p>

@foreach ($boards as $board)

<h3>{{$board->name}}</h3>

	@foreach (Forum::where_board_id($board->id)->get() as $forum)

	<div class="forum">
		<h4>{{HTML::link('forum/board/' . $forum->id . '/' . URL::slug($forum->name), $forum->name)}}</h4>

		<?php
		// These need to be somewhere else.
		$topic_count = count(Thread::where_forum_id($forum->id)->get());
		$reply_count = count(Reply::where_forum_id($forum->id)->get());
		?>

		({{$topic_count}}
		{{Inflector::plural('thread', $topic_count)}},

		{{$reply_count}}
		{{Inflector::plural('reply', $reply_count)}}
		|
		Last post by: Nobody)

		<p>{{$forum->description}}</p>

	</div>

	@endforeach

@endforeach