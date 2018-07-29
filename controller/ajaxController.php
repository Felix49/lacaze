<?php

class ajaxController extends Controller {

	function __construct($param){
		parent::__construct($param);
	}

	private function renderJSON($data,$die = true){
		header('Content-type: application/json');
		echo json_encode($data);
		if( $die ) die();
	}

	protected function ACTION_getcalendar(){
		Tool::renderCalendar($_POST['month'], $_POST['year']);
		die();
	}

}