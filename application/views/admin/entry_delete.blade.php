<h1>{{$heading}}</h1>

<h2>ACP - Delete entry</h2>

<p>{{Session::get('message')}}</p>

<h4>Delete blog entry</h4>

<?php $id = URI::segment(3, 0); ?>

<p>Are you sure you wish to delete this blog entry titled <b>"{{Post::find($id)->title}}"</b>?</p>

{{Form::open('admin/entry_delete_do')}}
<input type="hidden" name="post_id" value="{{$id}}" />
<input type="submit" value="Delete" />
{{Form::close()}}