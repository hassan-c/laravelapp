<h1><?php echo $heading; ?></h1>

<h2><?php echo $board; ?></h2>

<p><?php echo Session::get('message'); ?></p>

<?php foreach ($threads as $thread): ?>

<div class="thread">
	
	<h4><?php echo HTML::link('forum/thread/' . $thread->id . '/' . URL::slug($thread->title), $thread->title); ?></h4>

	<p><?php echo $forum->description; ?></p>
</div>

<?php endforeach; ?>