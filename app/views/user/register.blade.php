@extends('layouts.master')

@section('head')
	@parent

	<title>Register</title>

   @stop

   @section('content')
   
   		<div class="container">
   				<h1>Register</h1>

   					<form role="form" method="post" action="{{ URL::route('postCreate') }}">
   							
   							<div class="form-group">
   									<label for="username">Username:</label>
   									<input id="username" name="username" type="text" class="form-control">
   							</div>
   							
   							<div class="form-group">
   									<label for="pass1">Password:</label>
   									<input id="pass1" name="pass1" type="text" class="form-control">
   							</div>

   							<div class="form-group">
   									<label for="pass2">Confirm Password:</label>
   									<input id="pass2" name="pass2" type="text" class="form-control">
   							</div>
   							
   								{{ Form::token() }}

   							<div class="form-group">
   									<input type="submit" value="register" class="btn btn-default">
   							</div>

   					</form>
   		</div>

   @stop