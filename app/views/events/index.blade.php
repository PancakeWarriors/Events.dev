<?php
	require_once("infinite-scroll/connect.php");
	$results = $connect->query("SELECT * FROM calendar_events ORDER BY updated_at DESC LIMIT 0,5");
	$count = $connect->query("SELECT * FROM calendar_events");
	$number = $count->rowCount();

?>
@extends('layouts.master')

@section('head')
	<style>
		.loader{

			bottom: 5px;
		}
	</style>
@stop

@section('content')
{{-- /vagrant/sites/events.dev/app/views/events/index.blade.php --}}
<header id="head" class="secondary"></header>

<!-- container -->
<div class="container">

	<ol class="breadcrumb">
		<li><a href="{{{ action('HomeController@showHome')}}}">Home</a></li>
		<li class="active">Events</li>
	</ol>

	<div class="row">

		<!-- Article main content -->
		<article class="col-sm-8 maincontent calEvents">
			<header class="page-header">
				<h1 class="page-title">Upcoming Events</h1>
			</header>
			@forelse($calendarEvents as $event)
				<div class="col-md-12">
					<h3>
						<a href="{{{ action('CalendarEventsController@show', $event->id) }}}">{{{$event->title}}}
					</h3>
					<p><img src="http://lorempixel.com/400/400" alt="" class="img-rounded pull-left" width="300" height="200" > {{{ $event->description }}}</p>
					<h5>From: {{{date_create($event->start_dateTime)->format('l, F jS Y @ h:i:s a')}}}</h5>
					<h5>To: {{{date_create($event->end_dateTime)->format('l, F jS Y @ h:i:s a')}}}</h5></a>

				</div>

			@empty
			    <h3>No events found.</h3>
			@endforelse


		</article>
		<!-- /Article -->

		<!-- Sidebar -->
		<aside class="col-sm-4 sidebar sidebar-right">

			<div class="widget">
				<h4>Categories</h4>
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
<div class="loader row text-center">
	<img src='images/loader.gif'>
</div>
<div class="endOfFile row text-center">
	<h3>No more content!</h3>
</div>

@stop

@section('script')
	<script>
		$(document).ready(function(){
			$('.loader').hide();
			$('.endOfFile').hide();
			var load = 0;
			var number = <?php echo $number;?>;
			$(window).scroll(function()
			{
				if($(window).scrollTop() == $(document).height() - $(window).height())
				{
					$('.loader').show();
					load++;
					if(load * 5 > number){
						$('.endOfFile').show();
						$('.loader').hide();
					}else{
						$.post("infinite-scroll/ajax.php",{load:load}, function(data){
							$(".calEvents").append(data);
							$('.loader').hide();
						});
					};
				}
			});
		});
	</script>
@stop