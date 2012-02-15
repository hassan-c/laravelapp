<h1>{{$heading}}</h1>

<h2>Blog</h2>

@foreach ($errors->all() as $error)
	<p>{{$error}}</p>
@endforeach

<p>{{Session::get('message')}}</p>

<h4>{{$count}} {{Inflector::plural('post', $count)}}</h4>

@foreach ($posts as $post)

	<b>{{$post->title}}</b> by
	<i>{{$post->author}}</i>, posted
	{{Time::ago((int) strtotime($post->created_at))}}

	<p>{{Str::words($post->body, 50)}}</p>

	@if (Str::words($post->body, 50) != $post->body)
		<p><a href="{{URL::to('blog/comments/' . $post->id)}}">Continue reading &raquo;</p>
	@endif

	<p><a href="{{URL::to('blog/comments/' . $post->id)}}">
	View comments ({{count(Comment::where_post_id($post->id)->get())}})</a></p>

	<hr />

@endforeach