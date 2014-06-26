<?php

class WordpressTermTaxonomy extends Eloquent {
  
  protected $table = 'wp_term_taxonomy';
  protected $guarded = array();
  public $timestamps = false;
  protected $primaryKey = 'term_taxonomy_id';



}


?>
