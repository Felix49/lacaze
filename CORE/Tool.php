<?php

class Tool{

	static public function db(){
		return new DB();
	}

	static public function log($d,$ex=true){
		echo '<pre>';
		var_dump($d);
		echo '</pre>';
		if($ex) exit;
	}

	static public function slugify($text){ 

	  // replace non letter or digits by -
	  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
	  // trim
	  $text = trim($text, '-');
	  // transliterate
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	  // lowercase
	  $text = strtolower($text);
	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', '', $text);

	  if (empty($text)) return 'n-a';

	  return $text;
	}

	static public function GdistanceMatrix($arLl1,$arLl2){

	}

	static public function getAllReservations($sup = null,$daysupp = false){

		$days = [];
		$resa_ar = array();
		$resas = self::db()->select('*','reservation',null,$sup,false);

		foreach ($resas as $resa) {
			$clid = Tool::getClientById($resa['id_client']);
			$typebien = self::db()->select('nom','typebien',['id' => $resa['typeBien']]);
			$resa_ar[$resa['id']] = new Reservation(
				$resa['id'],
				$resa['dateDebut'],
				$resa['dateFin'],
				$typebien['nom'],
				$resa['nbPersonne'],
				$clid
			);
		}

		foreach ( $resa_ar as $res ) {

			for($nbd = $res->nbjours;$nbd > 0;$nbd--){
				$df = $res->dateDebut->format('dmY');
				if(!isset($days[$df])){
					$days[$df] = intval($res->nbPersonne);
				}else{
					$days[$df] = $days[$df] + $res->nbPersonne;
				}
				$res->dateDebut->modify('+1 day');
			}
		}

		if($daysupp){
			$resa_ar = [$resa_ar,$days];
		}

		return $resa_ar;
	}

	static public function getReservationByClientId($id){
		$result = array();

		$resa = self::db()->select('*', 'reservation', ['id_client' => $id],null,false);
		foreach ($resa as $key => $res) {
			$cl = Tool::getClientById($res['id_client']);
			array_push($result, new Reservation(
				$res['id'],
				$res['dateDebut'],
				$res['dateFin'],
				$res['typeBien'],
				$res['nbPersonne'],
				$cl
				));
		}

		return $result;
	}

	static public function getAllClients(){
		$cl_ar = array();

		foreach (self::db()->select('*','client',null,'',false) as $c) {
			$cl_ar[$c['id']] = new Client(
				$c['id'],
				$c['nom'],
				$c['prenom'],
				$c['mail'],
				$c['telephone'],
				$c['adresse_postale'],
				$c['date_creation']
				);
		}
		return $cl_ar;
	}

	static public function getClientById($id){
		$cl = self::db()->select('*','client',['id' => $id]);

		if(!empty($cl)){

			$cli = new Client(
				$cl['id'],
				$cl['nom'],
				$cl['prenom'],
				$cl['mail'],
				$cl['telephone'],
				$cl['adresse_postale'],
				$cl['date_creation']
				);
		}else{
			return null;
		}

		return $cli;
	}

	static public function getReservationById($id){

		$res = self::db()->select('*', 'reservation', ['id' => $id]);

		if(!empty($res)){

			$cl = Tool::getClientById($res['id_client']);

			return new Reservation(
				$res['id'],
				$res['dateDebut'],
				$res['dateFin'],
				$res['typeBien'],
				$res['nbPersonne'],
				$cl
				);
			
		}else{

			return false;
			
		}
	}

	static public function getClientByName($name){

		$cl;
	}

	static public function getAllType(){
		$types = self::db()->select('*','typebien');

		return $types;
	}

	static public function getTypeById($id){

		$type = self::db()->select('nom', 'typebien', ['id' => $id]);

		return $type['nom'];
	}

	static public function getAlentoursSpots(){
		$al = self::db()->select('*','alentours_spot',null,null,false);
		
		$res = array();

		foreach ($al as $ale) {

			//transformation des coordonnées
			// $lat = isset(explode(',', $ale['map'])[0]) ? explode(',', $ale['map'])[0] : null;
			// $long = isset(explode(',', $ale['map'])[1]) ? explode(',', $ale['map'])[1] : null;
			// $ale['map'] = ['lat' => $lat, 'long' => $long];

			if(isset($res[$ale['id_categorie']])){
				array_push($res[$ale['id_categorie']], $ale);
			}else{
				$res[$ale['id_categorie']] = array();
				array_push($res[$ale['id_categorie']], $ale);
			}
		}

		return $res;
	}

