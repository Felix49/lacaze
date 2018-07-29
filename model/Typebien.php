<?php

class Typebien{

	private $id;
	private $nom;
	private $nbPlaces;

	function __construct($i,$n,$nb){
		$this->id = $i;
		$this->nom = $n;
		$this->nbPlaces = $tel;
	}

	public function render(){
		return array(
			'id' => $this->id,
			'nom' => $this->nom,
			'prenom' => $this->prenom,
			'mail' => $this->mail,
			'telephone' => $this->telephone,
			);
	}

}