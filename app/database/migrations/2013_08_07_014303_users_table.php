<?php

use Illuminate\Database\Migrations\Migration;

class UsersTable extends Migration {

	public function up( ) {
	
	  Schema::create('users', function($table){
      $table->increments('id');
      
      // authentication information
      $table->string('email');
      $table->string('google_id');
      $table->string('image_url');
      $table->string('display_name');
      $table->string('access_token', 2000 );
      
      // user information stuffs
      $table->string('firstname');
      $table->string('lastname');
      
      $table->timestamps( ); 
    });
    
    
	}

	public function down( ) {
	  Schema::dropIfExists('users');
	}

}