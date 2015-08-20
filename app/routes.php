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

Route::get('/', ['uses' => 'HomeController@hello' , 'as' => 'home']);

Route::group(['prefix' => '/forum'] , function(){


		Route::get('/' , ['uses' => 'ForumController@index' , 'as' => 'forum-home']);
		Route::get('/category/{id}',['uses' => 'ForumController@category', 'as' => 'forum-category']);
		Route::get('/thread/{id}',['uses' => 'ForumController@thread' , 'as' => 'forum-thread']);

	Route::group(['before' => 'admin'] , function(){

		Route::get('/group/{id}/delete',['uses' => 'ForumController@deleteGroup' , 'as' => 'forum-delete-group']);

		Route::group(['before' => 'csrf'] , function(){

			Route::post('/group' , ['uses' => 'ForumController@storeGroup' , 'as' =>'forum-store-group']);
		});

	});

});

Route::group(['before' => 'guest'],function(){

		Route::get('/user/create', ['uses' => 'UserController@getCreate','as' => 'getCreate']);
		Route::get('/user/login',  ['uses' => 'UserController@getLogin','as'  =>'getLogin']);

});	

Route::group(['before' => 'csrf' ] , function(){

	Route::post('/user/create', ['uses' => 'UserController@postCreate', 'as' => 'postCreate']);
	Route::post('/user/login',  ['uses' => 'UserController@postLogin' , 'as' => 'postLogin']);

});

Route::group(['before' => 'auth'] , function(){

	Route::get('/user/logout' , ['uses' => 'UserController@getLogout' , 'as' => 'getLogout']);

});