	static public function getAlentoursSpotById($id){

		$sp = self::db()->select('*', 'alentours_spot',['id' => $id]);

		// $lat = isset(explode(',', $sp['map'])[0]) ? explode(',', $sp['map'])[0] : null;
		// $long = isset(explode(',', $sp['map'])[1]) ? explode(',', $sp['map'])[1] : null;

		// $sp['map'] = ['lat' => $lat, 'long' => $long];

		return $sp;
	}

	static public function getAlentoursCategories(){
		$req = self::db()->select('id,nom','alentours_categorie');
		$res = array();
		foreach ($req as $key => $value) {
			$res[$value['id']] = $value['nom'];
		}
		return $res;
	}

	static public function getContact(){
		return self::db()->select('*','contact');
	}

	static public function getGalleriePhotos($cat = ''){
//		$imgstemp = scandir(ROOT.'/web/img/gallerie');
//		$imgs = array();
//		foreach ($imgstemp as $k => $value) {
//			if(!in_array($value, ['.','..','miniature'])) array_push($imgs, $value);
//		}
		$where = null;
		if($cat != '') $where = ['categorie' => $cat];
		$imgs = Tool::db()->select('*','photos',$where,null,false);

		return $imgs;
	}

    static public function getAllTextes(){
        $txt = self::db()->select('*','textes',null,null,false);
	    $res = [];
	    foreach($txt as $t){
		    $res[$t['nom']] = $t;
	    }

        return $res;
    }
	static public function getTexteByName($n){
		$ret = false;
		$t = self::db()->select('*','textes',['nom' => $n],null,false);

		if(sizeof($t) == 1){
			$ret = $t[0];
		}
		return $ret;
	}

	// CALENDAR
	static public function renderCalendar($month,$year){
		$allresas = Tool::getAllReservations(null,true);
		$resas = $allresas[0];
		$days = $allresas[1];
		$month = intval($month);
		$year = intval($year);
		$timeData = [
			'days'      => ['','LUN','MAR','MER','JEU','VEN','SAM','DIM'],
			'month'     => ['','Janvier','Février','Mars', 'Avril', 'Mai', 'Juin','Juillet','Aout','Septembre','Octobre','Novembre','Décembre']
		];
		$daysinmonth = Tool::daysInMonth($month,$year);
		$dstart = intval(date("N", mktime(0, 0, 0, $month, 1, $year)));
		$day = 1;

		$html = '<table class="calendar">';
		$html .= '<p class="month"><span class="navmonth prev"><</span><span class="m">'.$timeData['month'][$month].'</span> <span class="year">'.$year.'</span><span class="navmonth next">></span></p>';
		$html .= '<tr class="days">
			<td>LUN</td>
			<td>MAR</td>
			<td>MER</td>
			<td>JEU</td>
			<td>VEN</td>
			<td>SAM</td>
			<td>DIM</td>
		</tr>';
		$html .= '<tr>';
		// JOURS VIDES DEBUT DE MOIS
		for($i = 0;$i < $dstart-1; $i++){
			$html .= '<td class="empty" did="'.$day.'-'.$month.'"></td>';
		}
		// JOURS PLEINS DE LA PREMIERE SEMAINE
		for($i = 0;$i < 8-$dstart; $i++){
//			$key = str_pad($i,2,'0',STR_PAD_LEFT).$kdays;
//			if(isset($days[intval($key)])){
//				Tool::log($days[$key]);
//			}
			$html .= '<td day="'.$day.'">'.$day.'</td>';
			$day ++;
		}
		// RESTE DES JOURS
		for($i = 0;$i < 5;$i++){
			$html .= '<tr>';
			for($ii=0;$ii<7;$ii++){
				if($day <= $daysinmonth){
					$html .= '<td day="'.$day.'" did="'.$day.'-'.$month.'">'.$day.'</td>';
					$day ++;
				}else{
					$html .= '<td class="empty" did="'.$day.'-'.$month.'"></td>';
				}
			}
			$html .= '</tr>';
		}
		$html .= '</tr>';
		$html .= '</table>';

		echo $html;
	}
	static public function daysInMonth($month,$year){
		if($month!=2) {
			if($month==9||$month==4||$month==6||$month==11)
				return 30;
			else
				return 31;
		}
		else
			return $year%4==""&&$year%100!="" ? 29 : 28;
	}
}