<?php

class Router{

	static public function parse($url){

		if(defined('REDIRECT_BASE')) $url = preg_replace('#'.REDIRECT_BASE.'#', '', $url);

		$url = trim($url,'/');
		$url = explode('/', $url);

		foreach ($url as $k => $elmt) {
			$url[$k] = str_replace('-','',$elmt);
			// Conservation des paramètres GET
			if(preg_match('#(\?.+)#', $elmt, $matches)) $url[$k] = str_replace($matches[0], '', $elmt); 
		}

		$param = [
			'controller'	=> !empty($url[0]) ? $url[0] : 'home',
			'action'		=> !empty($url[1]) ? $url[1] : null,
			'value'			=> !empty($url[2]) ? $url[2] : null,
			'value2'		=> !empty($url[3]) ? $url[3] : null
		];

		return $param;
	}

}