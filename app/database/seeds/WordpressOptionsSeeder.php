<?php

class WordpressOptionsSeeder extends Seeder {

  public function run() {
    $this->command->info('- Filling in the wp_options');

    $roles = File::get(app_path().'/database/wp/user_roles.txt');

    $options = array(
      'siteurl' => 'http://admin.lofti.local',
      'home' => 'http://admin.lofti.local',
      'blogname' => 'My Site',
      'blogdescription' => 'Just another WordPress site',
      'users_can_register' => 0,
      'admin_email' => 'you@example.com',
      'start_of_week' => '1',
      'use_balanceTags' => 0,
      'use_smilies' => 1,
      'require_name_email' => 1,
      'comments_notify' => 1,
      'posts_per_rss' => 10,
      'rss_use_excerpt' => 0,
      'mailserver_url' => 'mail.example.com',
      'mailserver_login' => 'login@example.com',
      'mailserver_pass' => 'password',
      'mailserver_port' => 110,
      'default_category' => 1,
      'default_comment_status' => 'open',
      'default_ping_status' => 'open',
      'default_pingback_flag' => 1,
      'posts_per_page' => 10,
      'date_format' => 'F j, Y',
      'time_format' => 'g:i a',
      'links_updated_date_format' => 'F j, Y g:i a',
      'comment_moderation' => 0,
      'moderation_notify' => 1,
      'permalink_structure' => '',
      'gzipcompression' => 0,
      'hack_file' => 0,
      'blog_charset' => 'UTF-8',
      'moderation_keys' => '',
      'active_plugins' => '',
      'category_base' => '',
      'ping_sites' => 'http://rpc.pingomatic.com/',
      'advanced_edit' => 0,
      'comment_max_links' => 2,
      'gmt_offset' => 0,
      'default_email_category' => 1,
      'recently_edited' => '',
      'template' => 'twentyfourteen',
      'stylesheet' => 'twentyfourteen',
      'comment_whitelist' => 1,
      'blacklist_keys' => '',
      'comment_registration' => 0,
      'html_type' => 'text/html',
      'use_trackback' => 0,
      'default_role' => 'subscriber',
      'db_version' => '27916',
      'uploads_use_yearmonth_folders' => '1',
      'upload_path' => '',
      'blog_public' => '1',
      'default_link_category' => 2,
      'show_on_front' => 'posts',
      'tag_base' => '',
      'avatar_rating' => 'G',
      'upload_url_path' => '',
      'thumbnail_size_w' => 150,
      'thumbnail_size_h' => 150,
      'thumbnail_crop' => 1,
      'medium_size_w' => 300,
      'medium_size_h' => 300,
      'avatar_default' => 'mystery',
      'large_size_w' => 1024,
      'large_size_h' => 1024,
      'image_default_link_type' => 'file',
      'image_default_size' => '',
      'image_default_align' => '',
      'close_comments_for_old_posts' => 0,
      'close_comments_days_old' => 14,
      'thread_comments' => 1,
      'thread_comments_depth' => 5,
      'page_comments' => 0,
      'comments_per_page' => 50,
      'default_comments_page' => 'newest',
      'comment_order' => 'asc',
      'widget_categories' => '',
      'widget_text' => '',
      'widget_rss' => '',
      'uninstall_plugins' => '',
      'timezone_string' => '',
      'page_for_posts' => 0,
      'page_on_front' => 0,
      'default_post_format' => 0,
      'link_manager_enabled' => 0,
      'wp_user_roles' => $roles
    );

    foreach($options as $key=>$value) {
      $opt = new WordpressOption;
      $opt->autoload = 'yes';
      $opt->option_name = $key;
      $opt->option_value = $value;
      $opt->save();
    }

  }

}
