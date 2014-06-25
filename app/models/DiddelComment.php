<?php

class DiddelComment extends Eloquent {

	protected $table = 'comments';

  public function decorate( ) {
    $out = array( );
    $author = User::find( $this->user_id );
    $out['user'] = $author->decorate( );
    $out['posted'] = $this->created_at;
    $out['commment'] = $this->comment;
    return $out;
  }

}