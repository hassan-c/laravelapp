<?php

class Admin_Controller extends Controller {

	public function __construct()
	{
		$this->filter('before', 'auth_admin');
	}

	// Dashboard with links to things the admin(s) can do.
	public function action_index()
	{
		$posts = Post::order_by('id', 'desc')->get();
		$data = array(
			'heading' => 'Laravel App',
			'user' => Auth::user(),
			'posts' => $posts
		);

		$view = View::of_blog()->nest('body', 'admin.index', $data);
		$view->title = 'Administration &raquo; Laravel App';

		return $view;
	}

	// Create a new blog entry after doing validation and auth
	public function action_entry_new()
	{
		$title = Input::get('title');
		$body = Input::get('body');

		$rules = array(
			'title' => 'required',
			'body' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->invalid())
		{
			return Redirect::to('admin')
				->with_input()
				->with_errors($validator);
		}

		$post = new Post();
		$post->author = Auth::user()->user;
		$post->title = $title;
		$post->body = nl2br($body);
		$post->save();

		Session::flash('message', 'Created new blog entry');
		return Redirect::to('admin');
	}

	// Show the form for editing an existing blog entry
	public function action_entry_edit($id)
	{
		$post = Post::find($id);

		if (!$post)
		{
			return Redirect::to('admin');
		}

		$data = array(
			'heading' => 'Laravel App',
			'post_title' => $post->title,
			'post_body' => $post->body,
		);

		$view = View::of_blog()->nest('body', 'admin.entry_edit', $data);
		$view->title = 'Edit entry &raquo; Laravel App';

		return $view;
	}

	// Edit an existing blog entry after doing validation and auth
	public function action_entry_edit_do()
	{
		$post_id = Input::get('post_id');
		$title = Input::get('title');
		$body = Input::get('body');

		$rules = array(
			'title' => 'required',
			'body' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->invalid())
		{
			return Redirect::to('admin/entry_edit/' . $post_id)
				->with_input()
				->with_errors($validator);
		}

		$post = Post::find($post_id);
		$post->title = $title;
		$post->body = nl2br($body);
		$post->save();

		Session::flash('message', 'Edited blog entry');
		return Redirect::to('admin');
	}

	// Show the form for deleting a blog entry
	public function action_entry_delete($id)
	{
		if (!Post::find($id))
		{
			return Redirect::to('admin');
		}

		$data = array(
			'heading' => 'Laravel App'
		);

		$view = View::of_blog()->nest('body', 'admin.entry_delete', $data);
		$view->title = 'Delete entry &raquo; Laravel App';

		return $view;
	}

	// Delete a blog entry
	public function action_entry_delete_do()
	{
		$id = Input::get('post_id');
		
		if (!Post::find($id))
		{
			return Redirect::to('admin');
		}

		// Delete all comments associated with the post
		// as well as the post itself.
		$post = Post::find($id);
		$post->comments()->delete();
		$post->delete();

		Session::flash('message', 'Deleted blog entry');
		return Redirect::to('admin');
	}

	// Delete a comment
	public function action_comment_delete()
	{
		$post_id = Input::get('post_id');
		$id = Input::get('id');
		
		Comment::where_post_id($post_id)
			->find($id)
			->delete();

		Session::flash('message', 'Deleted comment successfully');
		return Redirect::to('blog/comments/' . $post_id);
	}
}

?>