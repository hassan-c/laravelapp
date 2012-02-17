<?php

class Forum_Controller extends Controller {

	public function __construct()
	{
		$this->filter('before', 'auth')->only(
			'thread_new',
			'thread_new_make',
			'thread_reply'
		);
	}

	// Display all forums
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

	// Display threads in a given forum
	public function action_board($id)
	{
		if (!Forum::find($id))
		{
			return Redirect::to('forum');
		}

		$data = array(
			'heading' => 'Laravel App',
			'user' => Auth::user(),
			'board' => Forum::find($id)->name,
			'threads' => Thread::where_forum_id($id)->order_by('updated_at', 'desc')->get()
		);

		$view = View::of_forum()->nest('body', 'forum.board', $data);
		$view->title = 'Forums: ' . $data['board'] . ' &raquo; Laravel App';

		return $view;
	}

	// Display replies in a given thread
	public function action_thread($id)
	{
		if (!Thread::find($id))
		{
			return Redirect::to('forum');
		}

		$thread = Thread::find($id);
		$thread->views++;
		
		// False to prevent timestamps from updating
		$thread->save(false);

		$data = array(
			'heading' => 'Laravel App',
			'user' => Auth::user(),
			'thread' => $thread->title,
			'replies' => Reply::where_thread_id($id)->get()
		);

		$view = View::of_forum()->nest('body', 'forum.thread', $data);
		$view->title = $data['thread'] . ' &raquo; Laravel App';

		return $view;
	}

	// Show the form for creating a new thread
	public function action_thread_new()
	{
		$data = array(
			'heading' => 'Laravel App',
			'user' => Auth::user()
		);

		if (!Input::get('forum_id'))
		{
			return Redirect::to('forum');
		}

		$view = View::of_forum()->nest('body', 'forum.thread_new', $data);
		$view->title = 'Forums: ' . $data['board'] . ' &raquo; Laravel App';

		return $view;
	}

	// Create a new thread after doing validation and auth
	public function action_thread_new_make()
	{
		$forum_id = Input::get('forum_id');
		$title = Input::get('title');
		$body = Input::get('body');

		if (!Thread::find($forum_id))
		{
			return Redirect::to('forum');
		}

		$rules = array(
			'title' => 'required',
			'body' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->invalid())
		{
			return Redirect::to('forum/thread_new/' . $forum_id)
				->with_input()
				->with_errors($validator);
		}

		$user = Auth::user();

		$thread = new Thread();
		$thread->forum_id = $forum_id;
		$thread->author = $user->user;
		$thread->title = $title;
		$thread->last_poster = $user->user;
		$thread->save();

		$reply = new Reply();
		$reply->thread_id = $thread->id;
		$reply->forum_id = $thread->forum_id;
		$reply->author = $user->user;
		$reply->body = $body;
		$reply->save();

		Session::flash('message', 'Created new thread');
		return Redirect::to('forum/thread/' . $thread->id . '/' . URL::slug($thread->title));
	}

	// Create a new reply to a given thread
	public function action_thread_reply()
	{
		$thread_id = Input::get('thread_id');
		$body = Input::get('body');

		$rules = array(
			'body' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->invalid())
		{
			return Redirect::to('forum/thread/' . $thread_id)
				->with_input()
				->with_errors($validator);
		}

		$user = Auth::user();

		$thread = Thread::find($thread_id);
		$thread->last_poster = $user->user;
		$thread->save();

		$reply = new Reply();
		$reply->thread_id = $thread_id;
		$reply->forum_id = $thread->forum_id;
		$reply->author = Auth::user()->user;
		$reply->body = $body;
		$reply->save();

		Session::flash('message', 'Posted reply to thread');
		return Redirect::to('forum/thread/' . $reply->thread_id . '/' . URL::slug($thread->title));
	}

}