<?php

use \Esensi\Model\Model;

class Locations extends \Model {
	
	protected $fillable = [];
	protected $table = '';

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