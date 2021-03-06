<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author"      content="Sergey Pozhilov (GetTemplate.com)">

	<title>Events</title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/fonts/fontawesome-webfont.ttf">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/fonts/fontawesome-webfont.woff">
	<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/font-awesome.min.css">

	<!-- Custom styles for our template -->
	<link rel="stylesheet" href="/css/bootstrap-theme.css" media="screen" >
	<link rel="stylesheet" href="/css/main.css">

	
	<link rel="stylesheet" href="/css/event.css">
	@yield('head')


	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="assets/js/html5shiv.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->
</head>

<body class="home">
	<!-- Fixed navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top headroom" >
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				<a class="navbar-brand" href="/"><span class="glyphicon glyphicon-calendar"></span>EventFinder</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
					<li {{ Request::is('/')? 'class="active"': '' }}><a href="/">Home</a></li>
					<li {{ Request::is('events')? 'class="active"': '' }}><a href="{{{ action('CalendarEventsController@index') }}}">Events</a></li>
					@if (Auth::check()) 
						<li {{ (Request::segment(1) == 'users')? 'class="active"': '' }} class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"> {{{ Auth::user()->email }}}<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li {{ (Request::segment(1) == 'users' && !Request::segment(3))? 'class="active"': '' }}><a href="{{{ action('UsersController@showUser', Auth::id()) }}}">Profile</a></li>
								<li {{ (Request::segment(3) == 'calendar')? 'class="active"': '' }}><a href="{{{ action('UsersController@showCalendar', Auth::id()) }}}">Calendar</a></li>
							</ul>
						</li>
						<li><a href="{{{ action('CalendarEventsController@create') }}}"><span class="glyphicon glyphicon-plus-sign"></span> Create Event</a></li>
						<li><a class="btn" href="{{{ action('UsersController@doLogout') }}}">Logout</a></li>
					@else
						<li {{ Request::is('signin')? 'class="active"': '' }}><a class="btn" href="{{{ action('UsersController@showLogin') }}}">SIGN IN / SIGN UP</a></li>
					@endif
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>
	<!-- /.navbar -->
	@yield('content')

	<!-- /social links -->

	<footer id="footer" class="top-space">

		<div class="footer1">
			<div class="container">
				<div class="row">

					<div class="col-md-3 widget">
						<h3 class="widget-title">Contact</h3>
						<div class="widget-body">
							<p>+234 23 9873237<br>
								<a href="mailto:#">some.email@somewhere.com</a><br>
								<br>
								234 Hidden Pond Road, Ashland City, TN 37015
							</p>
						</div>
					</div>

					<div class="col-md-3 widget">
						<h3 class="widget-title">Follow me</h3>
						<div class="widget-body">
							<p class="follow-me-icons">
								<a href=""><i class="fa fa-twitter fa-2"></i></a>
								<a href=""><i class="fa fa-dribbble fa-2"></i></a>
								<a href=""><i class="fa fa-github fa-2"></i></a>
								<a href=""><i class="fa fa-facebook fa-2"></i></a>
							</p>
						</div>
					</div>

					<div class="col-md-6 widget">
						<h3 class="widget-title">Text widget</h3>
						<div class="widget-body">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi, dolores, quibusdam architecto voluptatem amet fugiat nesciunt placeat provident cumque accusamus itaque voluptate modi quidem dolore optio velit hic iusto vero praesentium repellat commodi ad id expedita cupiditate repellendus possimus unde?</p>
							<p>Eius consequatur nihil quibusdam! Laborum, rerum, quis, inventore ipsa autem repellat provident assumenda labore soluta minima alias temporibus facere distinctio quas adipisci nam sunt explicabo officia tenetur at ea quos doloribus dolorum voluptate reprehenderit architecto sint libero illo et hic.</p>
						</div>
					</div>

				</div> <!-- /row of widgets -->
			</div>
		</div>

		<div class="footer2">
			<div class="container">
				<div class="row">

					<div class="col-md-6 widget">
						<div class="widget-body">
							<p class="simplenav">
								<a href="#">Home</a> |
								<a href="about.html">About</a> |
								<a href="sidebar-right.html">Sidebar</a> |
								<a href="contact.html">Contact</a> |
								<b><a href="signup.html">Sign up</a></b>
							</p>
						</div>
					</div>

					<div class="col-md-6 widget">
						<div class="widget-body">
							<p class="text-right">
								Copyright &copy; 2014, NameName. Design: <a href="http://www.gettemplate.com" rel="designer">GetTemplate</a>
							</p>
						</div>
					</div>

				</div> <!-- /row of widgets -->
			</div>
		</div>

	</footer>

	<div class="fpro" style="display: none;">
		<a class="fpro-close" href="#"><i class="fa fa-times"></i></a>
		<div class="fpro-intro">See also:</div>
		<h4 class="fpro-caption"><a target="_blank" href="/pro/progressus.html">Progressus PRO <span>Multipurpose Premium Bootstrap Temlplate</span></a> </h4>
		<div class="fpro-media">
			<a target="_blank" href="/pro/progressus.html"><img src="" alt="Progressus PRO"></a>
			<div class="fpro-desc">
				<p>
					Progressus PRO is a clean and feature-rich Bootstrap theme which will save you a lot of time &amp; effort.
					<a target="_blank" href="/pro/progressus.html"><b>View Details &rarr;</b></a></p>
			</div>
		</div>
	</div>

	<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
	<script src="/js/jquery.js"></script>
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script src="/js/headroom.min.js"></script>
	<script src="/js/jQuery.headroom.min.js"></script>
	<script src="/js/template.js"></script>
	@yield('script')

	<!-- <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-52d8f8d75dfc85f4"></script> -->
</body>
</html>