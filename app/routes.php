<?php

Route::any('/home','BaseController@home');
Route::any('/blog','BaseController@home');
Route::any('/blog/{id}','BaseController@home');
Route::any('/b/{id}','BaseController@blogShortcut');
Route::any('/about','BaseController@home');
Route::any('/upgrade','BaseController@upgrade');
Route::any('/whoops', array('as' => 'four_oh_four', 'uses' => 'BaseController@home'));

Route::group(array('prefix' => 'api'), function( ){
  $index_show = array('index', 'show');
  Route::resource('projects', 'ProjectsController', array('only' => $index_show));
  Route::resource('posts', 'BlogController', array('only' => $index_show));
  Route::resource('techs', 'TechController', array('only' => $index_show));
  Route::resource('comments', 'CommentController');
  Route::any('comments/{comment_id}/delete', 'CommentController@destroy');
});

Route::any('/auth', 'AuthController@auth' );
Route::any('/logout', 'AuthController@destroy' );
Route::any('/debug', 'AuthController@debug' );

// force home controller routing
Route::any('/', function( ) { return Redirect::to('/home'); });

App::missing(function($exception){ 
  if(Request::wantsJson())
    return Response::json(array(), 404);
  else
    return Redirect::route('four_oh_four');
});

?>
