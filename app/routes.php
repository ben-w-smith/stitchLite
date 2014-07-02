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

// authenticated
Route::group(array('before' => 'auth'), function() {
	Route::group(array('before' => 'csrf'), function() {

	});

	Route::get('stores/create/{name}', array(
		'as' => 'create.store.form',
		'uses' => 'StoreController@getCreateForm'
	));

	Route::get('users/logout', array(
		'as' => 'get.logout',
		'uses' => 'UserController@getLogout'
	));

	Route::get('products/pull', array(
		'as' => 'products.get.pull',
		'uses' => 'PullController@pull'
	));

	Route::get('products/push', array(
		'as' => 'products.get.push',
		'uses' => 'PushController@push'
	));

	Route::resource('products', 'ProductController');

	Route::resource('stores', 'StoreController');
});

// guest
Route::group(array('before' => 'guest'), function() {
	Route::group(array('before' => 'csrf'), function() {
		Route::post('users/index', array(
			'as' => 'users.post.login',
			'uses' => 'UserController@postLogin'
		));
		Route::post('users/create', array(
			'as' => 'users.post.create',
			'uses' => 'UserController@postCreate'
		));
	});

	Route::get('/login', array(
		'as' => 'users.get.login',
		'uses' => 'UserController@getLogin'
	));

	Route::get('users/index', array(
		'as' => 'users.get.login',
		'uses' => 'UserController@getLogin'
	));

	Route::get('users/create', array(
		'as' => 'users.get.create',
		'uses' => 'UserController@getCreate'
	));
});