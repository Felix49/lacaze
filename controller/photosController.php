<?php

class photosController extends mainController{

	public function __construct($param){
		parent::__construct($param);

		$this->init();

		$this->lunchView('photos');
	}

	private function init(){
		$photos = Tool::getGalleriePhotos(1);
		usort($photos, function($a, $b){
			return date_create_from_format('d/m/Y',$b['date_ajout'])->getTimestamp() - date_create_from_format('d/m/Y',$a['date_ajout'])->getTimestamp();
		});
		$this->view->setData([
			'title' 	=> 'La Caze - Photos',
			'bodyclass'	=> 'photos',
			'photos' 	=> $photos,
			'first' 	=> reset($photos)
			]);
	}

}