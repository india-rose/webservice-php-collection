<?php

Route::group(['prefix' => 'api/v1'], function(){
	
	// create a new user
	Route::post('user', 'UserController@store');
	
	Route::group(['prefix' => 'user', 'middleware' => 'auth'], function(){
		// get information about the user
		Route::get('/', 'UserController@show');
		Route::post('edit', 'UserController@update');
		Route::post('delete', 'UserController@destroy');
	});
	
	
});
