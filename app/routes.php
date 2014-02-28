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

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('login',array('before' => 'allow-options', 'after' => 'allow-cors', function() {
	$credentials = array(
		'email' => Input::get('email', ''),
		'password' => Input::get('password', '')
		);
	$message = new Illuminate\Support\MessageBag();
	if(Auth::attempt($credentials, false, true)) {
		$message->add('login', Auth::user()->getApiKey());
	} else {
		$message->add('error', 'Credenciales no validas');
	}
	return Response::json($message)->setCallback(Input::get('callback'));;
}));

Route::get('register', function() {
	$input = Input::only(array('username', 'email', 'password', 'password_confirmation'));
	$rules = array(
		'username' => 'required|unique:users,username',
		'email' => 'required|email|unique:users,email',
		'password' => 'required|min:6|confirmed'
		);
	$validator = Validator::make($input, $rules);
	if($validator->fails()) {
		$message = array('error' => $validator->messages());
	} else {
		$message = new Illuminate\Support\MessageBag();
		unset($input['password_confirmation']);
		$input['password'] =  Hash::make($input['password']);
		$user = User::create($input);
		$message->add('login', 'success');
	}
	return Response::json($message)->setCallback(Input::get('callback'));
});

Route::group(array('prefix' => 'api/v1', 'before' => 'api-auth'), function() {

	Route::group(array('prefix' => 'groms'), function() {
		Route::model('grom', 'Grom');
		Route::get('/', array(
			'as' => 'groms.index',
			'uses' => 'GromsController@index'
			));
		Route::post('/', array(
			'as' => 'groms.store',
			'uses' => 'GromsController@store'
			));
		Route::get('{grom}.png', array(
			'as' => 'groms.image',
			'uses' => 'GromsController@image'
			));
	});

	Route::model('user', 'User');
	Route::get('user/{user}', array(
		'as' => 'groms.user',
		'uses' => 'GromsController@user'
		));

});