<?php

class User_Controller extends Controller {
	
	public function __construct()
	{
		$this->filter('before', 'logged_in')->only(
			'register',
			'register_check'
		);

		$this->filter('before', 'auth')->except(
			'login',
			'login_check',
			'register',
			'register_check'
		);
	}

	public function action_index()
	{
		$data = array(
			'heading' => 'Laravel App',
			'user' => Auth::user(),
		);

		$view = View::of_blog()->nest('body', 'user.index', $data);
		$view->title = 'User profile &raquo; Laravel Blog App';

		return $view;
	}

	public function action_register()
	{
		$data = array(
			'heading' => 'Laravel App',
		);

		$view = View::of_blog()->nest('body', 'user.register', $data);
		$view->title = 'Register &raquo; Laravel App';

		return $view;
	}

	public function action_register_check()
	{
		$username = Input::get('user');
		$pass = Input::get('pass');

		$rules = array(
			'user' => 'required|unique:users',
			'pass' => 'required|confirmed'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->invalid())
		{
			return Redirect::to('user/register')
				->with_input()
				->with_errors($validator);
		}

		$user = new User();
		$user->user = $username;
		$user->pass = Hash::make($pass);
		$user->group = 'user';
		$user->save();

		Auth::login($user);

		Session::flash('message', 'Registered new account successfully');
		return Redirect::to('user');
	}

	public function action_login()
	{
		$data = array(
			'heading' => 'Laravel App',
		);

		$view = View::of_blog()->nest('body', 'user.login', $data);
		$view->title = 'Log in &raquo; Laravel App';

		return $view;
	}

	public function action_login_check()
	{
		$user = Input::get('user');
		$pass = Input::get('pass');

		$rules = array(
			'user' => 'required',
			'pass' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->invalid())
		{
			return Redirect::to('user/login')
				->with_input()
				->with_errors($validator);
		}

		if (Auth::attempt($user, $pass))
		{
			return Redirect::to('user');
		}

		Session::flash('message', 'Incorrect username or password');
		return Redirect::to('user/login');
	}

	public function action_logout()
	{
		Auth::logout();
		
		Session::flash('message', 'Logged out successfully');
		return Redirect::to('user/login');
	}
}