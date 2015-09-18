@extends('layouts.master')

@section('head')
	<style>
		body{
			background-color: #FFF;
		}
		.breadcrumb{
			margin-bottom: 20px;
			background-color: #FFF;
		}
		.footer1{
			background-color: #000;
		}
		#map-canvas {
		    width: 100%;
		    height: 400px;
		}
	</style>
	<link rel="stylesheet" type="text/css" href="/css/datetimepicker.css">
@stop

@section('content')
{{-- /vagrant/sites/events.dev/app/views/events/create.blade.php --}}

<header id="head" class="secondary"></header>
<!-- Blog Entries Column -->
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<ol class="breadcrumb">
				<li><a href="{{{ action('HomeController@showHome')}}}">Home</a></li>
				<li><a href="/events/{{{$event->id}}}">Events</a></li>
				<li class="active">Edit</li>
			</ol>
		</div>
	</div>
	<div class="col-md-12">

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
		{{ Form::open(array('action' => array('CalendarEventsController@update', $event->id ), 'enctype' => "multipart/form-data", 'method' => 'PUT'))  }}
		{{-- <form method="POST" action="{{{action('PostsController@store')}}}"> --}}
		<div class="form-group col-sm-8">
			<label class="control-label" for="title">Title</label>
			<input type="text" class="form-control" id="title" name="title" value="{{{ $event->title }}}">
		</div>
		<div class="form-group col-sm-8">
	        {{ Form::label('start', 'Event Start') }}
	        {{ Form::text('start_dateTime', $event->start_dateTime, ['class' => 'form-control', 'id' => 'start_dateTime', 'readonly','placeholder' =>'Start Date Time'])}}
	    </div>

		<div class="form-group col-sm-8">
	        {{ Form::label('event_end', 'Event End') }}
	        {{ Form::text('end_dateTime', $event->end_dateTime, ['class' => 'form-control', 'id' => 'end_dateTime', 'readonly','placeholder' =>'End Date Time'])}}
	    </div>
		<div class="form-group col-sm-8">
			<label class="control-label" for="description">Event Description</label>
			<textarea data-provide="markdown" class="form-control" id="description" name="description" rows="2" >{{{ $event->description }}}</textarea>
		</div>
		<div class="form-group col-sm-8">
			<label class="control-label" for="body">Event Details</label>
			<textarea data-provide="markdown" class="form-control" id="body" name="body" rows="15" >{{{ $event->body }}}</textarea>
		</div>
		<div class="form-group col-sm-8">
			<label class="control-label" for="price">Event Price</label>
			<div class="input-group">
				<div class="input-group-addon">$</div>
				<input type="number" class="form-control" id="price" name="price" rows="15" value="{{{ $event->price }}}">
			</div>
		</div>
		<div class="form-group col-sm-8">
			{{ Form::label('locationTitle', 'Name of location') }}
			{{ Form::text('place', $event->location->title, ['class' => 'form-control location', 'id' => 'locationTitle']) }}
		</div>
		<div class="form-group col-sm-8">
			{{ Form::label('locationAddress', 'Street number and name') }}
			{{ Form::text('address', $event->location->address, ['class' => 'form-control location', 'id' => 'locationAddress']) }}
		</div>
		<div class="form-group col-sm-8">
			{{ Form::label('locationCity', 'City') }}
			{{ Form::text('city', $event->location->city, ['class' => 'form-control location', 'id' => 'locationCity']) }}
		</div>
		<div class="form-group col-sm-8">
			{{ Form::label('locationState', 'State') }}
			{{ Form::text('state', $event->location->state, ['class' => 'form-control location', 'id' => 'locationState']) }}
		</div>
		<div class="form-group col-sm-8">
			{{ Form::label('locationZip', 'Zip') }}
			{{ Form::text('zip', $event->location->zip, ['class' => 'form-control location', 'id' => 'locationZip']) }}
		</div>
		<div class="form-group col-sm-8">
			<h4>Location</h4>
			<!-- div to hold map -->
			<div class="col-sm-12"id="map-canvas"></div>
		</div>
		<div class="form-group col-sm-8">
			<label for="tags">Tags</label>
			<?php 	$arrays = $event->tags; 
					$oldtags = [];
			?>
			@foreach ($arrays as $array) 
			    <?php $oldtags[] = $array->name;?>
			@endforeach
			<?php $oldtags = implode(',', $oldtags);?>

			<input type="text" name="tags" class="form-control" placeholder="Tags" value="{{$oldtags}}" id="tags">
		</div>
		{{-- Image Upload --}}
		<div class="form-group col-sm-8">
			<label for="image_url">Event Image</label>
			<input type="file" value="image_url" id="image_url" name="image_url" alt="event picture">
			<p class="help-block">Post picture for event.</p>
			<button type="submit" class="btn btn-primary">Submit</button>
		</div>
		{{-- </form> --}}
		{{ Form::close() }}
	{{-- close row --}}
	</div>
</div>
@stop

@section('script')
	<script src="/js/datetimepicker.js"></script>
	<script>
		jQuery('#start_dateTime').datetimepicker();
		jQuery('#end_dateTime').datetimepicker();

		//MAKE BUTTON VAL = TEXT VAL
		$( document ).ready(function() {
			$('#start_display').val($('#start_dateTime').val());
			$('#end_display').val($('#end_dateTime').val());
		});

		$('#start_dateTime').change(function() {
		    $('#start_display').val($(this).val());
		});

		$('#end_dateTime').change(function() {
		    $('#end_display').val($(this).val());
		});
	</script>

	<!-- Load the Google Maps API [DON'T FORGET TO USE A KEY] -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAc7OOhJbXTc7PTiL57yzMNF2xXpyJl9uw"></script>

	<!-- Script to show address on map -->
	<script type="text/javascript">
		"use strict";
		(function() {
			if($('#locationTitle').val() && $('#locationAddress').val() && $('#locationCity').val() && $('#locationState').val() && $('#locationZip').val()){
				var locationTitle = $('#locationTitle').val();
				var locationAddress = $('#locationAddress').val();
				var locationCity = $('#locationCity').val();
				var locationState = $('#locationState').val();
				var locationZip = $('#locationZip').val();

				// Set our address to geocode
				var address = locationAddress+", "+locationCity+", "+locationState+" "+locationZip;

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
				      content: '<h4>'+locationTitle+'</h4>'+locationAddress+'<br>'+locationCity+', '+locationState+' '+locationZip
				    });
				    // Open the window using our map and marker
				    infowindow.open(map,marker);
				  } else{
				      // Show an error message with the status if our request fails
				      alert("Error finding address. Please check your location input fields.");
				  }
				});
			}
			$('.location').change(function(){
				if($('#locationTitle').val() && $('#locationAddress').val() && $('#locationCity').val() && $('#locationState').val() && $('#locationZip').val()){
					var locationTitle = $('#locationTitle').val();
					var locationAddress = $('#locationAddress').val();
					var locationCity = $('#locationCity').val();
					var locationState = $('#locationState').val();
					var locationZip = $('#locationZip').val();

					// Set our address to geocode
					var address = locationAddress+", "+locationCity+", "+locationState+" "+locationZip;

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
					      content: '<h4>'+locationTitle+'</h4>'+locationAddress+'<br>'+locationCity+', '+locationState+' '+locationZip
					    });
					    // Open the window using our map and marker
					    infowindow.open(map,marker);
					  } else{
					      // Show an error message with the status if our request fails
					      alert("Error finding address. Please check your location input fields.");
					  }
					});
				}
			});
		})();
	</script>
@stop