<?php

class AdminController extends BaseController {

  public function debug() {
    $logdir_path = storage_path().'/logs';
    $logdir_contents = scandir($logdir_path);
    $log = "";
    foreach($logdir_contents as $logdir_item) {
      if(File::extension($logdir_item) === 'log') {
        $log .= File::get($logdir_path.'/'.$logdir_item);
      }
    }
    return View::make('admin.debug')->with('log', $log);
  }

}

?>
