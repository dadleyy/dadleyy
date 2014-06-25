<?php

class AuthController extends Controller {
  
  public function __construct( ){
    
  }

  // [action]  
  public function debug( ) {
    if( Input::get('danny') )
    	return Response::json( User::all( ) );
    else 
      return Redirect::to('/home');
  }
  
  // [action]  
  public function destroy( ) {
    Auth::logout( );
    return Redirect::to('/home');
  }
  
  // [action]  
  public function auth( ){
          
    if( Input::get('error') )
      return View::make('session.redirect');
    
    if( Input::get('state') !== Session::token( ) || !Input::get('code') )
      return App::abort(401, 'You don\'t really belong here...');
    
    $client = new Google_Client( );
    $client->setClientId('302274971419.apps.googleusercontent.com');
    $client->setClientSecret('lKcbnZXAQ8ut5Pi1-h0VeF_E');
    $client->setRedirectUri('http://dadleyy.com/auth');
    $client->setDeveloperKey('AIzaSyAJt0aJpr4_gGLRAl4HXoXveukrpdreN8U');
    $oauth2 = new Google_Oauth2Service( $client );
    $plus = new Google_PlusService( $client );
    $access_token = false;
    
    if( Input::get('code') ) {
    	$client->authenticate( Input::get('code') );
    	$access_token = $client->getAccessToken( );
    } else {
      return App::abort(401, 'You don\'t really belong here...');
    }
    
    $g_user = $oauth2->userinfo->get( );
    $p_user = $plus->people->get('me');
    
    // get all necessary information
    $email = $g_user['email'];
    $google_id = $p_user['id'];
    $google_name = $p_user['name'];
    $firstname = $google_name['givenName'];
    $lastname = $google_name['familyName'];
    $displayname = $p_user['displayName'];
    $image_url = '';
    if( array_key_exists('image', $p_user ) )
      $image_url = $p_user['image']['url'];

    $existing = User::where( 'google_id', '=', $google_id )->first( );
    if( $existing !== null ){
      $existing->access_token = $access_token;
      $existing->save( );
      Auth::login( $existing );
      return View::make('session.redirect')->with('title','session')->with('success',true);
    }
    
    $user = new User;
    $user->email = $email;
    $user->access_token = $access_token;
    $user->google_id = $google_id;
    $user->firstname = $firstname;
    $user->lastname = $lastname;
    $user->image_url = $image_url;
    $user->display_name = $displayname;
    $user->save( );
    
    return View::make('session.redirect')->with('title','session')->with('success',true);
    
  }

}
