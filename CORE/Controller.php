<?php

class Controller{

	protected $view;
	protected $db;
	protected $errors = array();
	protected $msg = [];
	protected $need_co;
	protected $form = [];
	protected $pages = [];
	protected $action;
	protected $value;

	/**
	 *    $need_co détermine si le controller a besoin que l'utilsateur soit connecté
	 *    pour qu'il puisse s'éxecuter
	 * @param null $param
	 */
	function __construct($param = null){

		$this->view = new View();
		if(ENABLE_DB) $this->db = new DB();

		$this->action = isset($param['action']) ? $param['action'] : null;
		$this->value = isset($param['value']) ? $param['value'] : null;

		// Récupération des msg en cas de redirection
		if(isset($_SESSION['msg'])) $this->msg = $_SESSION['msg'];

		//actions
		$iact = isset($_POST['action']) ? 'iact_'.$_POST['action'] : '';
		$iactrep = preg_replace('#-#', '', $iact);
		if(isset($_POST['action']) && method_exists($this, $iactrep)){call_user_func([$this,$iactrep]);}
		$action = 'ACTION_'.preg_replace('/-/', '', $param['action']);
		if(isset($param['action']) && method_exists($this, $action)) call_user_func([$this,$action]);

		if(defined('CURRENT_PAGE')) $this->view->setMetaData(['current_page' => CURRENT_PAGE]);
	}

	/*
	*	Démarre la vue, on définit quelle vue utiliser, et quelles données y passer
	*/
	protected function lunchView($template,$main = 'main'){
		if(!empty($this->errors)){$_SESSION['errors'] = $this->errors;}
		if(!empty($this->msg)){$_SESSION['msg'] = $this->msg;}
		if(!empty($this->form)) $this->view->setData(array('form' => $this->form));

		$this->view->initTemplate($template);
		$this->view->render($main);
	}

	protected function createForm($name,$method = '', $action = '',$enctype = null){
		$this->form[$name] = new Form($method,$action,$enctype);
	}

	protected function setPages($p){
		$this->pages = $p;
	}

	protected function redirect($to){
		// pour conserver les messages d'erreur et les messages
		if(isset($this->errors)) $_SESSION['errors'] = $this->errors;
		if(isset($this->msg)) $_SESSION['msg'] = $this->msg;

		header('Location: '.$to);
		exit();
	}

	protected function giveback($dat){
		foreach ($dat as $key => $value) {
			$_SESSION['giveback'][$key] = $value;
		}
	}

}
