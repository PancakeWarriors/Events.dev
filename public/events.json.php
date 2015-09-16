<?php

public function showEventsJson()
{

	$out = array();
	//grab all the events the user is going to and put in correct format
	 foreach(Auth::user()->calendar_events as $event){ 
	    $out[] = array(
	        'id' => $event->id,
	        'title' => $event->title,
	        'url' => "http://events.dev/events/" . $event->id,
	        'class' => 'event-important',
	        'start' => strtotime($event->start_dateTime).'000',
	        'end' => strtotime($event->end_dateTime).'000'
	    );
	}

	return Response::view(json_encode(array('success' => 1, 'result' => $out));
		// json_encode(array('success' => 1, 'result' => $out
	exit;
}

?>