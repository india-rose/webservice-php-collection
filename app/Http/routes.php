<?php

Route::get('/', function() {
	return "Welcome on India WS api";
});

Route::group(['prefix' => 'api/v1/'], function(){
	
	// create a new user (no need to auth for this one)
	Route::post('user', 'UserController@store');
	
	Route::group(['prefix' => 'user', 'middleware' => 'auth'], function(){
		// get information about the user
		Route::get('/', 'UserController@show');
		Route::post('edit', 'UserController@update');
		Route::post('delete', 'UserController@destroy');
	});
	
	Route::group(['prefix' => 'settings', 'middleware' => 'auth'], function(){
		Route::post('/', 'SettingsController@store');
		Route::get('/', 'SettingsController@getLast');
		Route::get('/{versionCode}', 'SettingsController@get');
	});
});
