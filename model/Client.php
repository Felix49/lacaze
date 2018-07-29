<?php

class Client{

	private $id;
	private $nom;
	private $prenom;
	private $mail;
    private $telephone;
    private $postale;
	private $date_creation;

	function __construct($i,$n,$pr,$m,$tel,$po,$dc){
		$this->id = $i;
		$this->nom = $n;
		$this->prenom = $pr;
		$this->mail = $m;
        $this->telephone = $tel;
        $this->postale = $po;
		$this->date_creation = $dc;
	}

	public function render(){

		echo 'client .. TODO FUNC';
	}

	public function update($data){

		foreach ($data as $key => $value) {
			$this->$$key = $value;
		}

		return $this;

	}

	public function arraify(){
		return array(
			'id' => $this->id,
			'nom' => $this->nom,
			'prenom' => $this->prenom,
			'mail' => $this->mail,
            'telephone' => $this->telephone,
			'postale' => $this->postale,
			);
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
     * Gets the value of nom.
     *
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Gets the value of prenom.
     *
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Gets the value of mail.
     *
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Gets the value of telephone.
     *
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Gets the value of postale.
     *
     * @return mixed
     */
    public function getPostale()
    {
        return $this->postale;
    }

    /**
     * Sets the value of id.
     *
     * @param mixed $id the id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Sets the value of nom.
     *
     * @param mixed $nom the nom
     *
     * @return self
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Sets the value of prenom.
     *
     * @param mixed $prenom the prenom
     *
     * @return self
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Sets the value of mail.
     *
     * @param mixed $mail the mail
     *
     * @return self
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Sets the value of telephone.
     *
     * @param mixed $telephone the telephone
     *
     * @return self
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Sets the value of postale.
     *
     * @param mixed $postale the postale
     *
     * @return self
     */
    public function setPostale($postale)
    {
        $this->postale = $postale;

        return $this;
    }

    /**
     * Gets the value of date_creation.
     *
     * @return mixed
     */
    public function getDate_creation()
    {
        return $this->date_creation;
    }

    /**
     * Sets the value of date_creation.
     *
     * @param mixed $date_creation the date_creation
     *
     * @return self
     */
    public function setDate_creation($date_creation)
    {
        $this->date_creation = $date_creation;

        return $this;
    }
}