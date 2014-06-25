<?php

class WordpressTermsSeeder extends Seeder {

  public function run() {
    $this->command->info('- Creating default wp_terms');

    $uncat = new WordpressTerm;
    $uncat->name = "Uncategorized";
    $uncat->slug = "uncategorized";
    $uncat->save();

    DB::table('wp_term_taxonomy')->insert(array(
      'term_id' => 1,
      'taxonomy' => 'category',
      'description' => ''
    ));

  }

}

?>
