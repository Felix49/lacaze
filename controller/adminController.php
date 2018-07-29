<?php

function getFirstprofileId(&$analytics) {
	// Get the user's first view (profile) ID.

	// Get the list of accounts for the authorized user.
	$accounts = $analytics->management_accounts->listManagementAccounts();
Tool::log($accounts);
	if (count($accounts->getItems()) > 0) {
//		Tool::log($items,false);
		$items = $accounts->getItems();
		$firstAccountId = $items[0]->getId();

		// Get the list of properties for the authorized user.
		$properties = $analytics->management_webproperties
			->listManagementWebproperties($firstAccountId);

		if (count($properties->getItems()) > 0) {
			$items = $properties->getItems();
			$firstPropertyId = $items[0]->getId();

			// Get the list of views (profiles) for the authorized user.
			$profiles = $analytics->management_profiles
				->listManagementProfiles($firstAccountId, $firstPropertyId);

			if (count($profiles->getItems()) > 0) {
				$items = $profiles->getItems();
				// Return the first view (profile) ID.
				return $items[0]->getId();

			} else {
				throw new Exception('No views (profiles) found for this user.');
			}
		} else {
			throw new Exception('No properties found for this user.');
		}
	} else {
		throw new Exception('No accounts found for this user.');
	}
}

function getResults(&$analytics, $profileId) {
	// Calls the Core Reporting API and queries for the number of sessions
	// for the last seven days.
	return $analytics->data_ga->get(
		'ga:' . $profileId,
		'7daysAgo',
		'today',
		'ga:sessions');
}

if (!function_exists('getallheaders'))
{
	function getallheaders()
	{
		foreach ($_SERVER as $name => $value)
		{
			if (substr($name, 0, 5) == 'HTTP_')
			{
				$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
			}
		}
		return $headers;
	}
}

class adminController extends Controller{
	
	protected $user;
	protected $tab = '';

	function __construct($param){
		parent::__construct($param);

		if($this->checkPostConnection()){
			$_SESSION['user'] = $this->user;
		}

		if($this->checkConnexion()){
			$this->initTab();
			$vv = 'admin/home';
		}else{
			$vv = 'admin/connexion';
		}

		$this->init();
		$this->lunchView($vv,'admin/main');
	}

	protected function init(){

		$res = Tool::getAllReservations();
		krsort($res);

		$types = $this->db->select('nom, id','typebien');

		$nms = array();
		$clname = $this->db->select('*', 'client',null,'',false);
//        Tool::log($clname,false);
		foreach ($clname as $key => $cl) {
//            Tool::log($cl,false);
			array_push($nms, '{value : \''.$cl['id'].' - '.$cl['prenom'].' '.$cl['nom'].'\', label : \''.$cl['id'].' - '.$cl['prenom'].' '.$cl['nom'].' / '.$cl['mail'].'\'}');
		}

		$this->view->setData(array(
			'title' 			=> 'Camping de la caze - Back office',
			'bodyclass' 		=> 'admin',
			'few_reservations' 	=> array_slice($res, 0, 4,true),
			'reservations' 		=> $res,
			'typebien' 			=> $types,
			'clientsname' 		=> $nms
		));

		if($this->checkConnexion()){
			$this->view->setData(array(
				'user' => $_SESSION['user']
			));
		}

		if(!empty($_SESSION['notif'])){
			$all_nt = array();
			foreach ($_SESSION['notif'] as $key => $nt) {
				array_push($all_nt, ['type' => $nt['type'], 'message' => $nt['message']]);
			}
		}
	}

