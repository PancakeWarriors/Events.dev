<?php

class LocationsController extends \BaseController {

	public static function store()
	{
		$location = new Location();
		$location->place = Input::get('place');
		$location->address = Input::get('address');
		$location->city = Input::get('city');
		$location->state = Input::get('state');
		$location->zip = Input::get('zip');
		$location->save();

	}
}