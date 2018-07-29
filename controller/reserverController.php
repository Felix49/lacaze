<?php

class reserverController extends mainController{

	private $timeData = [
		'days'      => ['','LUN','MAR','MER','JEU','VEN','SAM','DIM'],
		'month'     => ['Janvier','Février','Mars', 'Avril', 'Mai', 'Juin','Juillet','Aout','Septembre','Octobre','Novembre','Décembre']
	];

	//private $adresse = 'marchenay.felix@gmail.com';
	private $adresse = 'contact@camping-lacaze.fr';

	public function __construct($param){
		parent::__construct($param);

		$this->init();

		$this->lunchView('reserver');
	}

	private function init(){
		$this->createCalendar();
		$this->view->setData([
			'title' 	=> 'La Caze - Réservation et tarifs',
			'bodyclass'	=> 'reserver'
			]);
		$this->createForm('reserver','post','reserver/check');
		$this->form['reserver']->addRow('nom',[
			'type' => 'text',
			'placeholder' => 'Nom',
			'name' => 'nom',
			'label' => 'Nom'
			]);
	}

	private function createCalendar(){
		$today = date_create('now');
		$todayDay = $today->format('N');
		$this->view->setData([
			'dstart' => $todayDay,
			'month'     => $today->format('m'),
			'year'      => $today->format('Y')
		]);
	}

	protected function ACTION_send(){
		$p = $_POST;

        $elec = (isset($p['elec']))?'avec':'sans';

		$mail = new MAIL5();
		$mail->addto($this->adresse);
		$mail->subject('Nouvelle demande de réservation');
		$mail->from($p['mail'],$p['nom']);
		$mail->text('Nouvelle demande de réservations, de '.$p['nom'].'('.$p['mail'].'), DU '.$p['da'].' AU '.$p['dd'].' - '.$p['nb_pers'].' personne(s).');
		$mail->html(utf8_decode(
			'<html>'.
			'<head><style>@import url(http://fonts.googleapis.com/css?family=Roboto:400,500);</style></head>'.
			'<body>'.
			'<h1 style="font-size: 25px; font-weight: 400; font-family : Roboto; background : #089467; margin : 0; padding : 10px; color : #fff;">Nouvelle demande de réservation</h1>'.
			'<div class="body">'.
			'<p>Quelqu\'un a effectué une demande de réservation depuis le site web :</p>'.
			'<p style="font-size: 17px; text-transform : uppercase; ">Nom : <b>'.$p['nom'].'</b></p>'.
			'<p style="font-size: 17px; text-transform : uppercase; ">Du : <b>'.$p['da'].'</b></p>'.
			'<p style="font-size: 17px; text-transform : uppercase; ">Au : <b>'.$p['dd'].'</b></p>'.
			'<p style="font-size: 17px; text-transform : uppercase; ">Nombre d\'emplacements : <b>'.$p['emp'].'</b></p>'.
			'<p style="font-size: 17px; text-transform : uppercase; ">Nombre de chambre : <b>'.$p['room'].'</b></p>'.
			'<p style="font-size: 17px; text-transform : uppercase; ">Nombre de personnes : <b>'.$p['nb_pers'].'</b></p>'.
			'<p style="font-size: 17px; text-transform : uppercase; ">Electricité : <b>'.$elec.'</b></p>'.
			'<p style="font-size: 17px; text-transform : uppercase; ">Adresse : <b>'.$p['mail'].'</b></p>'.
			'</div>'.
		    '</body></html>'
		)
		);
		$s = $mail->send();
		if($s){
			$this->msg['resa'] = [
				'type' => 'success',
				'message' => 'Votre demande a été envoyée ! Nous vous répondrons par mail pour confirmer la réservation.'
			];
		}else{
			$this->msg['resa'] = [
				'type' => 'error',
				'message' => 'Erreur lors de l\'envoi, veuillez réessayer'
			];
		}

		$this->redirect('/reserver');

	}

}