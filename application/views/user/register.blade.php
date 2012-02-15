<h1>{{$heading}}</h1>

<h2>Register</h2>

@foreach ($errors->all() as $error)
	<p>{{$error}}</p>
@endforeach

<p>{{Session::get('message')}}</p>

{{Form::open('user/register_check')}}

<p>Username <input type="text" name="user" maxlength="100" value="{{Input::old('user')}}" /></p>
<p>Password <input type="password" name="pass" maxlength="255" /></p>
<p>Confirm password <input type="password" name="pass_confirmation" maxlength="255" /></p>
<p><input type="submit" value="Register" /></p>

{{Form::close()}}