<?php

ClassLoader::addDirectories(array(
	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
  app_path().'/errors'
));

$logFile = 'log-'.php_sapi_name().'.txt';

Log::useDailyFiles(storage_path().'/logs/'.$logFile);

App::error(function(TokenException $exception, $code) {
  return Response::make('', 401);
});

App::error(function(Exception $exception, $code) { });

App::down(function() {
	return Response::make("Be right back!", 503);
});

require app_path().'/filters.php';
