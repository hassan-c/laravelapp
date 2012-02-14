<h1><?php echo $heading; ?></h1>

<h2>Administration control panel</h2>

<p><?php echo Session::get('message'); ?></p>

<p>
	Welcome, <b><?php echo $user->user; ?></b>!
</p>

<?php echo Form::open('user/logout'); ?>
<input type="submit" value="Log out" />
<?php echo Form::close(); ?>

<h3>Manage entries</h3>

<h4>Create a new blog entry</h4>

<?php echo Form::open('admin/entry_new'); ?>

<p>Author <input type="text" name="author" maxlength="100" value="<?php echo Input::old('author'); ?>" /></p>

<p>Title <input type="text" name="title" maxlength="255" value="<?php echo Input::old('title'); ?>" /></p>

<p>Body</p>
<textarea name="body" maxlength="4000"><?php echo Input::old('body'); ?></textarea></p>

<p><input type="submit" value="Create Entry" /></p>

<?php echo Form::close(); ?>

<?php foreach ($posts as $post): ?>
	<b><?php echo $post->title; ?></b> by <i><?php echo $post->author; ?></i>, posted <?php echo Time::ago((int) strtotime($post->created_at)); ?></i>
	<p><?php echo Str::words($post->body, 5); ?></p>
	<p><a href="<?php echo URL::to('blog/comments/' . $post->id); ?>">View full entry &raquo;</a></p>

	<?php echo Form::open('admin/entry_delete'); ?>
	<input type="hidden" value="<?php echo $post->id; ?>" name="id" />
	<input type="submit" value="Delete" />
	<?php echo Form::close(); ?>

	<hr />
<?php endforeach; ?>