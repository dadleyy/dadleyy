<?php

class WordpressUser extends Eloquent {

  protected $table = 'wp_users';
  protected $guarded = array();
  protected $hidden = array('user_pass');
  public $timestamps = false;

}
