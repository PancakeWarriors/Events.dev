@extends('layouts.master')

@section('head')
	<style type="text/css">
        #map-canvas {
            width: 100%;
            height: 400px;
        }
        .tags{
        	background-color: lightyellow;
        	padding: 2px;
        }
    </style>
@stop

@section('content')
{{-- /vagrant/sites/events.dev/app/views/events/show.blade.php --}}
<header id="head" class="secondary"></header>
<!-- container -->
<div class="container">

	<ol class="breadcrumb">
		<li><a href="{{{ action('HomeController@showHome')}}}">Home</a></li>
		<li><a href="{{{ action('CalendarEventsController@index')}}}">Events</a></li>
		<li class="active"><a href="/events/{{{$event->id}}}">{{{ $event->title }}}</a></li>
	</ol>

	<div class="row">

		<!-- Event main content -->
		<article class="col-sm-8 maincontent">
			<header class="page-header">
				<h1 class="page-title"><strong>{{{ $event->title }}}</strong></h1>
			</header>
			<!-- success/error messages -->
		    @if (Session::has('successMessage'))
		        <div class="alert alert-success">{{{ Session::get('successMessage') }}}</div>
		    @endif
		    @if (Session::has('errorMessage'))
		        <div class="alert alert-danger">{{{ Session::get('errorMessage') }}}</div>
		    @endif

		    <!-- Date/Time -->
		    <p><span class="glyphicon glyphicon-time"></span>Updated on  {{{$event->updated_at->setTimezone('America/Chicago')->format('l, F jS Y @ h:i:s a')}}} by {{ $user->first_name }} {{ $user->last_name }}</p>

		    <hr>

		    <!-- Preview Image -->
		    <img class="img-responsive" src="{{{$event->img_url}}}" alt="">

		    <!-- Modal -->
		    <div id="editModal" class="modal fade" role="dialog">
		      <div class="modal-dialog">

		        <!-- Modal content-->
		        <div class="modal-content">
		          <div class="modal-header">
		            <button type="button" class="close" data-dismiss="modal">&times;</button>
		            <h4 class="modal-title">Delete event</h4>
		          </div>
		          <div class="modal-body">
		            <p>Are you sure you want to delete the event titled {{{$event->title}}}?</p>
		          </div>
		          <div class="modal-footer">
		            {{ Form::open(array('action' => array('CalendarEventsController@destroy', $event->id), 'style'=>'display:inline', 'method' => 'DELETE')) }}
		                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		                <button class="btn btn-danger" >Delete</button>
		            {{ Form::close() }}
		          </div>
		        </div>

		      </div>
		    </div>


		    <!-- event description -->
		    <h4>{{{ $event->description }}}</h4>
		    <hr>
		    <p>{{{ $event->body}}}</p>
		    <hr>
			<h5>From: {{{date_create($event->start_dateTime)->format('l, F jS Y @ h:i:s a')}}}</h5>
			<h5>To: {{{date_create($event->end_dateTime)->format('l, F jS Y @ h:i:s a')}}}</h5>
			<h5>Price: ${{{$event->price}}}</h5>
			<div>
				@if(!CalendarEvent::checkAttendance($event->id))
		            {{ Form::open(array('action' => array('CalendarEventsController@attending', $event->id), 'style'=>'display:inline'))}}
						<input type="submit" class="btn btn-default" value="Would you like to attend?">
					{{ Form::close() }}<hr>
				@else
		            {{ Form::open(array('action' => array('CalendarEventsController@cancelAttending', $event->id), 'style'=>'display:inline', 'method' => 'DELETE'))}}
						<input type="submit" class="btn btn-default" value="Attending! Cancel attendance?">
					{{ Form::close() }}<hr>
				@endif
			</div>

		    {{-- tag stuff --}}
		{{--     <p>
		        <strong>Tags:</strong>
		        @foreach ($event->tags as $tagInfo)
		            change href to go to url with this tag id
		            <a href="?tag={{{$tagInfo->id}}}">{{$tagInfo->name}}</a>
		        @endforeach
		    </p> --}}
		    {{-- Check to make sure only author of event sees 'edit' and 'delete' buttons --}}
		    @if ((Auth::check() && Auth::user()->id == $event->user_id) || Auth::id() == 1) 
		        <p>
		            <a class="btn btn-info" href="{{{ action('CalendarEventsController@edit', $event->id) }}}"><span class="glyphicon glyphicon-pencil"></span></a>
		            <!-- Trigger the modal with a button -->
		            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#editModal"><span class="glyphicon glyphicon-trash"></span></button>
		        </p>
		    @endif


		</article>
		<!-- /Article -->

		<!-- Sidebar -->
		<aside class="col-sm-4 sidebar sidebar-right">

			<div class="widget">
				<h4>Categories</h4>
				@forelse($tags as $tag)
					<a href="?t={{$tag->name}}"><span class="tags">{{{$tag->name}}}</span></a>
				@empty
					<h4>No tags found.</h4>
				@endforelse
			</div>
			<h4>Location</h4>
			<!-- div to hold map -->
			<div class="col-sm-12"id="map-canvas"></div>

		</aside>
		<!-- /Sidebar -->

	</div>
	

</div>	<!-- /container -->

@stop
@section('script')

	<!-- Load the Google Maps API [DON'T FORGET TO USE A KEY] -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAc7OOhJbXTc7PTiL57yzMNF2xXpyJl9uw"></script>

	<!-- Script to show address on map -->
	<script type="text/javascript">
	(function() {
		"use strict";
		// Set our address to geocode
		var address = '{{{ $event->location->address }}}, {{{ $event->location->city }}}, {{{ $event->location->state }}} {{{ $event->location->zip }}}';

		// Init geocoder object
		var geocoder = new google.maps.Geocoder();

		// Geocode our address
		geocoder.geocode( { 'address': address}, function(results, status) {
		  // Check for a successful result
		  if (status == google.maps.GeocoderStatus.OK) {
		  // Set our map options
		    var mapOptions = {
		      // Set the zoom level
		      zoom: 16,
		      // This sets the center of the map at our location
		      center: results[0].geometry.location
		    } 
		    //render the map
		    var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
		    //add marker to existing map
		    var marker = new google.maps.Marker({
		    position: results[0].geometry.location,
		    map: map
		    });
		    // Create a new infoWindow object with content
		    var infowindow = new google.maps.InfoWindow({
		      content: '<h4>{{{ $event->location->place }}}</h4>{{{ $event->location->address }}}<br>{{{ $event->location->city }}}, {{{ $event->location->state }}} {{{ $event->location->zip }}}'
		    });
		    // Open the window using our map and marker
		    infowindow.open(map,marker);
		  } else{
		      // Show an error message with the status if our request fails
		      alert("Geocoding was not successful - STATUS: " + status);
		  }
		});
	})();
	</script>
@stop