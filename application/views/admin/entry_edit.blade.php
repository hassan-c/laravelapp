<h2>ACP - Editing blog entry</h2>

@foreach ($errors->all() as $error)
	<p>{{$error}}</p>
@endforeach

<p>{{Session::get('message')}}</p>

{{Form::open('admin/entry_edit_do')}}

<input type="hidden" name="post_id" value="{{URI::segment(3, 0)}}" />

<p>Title <input type="text" name="title" maxlength="255" value="{{$post_title}}" /></p>

<p>Body</p>
<textarea name="body" maxlength="4000">{{$post_body}}</textarea>

<p><input type="submit" value="Save Changes" /> or {{HTML::link('admin/entry_manage', 'Cancel')}}</p>

{{Form::close()}}