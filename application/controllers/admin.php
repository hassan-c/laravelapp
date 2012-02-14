<?php

class Admin_Controller extends Controller {

	public function __construct()
	{
		$this->filter('before', 'auth_admin');
	}

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

	public function action_entry_new()
	{
		$author = Input::get('author');
		$title = Input::get('title');
		$body = Input::get('body');

		$rules = array(
			'author' => 'required',
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
		$post->author = $author;
		$post->title = $title;
		$post->body = nl2br($body);
		$post->save();

		Session::flash('message', 'Created new blog entry');
		return Redirect::to('admin');
	}

	public function action_entry_delete()
	{
		$id = Input::get('id');

		// Delete all comments associated with the post
		// as well as the post itself.
		$post = Post::find($id);
		$post->comments()->delete();
		$post->delete();

		Session::flash('message', 'Deleted blog entry');
		return Redirect::to('admin');
	}

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