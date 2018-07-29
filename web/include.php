<?php

require_once('../plugins/xpertmailer/MAIL.php');
require_once('../controller/mainController.php');

$dir = opendir('../controller');

while($file = readdir($dir)){
	if(preg_match('#\w{1,20}Controller\.php#', $file)){
		require_once('../controller/'.$file);
	}
}

closedir($dir);

$dir = opendir('../model');

while($file = readdir($dir)){
	if(preg_match('#\w{1,20}\.php#', $file)){
		require_once('../model/'.$file);
	}
}

closedir($dir);