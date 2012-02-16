<h1>{{$heading}}</h1>

<h2>ACP - Edit entry</h2>

@foreach ($errors->all() as $error)
	<p>{{$error}}</p>
@endforeach

<p>{{Session::get('message')}}</p>

<h4>Editing blog entry</h4>

{{Form::open('admin/entry_edit_do')}}

<input type="hidden" name="post_id" value="{{URI::segment(3, 0)}}" />

<p>Title <input type="text" name="title" maxlength="255" value="{{Input::had('title') ? Input::old('title') : $post_title}}" /></p>

<p>Body</p>
<textarea name="body" maxlength="4000">{{Input::had('body') ? str_replace('<br />', '', Input::old('body')) : str_replace('<br />', '', $post_body)}}</textarea></p>

<p><input type="submit" value="Save Changes" /> or {{HTML::link('admin', 'Cancel')}}</p>

{{Form::close()}}