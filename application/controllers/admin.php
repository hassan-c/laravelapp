<?php

class Admin_Controller extends Controller {

	public function __construct()
	{
		$this->filter('before', 'auth_admin');
	}

	// Manage entries
	public function action_entry_manage()
	{
		$data = array(
			'posts' => Post::order_by('id', 'desc')->get()
		);

		$view = View::of_default()->nest('body', 'admin.entry_manage', $data);
		$view->title = 'Manage entries';

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
			return Redirect::to('admin/entry_manage')
				->with_input()
				->with_errors($validator);
		}

		$post = new Post();
		$post->author = Auth::user()->user;
		$post->title = $title;
		$post->body = $body;
		$post->save();

		Session::flash('message', 'Created new blog entry');
		return Redirect::to('admin/entry_manage');
	}

	// Show the form for editing an existing blog entry
	public function action_entry_edit($id)
	{
		$post = Post::find($id);

		if (!$post)
		{
			return Redirect::to('admin/entry_manage');
		}

		$data = array(
			'post_title' => Input::had('title') ? Input::old('title') : $post->title,
			'post_body' => Input::had('body') ? Input::old('body') : $post->body
		);

		$view = View::of_default()->nest('body', 'admin.entry_edit', $data);
		$view->title = 'Edit entry';

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
		$post->body = $body;
		$post->save();

		Session::flash('message', 'Edited blog entry');
		return Redirect::to('admin/entry_manage');
	}

	// Show the form for deleting a blog entry
	public function action_entry_delete($id)
	{
		$post = Post::find($id);

		if (!$post)
		{
			return Redirect::to('admin/entry_manage');
		}

		$data = array(
			'post_id' => $id,
			'post_title' => $post->title
		);

		$view = View::of_default()->nest('body', 'admin.entry_delete', $data);
		$view->title = 'Delete entry';

		return $view;
	}

	// Delete a blog entry
	public function action_entry_delete_do()
	{
		$id = Input::get('post_id');
		$post = Post::find($id);

		// Delete all comments associated with the post
		// as well as the post itself.
		$post->comments()->delete();
		$post->delete();

		Session::flash('message', 'Deleted blog entry');
		return Redirect::to('admin/entry_manage');
	}

	// Delete a comment
	public function action_comment_delete()
	{
		Comment::find(Input::get('comment_id'))->delete();

		Session::flash('message', 'Deleted comment successfully');
		return Redirect::to('blog/comments/' . Input::get('post_id'));
	}
}

?>