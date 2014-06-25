<?php

use Illuminate\Database\Migrations\Migration;

class CommentsTable extends Migration {

	public function up( ) {
    Schema::create('comments', function( $table ) {
      $table->increments('id');
      $table->integer('user_id');
      $table->string('comment');
      $table->integer('post_id');
      $table->integer('response_to')->default(null);
      $table->timestamps( );
    });
	}

	public function down( ) {
    Schema::drop('comments');
	}

}