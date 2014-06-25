<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	protected $table = 'users';

	protected $hidden = array('password');
		
  public function getAuthIdentifier( ) {
    return $this->getKey();
  }
  
  public function decorate( ) {
    $out = array( );
    
    $out['id'] = sha1( $this->id );
    $out['name'] = $this->display_name;
    $out['image_url'] = $this->image_url;
    $out['plus_id'] = $this->google_id;
    
    return $out;
  }
  
  public function getAuthPassword( ) {
    return $this->password;
  }

  public function getReminderEmail( ) {
    return $this->email;
  }

  public function getRememberToken() {
    return "";
  }

  public function setRememberToken($token) {
    return "";
  }

  public function getRememberTokenName() {
    return "";
  }

}
