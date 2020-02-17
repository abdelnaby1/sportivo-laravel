<?php

Route::group(['prefix' => 'api/owner'], function() {
    
	Route::post('login','AuthController@login');
	Route::post('register','AuthController@register');
	Route::group(['middleware' => 'auth:api','role'], function(){

	// Route::get('logout', 'OwnerController@logout');

		Route::get('/places','Owner\OwnerController@getPlaces');
		Route::get('/places/{id}','Owner\OwnerController@getPlace');

	});
});
// Route::group(['prefix' => 'api/owner','middleware' => ['auth.owner','auth:api']], function() {
    
//     Route::get('/', function() {
//         return 'owners';
//  });
//     Route::get('details', 'UserController@details');
// 	Route::get('logout', 'UserController@logout');
// });


// Route::group(['middleware' => ['auth.admin','auth:api']], function() {
