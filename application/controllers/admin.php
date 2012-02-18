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

	// Show the form for creating a new forum category
	public function action_category_new()
	{
		$view = View::of_default()->nest('body', 'admin.category_new', $data);
		$view->title = 'Create new forum category';

		return $view;
	}

	// Create a new forum category
	public function action_category_new_make()
	{
		$name = Input::get('name');

		$rules = array(
			'name' => 'required|unique:boards'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->invalid())
		{
			return Redirect::to('admin/category_new')
				->with_input()
				->with_errors($validator);
		}

		$board = new Board();
		$board->name = $name;
		$board->save();

		return Redirect::to('admin/category_new')
			->with('message', 'Created new forum category');
	}

	// Show the form for creating a new forum board
	public function action_board_new()
	{
		$data = array(
			'categories' => Board::all()
		);

		$view = View::of_default()->nest('body', 'admin.board_new', $data);
		$view->title = 'Create new forum board';

		return $view;
	}

	// Create a new forum board
	public function action_board_new_make()
	{
		$category = Input::get('category');
		$name = Input::get('name');
		$description = Input::get('description');

		$rules = array(
			'category' => 'required',
			'name' => 'required|unique:forums',
			'description' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->invalid())
		{
			return Redirect::to('admin/board_new')
				->with_input()
				->with_errors($validator);
		}

		$forum = new Forum();
		$forum->board_id = DB::table('boards')
			->where_name($category)
			->first()
			->id;
		$forum->name = $name;
		$forum->description = $description;
		$forum->save();

		return Redirect::to('admin/board_new')
			->with('message', 'Created new forum board');
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

		return Redirect::to('admin/entry_manage')
			->with('message', 'Created new blog entry');
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

		return Redirect::to('admin/entry_manage')
			->with('message', 'Edited blog entry');
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

		return Redirect::to('admin/entry_manage')
			->with('message', 'Deleted blog entry');
	}

	// Delete a comment
	public function action_comment_delete()
	{
		Comment::find(Input::get('comment_id'))->delete();

		return Redirect::to('blog/comments/' . Input::get('post_id'))
			->with('message', 'Deleted comment successfully');
	}
}

?>