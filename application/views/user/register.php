<h1><?php echo $heading; ?></h1>

<h2>Register</h2>

<?php foreach ($errors->all() as $error): ?>
	<p><?php echo $error; ?></p>
<?php endforeach; ?>

<p><?php echo Session::get('message'); ?></p>

<?php echo Form::open('user/register_check'); ?>

<p>Username <input type="text" name="user" maxlength="100" value="<?php echo Input::old('user'); ?>" /></p>
<p>Password <input type="password" name="pass" maxlength="255" /></p>
<p>Confirm password <input type="password" name="pass_confirmation" maxlength="255" /></p>
<p><input type="submit" value="Register" /></p>

<?php echo Form::close(); ?>