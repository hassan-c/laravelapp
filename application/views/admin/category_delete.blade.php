<h2>ACP - Delete forum category</h2>

<p>{{Session::get('message')}}</p>

<p>Are you sure you wish to delete the forum category <b>"{{$category->name}}"</b>?</p>

<p>This will delete all forums, topics and replies the category contains.</p>

{{Form::open('admin/category_delete_do')}}

<input type="hidden" name="id" value="{{$category->id}}" />
<input type="submit" value="Delete" /> or {{HTML::link('admin/forums_manage', 'Cancel')}}

{{Form::close()}}