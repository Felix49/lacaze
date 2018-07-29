<?php

class alentoursController extends mainController{

	private $tpl = 'alentours';
	private $spots;

	public function __construct($param){
		parent::__construct($param);

		$this->init();

		$this->lunchView($this->tpl);
	}

	private function init(){
		$this->spots = Tool::getAlentoursSpots();

		$this->view->setData([
			'title' 	=> 'La Caze - Aux alentours, découvrez la région',
			'bodyclass'	=> 'alentours',
			'spots' => $this->spots,
			'categories' => Tool::getAlentoursCategories()
			]);
	}

	public function ACTION_details(){

		$id = $this->value;

		$this->tpl = 'alentours_details';
		
		$this->view->setData(['le_spot' => Tool::getAlentoursSpotById($id)]);

	}

}