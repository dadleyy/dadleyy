<?php

class ProjectsController extends \BaseController {

  public function index() {
    $projects = BlogPost::projects();
    return Response::json($projects);
	}
	
	public function show($project_id) {
  	return Response::json(array());
	}

}
