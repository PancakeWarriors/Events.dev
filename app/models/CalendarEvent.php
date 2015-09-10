<?php

use \Esensi\Model\Model;

class CalendarEvent extends Model {
	protected $fillable = [];
	protected $table = 'calendar_events';

	public function calendarEvents()
	{
		return $this->belongsTo('Location');
	}
	
	public static $rules = array(
		'start_dateTime' => 'required|max:255',
		'end_dateTime' => 'required|max:255',
		'title' => 'required|max:255',
		'description' => 'required|max:255',
		'price' => 'required|max:255',
	);
}