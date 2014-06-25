<?php

class WordpressUserMetaSeeder extends Seeder {
  
  public function run() {
    $this->command->info('- Creating user meta for the admin user');

    $meta = array(
      'first_name' => 'Admin',
      'last_name' => 'Lofti',
      'nickname' => 'admin',
      'description' => '',
      'rich_editing' => 'true',
      'comment_shortcuts' => 'false',
      'admin_color' => 'fresh',
      'use_ssl' => '0',
      'show_admin_bar_front' => 'true',
      'wp_capabilities' => 'a:1:{s:13:"administrator";b:1;}',
      'wp_user_level' => '10',
      'dismissed_wp_pointers' => 'wp350_media,wp360_revisions,wp360_locks,wp390_widgets',
      'show_welcome_panel' => '1',
      'wp_user-settings' => 'editor=html&ed_size=403&libraryContent=browse',
      'wp_user-settings-time' => '1402603053',
      'wp_dashboard_quick_press_last_post_id' => '2'
    );

    foreach($meta as $key=>$value) {
      $um = new WordpressUserMeta;
      $um->user_id = 1;
      $um->meta_key = $key;
      $um->meta_value = $value;
      $um->save();
    }
  }

}
