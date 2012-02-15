<h1>{{$heading}}</h1>

<h2>Log in</h2>

@foreach ($errors->all() as $error)
	<p>{{$error}}</p>
@endforeach

<p>{{Session::get('message')}}</p>

{{Form::open('user/login_check')}}

<p>Username <input type="text" name="user" maxlength="100" value="{{Input::old('user')}}" /></p>
<p>Password <input type="password" name="pass" maxlength="255" /></p>
<p><input type="submit" value="Log in" /></p>

{{Form::close()}}