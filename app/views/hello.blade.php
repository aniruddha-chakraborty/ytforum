@extends('layouts.master')

@section('head')
	@parent

	<title>Home page</title>
   @stop

   @section('content')
    Home Page

    	@if(Session::has('success'))
    		<div id="alert alert-success">{{ Session::get('success') }}</div>
    	@elseif (Session::has('fail'))
    		<div class="alert alert-danger">{{ Session::get('fail') }}</div>
    	@endif
    @stop