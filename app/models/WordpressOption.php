<?php

class WordpressOption extends Eloquent {

  protected $table = 'wp_options';
  protected $guarded = array();
  public $timestamps = false;

}

?>
