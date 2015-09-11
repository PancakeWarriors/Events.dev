<?php

class UsersController extends \BaseController {

	public function showLogin()
	{
		if(Auth::check()){
			return Redirect::action('CalendarEventsController@index');
		}else{
			return View::make('login');
		}
	}

	public function doLogin()
	{
		$email = Input::get('email');
		$password = Input::get('password');

		if(Auth::attempt(array('email' => $email, 'password' => $password))){
			return Redirect::intended('/');
		}else{
			Session::flash('errorMessage', 'Email and password combination failed');
			Log::info('validator failed', Input::all());
			return Redirect::action('UsersController@showLogin');
		}
	}

	public function doLogout()
	{
		Auth::logout();
		Session::flash('successMessage', 'Goodbye!');
		return Redirect::to('/login');
	}

	public function showCreate()
	{
		if(!Auth::check()){
			return View::make('new_user');
		}else{
			return Redirect::action('CalendarEventsController@index');
		}
	}

	public function newUser()
	{
		$validator = Validator::make(Input::all(), User::$rules);
		if($validator->fails()){
			Session::flash('errorMessage', 'Something went wrong, refer to the red text below:');
			Log::info('validator failed', Input::all());
			return Redirect::back()->withInput()->withErrors($validator);
		}else{	
			$user = new User();
			$user->email = Input::get('email');
			$user->password = Input::get('password');
			$user->first_name = Input::get('first_name');
			$user->last_name = Input::get('last_name');
			$user->save();

			$email = Input::get('email');
			$password = Input::get('password');
			Auth::attempt(array('email' => $email, 'password' => $password));
			return Redirect::action('CalendarEventsController@index');
		}
	}

	public function showEdit()
	{
		if(Auth::check()){
			$user = Auth::user();
			return View::make('users.edit')->with('user',$user);
		}else{
			return Redirect::action('CalendarEventsController@index');
		}
	}

	public function editProfile()
	{
		$validator = Validator::make(Input::all(), User::$rules2);
		if($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}else{
			$profile = User::find(Auth::user()->id);
			$profile->first_name = Input::get('first_name');
			$profile->last_name = Input::get('last_name');
			if(!empty(Input::has('email'))){
				$profile->email = Input::get('email');
			}
			if (Hash::check(Input::get('current_password'), Auth::user()->password)){
				$profile->password = Input::get('password');
			}
			$profile->save();
			Session::flash('successMessage', 'Profile Updated!');
			return Redirect::action('CalendarEventsController@index');
		}
	}
}