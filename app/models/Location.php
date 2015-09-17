<?php

use \Esensi\Model\Model;

class Location extends Eloquent {
	
	protected $fillable = [];
	protected $table = 'locations';

	public function calendarEvents()
	{
		return $this->hasMany('CalendarEvent');
	}

	public static $rules = array(
		'title' => 'required|max:255',
		'address' => 'required|max:255',
		'city' => 'required|max:255',
		'state' => 'required|max:255',
		'zip' => 'required|max:255',
	);

}