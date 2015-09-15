@extends('layouts.master')

@section('content')
{{-- /vagrant/sites/events.dev/app/views/users/create.blade.php --}}
<header id="head" class="secondary"></header>

<!-- container -->
<div class="container">

	<ol class="breadcrumb">
		<li><a href="{{{ action('HomeController@showHome')}}}">Home</a></li>
		<li><a href="{{{ action('UsersController@showLogin')}}}">User access</a></li>
		<li class="active">New user</li>
	</ol>

	{{-- show errors in alert box --}}
	@if (Session::has('errorMessage'))
	    <div class="alert alert-danger">{{{ Session::get('errorMessage') }}}</div>
	@endif
	@if($errors->has())

		<div class="alert alert-danger" role="alert">
			<ul>
				@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<div class="row">

		<!-- Article main content -->
		<article class="col-xs-12 maincontent">
			<header class="page-header">
				<h1 class="page-title">Sign Up</h1>
			</header>
			@if (Session::has('errorMessage'))
			    <div class="alert alert-danger">{{{ Session::get('errorMessage') }}}</div>
			@endif
			<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
				<div class="panel panel-default">
					<div class="panel-body">
						<h3 class="thin text-center">Create a free account</h3>
						<hr>

						{{ Form::open(array('action' => 'UsersController@newUser')) }}
							<div class="top-margin">
								<label for="email">Email <span class="text-danger">*</span></label>
								<input type="email" class="form-control" id="email" name="email" value="{{{ Input::old('email') }}}">
							</div>
							<div class="top-margin">
								<label for="password">Password <span class="text-danger">*</span></label>
								<input type="password" class="form-control" id="password" name="password">
							</div>
							<div class="top-margin">
								<label for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
								<input type="password" class="form-control" id="confirm_password" name="password_confirmation">
							</div>
							<div class="top-margin">
								<label for="first_name">First name <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="first_name" name="first_name" value="{{{ Input::old('first_name') }}}">
							</div>
							<div class="top-margin">
								<label for="last_name">Last name <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="last_name" name="last_name" value="{{{ Input::old('last_name') }}}">
							</div>


							<hr>

							<div class="row">
								<div class="col-lg-4 text-right">
									<button class="btn btn-action" type="submit">Sign up</button>
								</div>
							</div>
						{{ Form::close() }}
					</div>
				</div>

			</div>

		</article>
		<!-- /Article -->

	</div>
</div>	<!-- /container -->
@stop