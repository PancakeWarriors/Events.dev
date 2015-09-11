<?php

class CalendarEventsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /calendarevents
	 *
	 * @return Response
	 */
	public function index()
	{
		$events = CalendarEvent::with('user')->orderBy('updated_at', 'desc');
		return View::make('#.index')->with(['events' => $events]);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /calendarevents/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('#.create');
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
			$calendarEvent->body = Input::get('body');
			$calendarEvent->user_id = Auth::id();
			$calendarEvent->description = Input::get('description');
			$calendarEvent->save();
			$tags = explode(",", Input::get('tags'));
			foreach ($tags as $tag) {
				calendarEvent::storeTags($tag,$calendarEvent);
			}
			return Redirect::action('calendarEventsController@index');
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
		//
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
		//
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
		//
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
		//
	}

}