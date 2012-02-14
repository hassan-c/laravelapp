<h1><?php echo $heading; ?></h1>

<h2>Log in</h2>

<?php foreach ($errors->all() as $error): ?>
	<p><?php echo $error; ?></p>
<?php endforeach; ?>

<p><?php echo Session::get('message'); ?></p>

<?php echo Form::open('user/login_check'); ?>

<p>Username <input type="text" name="user" maxlength="100" value="<?php echo Input::old('user'); ?>" /></p>
<p>Password <input type="password" name="pass" maxlength="255" /></p>
<p><input type="submit" value="Log in" /></p>

<?php echo Form::close(); ?>