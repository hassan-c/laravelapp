<h2>ACP - Create new forum category</h2>

@foreach ($errors->all() as $error)
	<p>{{$error}}</p>
@endforeach

<p>{{Session::get('message')}}</p>

{{Form::open('admin/category_new_make')}}

<p>Name <input type="text" name="name" maxlenght="100" value="{{Input::old('name')}}" /></p>
<input type="submit" value="Create" /> or {{HTML::link('user', 'Cancel')}}

{{Form::close()}}