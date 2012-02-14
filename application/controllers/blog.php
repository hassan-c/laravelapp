<?php

class Blog_Controller extends Controller {

	public function action_index()
	{
		$posts = Post::order_by('id', 'desc')->get();
		$data = array(
			'heading' => 'Laravel App',
			'posts' => $posts,
			'count' => count($posts),
		);

		$view = View::of_blog()->nest('body', 'blog.index', $data);
		$view->title = 'Laravel App';

		return $view;
	}

	public function action_comments($id)
	{
		if (!Post::find($id))
		{
			return Redirect::to('blog');
		}

		$comments = Comment::where_post_id($id)
			->order_by('id', 'desc')
			->get();

		$data = array(
			'heading' => 'Laravel App',
			'comments' => $comments,
			'post' => Post::find($id),
			'count' => count($comments),
		);

		$view = View::of_blog()->nest('body', 'blog.comments', $data);
		$view->title = 'Comments &raquo; Laravel App';

		return $view;
	}

	public function action_comment_new()
	{
		$post_id = Input::get('post_id');
		$message = Input::get('message');


		if (Auth::guest())
		{
			return Redirect::to('blog/comments/' . $post_id);
		}

		$rules = array(
			'post_id' => 'required',
			'message' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->invalid())
		{
			return Redirect::to('blog/comments/' . $post_id)
				->with_input()
				->with_errors($validator);
		}

		$comment = new Comment();
		$comment->post_id = $post_id;
		$comment->name = Auth::user()->name;
		$comment->message = $message;
		$comment->save();

		Session::flash('message', 'Posted comment to article');
		return Redirect::to('blog/comments/' . $post_id);
	}

}