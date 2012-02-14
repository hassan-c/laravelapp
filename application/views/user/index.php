<h1><?php echo $heading; ?></h1>

<h2>User profile</h2>

<p><?php echo Session::get('message'); ?></p>

<p>
	Welcome to your profile, <b><?php echo $user->user; ?></b>!
	<?php if ($user->group == 'admin'): ?>
	<?php echo HTML::link('admin', 'ACP'); ?>
	<?php endif; ?>
</p>

<?php echo Form::open('user/logout'); ?>
<input type="submit" value="Log out" />
<?php echo Form::close(); ?>

<h3>Account information</h3>

<p><b>Username:</b> <?php echo $user->user; ?></p>
<p><b>Joined:</b> <?php echo $user->created_at; ?> (<?php echo Time::ago((int) strtotime($user->created_at)); ?>)
<p><b>Group:</b> <?php echo $user->group; ?></p>

<hr />