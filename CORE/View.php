<?php

class View{
	
	private $tpl_dir;
	private $datas = array();
	private $meta = array();
	private $template;
	private $template_main;

	function __construct($datas = null){
		$this->tpl_dir = ROOT.'/view';
		$this->form = new Form();
		$this->template_main = $this->tpl_dir.'/main.tpl.php';
		
		if(isset($datas)) $this->setData($datas);
	}

	public function setData($d){
		foreach ($d as $key => $value) {
			$this->datas[$key] = $value;
		}
	}

	public function setMetaData($d){
		foreach ($d as $key => $value) {
			$this->meta[$key] = $value;
		}
	}

	public function getData(){
		return $this->datas;
	}

	public function render($tpl_main){

		$d = $this->datas;
		$meta = $this->meta;

		$meta['template'] = $this->template;
		if(!empty($_SESSION['msg'])){
			foreach ($_SESSION['msg'] as $key => $value) {
				$_SESSION['msg'][$key] = json_encode($value);
			}
			$msg = (isset($_SESSION['msg'])) ? $_SESSION['msg'] : null;
		}

		ob_start();

		if(isset($tpl_main)){
			include($this->tpl_dir.'/'.$tpl_main.'.tpl.php');
		}else{
			include($this->template);
		}

		if(!empty($de)){
			echo '<script>$(document).ready(function(){$(\'#debuger h1\').click(function(){$(\'#debuger pre\').slideToggle()})})</script>';
		}

		$html = ob_get_contents();

		ob_end_clean();
		
		echo $html;
		
		$_SESSION['errors'] = array();
		$_SESSION['msg'] = array();
	}

	public function initTemplate($tpl_name){
		$this->template = $this->tpl_dir.'/'.$tpl_name.'.tpl.php';
	}

}