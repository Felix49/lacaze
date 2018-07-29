<?php

class mainController extends Controller{

	function __construct($param) {
		parent::__construct( $param );

		$this->init();
	}

	private function init(){
		$ph = Tool::getGalleriePhotos(2);
		$this->view->setData([
			'fonds' => $ph,
		]);
	}


}