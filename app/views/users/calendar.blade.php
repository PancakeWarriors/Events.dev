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

		{{-- {{ $user->calendar_events[0]->title }} --}}

		<div class="row">
			{{-- show message --}}
			@if (Session::has('message'))
			    <div class="alert alert-success">{{{ Session::get('message') }}}</div>
			@endif
			<!-- Profile main content -->
			<article class="col-xs-12 maincontent">
				<header class="page-header">
					<div class="pull-right form-inline">
						<div class="btn-group btn-group-sm">
							<button class="btn btn-primary" data-calendar-nav="prev">Prev</button>
							<button class="btn" data-calendar-nav="today">Today</button>
							<button class="btn btn-primary" data-calendar-nav="next">Next ></button>
						</div>
						<div class="btn-group btn-group-sm">
							<button class="btn btn-default" data-calendar-view="year">Year</button>
							<button class="btn btn-default active" data-calendar-view="month">Month</button>
							<button class="btn btn-default" data-calendar-view="week">Week</button>
							<button class="btn btn-default" data-calendar-view="day">Day</button>
						</div>
					</div>
					{{-- header that changes according to the date/day --}}
					<h3></h3>
				
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
<!--    <script type="text/javascript" src="/vendor/bootstrap-calendar/js/app.js"></script> -->
    <script type="text/javascript">
        "use strict";
        var today = new Date();
		var year = today.getFullYear();
		var month = '0' + (today.getMonth()+1);
		var day = today.getDate();

		var todayFormated = year + '-' + month + '-' + day;
		console.log(todayFormated);

        var options = {
        	events_source: '../../../user/calendarjson',
        	view: 'month',
        	tmpl_path: '/vendor/bootstrap-calendar/tmpls/',
        	tmpl_cache: false,
        	day: todayFormated,
        	onAfterEventsLoad: function(events) {
        		if(!events) {
        			return;
        		}
        		var list = $('#eventlist');
        		list.html('');

        		$.each(events, function(key, val) {
        			$(document.createElement('li'))
        				.html('<a href="' + val.url + '">' + val.title + '</a>')
        				.appendTo(list);
        		});
        	},
        	onAfterViewLoad: function(view) {
        		$('.page-header h3').text(this.getTitle());
        		$('.btn-group button').removeClass('active');
        		$('button[data-calendar-view="' + view + '"]').addClass('active');
        	},
        	classes: {
        		months: {
        			general: 'label'
        		}
        	}
        };

        var calendar = $('#calendar').calendar(options);

        $('.btn-group button[data-calendar-nav]').each(function() {
        	var $this = $(this);
        	$this.click(function() {
        		calendar.navigate($this.data('calendar-nav'));
        	});
        });

        $('.btn-group button[data-calendar-view]').each(function() {
        	var $this = $(this);
        	$this.click(function() {
        		calendar.view($this.data('calendar-view'));
        	});
        });

        $('#first_day').change(function(){
        	var value = $(this).val();
        	value = value.length ? parseInt(value) : null;
        	calendar.setOptions({first_day: value});
        	calendar.view();
        });

        $('#language').change(function(){
        	calendar.setLanguage($(this).val());
        	calendar.view();
        });

        $('#events-in-modal').change(function(){
        	var val = $(this).is(':checked') ? $(this).val() : null;
        	calendar.setOptions({modal: val});
        });
        $('#format-12-hours').change(function(){
        	var val = $(this).is(':checked') ? true : false;
        	calendar.setOptions({format12: val});
        	calendar.view();
        });
        $('#show_wbn').change(function(){
        	var val = $(this).is(':checked') ? true : false;
        	calendar.setOptions({display_week_numbers: val});
        	calendar.view();
        });
        $('#show_wb').change(function(){
        	var val = $(this).is(':checked') ? true : false;
        	calendar.setOptions({weekbox: val});
        	calendar.view();
        });
        $('#events-modal .modal-header, #events-modal .modal-footer').click(function(e){
        	//e.preventDefault();
        	//e.stopPropagation();
        });
    </script>
@stop

