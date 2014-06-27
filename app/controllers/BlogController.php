<?php

class BlogController extends \BaseController {

  public function index() {
    $posts = LvpressPost::all();
    $out = array();
    foreach($posts as $post) {
      $out[] = array(
        "ID" => $post->ID,
        "post_date" => strtotime($post->post_date) * 1000,
        "post_title" => $post->post_title,
        "post_content" => $post->post_content,
        "author" => $post->author()
      );
    }
    return Response::json($out);
  }
  
  public function show($post_id) {
    return Response::make('',404);
  }

}
