@extends('layouts.master')

@section('content')
{{-- /vagrant/sites/events.dev/app/views/events/show.blade.php --}}
<header id="head" class="secondary"></header>

<!-- container -->
<div class="container">

	<ol class="breadcrumb">
		<li><a href="{{{ action('HomeController@showHome')}}}">Home</a></li>
		<li class="active">Events</li>
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
		    <p><span class="glyphicon glyphicon-time"></span>Updated on  {{{$event->updated_at->setTimezone('America/Chicago')->format('l, F jS Y @ h:i:s a')}}} by {{ $event->user->first_name }} {{ $event->user->last_name }}</p>

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
		            {{ Form::open(array('action' => array('CalendarEventsController@destroy', $event->id, 'style'=>'display:inline;'), 'method' => 'DELETE')) }}
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
			<h5>To: {{{date_create($event->end_dateTime)->format('l, F jS Y @ h:i:s a')}}}</h5></a>

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
		            <a class="btn btn-primary" href="{{{ action('CalendarEventsController@edit', $event->id) }}}"><span class="glyphicon glyphicon-pencil"></span></a>
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