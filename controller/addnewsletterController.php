<?php 

class addnewsletterController extends Controller{

	function __construct(){
		parent::__construct();
		
		$this->add();
	}

	private function add(){
		$p = $_POST;

		$ok = true;
		if(!filter_var($p['mail'],FILTER_VALIDATE_EMAIL)){
			$ok = false;
			$this->msg['mail'] = [
				'message' => 'L\'adresse mail est incorrect',
				'type' => 'error'
			];
		}else{
			$this->msg['mail'] = [
				'message' => 'Vous vous êtes bien inscrit à la newsletter !',
				'type' => 'success',
				'showCloseButton' => true
			];
		}

		if($ok)	$this->db->insert('contact',['mail' => $p['mail']]);

		$this->redirect('/');
	}

}