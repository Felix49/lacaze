<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
define('ROOT', preg_replace('#[\\\/]web#', '', dirname(__FILE__)));
define('WEBROOT', '');
define('WEB', WEBROOT.'/web');
ini_set("display_errors",1);
error_reporting(-1);
date_default_timezone_set('Europe/Paris');
header('Access-Control-Allow-Origin: *');

include('../CORE/Core.php');
include('include.php');

// Core initialization with array of options
$core = new Core([
	'db' 	=> true,
	'base'	=> ''
	]);

$core->start();
