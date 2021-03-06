<?php

class Blog_Controller extends Controller {

	public function action_index()
	{
		$posts = Post::order_by('id', 'desc');
		
		$data = array(
			'posts' => $posts->get(),
			'count' => $posts->count()
		);

		$view = View::of_default()->nest('body', 'blog.index', $data);
		$view->title = 'Blog';

		return $view;
	}

	public function action_comments($id)
	{
		$post = Post::find($id);

		if (!$post)
		{
			return Redirect::to('blog');
		}

		$comments = Comment::where_post_id($id)
			->order_by('id', 'desc');

		$data = array(
			'comments' => $comments->get(),
			'count' => $comments->count(),
			'post' => $post,
			'post_id' => $id,
			'post_created_at' => Time::ago((int) strtotime($post->created_at))
		);

		$view = View::of_default()->nest('body', 'blog.comments', $data);
		$view->title = 'Comments';

		return $view;
	}

	public function action_comment_new()
	{
		$post_id = Input::get('post_id');
		$message = Input::get('message');

		if (Auth::guest())
		{
			return Redirect::to('blog/comments/' . $post_id)
				->with('message', 'Log in to post a comment');
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
		$comment->name = Auth::user()->user;
		$comment->message = $message;
		$comment->save();

		return Redirect::to('blog/comments/' . $post_id)
			->with('message', 'Posted comment to article');
	}

}