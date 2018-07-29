<?php

class notFoundController extends mainController{

	public function __construct($param){
		parent::__construct($param);

		$this->view->setData([
			'title'=> 'La Caze - Erreur 404 Page introuvable',
			'path' => $_SERVER['REQUEST_URI'],
			]);

		$this->lunchView('404');
	}

}