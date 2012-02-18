<?php

class User_Controller extends Controller {
	
	public function __construct()
	{
		$filter_list = array(
			'login',
			'login_check',
			'register',
			'register_check'
		);

		$this->filter('before', 'logged_in')->only($filter_list);
		$this->filter('before', 'auth')->except($filter_list);
	}

	public function action_index()
	{
		$data = array(
			'user' => Auth::user()
		);

		$view = View::of_default()->nest('body', 'user.index', $data);
		$view->title = 'User profile';

		return $view;
	}

	public function action_register()
	{
		$view = View::of_default()->nest('body', 'user.register', $data);
		$view->title = 'Register';

		return $view;
	}

	public function action_register_check()
	{
		$username = Input::get('user');
		$pass = Input::get('pass');

		$rules = array(
			'user' => 'required|alpha_dash|unique:users',
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
		$view = View::of_default()->nest('body', 'user.login', $data);
		$view->title = 'Log in';

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