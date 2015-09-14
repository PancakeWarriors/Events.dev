@extends('layouts.master')

@section('content')
{{-- /vagrant/sites/events.dev/app/views/users/create.blade.php --}}
<header id="head" class="secondary"></header>

<!-- container -->
<div class="container">

	<ol class="breadcrumb">
		<li><a href="{{{ action('HomeController@showHome')}}}">Home</a></li>
		<li class="active">User access</li>
		<li></li>
	</ol>

	<div class="row">

		<!-- Article main content -->
		<article class="col-xs-12 maincontent">
			<header class="page-header">
				<h1 class="page-title">Sign in</h1>
			</header>
			@if (Session::has('errorMessage'))
			    <div class="alert alert-danger">{{{ Session::get('errorMessage') }}}</div>
			@endif
			<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
				<div class="panel panel-default">
					<div class="panel-body">
						<h3 class="thin text-center">Sign in to your account</h3>
						<p class="text-center text-muted">Don't have an account? <a href="signup">Signup</a> to create events or add them to your calendar. </p>
						<hr>

						{{ Form::open(array('action' => 'UsersController@doLogin')) }}
							<div class="top-margin">
								<label for="email">Email <span class="text-danger">*</span></label>
								<input type="email" class="form-control" id="email" name="email" value="{{{ Input::old('email') }}}">
							</div>
							<div class="top-margin">
								<label for="password">Password <span class="text-danger">*</span></label>
								<input type="password" class="form-control" id="password" name="password" value="{{{ Input::old('password') }}}">
							</div>

							<hr>

							<div class="row">
								<div class="col-lg-8">
									<b><a href="">Forgot password?</a></b>
								</div>
								<div class="col-lg-4 text-right">
									<button class="btn btn-action" type="submit">Sign in</button>
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