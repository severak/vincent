<?php
if (!file_exists(__DIR__ . '/config.php')) {
	die("ERROR: Kyselo not installed.");
}
$config = require __DIR__ . '/config.php';

// init framework
require 'lib/flight/Flight.php';
require "lib/flight/autoload.php";

Flight::init();
Flight::set('flight.handle_errors', false);
Flight::set('flight.views.path', __DIR__ . '/lib/views');

// init debugger
require "lib/tracy/src/tracy.php";
use \Tracy\Debugger;
Debugger::enable(!empty($config['show_debug']) ? Debugger::DEVELOPMENT : Debugger::DETECT);
Debugger::$showBar = false;
Debugger::$errorTemplate = __DIR__ . '/lib/views/500.htm';

// global helpers:
Flight::map('rootpath', function() {
	return __DIR__;
});

Flight::map('config', function($property=null) {
	global $config;
	if ($property) {
		return isset($config[$property]) ? $config[$property] : null;
	}
	return $config;
});

Flight::map('user', function($property=null) {
	if (!empty($_SESSION['user'])) {
		if ($property) {
			return $_SESSION['user'][$property];
		}
		return $_SESSION['user'];
	}
	return null;
});

Flight::map('flash', function($msg, $success=true) {
	$_SESSION['flash'][] = ['msg'=>$msg, 'class'=>$success ? 'success' : 'error'];
});

Flight::map('requireLogin', function() {
	if (!Flight::user()) Flight::redirect('/act/login');
});

Flight::map('rows', function() use($config) {
	static $rows = null;
	if (!$rows) {
		$pdo = new PDO('sqlite:' . __DIR__ . '/' .  $config['database'], null, null, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
		$rows = new severak\database\rows($pdo);
	}
	return $rows;
});

Flight::map('notFound', function(){
	Flight::response(false)
            ->status(404)
            ->write(
                file_get_contents(__DIR__ . '/lib/views/404.htm')
            )
            ->send();
});

Flight::map('forbidden', function(){
	Flight::response(false)
            ->status(404)
            ->write(
                file_get_contents(__DIR__ . '/lib/views/403.htm')
            )
            ->send();
});

// routes:

require __DIR__ . '/lib/routes.php';

Flight::start();