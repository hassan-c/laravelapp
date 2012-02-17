<h1>{{$heading}}</h1>

<h2>Blog &raquo; Comments</h2>

<h3>Article</h3>

<b>{{$post->title}}</b> by <i>{{$post->author}}</i>, posted {{$post_created_at}}</i>
<p>{{nl2br($post->body)}}

<hr />

@foreach ($errors->all() as $error)
	<p>{{$error}}</p>
@endforeach

<p>{{Session::get('message')}}</p>

<h3>Post a comment</h3>

@if (Auth::check())

	{{Form::open('blog/comment_new')}}

		<input type="hidden" name="post_id" value="{{$post_id}}" />
		<p>Message</p>
		<textarea name="message" maxlength="1000">{{Input::old('message')}}</textarea>
		<p><input type="submit" value="Post comment" /></p>

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
			<input type="hidden" name="post_id" value="{{$post_id}}" />
			<input type="hidden" name="comment_id" value="{{$comment->id}}" />
			<input type="submit" value="Delete" />
		{{Form::close()}}

	@endif

	<hr />

@endforeach