<?php

class Forum_Controller extends Controller {
	
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
			'board' => Board::find($id)->name,
			'threads' => Thread::where_forum_id($id)->get()
		);

		$view = View::of_forum()->nest('body', 'forum.board', $data);
		$view->title = 'Forums &raquo; Laravel App';

		return $view;
	}

}