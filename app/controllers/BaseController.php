<?php

use Illuminate\Routing\Controller;

class BaseController extends Controller {

  protected function setupLayout( ){
    if ( !is_null($this->layout) ){
      $this->layout = View::make($this->layout);
    }
  }
  
  public function blogShortcut($id = 0) {
    return Redirect::to('/blog/'.$id);
  }
  
  // [action]  
  public function home( ){
    return View::make('home.index')->with('title','home');
  }
  
  // [action]
  public function upgrade( ){
    return View::make('home.upgrade')->with('title','uh oh'); 
  }


}
