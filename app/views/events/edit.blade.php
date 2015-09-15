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

	</style>
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
				<li><a href="{{{ action('CalendarEventsController@show')}}}">Events</a></li>
				<li class="active">Create</li>
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
		{{ Form::open(array('action' => 'CalendarEventsController@store', 'enctype' => "multipart/form-data")) }}
		{{-- <form method="POST" action="{{{action('PostsController@store')}}}"> --}}
		<div class="form-group col-sm-8">
			<label class="control-label" for="title">Title</label>
			<input type="text" class="form-control" id="title" name="title" value="{{{ $event->title }}}">
		</div>
		<div class="form-group col-sm-8">
			<label class="control-label" for="start_dateTime">Start date</label>
			<input type="date" class="form-control" id="start_date" name="start_date" value="{{{ $event->start_date }}}">
		</div>
		<div class="form-group col-sm-8">
			<label class="control-label" for="start_dateTime">Start time (hh:mm:AM/PM)</label>
			<input type="time" class="form-control" id="start_time" name="start_time" value="{{{ $event->start_time }}}">
		</div>
		<div class="form-group col-sm-8">
			<label class="control-label" for="end_dateTime">End date</label>
			<input type="date" class="form-control" id="end_date" name="end_date" value="{{{ $event->end_date }}}">
		</div>
		<div class="form-group col-sm-8">
			<label class="control-label" for="end_dateTime">End time (hh:mm:AM/PM)</label>
			<input type="time" class="form-control" id="end_time" name="end_time" value="{{{ $event->end_time }}}">
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
			<input type="number" class="form-control" id="price" name="price" rows="15" value="{{{ $event->price }}}">
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
