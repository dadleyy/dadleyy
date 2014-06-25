<?php

class BlogPost extends Eloquent {

  protected $table = 'wp_posts';
  protected $guarded = array();
  public $timestamps = false;

  public static function findBySlug($slug) {
    $ret = null;
    foreach(static::all() as $post) {
      $post_slug = $post->getUrlSlug();

      if($slug === $post_slug)
        $ret = $post;
    }
    return $ret;
  }

  public function author() {
    return $this->hasOne('WordpressUser', 'ID', 'post_author');
  }

  public function getUrlSlug() {
    $title = $this->post_title;
    $lower = strtolower($title);
    $chars = preg_replace('/[^\w\s]/', '', $lower);
    return preg_replace('/\s/', '-', $chars);
  }

}

?>
