<h1>{{$heading}}</h1>

<h2>Administration control panel</h2>

@foreach ($errors->all() as $error)
	<p>{{$error}}</p>
@endforeach

<p>{{Session::get('message')}}</p>

<p>
	Welcome, <b>{{$user->user}}</b>!
</p>

{{Form::open('user/logout')}}
	<input type="submit" value="Log out" />
{{Form::close()}}

<h3>Manage entries</h3>

<h4>Create a new blog entry</h4>

{{Form::open('admin/entry_new')}}

<p>Title <input type="text" name="title" maxlength="255" value="{{Input::old('title')}}" /></p>

<p>Body</p>
<textarea name="body" maxlength="4000">{{Input::old('body')}}</textarea></p>

<p><input type="submit" value="Create Entry" /></p>

{{Form::close()}}

@foreach ($posts as $post)

	<b>{{$post->title}}</b> by <i>{{$post->author}}</i>, posted {{Time::ago((int) strtotime($post->created_at))}}</i>
	<p>{{Str::words($post->body, 5)}}</p>
	<p><a href="{{URL::to('blog/comments/' . $post->id)}}">View full entry &raquo;</a></p>

	<p>{{HTML::link('admin/entry_edit/' . $post->id, 'Edit')}} or {{HTML::link('admin/entry_delete/' . $post->id, 'Delete')}}</p>

	<hr />

@endforeach