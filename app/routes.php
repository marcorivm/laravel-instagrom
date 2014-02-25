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

Route::group(array('prefix' => 'api/v1'), function() {

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

});