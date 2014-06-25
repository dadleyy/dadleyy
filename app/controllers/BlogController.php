<?php

class BlogController extends \BaseController {

  public function index() {
    $posts = BlogPost::all();
    return Response::json($posts);
  }
  
  public function show($post_id) {
    return Response::make('',404);
  }

}
