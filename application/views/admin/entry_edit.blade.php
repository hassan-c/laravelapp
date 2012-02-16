<h1>{{$heading}}</h1>

<h2>ACP - Edit entry</h2>

@foreach ($errors->all() as $error)
	<p>{{$error}}</p>
@endforeach

<p>{{Session::get('message')}}</p>

<h4>Editing blog entry</h4>

{{Form::open('admin/entry_edit_do')}}

<input type="hidden" name="post_id" value="{{URI::segment(3, 0}}" />

<p>Title <input type="text" name="title" maxlength="255" value="{{Input::old('title')}}" /></p>

<p>Body</p>
<textarea name="body" maxlength="4000">{{Input::old('body')}}</textarea></p>

<p><input type="submit" value="Save Changes" /></p>

{{Form::close()}}