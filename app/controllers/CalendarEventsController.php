<?php

class CalendarEventsController extends \BaseController {

	public function __construct()
	{
		parent::__construct();
		$this->beforeFilter('auth', array('except' => array('index', 'show')));
	}

	/**
	 * Display a listing of the resource.
	 * GET /calendarevents
	 *
	 * @return Response
	 */
	public function index()
	{
		$events = CalendarEvent::with('user')->orderBy('updated_at', 'desc')->get();
		return View::make('events.index')->with(['calendarEvents' => $events]);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /calendarevents/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('events.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /calendarevents
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make(Input::all(), CalendarEvent::$rules);
		if($validator->fails()){
			Session::flash('errorMessage', 'Something went wrong, refer to the red text below:');
			Log::info('validator failed', Input::all());
			return Redirect::back()->withInput()->withErrors($validator);
		}else{
			$calendarEvent = new CalendarEvent();
			$calendarEvent->title = Input::get('title');
			$calendarEvent->start_dateTime = Input::get('start_dateTime');
			$calendarEvent->end_dateTime = Input::get('end_dateTime');
			$calendarEvent->description = Input::get('description');
			$calendarEvent->price = Input::get('price');
			$calendarEvent->user_id = Auth::id();
			$calendarEvent->location_id = Input::get('price');
			$calendarEvent->save();
			$tags = explode(",", Input::get('tags'));
			foreach ($tags as $tag) {
				calendarEvent::storeTags($tag,$calendarEvent);
			}
			return Redirect::action('CalendarEventsController@index');
		}
	}

	/**
	 * Display the specified resource.
	 * GET /calendarevents/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if(CalendarEvent::find($id)){		
			$calendarEvent = CalendarEvent::find($id);
			return View::make('events.show')->with('event', $event);
		}else{
			App::abort(404);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /calendarevents/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$event = CalendarEvent::find($id);
		if(Auth::check() && Auth::user()->id === $event->user_id){
			return View::make('events.edit')->with('event', $event);
		}else{
			Session::flash('errorMessage', 'Can not edit a event that is not yours.');
			return View::make('events.show')->with('event', $event);
		}
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /calendarevents/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$validator = Validator::make(Input::all(), Post::$rules);
		if($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}else{
			$event = CalendarEvent::find($id);
			$event->title = Input::get('title');
			$event->start_dateTime = Input::get('start_dateTime');
			$event->end_dateTime = Input::get('end_dateTime');
			$event->description = Input::get('description');
			$event->price = Input::get('price');
			$event->user_id = Auth::id();
			$event->location_id = Input::get('price');
			$event->save();
			$event->tags()->detach();
			$tags = explode(",", Input::get('tags'));
			foreach ($tags as $tag) {
				CalendarEvent::storeTags($tag,$event);
			}
			return Redirect::action('CalendarEventController@show', array($id));
		}
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /calendarevents/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$event = CalendarEvent::find($id);

        if (Request::wantsJson()) {
        	$event->delete();
            return Response::json(array(/* ... */));
        } elseif(Auth::check() && Auth::user()->id === $event->user_id){
			$event->delete();
			return Redirect::action('CalendarEventController@index');
		}else{
			Session::flash('errorMessage', 'Can not delete a event that is not yours.');
			return View::make('events.show')->with('event', $event);
		}
	}
}