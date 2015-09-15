@extends('layouts.master')
@section('head')
	<link rel="stylesheet" href="/vendor/bootstrap-calendar/css/calendar.css">
@stop
@section('content')
{{-- /vagrant/sites/events.dev/app/views/users/calendar.blade.php --}}
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
				<div id="calendar"></div>

			</article>
			<!-- /Article -->

		</div>
	</div>	<!-- /container -->
@stop
@section('script')
    <script type="text/javascript" src="/vendor/underscore/underscore-min.js"></script>
    <script type="text/javascript" src="/vendor/bootstrap-calendar/js/calendar.js"></script>
    <script type="text/javascript">
        var calendar = $("#calendar").calendar(
            {
                tmpl_path: "/vendor/bootstrap-calendar/tmpls/",
                events_source: function () { return []; }
            });         
    </script>
@stop
