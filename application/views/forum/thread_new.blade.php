<h1>{{$heading}}</h1>

<h2>Forums</h2>

@foreach ($errors->all() as $error)
	<p>{{$error}}</p>
@endforeach

<p>{{Session::get('message')}}</p>

<h3>Create new thread</h3>

{{Form::open('forum/thread_new_make')}}

<input type="hidden" name="forum_id" value="{{URI::segment(3, 0)}}" />

Title <input type="text" name="title" value="{{Input::old('title')}}" />

<p>Body</p>

<textarea name="body">{{Input::old('body')}}</textarea>

<p><input type="submit" value="Create new thread" /> or {{HTML::link('forum/board/' . URI::segment(3, 0), 'Cancel')}}</p>

{{Form::close()}}
