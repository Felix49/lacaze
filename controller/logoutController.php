<?php 

class logoutController extends Controller{

	function __construct(){
		parent::__construct();

		$_SESSION['user'] = array();

		$redir = isset($_GET['redir']) ? $_GET['redir'] : '';
		
		header('location: /'.$redir);
	}

}