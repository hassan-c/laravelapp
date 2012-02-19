<h2>ACP - Create new forum board</h2>

@foreach ($errors->all() as $error)
	<p>{{$error}}</p>
@endforeach

<p>{{Session::get('message')}}</p>

@if (count($categories) > 0)

	{{Form::open('admin/board_new_make')}}

	<p>
		Category
		<select name="category">
		@foreach ($categories as $category)
			<option value="{{$category->name}}">{{$category->name}}</option>
		@endforeach
		</select>
	</p>

	<p>Name <input type="text" name="name" maxlength="100" value="{{Input::old('name')}}" /></p>
	<p>Description</p>
	<textarea name="description" maxlength="500">{{Input::old('description')}}</textarea>
	
	<p><input type="submit" value="Create" /> or {{HTML::link('user', 'Cancel')}}</p>

	{{Form::close()}}

@else

<p>You'll need to first {{HTML::link('admin/category_new', 'create a category')}} to do that.</p>

@endif