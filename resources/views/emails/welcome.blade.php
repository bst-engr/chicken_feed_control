<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Welcome {{$username}}</h2>
		<p><h3>your Login Credentials are: </h3></p>
		<p><b>Username:</b> {{{ $email }}}</p>
		<p><b>Password:</b> {{{ $password }}}</p>
		<p>Please login and change your account password immediatly, <a href="{{ route('sentinel.profile.edit') }}">click here.</a></p>
		<p>Thank you, <br />
			~The Admin Team<br />
			Roomi Foods</p>
	</body>
</html>