	protected function checkPostConnection(){
		if(isset($_POST['hid'])){

			$res = true;

			$p = $_POST;

			if(strlen($p['name']) < 1
				|| strlen($p['name']) > 60){
				$res = false;
				$this->errors['name'] = 'Nom incorrect';		
			}else $name = $p['name'];

			if(strlen($p['pw']) < 1
				|| strlen($p['pw']) > 60){
				$res = false;
				$this->errors['pw'] = 'Mot de passe incorrect';		
			}else $pw = $p['pw'];

			if(empty($this->errors)){
				$results = $this->db->count('user',array('nom' => $name, 'password' => sha1($pw)));

				if($results == 1){
					$temp = $this->db->select('*','user',array(
						'nom' => $name,
						'password' => sha1($pw)
						));
					$this->user = $temp;

					return true;
				}else{
					$this->errors['account'] = 'Le mot de passe ne correspond pas au nom d\'utilisateur';
				}
			}else return $res;

		}else return false;

		return false;
	}

	protected function checkConnexion(){
		$res = false;

		if(!empty($_SESSION['user'])){
			$res = true;
		}

		return $res;
	}

	protected function initTab(){

		if(isset($this->action)){
			if($this->tab == ''){
				$tab = $this->action;
			}else{
				$tab = $this->tab;
			}
		}else $tab = 'home';

		$this->view->setData(array(
			'tab' => 'tab/'.$tab.'.tab.php'
			));
	}

	private function getAlentoursForm(){
		$cat = Tool::getAlentoursCategories();
		$optionscat = array();
		foreach ($cat as $id => $nom) {
			array_push($optionscat, ['value' => $id, 'text' => $nom, 'selected' => null]);
		}

		$this->createForm('spots','post','/admin/addspot','multipart/form-data');

		$this->form['spots']->addRow('spots',[
			'type' 	=> 'text',
			'label'	=> 'Nom',
			'name' => 'nom'
		]);
		$this->form['spots']->addRow('cat',[
			'type' => 'select',
			'option' => $optionscat,
			'name' => 'categorie',
			'label' => 'Catégorie'
		]);
		$this->form['spots']->addRow('desc',[
			'type' => 'trumbowyg',
			'label' => 'Description',
			'name'	=> 'description',
		]);
		$this->form['spots']->addRow('image',[
			'type' => 'file',
			'label' => 'Image',
			'name' => 'image',
		]);
		$this->form['spots']->addRow('h3',[
			'rough'     => true,
			'content'   => '<h3>Géolocalisation</h3>'
		]);
		$this->form['spots']->addRow('latitude',[
			'label'     => 'Latitude',
			'input-shape'   => 'line-double'
		]);
		$this->form['spots']->addRow('longitude',[
			'label'     => 'Longitude',
			'input-shape'   => 'line-double'
		]);
		$this->form['spots']->addRow('clear',[
			'rough'     => true,
			'content'   => '<div class="clear"></div>'
		]);
		$this->form['spots']->addRow('km',[
			'label'     => 'Km',
			'input-shape'   => 'line-double'
		]);
		$this->form['spots']->addRow('minute',[
			'label'     => 'Min',
			'input-shape'   => 'line-double'
		]);
		$this->form['spots']->addRow('clear2',[
			'rough'     => true,
			'content'   => '<div class="clear"></div>'
		]);
		$this->form['spots']->addRow('map',[
			'rough'     => true,
			'content'   => '<p>Clic droit pour placer le repère</p><p><input name="mapsearch" placeholder="Recherche une ville, un lieu, une place ..." type="text"/><button id="mapsearch">Rechercher</button></p><div id="map"></div>'
		]);
		$this->form['spots']->addRow('sub',[
			'class' => 'btn',
			'type' => 'submit',
			'value' => 'Valider',
			'label' => false
		]);
	}

	/*****************************************************************/
	// *
	// *	
	// *
	// *						ACTION 		
	// *
	// *		
	/****************************************************************/

