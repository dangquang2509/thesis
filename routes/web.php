<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
	return view('welcome');
});

Route::get('/image/{id}', 'WebController@showSpherical');
Route::get('/tour/{id}', 'WebController@showTour');

Route::get('/house/full/{id}', 'Fontend\WebController@getFullTourDetail');


Route::get('/', 'Fontend\WebController@home');

Route::get('/login', 'Admin\UserController@getLogin');
Route::post('/login', 'Admin\UserController@postLogin');
Route::get('/logout', 'Admin\UserController@getLogout');
Route::get('/register', 'Admin\UserController@showRegister');

Route::get('/admincp',  [
    'middleware' => 'auth',
    'uses' => 'Admin\TourController@showRecentTour'
]);

Route::group(['middleware' => 'auth', 'prefix' => 'admincp/image', 'namespace' => 'Admin'], function () {
	Route::get('/list', 'ImageController@showList');
	Route::get('/detail/{id}', 'ImageController@getImageDetail');
	Route::get('/new', 'ImageController@newImage');
	Route::post('/create', 'ImageController@createImage');
	Route::get('/edit/{id}', 'ImageController@editImage');
	Route::post('/update', 'ImageController@updateImage');
	Route::delete('/delete/{id}', 'ImageController@destroy');
	Route::delete('/deleteAll', 'ImageController@deleteAllImage');
});

Route::group(['middleware' => 'auth', 'prefix' => 'admincp/house', 'namespace' => 'Admin'], function () {
	Route::get('/new', 'TourController@newTour');
	Route::post('/save', 'TourController@saveNewTour');
	Route::post('/update', 'TourController@updateTour');
	Route::post('/upload-spherical-photo', 'TourController@uploadSpherical');
	Route::post('/upload-plan-photo', 'TourController@uploadPlan');
	Route::post('/delete-plan-photo', 'TourController@deletePlan');
	Route::post('/check-tour-key', 'TourController@checkTourKey');
	Route::get('/list', 'TourController@showList');
	Route::get('/detail/{id}', 'TourController@getTourDetail');
	Route::get('/edit/{id}', 'TourController@editTour');
	Route::post('/save/{id}', 'TourController@SaveEditTour');
	Route::delete('/delete/{id}', 'TourController@destroy');
	Route::delete('/deleteAll', 'TourController@deleteAllTour');
});

Route::group(['middleware' => 'auth', 'prefix' => 'admincp/user', 'namespace' => 'Admin'], function () {
	Route::get('/new', 'UserController@newUser');
	Route::post('/create', 'UserController@createUser');
	Route::get('/list', 'UserController@showList');
	Route::get('/detail/{id}', 'UserController@getUserDetail');
	Route::get('/edit/{id}', 'UserController@editUser');
	Route::post('/update', 'UserController@updateUser');
	Route::delete('/delete/{id}', 'UserController@destroy');
	Route::delete('/deleteAll', 'UserController@deleteAllUser');
});

Route::group(['prefix' => 'user', 'namespace' => "User"], function(){
	Route::get('/home', 'UserController@index');
	Route::get('/contact', 'UserController@contact');
	Route::get('/all', 'UserController@allHouse');
	Route::get('/detail/{id}', 'UserController@getHouseDetail');
});