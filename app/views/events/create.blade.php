@extends('layouts.master')

@section('content')
{{-- /vagrant/sites/events.dev/app/views/events/create.blade.php --}}
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
	<div class="form-group @if($errors->has('title')) has-error @endif">
		<label class="control-label" for="title">Title</label>
		<input type="text" class="form-control" id="title" name="title" value="{{{ Input::old('title') }}}">
	</div>
	<div class="form-group @if($errors->has('start_dateTime')) has-error @endif">
		<label class="control-label" for="start_dateTime">Start date</label>
		<input type="text" class="form-control" id="start_dateTime" name="start_dateTime" value="{{{ Input::old('start_dateTime') }}}">
	</div>
	<div class="form-group @if($errors->has('end_dateTime')) has-error @endif">
		<label class="control-label" for="end_dateTime">End date</label>
		<input type="text" class="form-control" id="end_dateTime" name="end_dateTime" value="{{{ Input::old('end_dateTime') }}}">
	</div>
	<div class="form-group @if($errors->has('description')) has-error @endif">
		<label class="control-label" for="description">Event Description</label>
		<textarea data-provide="markdown" class="form-control" id="description" name="description" rows="20" >{{{ Input::old('description') }}}</textarea>
	</div>
{{-- 	<div class="form-group">
		<label for="tags">Tags</label>
		<input type="text" class="form-control" id="tags" name="tags" value="foo,bar,baz">
	</div> --}}
	{{-- Image Upload --}}
	<div class="form-group">
		<label for="image_url">Event Image</label>
		<input type="file" value="image_url" id="image_url" name="image_url" alt="event picture">
		<p class="help-block">Post picture for event.</p>
	</div>
	<button type="submit" class="btn btn-primary">Submit</button>
	{{-- </form> --}}
	{{ Form::close() }}
{{-- close row --}}
</div>
@stop
@section('script')
<script type="text/javascript" src="/js/bootstrap-markdown.js"></script>
<script type="text/javascript" src="/js/markdown.js"></script>
<script type="text/javascript" src="/js/to-markdown.js"></script>
{{-- fancy tags --}}
<script src="/js/jquery.tagsinput.js"></script>
<script>
	$("#description").markdown({autofocus:false, savable:false});
	// $('#tags').tagsInput();
</script>
@stop