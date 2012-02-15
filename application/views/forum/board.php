<h1><?php echo $heading; ?></h1>

<h2>Forums</h2>

<p><?php echo Session::get('message'); ?></p>

<h3><?php echo $board; ?></h3>

<?php if (Auth::check()): ?>

<?php echo Form::open('forum/thread_new'); ?>
<input type="submit" value="Create new thread" />
<?php echo Form::close(); ?>

<?php else: ?>

<?php echo HTML::link('user/login', 'Log in'); ?> to create new threads.

<?php endif; ?>

<?php foreach ($threads as $thread): ?>

<div class="thread">
	<h4><?php echo HTML::link('forum/thread/' . $thread->id . '/' . URL::slug($thread->title), $thread->title); ?></h4>

	by <i><?php echo $thread->author; ?></i> |
	last post by <i><?php echo $thread->last_poster; ?></i>, <?php echo Time::ago((int) strtotime($thread->updated_at)); ?>
</div>

<?php endforeach; ?>