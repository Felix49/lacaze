<?php

class lecampingController extends mainController{

	private $tpl = 'lecamping';

	public function __construct($param){
		parent::__construct($param);

		$this->init();

		$this->lunchView($this->tpl);
	}

	private function init(){

		$txts = Tool::getAllTextes();

		$this->view->setData([
			'title'     => 'La Caze - Présentation du camping',
			'textes'    => $txts
		]);

	}

}