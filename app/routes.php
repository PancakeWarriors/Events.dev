<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@showHome');

Route::get('/signin', 'HomeController@showSignin');




Route::get('/events/{id}', 'CalendarEventsController@show');

Route::resource('/events', 'CalendarEventsController');
