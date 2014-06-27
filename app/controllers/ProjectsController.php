<?php

class ProjectsController extends \BaseController {

  public function index() {
    $projects = LvpressPost::all();
    return Response::json($projects);
	}
	
	public function show($project_id) {
  	return Response::json(array());
	}

}
