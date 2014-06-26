<?php

class WordpressTerm extends Eloquent {

  protected $table = 'wp_terms';
  protected $guarded = array();
  protected $primaryKey = 'term_id';
  public $timestamps = false;

  public function taxonomy() {
    return $this->hasMany('WordpressTermTaxonomy', 'term_id', 'term_id');
  }

}

?>
