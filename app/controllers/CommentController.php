<?php

class CommentController extends \BaseController {

  public function index( ) {
    return Response::json(Comment::all( ));
  }

  public function create( ) {
    return Response::json(array( ));
  }

  public function store( ) {
    if( !Auth::check( ) )
      return App::abort(401, 'You don\'t really belong here...');
      
    if( !Input::get('post_id') || !Input::get('comment') )
      return App::abort(401, 'You don\'t really belong here...');
      
    $user = Auth::user( );
    
    $comment = new Comment;
    $comment->user_id = $user->id;
    $comment->comment = Input::get('comment');
    $comment->post_id = Input::get('post_id');
    
    if( Input::get('response_to') )
      $comment->response_to = Input::get('response_to');
    
    $comment->save( );
    
    return Response::json($comment);  
  }

  public function show($id) {
    return Response::json(array('hello'));
  }
  
  public function edit($id) {
    return Response::json(array('hello'));
  }

  public function update($id) {
    return Response::json(array('hello'));
  }

  public function destroy($id = false) {  
    if( !$id ) 
      return App::abort(401, 'You don\'t really belong here...');
    
    $target = Comment::find($id);
    if( !$target || $target->user_id !== Auth::user( )->id )
      return App::abort(401, 'You don\'t really belong here...');    
      
    $target->delete( );
    
    return Response::make('', 204);
  }

}
