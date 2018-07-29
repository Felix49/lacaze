<?php 

class homeController extends mainController{

	function __construct($param){
		parent::__construct($param);

		$this->init();

		$this->lunchView('home');
	}

	private function init(){

		$txts = Tool::getAllTextes();

		$this->view->setData(array(
			'title' => 'Camping de la caze - Accueil',
			'bodyclass' => 'home',
			'textes' => $txts
		));
		
	}

	private function checkPost(){
		$res = true;
	
		return $res;
	}

}
