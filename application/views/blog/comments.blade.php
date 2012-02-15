<h1>{{$heading}}</h1>

<h2>Blog &raquo; Comments</h2>

<h3>Article</h3>

<b>{{$post->title}}</b> by <i>{{$post->author}}</i>, posted {{Time::ago((int) strtotime($post->created_at))}}</i>
<p>{{$post->body}}

<hr />

@foreach ($errors->all() as $error)
	<p>{{$error}}</p>
@endforeach

<p>{{Session::get('message')}}</p>

<h3>Post a comment</h3>

@if (Auth::check())

	{{Form::open('blog/comment_new')}}

		<input type="hidden" name="post_id" value="{{URI::segment(3, 0)}}" />
		<p>Message</p>
		<textarea name="message" maxlength="1000">{{Input::old('message')}}</textarea>
		<p><input type="submit" value="Post Comment" /></p>

	{{Form::close()}}

@else

	<p>{{HTML::link('user/login', 'Log in')}} to post a comment!</p>

@endif

<h4>{{$count}} {{Inflector::plural('comment', $count)}}</h4>

@foreach ($comments as $comment)

	<p><b>{{$comment->name}}</b> said
	({{Time::ago((int) strtotime($comment->created_at))}}):</p>

	<p>{{$comment->message}}</p>

	@if (Auth::user()->group == 'admin')

		{{Form::open('admin/comment_delete')}}
			<input type="hidden" name="post_id" value="{{URI::segment(3, 0); ?>" />
			<input type="hidden" value="{{$comment->id; ?>" name="id" />
			<input type="submit" value="Delete" />
		{{Form::close()}}

	@endif

	<hr />

@endforeach