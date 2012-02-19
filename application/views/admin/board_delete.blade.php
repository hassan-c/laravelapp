<h2>ACP - Delete forum board</h2>

<p>{{Session::get('message')}}</p>

<p>Are you sure you wish to delete the forum board <b>"{{$board->name}}"</b>?</p>

{{Form::open('admin/board_delete_do')}}

<input type="hidden" name="id" value="{{$board->id}}" />
<input type="submit" value="Delete" /> or {{HTML::link('admin/forums_manage', 'Cancel')}}

{{Form::close()}}