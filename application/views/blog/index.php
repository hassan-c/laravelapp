<h1><?php echo $heading; ?></h1>

<h2>Blog</h2>

<?php foreach ($errors->all() as $error): ?>
	<p><?php echo $error; ?></p>
<?php endforeach; ?>

<p><?php echo Session::get('message'); ?></p>

<h4><?php echo $count; ?> <?php echo Inflector::plural('post', $count); ?></h4>

<?php foreach ($posts as $post): ?>
	<b><?php echo $post->title; ?></b> by <i><?php echo $post->author; ?></i>, posted <?php echo Time::ago((int) strtotime($post->created_at)); ?></i>
	<p><?php echo Str::words($post->body, 50); ?></p>
	<?php if (Str::words($post->body, 50) != $post->body): ?>
		<p><a href="<?php echo URL::to('blog/comments/' . $post->id); ?>">Continue reading &raquo;</p>
	<?php endif; ?>

	<p><a href="<?php echo URL::to('blog/comments/' . $post->id); ?>">View comments (<?php echo count(Comment::where_post_id($post->id)->get()); ?>)</a></p>

	<hr />
<?php endforeach; ?>