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

// Route::get('/', function () {
// 	return view('welcome');
// });

Route::get('/image/{id}', 'WebController@showSpherical');
Route::get('/tour/{id}', 'WebController@showTour');

Route::get('/house/full/{id}', 'Fontend\WebController@getFullTourDetail');


// Route::get('/', 'Fontend\WebController@home');

Route::get('/admincp/login', 'Admin\UserController@getLogin');
Route::post('/admincp/login', 'Admin\UserController@postLogin');
Route::get('/admincp/logout', 'Admin\UserController@getLogout');

Route::get('/admincp/top',  [
    'middleware' => 'auth',
    'uses' => 'Admin\TourController@showRecentTour'
]);

Route::get('/admincp/history_request',  [
    'middleware' => 'auth',
    'uses' => 'Admin\TourController@getHistoryRequest'
]);

Route::group(['namespace' => "User"], function(){
	Route::get('/', 'UserController@index');
	Route::get('/contact', 'UserController@contact');
	Route::post('/sendRequest', 'UserController@sendRequest');
	Route::get('/all', 'UserController@allHouse');
	Route::get('/wishlist', 'UserController@wishlist');
	Route::get('/detail/{id}', 'UserController@getHouseDetail');
	Route::post('/search', 'UserController@search');
	Route::post('/contactAgent', 'UserController@contactAgent');
	Route::post('/addWishlist', 'UserController@addWishlist');
	Route::post('/removeWishlist', 'UserController@removeWishlist');
	Route::post('/register', 'UserController@register');
	Route::post('/setPublic', 'UserController@setPublic');
});


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
	Route::post('/upload-plain-photo', 'TourController@uploadPhoto');
	Route::post('/upload-plan-photo', 'TourController@uploadPlan');
	Route::post('/delete-plan-photo', 'TourController@deletePlan');
	Route::post('/check-tour-key', 'TourController@checkTourKey');
	Route::get('/list', 'TourController@showList');
	Route::get('/detail/{id}', 'TourController@getTourDetail');
	Route::get('/edit/{id}', 'TourController@editTour');
	Route::post('/save/{id}', 'TourController@SaveEditTour');
	Route::delete('/delete/{id}', 'TourController@destroy');
	Route::delete('/deleteAll', 'TourController@deleteAllTour');
	Route::get('/stat/{id}','UserController@statistic');

});

Route::group(['middleware' => 'auth', 'prefix' => 'admincp/user', 'namespace' => 'Admin'], function () {
	Route::get('/new', 'UserController@newUser');
	Route::post('/create', 'UserController@createUser');
	Route::get('/list', 'UserController@showList');
	Route::get('/listRequest', 'UserController@showListRequest');
	Route::get('/detail/{id}', 'UserController@getUserDetail');
	Route::get('/detailRequest/{id}', 'UserController@getUserRequestDetail');
	Route::get('/edit/{id}', 'UserController@editUser');
	Route::post('/update', 'UserController@updateUser');
	Route::post('/accept', 'UserController@acceptUser');
	Route::delete('/delete/{id}', 'UserController@destroy');
	Route::delete('/deleteAll', 'UserController@deleteAllUser');
	Route::get('/myaccount','UserController@myAccount');

});

