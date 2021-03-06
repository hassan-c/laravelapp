<h2>ACP - Manage entries</h2>

@foreach ($errors->all() as $error)
	<p>{{$error}}</p>
@endforeach

<p>{{Session::get('message')}}</p>

<h3>Create a new blog entry</h3>

{{Form::open('admin/entry_new')}}

<p>Title <input type="text" name="title" maxlength="255" value="{{Input::old('title')}}" /></p>

<p>Body</p>
<textarea name="body" maxlength="4000">{{Input::old('body')}}</textarea></p>

<p><input type="submit" value="Create entry" /></p>

{{Form::close()}}

@foreach ($posts as $post)

	<b>{{$post->title}}</b> by <i>{{$post->author}}</i>, posted {{Time::ago((int) strtotime($post->created_at))}}</i>

	<p>{{Str::words(nl2br($post->body), 5)}}</p>
	
	<p>{{HTML::link('blog/comments/' . $post->id, 'View full entry &raquo;')}}</p>

	<p>
	{{HTML::link('admin/entry_edit/' . $post->id, 'Edit')}}
	or
	{{HTML::link('admin/entry_delete/' . $post->id, 'Delete')}}
	</p>

	<hr />

@endforeach