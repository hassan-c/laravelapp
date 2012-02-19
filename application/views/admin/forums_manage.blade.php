<h2>ACP - Manage forums</h2>

@foreach ($errors->all() as $error)
	<p>{{$error}}</p>
@endforeach

<p>{{Session::get('message')}}</p>
@foreach ($boards as $board)

<h3>{{$board->name}}</h3>

<p>{{HTML::link('admin/category_delete/' . $board->id, 'Delete category')}}</p>

	<?php

	$forums = Forum::where_board_id($board->id)->get();
	
	?>
	
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

		{{HTML::link('admin/board_delete/' . $forum->id, 'Delete board')}}

		<p>{{$forum->description}}</p>

	</div>

	@endforeach

@endforeach