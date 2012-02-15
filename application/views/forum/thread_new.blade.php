<h1>{{$heading}}</h1>

<h2>Forums</h2>

<p>{{Session::get('message')}}</p>

<h3>Create new thread</h3>

Title <input type="text" name="title" />

<p>Body</p>

<textarea name="body"></textarea>

{{Form::open('forum/thread_new_make')}}
<input type="submit" value="Create new thread" />
{{Form::close()}}
