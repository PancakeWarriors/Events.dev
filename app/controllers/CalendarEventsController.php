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
			$events = CalendarEvent::with('user')->orderBy('updated_at', 'desc')->paginate(20);
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
			$calendarEvent = new CalendarEvent();
			$calendarEvent->title = Input::get('title');
			$calendarEvent->start_dateTime = Input::get('start_dateTime');
			$calendarEvent->end_dateTime = Input::get('end_dateTime');
			$calendarEvent->description = Input::get('description');
			$calendarEvent->body = Input::get('body');
			$calendarEvent->price = Input::get('price');
			$calendarEvent->user_id = Auth::id();
			$calendarEvent->location_id = Auth::id();
			if(!empty(basename($_FILES['image_url']['name'])) && empty($errors)) {
			    $uploads_directory = 'images/';
			    $filename = $uploads_directory . basename($_FILES['image_url']['name']);
			    if (move_uploaded_file($_FILES['image_url']['tmp_name'], $filename)) {
			        echo '<p>The file '. basename( $_FILES['image_url']['name']). ' has been uploaded.</p>';
			    } else {
			        echo "Sorry, there was an error uploading your file.";
			    }
				$calendarEvent->image_url = $filename;   
			}else{
				$calendarEvent->image_url = 'images/image.jpeg';   
			}
			$calendarEvent->save();

			$calendarEvent->tag_list = Input::get('tags');

			return Redirect::action('CalendarEventsController@index');
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
			return View::make('events.show')->with(['event' => $event, 'tags' => $tags, 'user' => $user]);
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
		$validator = Validator::make(Input::all(), Post::$rules);
		if($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}else{
			$event = CalendarEvent::find($id);
			$event->id = $id;
			$event->title = Input::get('title');
			$event->start_dateTime = Input::get('start_dateTime');
			$event->end_dateTime = Input::get('end_dateTime');
			$event->description = Input::get('description');
			$event->body = Input::get('body');
			$event->price = Input::get('price');
			$event->user_id = Auth::id();
			$event->location_id = Auth::id();
			$event->save();
			$tags = explode(",", Input::get('tags'));
			foreach ($tags as $tag) {
				CalendarEvent::storeTags($tag,$id);
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