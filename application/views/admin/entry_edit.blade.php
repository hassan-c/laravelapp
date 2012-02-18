<h2>ACP - Edit entry</h2>

@foreach ($errors->all() as $error)
	<p>{{$error}}</p>
@endforeach

<p>{{Session::get('message')}}</p>

<h4>Editing blog entry</h4>

{{Form::open('admin/entry_edit_do')}}

<input type="hidden" name="post_id" value="{{URI::segment(3, 0)}}" />

<p>Title <input type="text" name="title" maxlength="255" value="{{$post_title}}" /></p>

<p>Body</p>
<textarea name="body" maxlength="4000">{{$post_body}}</textarea>

<p><input type="submit" value="Save Changes" /> or {{HTML::link('admin', 'Cancel')}}</p>

{{Form::close()}}