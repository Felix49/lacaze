<?php

class contactController extends mainController{

	function __construct($param){
		parent::__construct($param);

		$this->init();

		$this->lunchView('contact');
	}

	private function init(){

		$this->view->setData([
			'title' => 'La Caze - Contact'
			]);

	}

	protected function ACTION_send(){
		if(empty($_POST)) $this->redirect('/contact');
		$p = $_POST;

//		$adresse = 'marchenay.felix@gmail.com';
		$adresse = 'contact@camping-lacaze.fr';

		if(!filter_var($p['mail'],FILTER_VALIDATE_EMAIL)) $this->errors['mail'] = 'Adresse mail incorrecte';

		if(strlen($p['nom']) <= 1) $this->errors['nom'] = 'Nom incorrect';

		if(strlen($p['content']) < 3) $this->errors['content'] = 'Le message doit faire au moins 3 caractères';

		if(empty($this->errors)){
			$m = new MAIL5();
			$m->addto($adresse);
			$m->from($p['mail'], $p['nom']);
			$m->subject('Message depuis camping-lacaze.fr');
			$m->text($p['content']);
			$m->addheader('charset', 'iso-8859-1');
			$m->html(utf8_decode('<h3>E-mail reçu depuis le site www.camping-lacaze.fr , de '.$p['nom'].' ('.$p['mail'].')</h3>').
				'<p>'.
					utf8_decode($p['content'])
				.'</p>');
			$s = $m->send();
			if($s){
				$this->msg['mail'] = [
					'message'       => 'Message envoyé avec succès',
					'type'          => 'success'
				];
			}else{
				$this->msg['mail'] = [
					'message'       => 'Erreur lors de l\'envoi du message',
					'type'          => 'error'
				];
			}
			$this->redirect('/contact');
		}else{
			$this->msg['mail'] = [
				'message'       => 'Erreur : '.implode(' / ',$this->errors),
				'type'          => 'error'
			];
			$this->redirect('/contact');
		}
	}

}