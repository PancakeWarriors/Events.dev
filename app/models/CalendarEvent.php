<?php

use \Esensi\Model\Model;

class CalendarEvent extends Eloquent {
	protected $fillable = [];
	protected $table = 'calendar_events';

	public function location()
	{
		return $this->belongsTo('Location');
	}
	public function user()
	{
	    return $this->belongsTo('User');
	}
	
	protected $rules = array(
		'start_dateTime' => 'required|max:255',
		'end_dateTime' => 'required|max:255',
		'title' => 'required|max:255',
		'description' => 'required|max:255',
		'price' => 'required|max:255',
	);
}