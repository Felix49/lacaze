<?php

class lachambreController extends mainController{

    public function __construct($param){
        parent::__construct($param);
        
        $txts = Tool::getAllTextes();

        $this->view->setData([
            'title' => 'La chambre - camping de la caze',
            'txt' => $txts['la_chambre']
        ]);

		$this->lunchView('chambre');
	}

}
