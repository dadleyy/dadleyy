<?php

class ProjectsController extends \BaseController {


  public function index() {
    return Response::json();
	}
	
	public function show($project_id) {
  	return Response::json(array());
	}

}
