<?php
/*
*	FEMWORK - 2014 Félix Marchenay 
*/
require_once('Controller.php');
require_once('View.php');
require_once('Form.php');
require_once('db/DB.php');
require_once('Tool.php');
//require_once('Mail.php');
require_once('Router.php');
require_once('Lang.php');

class Core{
	private $questions;
	private $mainController = 'home';
	private $options = [];
	private $url;
	
	function __construct($opt = []){

		$this ->options = array_merge($this->options, $opt);

		define('ENABLE_DB', (isset($this->options['db']) ? $this->options['db'] : null));
		define('REDIRECT_BASE', (isset($this->options['base']) ? $this->options['base'] : null));
		if(isset($_SESSION['LANG'])){
			$l = $_SESSION['LANG'];
		}else{
			$l = Lang::getDefaultLocale();
			$_SESSION['LANG'] = $l;
		}
		define('LANG',$l);

		$this->url = $_SERVER['REQUEST_URI'];
	}

	public function start(){
		$param = Router::parse($this->url);
		if(class_exists($param['controller'].'Controller')){
			$this->loadController($param['controller'],$param);
		}else{
			$this->loadController('notfound');
		}
	}

	public function loadController($ctrl_name,$param = null){
		$ct = $ctrl_name.'Controller';
		$controller = new $ct($param);
	}

}