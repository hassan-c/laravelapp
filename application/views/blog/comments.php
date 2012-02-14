<h1><?php echo $heading; ?></h1>

<h2>Blog &raquo; Comments</h2>

<h3>Article</h3>

<b><?php echo $post->title; ?></b> by <i><?php echo $post->author; ?></i>, posted <?php echo Time::ago((int) strtotime($post->created_at)); ?></i>
<p><?php echo $post->body; ?>

<hr />

<?php foreach ($errors->all() as $error): ?>
	<p><?php echo $error; ?></p>
<?php endforeach; ?>

<p><?php echo Session::get('message'); ?></p>

<h3>Post a comment</h3>

<?php if (Auth::check()): ?>

<?php echo Form::open('blog/comment_new'); ?>
<input type="hidden" name="post_id" value="<?php echo URI::segment(3, 0); ?>" />
<p>Message</p>
<textarea name="message" maxlength="1000"><?php echo Input::old('message'); ?></textarea>
<p><input type="submit" value="Post Comment" /></p>
<?php echo Form::close(); ?>

<?php else: ?>

<p><?php echo HTML::link('user/login', 'Log in'); ?> to post a comment!</p>

<?php endif; ?>

<h4><?php echo $count; ?> <?php echo Inflector::plural('comment', $count); ?></h4>

<?php foreach ($comments as $comment): ?>

	<p><b><?php echo $comment->name; ?></b> said (<?php echo Time::ago((int) strtotime($comment->created_at)); ?>):</p>

	<p><?php echo $comment->message; ?></p>

	<?php if (Auth::user()->group == 'admin'): ?>

	<?php echo Form::open('admin/comment_delete'); ?>
	<input type="hidden" name="post_id" value="<?php echo URI::segment(3, 0); ?>" />
	<input type="hidden" value="<?php echo $comment->id; ?>" name="id" />
	<input type="submit" value="Delete" />
	<?php echo Form::close(); ?>

	<?php endif; ?>

	<hr />
<?php endforeach; ?>