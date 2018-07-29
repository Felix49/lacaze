<?php

class Reservation{

	public $id;
	public $dateDebut;
	public $dateFin;
	public $typeBien;
	public $nbPersonne;
	public $client;
	public $nbjours;
	public $nbEmplacement;

	function __construct($idobj,$dateDebutobj,$dateFinobj,$typeBienobj,$nbPersonneobj,$idClientobj = null){
		$this->id = $idobj;
		$this->dateDebut = DateTime::createFromFormat('Y-m-d',$dateDebutobj);
		$this->dateFin = DateTime::createFromFormat('Y-m-d',$dateFinobj);
		$this->typeBien = $typeBienobj;
		$this->nbPersonne = $nbPersonneobj;
		$this->client = $idClientobj;
		$this->nbjours = (strtotime($dateFinobj) - strtotime($dateDebutobj)) / (60*60*24);
	}

	public function render(){

		return array(
			'id' => $this->id,
			'dateDebut' => $this->dateDebut,
			'dateFin' => $this->dateFin,
			'typeBien' => $this->typeBien,
			'nbPersonne' => $this->nbPersonne,
			'client' => $this->client ? $this->client->arraify() : null,
			);
	}

	public function arraify(){
		return array(
			'id' => $this->id,
			'dateDebut' => $this->dateDebut,
			'dateFin' => $this->dateFin,
			'typeBien' => $this->typeBien,
			'nbPersonne' => $this->nbPersonne,
			'client' => $this->client ? $this->client->arraify() : null,
			);
	}

    public function update($param){
        $db = new DB();
        $db->update($param,['id' => $this->id],'reservations');
    }


    /**
     * Gets the value of id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the value of dateDebut.
     *
     * @return mixed
     */
    public function getDateDebut($format = false)
    {
        if($format){
            return $this->dateDebut->format($format);
        }else{
            return $this->dateDebut;
        }
    }

    /**
     * Gets the value of dateFin.
     *
     * @return mixed
     */
    public function getDateFin($format = false)
    {
        if($format){
            return $this->dateFin->format($format);
        }else{
            return $this->dateFin;
        }
    }

    /**
     * Gets the value of typeBien.
     *
     * @return mixed
     */
    public function getTypeBien()
    {
        return $this->typeBien;
    }

    /**
     * Gets the value of nbPersonne.
     *
     * @return mixed
     */
    public function getNbPersonne()
    {
        return $this->nbPersonne;
    }

    /**
     * Gets the value of client.
     *
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }
}