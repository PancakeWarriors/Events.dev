<?php

use \Esensi\Model\Model;

class CalendarEvent extends Model {
	protected $fillable = [];
	protected $table = 'calendar_events';

	public function location()
	{
		return $this->belongsTo('Location');
	}
	public function user()
	{
	    return $this->belongsToMany('User', 'calendar_event_user')->withTimestamps();
	}

	public function tags()
	{
		return $this->belongsToMany('Tag', 'calendar_event_tag')->withTimestamps();
	}
	
	protected $rules = array(
		'start_dateTime' => 'required',
		'end_dateTime' => 'required',
		'title' => 'required|max:50',
		'description' => 'required|max:255',
		'price' => 'required|max:255',
	);

	public static function urlBuilder()
	{
		// $getRequests = Input::except('p');
		// if(isset($getRequests['user'])){
		// 	return "?user=" . $getRequests['user'];
		// }elseif(isset($getRequests['tag'])){
		// 	return "?tag=" . $getRequests['tag'];
		// }elseif(isset($getRequests['search'])){
		// 	return "?search=" . $getRequests['search'];
		// }
	}

	public static function findTag($tag)
	{
		$query = Tag::where('name', '=', $tag)->get();	
		return $query;
	}

	public static function storeTags($tag,$calendarEvent)
	{
		if(CalendarEvent::findTag(trim($tag))->first()){
			$tags = Tag::where('name', '=' , trim($tag));
			$calendarEvent->tags()->attach($tags->first()->id);
		}else{
			$tags = new Tag();
			$tags->name = $tag;
			$calendarEvent->tags()->save($tags);
		}
	}

	public static function checkAttendance($eventId)
	{
		$attendingUsers = DB::select('SELECT * FROM calendar_event_user WHERE calendar_event_id = ?', array($eventId));
		foreach ($attendingUsers as $user) {
			if($user->user_id == Auth::id()){
				return true;
			}
		}
		return false;

	}


}