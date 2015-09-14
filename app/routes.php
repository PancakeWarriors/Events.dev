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

// HOME

Route::get('/', 'HomeController@showHome');

Route::get('/signin', 'UsersController@showLogin');

// USERS

Route::get('login', 'UsersController@showLogin');

Route::post('login', 'UsersController@doLogin');

Route::get('logout', 'UsersController@doLogout');

Route::get('users/{id}', 'UsersController@showUser');

Route::get('users/{id}/calendar', 'UsersController@showCalendar');

Route::get('signup', 'UsersController@showCreate');

Route::post('signup', 'UsersController@newUser');

Route::get('users/{id}/edit', 'UsersController@edit');

Route::post('users/{id}/edit', 'UsersController@editProfile');

// EVENTS

Route::resource('/events', 'CalendarEventsController');
