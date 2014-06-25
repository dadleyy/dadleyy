<?php

App::before(function($request) {  
});


App::after(function($request, $response) {
});

Route::filter('auth', function( ){
  if ( Auth::guest( ) ) 
    return Redirect::guest('login');
});


Route::filter('auth.basic', function( ){
  return Auth::basic( );
});

Route::filter('guest', function( ){
  if ( Auth::check( ) ) 
    return Redirect::to('/');
});

Route::filter('csrf', function($route, $request) {
  $in_token = $request->headers->get('X-CSRF');

  if(!$in_token)
    $in_token = Input::get('_token');

  if($in_token != Session::token())
    throw new TokenException('the session token is invalid ['.$in_token.']');

});
