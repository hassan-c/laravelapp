<!doctype html>
<html>
	<head>
		<meta charset="utf-8">

		<title><?php echo $title; ?></title>

		<?php echo Asset::styles(); ?>
	</head>
	<body>
		<div id="main">
		
		<p>
			Welcome, <?php echo $user->user ? HTML::link('user', $user->user) : 'Guest'; ?>

			<?php if (Auth::check()): ?>
				(<?php echo HTML::link('user/logout', 'Logout'); ?>).
			<?php else: ?>
				<?php echo HTML::link('user/login', 'Log in'); ?>
				<?php echo HTML::link('user/register', 'Register'); ?> |
			<?php endif; ?>

			<?php echo HTML::link('home', 'Home'); ?>
			<?php echo HTML::link('blog', 'Blog'); ?>
			<?php echo HTML::link('forum', 'Forums'); ?>
		</p>