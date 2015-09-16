@extends('layouts.master')

@section('content')
{{-- /vagrant/sites/events.dev/app/views/events/show.blade.php --}}
<header id="head" class="secondary"></header>

<!-- container -->
<div class="container">

	<ol class="breadcrumb">
		<li><a href="{{{ action('HomeController@showHome')}}}">Home</a></li>
		<li><a href="{{{ action('CalendarEventsController@index')}}}">Events</a></li>
		<li class="active">Event</li>
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
					<a href="?t={{$tag->name}}"><h5>{{{$tag->name}}}</h5></a>
				@empty
					<h4>No tags found.</h4>
				@endforelse
			</div>

		</aside>
		<!-- /Sidebar -->

	</div>
</div>	<!-- /container -->
    
@stop