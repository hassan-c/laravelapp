<h2>ACP - Delete blog entry</h2>

<p>{{Session::get('message')}}</p>

<p>Are you sure you wish to delete this blog entry titled <b>"{{$post_title}}"</b>?</p>

{{Form::open('admin/entry_delete_do')}}

<input type="hidden" name="post_id" value="{{$post_id}}" />
<input type="submit" value="Delete" /> or {{HTML::link('admin/entry_manage', 'Cancel')}}

{{Form::close()}}