@extends('layouts.master')

@section('content')
{{-- /vagrant/sites/events.dev/app/views/events/index.blade.php --}}
<header id="head" class="secondary"></header>

<!-- container -->
<div class="container">

	<ol class="breadcrumb">
		<li><a href="index.html">Home</a></li>
		<li class="active">Events</li>
	</ol>

	<div class="row">

		<!-- Article main content -->
		<article class="col-sm-8 maincontent">
			<header class="page-header">
				<h1 class="page-title">Upcoming Events</h1>
			</header>
			{{dd($calendarEvents)}}


		</article>
		<!-- /Article -->

		<!-- Sidebar -->
		<aside class="col-sm-4 sidebar sidebar-right">

			<div class="widget">
				<h4>Vacancies</h4>
				<ul class="list-unstyled list-spaces">
					<li><a href="">Lorem ipsum dolor</a><br><span class="small text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi, laborum.</span></li>
					<li><a href="">Totam, libero, quis</a><br><span class="small text-muted">Suscipit veniam debitis sed ipsam quia magnam eveniet perferendis nisi.</span></li>
					<li><a href="">Enim, sequi dignissimos</a><br><span class="small text-muted">Reprehenderit illum quod unde quo vero ab inventore alias veritatis.</span></li>
					<li><a href="">Suscipit, consequatur, aut</a><br><span class="small text-muted">Sed, mollitia earum debitis est itaque esse reiciendis amet cupiditate.</span></li>
					<li><a href="">Nam, illo, veritatis</a><br><span class="small text-muted">Delectus, sapiente illo provident quo aliquam nihil beatae dignissimos itaque.</span></li>
				</ul>
			</div>

		</aside>
		<!-- /Sidebar -->

	</div>
</div>	<!-- /container -->

@stop