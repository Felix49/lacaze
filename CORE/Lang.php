<?php 

class Lang{

	private static function db(){
		return new DB();
	} 

	public static function getDefaultLocale(){
		// Français par défaut
		$def = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : 'fr';
		return $def;
	}

	public static function trad($str,$from = null,$to = null){
		
		$res = $str;

		$from = isset($from) ? $from : Lang::getDefaultLocale();
		$to = isset($to) ? $to : LANG;

		$tr = self::db()->select('*','traduction',['fr_text' => $str],null,false);

		if(sizeof($tr) == 0){
			$col = 'fr_text';
			self::db()->insert('traduction',[$col => $str]);
		}else{
			$trs = $tr[0][$to.'_text'];
			$res = (empty($trs)) ? $str : $trs;
		}

		return $res;
	}

	public static function getTrads($from = null, $to = null){
		$from = isset($from) ? $from : self::getDefaultLocale();

		$res = self::db()->select(['id',$from.'_text', $to.'_text'],'traduction');

		return $res;
	}

}