	protected function ACTION_clients(){

		$cl = Tool::getAllClients();

		$this->view->setData([
			'clients'		=> $cl,
			'nb_clients'	=> sizeof($cl)
        ]);

		$this->createForm('newclient','post','addclient');
		$this->form['newclient']->addRow('nom',[
			'type' => 'text',
			'placeholder' => 'Nom',
			'name' => 'nom',
			'label' => 'Nom'
			]);
		$this->form['newclient']->addRow('prenom',[
			'type' => 'text',
			'placeholder' => 'Prénom',
			'name' => 'prenom',
			'label' => 'Prénom'
			]);
		$this->form['newclient']->addRow('mail',[
			'type' => 'text',
			'placeholder' => 'Adresse-mail',
			'name' => 'mail',
			'label' => 'Adresse-mail'
			]);
		$this->form['newclient']->addRow('telephone',[
			'type' => 'text',
			'placeholder' => 'Téléphone',
			'name' => 'telephone',
			'label' => 'Téléphone'
			]);
		$this->form['newclient']->addRow('postale',[
			'type' => 'text',
			'placeholder' => 'Adresse postale',
			'name' => 'postale',
			'label' => 'Adresse postale'
			]);
		$this->form['newclient']->addRow('submit',[
			'label' => false,
			'type' => 'submit',
			'class' => 'btn',
			'value' => 'Créer'
			]);
	}
	protected function ACTION_reservations(){
		$types = $this->db->select('nom, id','typebien');
		$option = array();
		foreach ($types as $key => $value) {
			array_push($option, ['value' => $value['id'], 'text' => $value['nom'],'selected' => null]);
		}

		$resas = Tool::getAllReservations();
		$this->view->setData(['resa' => $resas]);

		$nms = array();
		$clname = $this->db->select('*', 'client',null,'',false);

		foreach ($clname as $key => $cl) {
			array_push($nms, '{value : \''.$cl['id'].' - '.$cl['prenom'].' '.$cl['nom'].'\', label : \''.$cl['id'].' - '.$cl['prenom'].' '.$cl['nom'].' / '.$cl['mail'].'\'}');
		}

		$this->view->setData(['clientsname' => $nms]);

		$this->createForm('newreservation','post','addreservation');
		$this->form['newreservation']->addRow('client',[
			'type' => 'text',
			'id' => 'clientautocomplete',
			'placeholder' => 'Client',
			'name' => 'client',
			'label' => 'Sélectionner un client',
			'class'     => 'autosearch',
			'src'       => 'clients'
			]);
		$this->form['newreservation']->addRow('arrive',[
			'type' => 'date',
			'placeholder' => 'Client',
			'name' => 'arrive',
			'label' => 'Date d\'arrivée'
			]);
		$this->form['newreservation']->addRow('depart',[
			'type' => 'date',
			'placeholder' => 'Client',
			'name' => 'depart',
			'label' => 'Date de départ'
			]);
		$this->form['newreservation']->addRow('nbp',[
			'type' => 'number',
			'placeholder' => 'Nombre de personnes',
			'name' => 'nbp',
			'label' => 'Nombre de personnes'
			]);
		$this->form['newreservation']->addRow('typebien',[
			'type' => 'select',
			'option' => $option,
			'name' => 'typebien',
			'label' => 'Type hébergement'
			]);
		$this->form['newreservation']->addRow('submit',[
			'type' => 'submit',
			'label' => false,
			'value' => 'Créer',
			'class' => 'btn'
			]);
	}
	protected function ACTION_detail_reservation(){
		$id = $this->value;

		$res = Tool::getReservationById($id);
		$tb = Tool::getAllType();

		$res = $res ? $res : null;

		$this->view->setData(['reservation' => $res, 'types' => $tb]);

		$nms = array();
		$clname = $this->db->select('*', 'client');

		foreach ($clname as $key => $cl) {
			array_push($nms, '{value : \''.$cl['id'].' - '.$cl['prenom'].' '.$cl['nom'].'\', label : \''.$cl['id'].' - '.$cl['prenom'].' '.$cl['nom'].' / '.$cl['mail'].'\'}');
		}

		$this->view->setData(['clientsname' => $nms]);
	}
	protected function ACTION_detail_client(){
		$id = $this->value;

		$cl = Tool::getClientById($id);
		$cl = $cl ? $cl : null;

		$this->view->setData(['client' => $cl]);
	}
	protected function ACTION_pages(){
		// $pages = Tool::getPages();

		// Tool::log($pages);
	}
	protected function ACTION_alentours(){

		$sp = Tool::getAlentoursSpots();

		// COMPTE DES SPOTS
		$nbspots = 0;
		foreach($sp as $s){
			$nbspots += sizeof($s);
		}

		$this->view->setData([
			'spots' => $sp,
			'nbspots'   => $nbspots,
			'categories' => Tool::getAlentoursCategories()
			]);
	}
	protected function ACTION_alentours_details(){
		$id = $this->value;
		$sp = Tool::getAlentoursSpotById($id);

		if(!empty($sp)){

			$this->getAlentoursForm();
			$this->form['spots']->setMethodAction('post','/admin/update_alentours/'.$id);
			$this->form['spots']->setAttribute('spots',['value' => $sp['nom']]);
			$this->form['spots']->setOptionSelected('cat',$sp['id_categorie']);
			$this->form['spots']->setAttribute('desc',['value' => $sp['description']]);
			$this->form['spots']->setAttribute('latitude',['value' => $sp['latitude'], 'disabled' => 'disabled']);
			$this->form['spots']->setAttribute('longitude',['value' => $sp['longitude'],  'disabled' => 'disabled']);
			$this->form['spots']->setAttribute('km',['value' => $sp['km'],  'disabled' => 'disabled']);
			$this->form['spots']->setAttribute('minute',['value' => $sp['minute'],  'disabled' => 'disabled']);

			$this->view->setData([
				'le_spot' => $sp,
				'trumbo' => $sp['description']
				]);
			
		}else{
			$this->view->setData(['le_spot' => false]);
		}
	}
	protected function ACTION_newalentours(){
		$this->getAlentoursForm();
	}
	protected function ACTION_search(){
		$s = strtolower($_POST['search']);

		if($_POST['type'] == 'client'){
			$clients_found = array();
			$lev = array();
			$cls = $this->db->select('*','client',null,null,false);
			foreach ($cls as $key => $cl) {
				array_push($lev, levenshtein(strtolower($cl['nom']), $s));
				array_push($lev, levenshtein(strtolower($cl['prenom']), $s));
				array_push($lev, levenshtein(strtolower($cl['nom'].' '.$cl['prenom']), $s));
				array_push($lev, levenshtein(strtolower($cl['prenom'].' '.$cl['nom']), $s));

				if(in_array(0, $lev) ||
					in_array(1, $lev) ||
					in_array(2, $lev)){
					array_push($clients_found, $cl);
					$lev = array();
				}
			}
			$this->view->setData(['found' => $clients_found]);
		}
	}
	protected function ACTION_contact(){
		$c = Tool::getContact();

		$this->view->setData(['contacts' => $c]);
	}
	protected function ACTION_photosgallerie(){
		$this->view->setData(['photos' => Tool::getGalleriePhotos(1)]);
	}
	protected function ACTION_photosfond(){
		$this->view->setData(['photos' => Tool::getGalleriePhotos(2)]);
	}
    protected function ACTION_textes(){
	    if(isset($this->value)){
			$txt = Tool::getTexteByName($this->value);

		    $this->tab = 'textes_detail';
		    $this->view->setData([
			    'texte' => $txt
		    ]);
	    }else{
		    $txts = Tool::getAllTextes();

		    $this->view->setData([
			    'textes' => $txts
		    ]);
	    }
    }
	protected function ACTION_updatetextes(){
		$id = $this->value;

		$this->db->update('textes',['contenu' => $_POST['trumbowyg']], ['id' => $id]);

		$this->redirect('/admin/textes/');

	}
	protected function ACTION_stats(){

		require_once('../plugins/google/analytics/src/Google/autoload.php');

		$redirect_uri = 'http://camping-lacaze.fr/admin/oauth2callback';

		$client = new Google_Client();
		$client->setAuthConfigFile('../plugins/google/analytics/client_secret.json');
		$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);

