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
			{{ Form::label('title', 'Title', ['class' => 'control-label']) }}
			{{ Form::text('title', null, ['class' => 'form-control']) }}
		</div>
		<div class="form-group col-sm-8">
	        {{ Form::label('start', 'Event Start') }}
	        {{ Form::text('start_dateTime', null, ['class' => 'form-control', 'id' => 'start_dateTime', 'readonly','placeholder' =>'Start Date Time'])}}
	    </div>

		<div class="form-group col-sm-8">
	        {{ Form::label('event_end', 'Event End') }}
	        {{ Form::text('end_dateTime', null, ['class' => 'form-control', 'id' => 'end_dateTime', 'readonly','placeholder' =>'End Date Time'])}}
	    </div>

		<div class="form-group col-sm-8">
			<label class="control-label" for="description">Event Description</label>
			<textarea data-provide="markdown" class="form-control" id="description" name="description" rows="2" >{{{ Input::old('description') }}}</textarea>
		</div>
		<div class="form-group col-sm-8">
			<label class="control-label" for="body">Event Details</label>
			<textarea data-provide="markdown" class="form-control" id="body" name="body" rows="15" >{{{ Input::old('body') }}}</textarea>
		</div>
		<div class="form-group col-sm-8">
			<label class="control-label" for="price">Event Price</label>
			<div class="input-group">
				<div class="input-group-addon">$</div>
				<input type="number" class="form-control" id="price" name="price" rows="15" >{{{ Input::old('price') }}}
			</div>
		</div>
		<div class="form-group col-sm-8">
			<label for="tags">Tags</label>
			<input type="text" class="form-control" id="tags" name="tags" value="">
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
		$('#start_dateTime').change(function() {
		    $('#start_display').val($(this).val());
		});
		$('#end_dateTime').change(function() {
		    $('#end_display').val($(this).val());
		});
	</script>
@stop
