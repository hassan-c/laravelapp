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
			'boards' => Board::all()
		);

		$view = View::of_default()->nest('body', 'forum.index', $data);
		$view->title = 'Forums';

		return $view;
	}

	// Display threads in a given forum
	public function action_board($id)
	{
		$forum = Forum::find($id);

		if (!$forum)
		{
			return Redirect::to('forum');
		}

		$data = array(
			'forum' => $forum,
			'threads' => Thread::where_forum_id($id)
				->order_by('updated_at', 'desc')
				->get()
		);

		$view = View::of_default()->nest('body', 'forum.board', $data);
		$view->title = $data['forum']->name;

		return $view;
	}

	// Display replies in a given thread
	public function action_thread($id)
	{
		$thread = Thread::find($id);

		if (!$thread)
		{
			return Redirect::to('forum');
		}

		$thread->views++;
		$thread->save(false); // False to prevent timestamps from updating

		$data = array(
			'user' => Auth::user(),
			'thread' => $thread,
			'replies' => Reply::where_thread_id($id)->get()
		);

		$view = View::of_default()->nest('body', 'forum.thread', $data);
		$view->title = $data['thread']->title;

		return $view;
	}

	// Show the form for creating a new thread
	public function action_thread_new()
	{
		$view = View::of_default()->nest('body', 'forum.thread_new', $data);
		$view->title = 'Create new thread';

		return $view;
	}

	// Create a new thread after doing validation and auth
	public function action_thread_new_make()
	{
		$forum_id = Input::get('forum_id');
		$title = Input::get('title');
		$body = Input::get('body');

		if (!Forum::find($forum_id))
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

		return Redirect::to('forum/thread/' . $thread->id . '/' . URL::slug($thread->title))
			->with('message', 'Created new thread');
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

		return Redirect::to('forum/thread/' . $reply->thread_id . '/' . URL::slug($thread->title))
			->with('message', 'Posted reply to thread');
	}

}