		if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
			// Set the access token on the client.
			$client->setAccessToken($_SESSION['access_token']);

			// Create an authorized analytics service object.
			$analytics = new Google_Service_Analytics($client);

			// Get the first view (profile) id for the authorized user.
			$profile = getFirstProfileId($analytics);

			// Get the results from the Core Reporting API and print the results.
			$results = getResults($analytics, $profile);

			Tool::log($results);

		} else {
			header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
		}


	}
	protected function ACTION_oauth2callback(){
		require_once('../plugins/google/analytics/src/Google/autoload.php');

// Create the client object and set the authorization configuration
// from the client_secrets.json you downloaded from the Developers Console.
		$client = new Google_Client();
		$client->setAuthConfigFile('../plugins/google/analytics/client_secret.json');
		$client->setRedirectUri('http://camping-lacaze.fr/admin/oauth2callback');
		$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);

// Handle authorization flow from the server.
		if (! isset($_GET['code'])) {
			$auth_url = $client->createAuthUrl();
			header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
		} else {
			$client->authenticate($_GET['code']);
			$_SESSION['access_token'] = $client->getAccessToken();
			$redirect_uri = 'http://camping-lacaze.fr/admin/stats';
			header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
		}
	}

	/**************
	*
	*		ACTIONS W REDIRECTION
	*
	************************/

	/*  CLIENTS       ****************/
	protected function ACTION_addclient(){
		if(!empty($_POST)){

			$post = $_POST;

            if(strlen($post['nom']) > 0){
                if(preg_match('#[\\\()<>]#', $post['nom'])){
                    $this->errors['nom'] = 'Le nom est incorrect';
                }
            }

            if(strlen($post['prenom']) > 0){
                if(preg_match('#[\\\()<>]#', $post['prenom'])){
                    $this->errors['prenom'] = 'Le prenom est incorrect';
                }
            }

            if(strlen($post['mail']) > 0){
                if(!filter_var($post['mail'],FILTER_VALIDATE_EMAIL)){
                    $this->errors['mail'] = 'L\'adresse mail est incorrect';
                }
            }

            if(strlen($post['telephone']) > 0){
                if(!preg_match('#[0-9]{10,10}#', $post['telephone'])){
                    $this->errors['telephone'] = 'Le numéro de téléphone est incorrect' ;
                }
            }

			if(empty($this->errors)){

				$ins = $this->db->insert(
                    'client',
					[
						'nom' => $post['nom'],
						'prenom' => $post['prenom'],
						'mail' => $post['mail'],
						'telephone' => $post['telephone'],
						'adresse_postale' => $post['postale'],
						'date_creation' => date('d-m-Y, h:i'),
					]
					);

				$this->msg['ok'] = [
					'message' => 'Monsieur '.$post['nom'].' enregistré avec succès',
					'type' => 'success',
					'showCloseButton' => true
				];
			}else{
				$this->giveback($post);
				$this->msg['err'] = [
					'message' => 'Monsieur '.$post['nom'].' ne s\'est pas enregistré, une erreur s\'est produite',
					'type' => 'error',
					'showCloseButton' => true
				];
			}

			
		}
		$this->redirect('clients');
	}
	protected function ACTION_delclient(){
		$del = $this->db->delete('client',['id' => $this->value]);

		$resas = Tool::getReservationByClientId($this->value);

		foreach ($resas as $res) {
			$res->update(['id_client' => null]);
		}

		$this->msg['ok'] = [
			'message' => 'Client supprimé avec succès, il est parti à tout jamais',
			'type' => 'success',
			'showCloseButton' => true
		];

		$this->redirect('../clients');
	}
	protected function ACTION_update_client(){
		$id = $this->value;

		$p = $_POST;

        if(strlen($p['nom']) > 0){
            if(preg_match('#[\\\()<>]#', $p['nom'])){
                $this->errors['nom'] = 'Le prenom est incorrect';
            }
        }

        if(strlen($p['prenom']) > 0){
            if(preg_match('#[\\\()<>]#', $p['prenom'])){
                $this->errors['prenom'] = 'Le prenom est incorrect';
            }
        }

        if(strlen($p['mail']) > 0){
            if(!filter_var($p['mail'],FILTER_VALIDATE_EMAIL)){
                $this->errors['mail'] = 'L\'adresse mail est incorrect';
            }
        }
        if(strlen($p['telephone']) > 0){
            if(!preg_match('#[0-9]{10,10}#', $p['telephone'])){
                $this->errors['telephone'] = 'Le numéro de téléphone est incorrect' ;
            }
        }

		if(empty($this->errors)){
			$this->db->update('client',
				[
					'nom' => $p['nom'],
					'prenom' => $p['prenom'],
					'mail' => $p['mail'],
					'telephone' => $p['telephone'],
					'adresse_postale' => $p['postale'],
				],
				['id' => $id]

			);

			$this->msg['ok'] = [
				'message' => 'Client mis à jour avec succès !',
				'type' => 'success',
				'showCloseButton' => true,
                'errors' => $this->errors
			];
		}else{
			$this->msg['ok'] = [
				'message' => 'Mise à jour du client impossible',
				'type' => 'error',
				'showCloseButton' => true,
                'errors' => $this->errors
			];
		}

		$this->redirect('../detail_client/'.$id);
	}
	/* *************************** */

	/*  RESERVATIONS      **********/
	protected function ACTION_addreservation(){
		if(!empty($_POST)){

			$post = $_POST;
			$clid = null;

			$d_ar = strtotime($_POST['arrive']);
			$d_d = strtotime($_POST['depart']);


			if(strlen($post['client']) <= 0){
				$this->errors['client'] = 'Vous devez entrer un client';
			}else{
				preg_match('#^([0-9]+) ?-#', $post['client'], $clid);
				$clid = isset($clid[1]) ? $clid[1] : null;

				if(null == (Tool::getClientById($clid))){
					$this->errors['client'] = 'Client introuvable';
				}
			}

			if($d_ar > $d_d){
				$this->errors['depart'] = 'La date d\'arrivée doit être antérieure à la date de départ';
			}

//			if($d_ar < strtotime(date('Y-m-d'))){
//				$this->errors['depart'] = 'Les dates doivent etre antérieures à a date du jour';
//			}

			if(empty($this->errors)){

				$ins = $this->db->insert(
					'reservation',
					[
						'id_client' => $clid,
						'dateDebut' => $post['arrive'],
						'dateFin' => $post['depart'],
						'nbPersonne' => $post['nbp'],
						'typeBien' => $post['typebien']
					]
				);

				$this->msg['ok'] = [
					'message' => 'C\'est tout bon, enregistrement effectué'
				];
			}else{
				$this->giveback($_POST);
				$this->msg['nop'] = [
					'message' => 'Une erreur s\'est produite',
					'type' => 'error',
				];
			}
		}

		$this->redirect('reservations');
	}
	protected function ACTION_update_reservation(){

		$id = $this->value;
		$p = $_POST;
		$clid = null;
//Tool::log($p);
		$d_ar = strtotime($p['arrive']);
		$d_d = strtotime($p['depart']);

		if(strlen($p['client']) <= 0){
			$this->errors['client'] = 'Vous devez entrer un client';
		}else{
			preg_match('#^([0-9]+) ?-#', $p['client'], $clid);
			$clid = isset($clid[1]) ? $clid[1] : null;
		}

		if(empty($this->errors)){
			$this->db->update(
				'reservation',
				[
					'id_client' => $clid,
					'dateDebut' => $p['arrive'],
					'dateFin' => $p['depart'],
					'nbPersonne' => $p['nbp'],
					'typeBien' => $p['type']
				],
				['id' => $id]

			);
			$this->msg['ok'] = [
				'message' => 'Réservation mis à jour avec succès !',
				'type' => 'success',
				'showCloseButton' => true
			];
		}else{
			$this->msg['ok'] = [
				'message' => 'Mise à jour de la réservation impossible',
				'type' => 'error',
				'showCloseButton' => true
			];
		}

		$this->redirect('../detail_reservation/'.$id);
	}
	protected function ACTION_delreservation(){
		$del = $this->db->delete('reservation',['id' => $this->value]);

		$this->msg['ok'] = [
			'message' => 'Reservation supprimée avec succès',
			'type' => 'success',
			'showCloseButton' => true
		];

		$this->redirect('../reservations');
	}
	/* *************************** */

	/*  ALENTOURS      *************/
	protected function ACTION_del_alentours(){
		$id = $this->value;

		$this->db->delete('alentours_spot',['id' => $id]);

		$this->redirect('/admin/alentours');
	}
	protected function ACTION_addspot(){

		if($_FILES['image']['size'] > 0){

			$img =  $_FILES['image']['tmp_name'];
			$imgb = false;
			$gdimg = imagecreatefromjpeg($img);
			$name = $_FILES['image']['name'];
//			Tool::log($gdimg);

			$wi = imagesx($gdimg);
			$he = imagesy($gdimg);

			$nw = $wi*(200/$he);
			$nh = 200;

			$mini = imagecreatetruecolor($nw, $nh);

			imagecopyresized($mini, $gdimg, 0, 0, 0, 0, $nw, $nh, $wi, $he);

			$ijpg = imagejpeg($mini, ROOT.'/web/img/spots/miniature/'.$name);
			$mov = move_uploaded_file($_FILES['image']['tmp_name'], ROOT.'/web/img/spots/'.$_FILES['image']['name']);

			if($mov){

			}else{
				$imgb = true;
			}
		}

		if($imgb) $this->msg['img'] = [
			'message' => 'Erreur dans l\'enregistrement de l\'image',
			'type' => 'error',
			'showCloseButton' => true
		];

		$ins = $this->db->insert('alentours_spot',[
			'nom'           => $_POST['nom'],
			'description'   => $_POST['trumbowyg'],
			'map' 		    => $_POST['map'],
			'id_categorie'  => $_POST['categorie'],
			'image'		    => $_FILES['image']['name'],
			'longitude'     => $_POST['longitude'],
			'latitude'      => $_POST['latitude'],
			'minute'        => $_POST['minute'],
			'km'            => $_POST['km']
		]
		);

		if($ins){
			//notification ok
			$this->msg['ok'] = [
				'message' => 'L\'élement '.$_POST['nom'].' enregistré avec succès',
				'type' => 'success',
				'showCloseButton' => true
			];
		}else{
			$this->msg['ok'] = [
				'message' => 'Erreur, enregistrement impossible',
				'type' => 'error',
				'showCloseButton' => true
			];
		}

		$this->redirect('/admin/alentours');
	}
	protected function ACTION_update_alentours(){
		$id = $this->value;

		$imgb = false;
		if($_FILES['image']['size'] > 0){
			$img =  $_FILES['image']['tmp_name'];
			$imgb = false;
			$gdimg = imagecreatefromjpeg($img);
			$name = $_FILES['image']['name'];
			$wi = imagesx($gdimg);
			$he = imagesy($gdimg);

			$nw = $wi*(200/$he);
			$nh = 200;

			$mini = imagecreatetruecolor($nw, $nh);

			imagecopyresized($mini, $gdimg, 0, 0, 0, 0, $nw, $nh, $wi, $he);

			$ijpg = imagejpeg($mini, ROOT.'/web/img/spots/miniature/'.$name);
			if(move_uploaded_file($_FILES['image']['tmp_name'], ROOT.'/web/img/spots/'.$_FILES['image']['name'])){
				$this->db->update('alentours_spot',
					['image' => $_FILES['image']['name']]
					,['id' => $id]);
			}else{
				$imgb = true;
			}
		}

		if($imgb) $this->msg['img'] = [
			'message' => 'Erreur dans l\'enregistrement de l\'image',
			'type' => 'error',
			'showCloseButton' => true
		];

        $map = isset($_POST['map'])?$_POST['map']:null;

		$up = $this->db->update('alentours_spot',[
			'nom'           => $_POST['nom'],
			'description'   => $_POST['trumbowyg'],
			'map' 		    => $map,
			'id_categorie'  => $_POST['categorie'],
			'latitude'      => $_POST['latitude'],
			'longitude'     => $_POST['longitude'],
			'minute'        => $_POST['minute'],
			'km'            => $_POST['km']
		],['id' => $id]);

		if($up !== false){
			//notification ok
			$this->msg['ok'] = [
				'message' => 'L\'élement '.$_POST['nom'].' enregistré avec succès',
				'type' => 'success',
				'showCloseButton' => true
			];
		}else{
			$this->msg['ok'] = [
				'message' => 'Enregistrement impossible',
				'type' => 'error',
				'showCloseButton' => true
			];
		}

		$this->redirect('/admin/alentours_details/'.$id);
	}
	/* *************************** */

	protected function ACTION_add_alentourscategorie(){
		$p = $_POST;

		$this->db->insert('alentours_categorie',['nom' => $_POST['nom']]);

		$this->redirect('/admin/alentours');
	}
	protected function ACTION_del_alentourscategorie(){
		$id = $this->value;

		$this->db->delete('alentours_categorie', ['id' => $id]);

		$this->redirect('/admin/alentours');
	}

	/*  PHOTOS      *************/
	protected function ACTION_ajaxphoto(){
		$cat = $this->value;

		$img = file_get_contents('php://input');
		$h = getallheaders();
		$gdimg = imagecreatefromstring($img);

		if($h['X-File-Type'] == 'image/jpeg'){
			$nom = trim($h['X-File-Name']);
			$nom = base64_encode($nom).'.jpg';

			$wi = imagesx($gdimg);
			$he = imagesy($gdimg);

			$nw = $wi*(200/$he);
			$nh = 200;

			$mini = imagecreatetruecolor($nw, $nh);
			
			imagecopyresized($mini, $gdimg, 0, 0, 0, 0, $nw, $nh, $wi, $he);
	
			$ijpg = imagejpeg($mini, ROOT.'/web/img/gallerie/miniature/'.$nom);
			$fpc = file_put_contents(ROOT.'/web/img/gallerie/'.$nom, $img);

			if($fpc && $ijpg){

				$this->db->insert('photos',[
					'categorie'         => $cat,
					'nom'               => $nom,
					'date_ajout'        => date('d/m/Y')
				]);

				header('Access-Control-Allow-Origin: *');
				header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
				json_encode(['success' => 'success']);
			}else{
				json_encode(['error' => 'error']);
			}
		}else{
			json_encode(['error' => 'mauvais type']);
		}
		die();
	}
	protected function ACTION_deletephoto(){
		$img = $this->value;

		$u = unlink(ROOT.'/web/img/gallerie/'.$img);
		unlink(ROOT.'/web/img/gallerie/miniature/'.$img);
		$this->db->delete('photos',['nom' => $img]);

		if($u){
			$this->msg['ok'] = [
				'message' => 'Photo retirée',
				'type'      => 'success'
			];
		}else{
			$this->msg['ok'] = [
				'message' => 'Erreur : impossible de supprimer la photo',
				'type'      => 'error'
			];
		}

		$this->redirect('/admin/photosgallerie');
	}
	/* *************************** */
}