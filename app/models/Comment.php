<?php

class Comment extends Eloquent {

	protected $table = 'comments';

  public function decorate( ) {
    $out = array( );
    $author = User::find( $this->user_id );
    $out['comment_id'] = $this->id;
    $out['user'] = $author->decorate( );
    $out['posted'] = $this->created_at;
    $out['comment'] = $this->comment;
    return $out;
  }

}
