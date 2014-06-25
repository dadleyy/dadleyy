<?php

class WordpressPostSeeder extends Seeder {

  public function run() {
    $this->command->info('- Creating a few wp_posts');

    for($i = 0; $i < 4; $i++) {
      $post_content = File::get(app_path().'/database/wp/example_post-'.$i.'.txt');
      $date_now = new DateTime;
      $post = new BlogPost;
      $post->post_author = 1;
      $post->post_date = $date_now;
      $post->post_date_gmt = $date_now;
      $post->post_content = $post_content;
      $post->post_title = substr($post_content, 10, 20);
      $post->post_status = (int)$i % 2 == 0 ? 'publish' : 'draft';
      $post->post_name = substr($post_content, 10, 20);
      $post->post_modified = $date_now;
      $post->post_modified_gmt = $date_now;
      $post->post_parent = 0;
      $post->guid = 'fakeguidseed-'.$i;
      $post->comment_status = 'open';
      $post->menu_order = 0;
      $post->post_type = 'post';
      $post->comment_count = 0;
      $post->save();
    }
  }

}
