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

	<p>{{Str::words(nl2br($post->body), 50)}}</p>

	@if (Str::words($post->body, 50) != $post->body)
		<p>{{HTML::link('blog/comments/' . $post->id, 'Continue reading &raquo;')}}</p>
	@endif

	<p>{{HTML::link('blog/comments/' . $post->id, 'View comments (' . Comment::where_post_id($post->id)->count() . ')')}}</a></p>

	<hr />

@endforeach