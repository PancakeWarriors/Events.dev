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
		if(Input::has('search')){
			$query = CalendarEvent::with('user');

			$query->whereHas('user', function($q){
				$search = Input::get('search');
				$q->where('title', 'like', "%$search%");
			});
			$events = $query->orderBy('created_at', 'desc')->paginate(4);
			$tags = DB::table('tags')->get();
			return View::make('events.index')->with(array('calendarEvents' => $events, 'tags' => $tags));
		}
		if(Input::has('t')){
			$query = CalendarEvent::with('tags');
			$query->WhereHas('tags', function($q){
				$tag = Input::get('t');
				$q->where('name', '=', "$tag");
			});

			$events = $query->orderBy('updated_at', 'desc')->paginate(20);
			$tags = DB::table('tags')->get();
			return View::make('events.index')->with(['calendarEvents'=> $events, 'tags' => $tags]);
		}else{
			$events = CalendarEvent::with('user')->orderBy('start_dateTime', 'desc')->paginate(20);
			$tags = DB::table('tags')->get();
			return View::make('events.index')->with(['calendarEvents' => $events, 'tags' => $tags]);
		}

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

		$location = DB::table('locations')
			->where('place', '=', Input::get('place'))
			->where('address', '=', Input::get('address'))
			->where('city', '=', Input::get('city'))
			->where('state', '=', Input::get('state'))
			->where('zip', '=', Input::get('zip'));


			$event = new CalendarEvent();
			$event->title = Input::get('title');
			$event->start_dateTime = Input::get('start_dateTime');
			$event->end_dateTime = Input::get('end_dateTime');
			$event->description = Input::get('description');
			$event->body = Input::get('body');
			$event->price = Input::get('price');
			$event->user_id = Auth::id();
			if($location->first()){
				$event->location_id = $location->first()->id;
			}else{
				$location = new Location();
				$location->place = Input::get('place');
				$location->address = Input::get('address');
				$location->city = Input::get('city');
				$location->state = Input::get('state');
				$location->zip = Input::get('zip');
				$location->save();
				$event->location_id = $location->id;
			}
			$event->image_url = 'images/image.jpeg';   

			if (!$event->save()) {
				$errors = $event->getErrors();
			} else {
				$event->tag_list = Input::get('tags');
				
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
			$event = CalendarEvent::find($id);
			$user = User::find(CalendarEvent::find($id)->user_id);
			$tags = DB::table('tags')->get();
			$location = Location::find(CalendarEvent::find($id)->location_id);
			return View::make('events.show')->with(['event' => $event, 'tags' => $tags, 'user' => $user, 'location' => $location]);
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
		if((Auth::check() && Auth::user()->id === $event->user_id) || Auth::id() == 1){
			$user = User::find(CalendarEvent::find($id)->user_id);
			return View::make('events.edit')->with(['event' => $event, 'user' => $user]);
		}else{
			Session::flash('errorMessage', 'Can not edit a event that is not yours.');
			$user = User::find(CalendarEvent::find($id)->user_id);
			$tags = DB::table('tags')->get();
			return View::make('events.show')->with(['event' => $event, 'tags' => $tags, 'user' => $user]);
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

		$event = CalendarEvent::find($id);
		$event->title = Input::get('title');
		$event->start_dateTime = Input::get('start_dateTime');
		$event->end_dateTime = Input::get('end_dateTime');
		$event->description = Input::get('description');
		$event->body = Input::get('body');
		$event->price = Input::get('price');
		$event->user_id = Auth::id();
		$event->location_id = Auth::id();
		$event->save();

		if (!$event->save()) {
			$errors = $event->getErrors();
		} else {
			$tags = DB::table('tags')->get();
			$event->tag_list = Input::get('tags');
			$user = User::find(CalendarEvent::find($id)->user_id);
			return View::make('events.show')->with(['event' => $event, 'tags' => $tags, 'user' => $user]);
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
        } elseif(Auth::check() && Auth::user()->id === $event->user_id || Auth::id() == 1){
			$event->delete();
			return Redirect::action('CalendarEventsController@index');
		}else{
			Session::flash('errorMessage', 'Can not delete a event that is not yours.');
			$user = User::find(CalendarEvent::find($id)->user_id);
			$tags = DB::table('tags')->get();
			return View::make('events.show')->with(['event' => $event, 'tags' => $tags, 'user' => $user]);
		}
	}

	public function attending($eventId)
	{
		$userId = Auth::id();
		DB::insert("INSERT into calendar_event_user (calendar_event_id, user_id) values (?,?)", array($eventId, $userId));
		return Redirect::back();
	}

	public function cancelAttending($eventId)
	{
		$userId = Auth::id();
		DB::delete("DELETE FROM calendar_event_user WHERE calendar_event_id = $eventId AND user_id = $userId");
		return Redirect::back();
	}

}