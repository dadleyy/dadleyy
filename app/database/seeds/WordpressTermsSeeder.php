<?php

class WordpressTermsSeeder extends Seeder {

  public function run() {
    $this->command->info('- Creating default wp_terms');

    $default_terms = array('uncategorized', 'project', 'blogpost');
    foreach($default_terms as $index=>$term) {
      $wp_term = new LvpressTerm;
      $wp_term->name = ucfirst($term);
      $wp_term->slug = $term;
      $wp_term->save();

      DB::table('wp_term_taxonomy')->insert(array(
        'term_id' => $index + 1,
        'taxonomy' => 'category',
        'description' => ''
      ));
    }
  }

}

?>
