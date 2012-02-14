<h1><?php echo $heading; ?></h1>

<h2>Forums</h2>

<p><?php echo Session::get('message'); ?></p>

<?php foreach ($boards as $board): ?>

<h3><?php echo $board->name; ?></h3>

	<?php foreach (Forum::where_board_id($board->id)->get() as $forum): ?>

	<div class="forum">
		<h4><?php echo HTML::link('forum/board/' . $forum->id . '/' . URL::slug($forum->name), $forum->name); ?></h4>

		<?php
		$topic_count = Thread::where_forum_id($forum->id)->get();
		?>

		(<?php echo count($topic_count); ?> <?php echo Inflector::plural('thread', count($topic_count)); ?>, 0 replies | Last post by: Nobody)

		<p><?php echo $forum->description; ?></p>

	</div>

	<?php endforeach; ?>

<?php endforeach; ?>