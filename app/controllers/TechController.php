<?php

class TechController extends \BaseController {

  public function __construct( ){
    $this->beforeFilter('csrf');
  }

  public function index( ) {
    return Response::json(array());
  }

}
