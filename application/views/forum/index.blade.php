<h2>Forums</h2>

<p>{{Session::get('message')}}</p>

@foreach ($boards as $board)

<h3>{{$board->name}}</h3>

	<?php

	$forums = Forum::where_board_id($board->id)->get();
	
	?>

	@if (count($forums) == 0)
		<p>This category does not have any forums yet.</p>
	@endif

	@foreach ($forums as $forum)

	<div class="forum">
		<h4>{{HTML::link('forum/board/' . $forum->id . '/' . URL::slug($forum->name), $forum->name)}}</h4>

		<?php

		$topic_count = Thread::where_forum_id($forum->id)->count();
		$reply_count = Reply::where_forum_id($forum->id)->count();

		?>

		({{$topic_count}}
		{{Inflector::plural('thread', $topic_count)}},

		{{$reply_count}}
		{{Inflector::plural('reply', $reply_count)}})

		<p>{{$forum->description}}</p>

	</div>

	@endforeach

@endforeach