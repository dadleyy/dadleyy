<?php

class WordpressUserSeeder extends Seeder {

  public function run() {
    $this->command->info('- Creating an admin wp_user');

    $admin = new WordpressUser;
    $admin->user_login = 'admin';
    $admin->user_pass = Hash::make('password');
    $admin->user_nicename = 'admin';
    $admin->user_email = 'admin@lofti.li';
    $admin->user_registered = new DateTime;
    $admin->user_status = 0;
    $admin->display_name = 'admin';
    $admin->save();
  }

}
