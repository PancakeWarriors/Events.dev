@extends('layouts.master')

@section('content')
{{-- /vagrant/sites/events.dev/app/views/users/show.blade.php --}}
<header id="head" class="secondary"></header>
<!-- container -->
<div class="container">

	<ol class="breadcrumb">
		<li><a href="{{{ action('HomeController@showHome')}}}">Home</a></li>
		<li class="active">User Profile</li>
	</ol>

	<div class="row">
		{{-- show message --}}
		@if (Session::has('message'))
		    <div class="alert alert-success">{{{ Session::get('message') }}}</div>
		@endif
		<!-- Profile main content -->
		<article class="col-xs-12 maincontent">
			<header class="page-header">
				<h1 class="page-title">{{ $user->first_name }} {{ $user->last_name }}</h1>
			</header>
			<div class="">
				<p><strong>User since: </strong>{{ $user->created_at }}</p>
				<p><strong>Contact: </strong>{{ $user->email }}</p>
				<p>
					<strong>Created Events: </strong>
					<?php $events = CalendarEvent::with('user')->where('user_id', '=', "$user->id")->get();?>
					<ul>
						@foreach($events as $event)
							<li><a href="{{{ action('CalendarEventsController@show', $event->id) }}}">{{{ $event->title }}}</a></li>
						@endforeach
					</ul>
				</p>
				<p><strong>Attending Events: </strong></p>
				<hr>
				@if (Auth::id() == $user->id) 
					<a class="btn btn-default" href="{{{ action('UsersController@edit', $user->id) }}}">Edit Profile</a><a class="btn btn-action" style="margin-left: 2px" href="{{{ action('UsersController@showCalendar', $user->id) }}}">View Calendar</a>
				@endif
			</div>

		</article>
		<!-- /Article -->

	</div>
</div>	<!-- /container -->
@stop