<?php

class UsersController extends \BaseController {

	public function showLogin()
	{
		if(Auth::check()){
			return Redirect::action('CalendarEventsController@index');
		}else{
			return View::make('users.signin');
		}
	}

	public function doLogin()
	{
		$email = Input::get('email');
		$password = Input::get('password');

		if(Auth::attempt(array('email' => $email, 'password' => $password))){
			return Redirect::intended('/');
		}else{
			Session::flash('errorMessage', 'Email and password combination failed.');
			Log::info('validator failed', Input::all());
			return Redirect::action('UsersController@showLogin');
		}
	}

	public function doLogout()
	{
		Auth::logout();
		Session::flash('successMessage', 'Goodbye!');
		return View::make('users.signin');
	}

	public function showCreate()
	{
		if(!Auth::check()){
			return View::make('users.create');
		}else{
			return Redirect::action('CalendarEventsController@index');
		}
	}
	// FOR ELOQUENT
	// public function newUser()
	// {
	// 	$validator = Validator::make(Input::all(), User::$rules);
	// 	if($validator->fails()){
	// 		Session::flash('errorMessage', 'Something went wrong, refer to the red text below:');
	// 		Log::info('validator failed', Input::all());
	// 		return Redirect::back()->withInput()->withErrors($validator);
	// 	}else{	
	// 		$user = new User();
	// 		$user->email = Input::get('email');
	// 		$user->password = Input::get('password');
	// 		$user->first_name = Input::get('first_name');
	// 		$user->last_name = Input::get('last_name');
	// 		$user->save();

	// 		$email = Input::get('email');
	// 		$password = Input::get('password');
	// 		Auth::attempt(array('email' => $email, 'password' => $password));
	// 		return Redirect::action('UsersController@showUser');
	// 	}

	// FOR ESENSI
	public function newUser()
	{
		$user = new User();

		// populate the model with the form data
		$user->email = Input::get('email');
		$user->password = Input::get('password');
		$user->first_name = Input::get('first_name');
		$user->last_name = Input::get('last_name');

		if (!$user->save()) {
		     $errors = $user->getErrors();
		     return Redirect::action('UsersController@showCreate')
		       ->with('errors', $errors)
		       ->withInput();
		}

		   // success!
			$email = Input::get('email');
			$password = Input::get('password');
			Auth::attempt(array('email' => $email, 'password' => $password));
		    return Redirect::action('UsersController@showUser', Auth::id())->with('message', 'Account with email of ' . $user->email . ' has been created!');
		
	 }

	public function showUser($id)
	{
		if(User::find($id)){
			$user = User::find($id);
			return View::make('users.show')->with('user', $user);
		}else{
			App::abort(404);
		}
	}

	public function showCalendar($id)
	{
		if(Auth::id() == $id){
			$user = Auth::user();
			return View::make('users.calendar')->with('user',$user);
		}else{
			return Redirect::action('CalendarEventsController@index');
		}
	}

	public function edit($id)
	{
		if(Auth::id() == $id){
			$user = Auth::user();
			return View::make('users.edit')->with('user',$user);
		}else{
			return Redirect::action('CalendarEventsController@index');
		}
	}

	public function editProfile()
	{
		//check if they used correct current password before allowing edits
		if (Hash::check(Input::get('current_password'), Auth::user()->password))
		{
			$user = User::find(Auth::user()->id);
			$user->first_name = Input::get('first_name');
			$user->last_name = Input::get('last_name');
			$user->email = Input::get('email');
			$user->password = Input::get('password');

			if (!$user->save()) {
			     $errors = $user->getErrors();
			     return Redirect::action('UsersController@edit', Auth::id())->with('errors', $errors)->withInput();
			}

		    // success!
			$email = Input::get('email');
			$password = Input::get('password');
			Auth::attempt(array('email' => $email, 'password' => $password));
		    return Redirect::action('UsersController@showUser', Auth::id())->with('message', 'Account with email of ' . $user->email . ' has been succesfully edited!');
		}else{
			// current password didn't match database
			return Redirect::action('UsersController@edit', Auth::id())->with('errorMessage', 'Current password was incorrect.');
		}
	}
}