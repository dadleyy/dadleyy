<?php

class WordpressTermTest extends TestCase {

  private $term;

  public function setUp() {
    parent::setUp();
    $this->term = WordpressTerm::find(1);
  }

  public function testTermSelect() {
    $this->assertTrue($this->term->slug == 'uncategorized');
  }

  public function testTaxonomySelect() {
    $taxonomy = $this->term->taxonomy()->first();
    $this->assertTrue($taxonomy->taxonomy === 'category');
  }

  public function testTaxonomyInsert() {
    $taxonomy = new WordpressTermTaxonomy;
    $taxonomy->taxonomy = 'stuff';
    $taxonomy->save();

    $associate = $this->term->taxonomy()->save($taxonomy);

    $select = DB::table('wp_term_taxonomy')
      ->where('term_id', '=', $this->term->term_id)
      ->get();

    $this->assertTrue(count($select) === 2);
  }

  public function tearDown() {
    parent::tearDown();
    $taxonomy = WordpressTermTaxonomy::where('taxonomy', '=', 'stuff')->first();
    if($taxonomy !== null)
      $taxonomy->delete();
  }


}
