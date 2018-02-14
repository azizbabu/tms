@extends('emails.master')

@section('title') New Account @endsection

@section('content')
	<p>Hi, {{ $name }}!</p>
	<p>Welcome to the <strong>{{ $app_name }}</strong> Community! </p>
	<p>Your username is <strong>{{$username}}</strong> and your temporary password is <strong>{{$password}}</strong></p>
	<p>We need to confirm your email address in order to activate your account. Please click on the following link to confirm your new <strong>{{ $app_name }}</strong> account.</p>
	<p>{!! url('users/account-varification/' . $jwt) !!}</p>
@endsection