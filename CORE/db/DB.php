<?php
class DB{

	private $pdo;
	private $dbconf;
	private $pdoEnabled = true;

	function __construct(){

		include('dbconf.php');

		// Fichier de configuartion importé	
		$this->dbconf = $dbconf;

		$param = $dbconf['server'].':host='.$dbconf['host'].';dbname='.$dbconf['dbname'];

		try{
			$this->pdo = new PDO($param,$dbconf['user'], $dbconf['password'],array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
		} catch (PDOException $e){
			Tool::log($e,false);
		}
	}

	public function request($q){

		$res = $this->pdo->query($q);
		return $res;
	}

	public function select($columns,$table,$conditions = null,$supp = '',$compact = true){
		
		if(is_array($columns)){
			$col = implode(', ', $columns);
		}else $col = $columns;

		$q = "SELECT $col FROM $table";

		if(isset($conditions)){
			$q .= ' WHERE 1 ';
			foreach ($conditions as $col => $val) { $q .= 'AND '.$col.' = ? '; }
		}else{
			$conditions = array();
		}
		
		if(!empty($supp)){
			$q .= $supp;
		};

		// execution of request with prepared statement
		$prep = $this->pdo->prepare($q);
		$prep->execute(array_values($conditions));
		$res = $prep->fetchAll(PDO::FETCH_ASSOC);

		// 1 elmt
		if($compact && is_array($res) && sizeof($res) == 1){
			$res = $res[0];
		}

		return $res;
	}

	public function update($table,$set,$where){
		$set = $this->quote($set);

		$q = "UPDATE ".$table.' SET ';
		
		$vals = array();
		foreach ($set as $key => $value) {
			array_push($vals, $key.' = '.$value);
		}

		$q .= implode(', ', $vals);

		$q .= ' WHERE ';

		$vals = array();
		$where = $this->quote($where);
		foreach ($where as $key => $value) {
			array_push($vals, $key.' = '.$value);
		}
		$q .= implode(' AND ', $vals);

		$res = $this->pdo->exec($q);

		return $res;
	}

	public function delete($table,$where){

		$where = $this->quote($where);

		$q = "DELETE FROM $table WHERE ";

		foreach ($where as $key => $value) {
			$q .= "$key = ".($value);
		}

		$res = $this->pdo->query($q);

		return $res;
	}

	public function insert($table,$datas){

		$values = array_map([$this->pdo, 'quote'], $datas);

		$q = "INSERT INTO ".$table."(".implode(',', array_keys($datas)).") VALUES (".implode(',', $values).")";
		$prep = $this->pdo->prepare($q);

		$prep->execute($datas) or die(var_dump($prep->errorInfo()));

		return $this->pdo->lastInsertId();
	}

	public function count($table,$where){

		$q = "SELECT COUNT(*) FROM `".$table."` WHERE 1 ";

		foreach ($where as $col => $val) {
			$q .= 'AND '.$col.' = \''.$val.'\' ';
		}
		foreach ($this->pdo->query($q) as $key => $value) {
			return intval($value['COUNT(*)']);
		}

	}

	private function quote($ar){
		$res = array();

		foreach ($ar as $key => $value) {
			$value = str_replace('\'', '\\\'', $value);
			if(!preg_match('#^[0-9]+[,\.]?[0-9]+$#', $value)) $value = '\''.$value.'\'';
			$res['`'.$key.'`'] = $value;
		}

		return $res;
	}

	public function getPdo(){
		return $this->pdo;
	}

}