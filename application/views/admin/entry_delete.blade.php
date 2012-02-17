<h1>{{$heading}}</h1>

<h2>ACP - Delete entry</h2>

<p>{{Session::get('message')}}</p>

<h4>Delete blog entry</h4>

<p>Are you sure you wish to delete this blog entry titled <b>"{{$post_title}}"</b>?</p>

{{Form::open('admin/entry_delete_do')}}

<input type="hidden" name="post_id" value="{{$post_id}}" />
<input type="submit" value="Delete" /> or {{HTML::link('admin', 'Cancel')}}

{{Form::close()}}