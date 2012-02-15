<?php

class Forum_Controller extends Controller {

	public function __construct()
	{
		$this->filter('before', 'auth')->only(
			'thread_new',
			'thread_new_make'
		);
	}

	public function action_index()
	{
		$data = array(
			'heading' => 'Laravel App',
			'user' => Auth::user(),
			'boards' => Board::all()
		);

		$view = View::of_forum()->nest('body', 'forum.index', $data);
		$view->title = 'Forums &raquo; Laravel App';

		return $view;
	}

	public function action_board($id)
	{
		$data = array(
			'heading' => 'Laravel App',
			'user' => Auth::user(),
			'board' => Forum::find($id)->name,
			'threads' => Thread::where_forum_id($id)->get()
		);

		$view = View::of_forum()->nest('body', 'forum.board', $data);
		$view->title = 'Forums: ' . $data['board'] . ' &raquo; Laravel App';

		return $view;
	}

	public function action_thread_new()
	{
		$data = array(
			'heading' => 'Laravel App',
			'user' => Auth::user(),
			'board' => Forum::find($id)->name,
			'threads' => Thread::where_forum_id($id)->get()
		);

		$view = View::of_forum()->nest('body', 'forum.board', $data);
		$view->title = 'Forums: ' . $data['board'] . ' &raquo; Laravel App';

		return $view;
	}

}