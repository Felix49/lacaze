<?php

class photosgallerieController extends Controller{

	public function __construct(){
		parent::__construct();

		$this->init();

		$this->lunchView('photos');
	}

	private function init(){
		$photos = Tool::getGalleriePhotos();
		$this->view->setData([
			'title' 	=> 'La Caze - Photos',
			'bodyclass'	=> 'photos',
			'photos' 	=> $photos,
			'first' 	=> reset($photos)
			]);
	}

}