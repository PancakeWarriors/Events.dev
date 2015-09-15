@extends('layouts.master')

@section('head')
	<style>
		body{
			background-color: #232323;
		}

	</style>
@stop

@section('content')
{{-- /vagrant/sites/events.dev/app/views/events/create.blade.php --}}

<header id="head" class="secondary"></header>
<!-- Blog Entries Column -->
<div class="row">
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
	<div class="form-group col-sm-8 col-sm-offset-1">
		<label class="control-label" for="title">Title</label>
		<input type="text" class="form-control" id="title" name="title" value="{{{ Input::old('title') }}}">
	</div>
	<div class="form-group col-sm-8 col-sm-offset-1">
		<label class="control-label" for="start_dateTime">Start date</label>
		<input type="date" class="form-control" id="start_date" name="start_date" value="{{{ Input::old('start_dateTime') }}}">
	</div>
	<div class="form-group col-sm-8 col-sm-offset-1">
		<label class="control-label" for="start_dateTime">Start time (hh:mm:AM/PM)</label>
		<input type="time" class="form-control" id="start_time" name="start_time" value="{{{ Input::old('start_dateTime') }}}">
	</div>
	<div class="form-group col-sm-8 col-sm-offset-1">
		<label class="control-label" for="end_dateTime">End date</label>
		<input type="date" class="form-control" id="end_date" name="end_date" value="{{{ Input::old('end_dateTime') }}}">
	</div>
	<div class="form-group col-sm-8 col-sm-offset-1">
		<label class="control-label" for="end_dateTime">End time (hh:mm:AM/PM)</label>
		<input type="time" class="form-control" id="end_time" name="end_time" value="{{{ Input::old('end_dateTime') }}}">
	</div>
	<div class="form-group col-sm-8 col-sm-offset-1">
		<label class="control-label" for="description">Event Description</label>
		<textarea data-provide="markdown" class="form-control" id="description" name="description" rows="20" >{{{ Input::old('description') }}}</textarea>
	</div>
	<div class="form-group col-sm-4 col-sm-offset-1">
		<label for="tags">Tags</label>
		<input type="text" class="form-control" id="tags" name="tags" value="foo,bar,baz">
	</div>
	{{-- Image Upload --}}
	<div class="form-group col-sm-8 col-sm-offset-1">
		<label for="image_url">Event Image</label>
		<input type="file" value="image_url" id="image_url" name="image_url" alt="event picture">
		<p class="help-block">Post picture for event.</p>
		<button type="submit" class="btn btn-primary">Submit</button>
	</div>
	{{-- </form> --}}
	{{ Form::close() }}
{{-- close row --}}
</div>
@stop
