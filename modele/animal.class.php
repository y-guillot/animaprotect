<?php

class Animal {
	
	private $id;
	private $idRace;
	private $idProprietaire;
	private $puce;
	private $nom;
	private $date_naissance;
	private $signe_distinctif;
	private $commentaire;
	
	private $race;
	private $espece;
	private $proprietaire;
	private $interventions; // array contenant les intenventions
	
    function __construct()
    {
    	$this->proprietaire = new Proprietaire();
    	$this->race = new Race();
    	$this->espece = new Espece();
    }
	
	
    // GETTERS
    
    function getId()
    {
    	return $this->id;
    }
    
    function getIdRace()
    {
    	return $this->idRace;
    }
    
    function getNom()
    {
    	return $this->nom;
    }
    
    function getIdProprietaire()
    {
    	return $this->idProprietaire;
    }
    
	function getPuce()
    {
    	return $this->puce;
    }

    function getDateNaissance()
    {
    	return $this->date_naissance;
    }

	function getSigneDistinctif()
    {
    	return $this->signe_distinctif;
    }

    function getCommentaire()
    {
    	return $this->commentaire;
    }

    // SETTERS
    
    function setId($id)
    {
    	$this->id = $id; // affectation inconditionnelle
    	
    	$result = ERROR_INTERVAL;
    	if (!is_int($this->id)) {
    		$result = ERROR_TYPE;
    	} else {
    		if ($this->id > 0) {
    			$result = NO_ERROR;
    		}
    	}
    	 
    	return $result;
    }
    
    function setIdRace($idRace)
    {
    	$this->idRace = $idRace;  // affectation inconditionnelle
    	
    	$result = ERROR_INTERVAL;
    	if (!is_int($this->idRace)) {
    		$result = ERROR_TYPE;
    	} else {
    		if ($this->idRace > 0) {
    			$result = NO_ERROR;
    		}
    	}
    	 
    	return $result;
    }
    
    function setIdProprietaire($idProprietaire)
    {
    	$this->idProprietaire = $idProprietaire;  // affectation inconditionnelle
    	
    	$result = ERROR_INTERVAL;
    	if (!is_int($this->idProprietaire)) {
    		$result = ERROR_TYPE;
    	} else {
    		if ($this->idProprietaire > 0) {
    			$result = NO_ERROR;
    		}
    	}
    	
    	return $result;
    }
    
    function setPuce($puce)
    {
    	$this->puce = $puce; // affectation inconditionnelle
    	
    	$result = ERROR_SIZE;
    	if (Tools::isStringSizeBetween($this->puce, 0, 15)) {
    		$result = NO_ERROR;
    	}
    	
    	return $result;
    }
    
    function setNom($nom)
    {
    	$this->nom = $nom; // affectation inconditionnelle
    	
    	$result = ERROR_SIZE;
    	if (Tools::isStringSizeBetween($this->nom, 2, 30)) {
    		$result = NO_ERROR;
    	}
    	 
    	return $result;
    }

    function setDateNaissance($date_naissance)
    {
    	$this->date_naissance = $date_naissance; // affectation inconditionnelle
    	
    	$result = ERROR_DATE;
    	if (Tools::isDateValid($date_naissance)) {
    		$result = NO_ERROR;
    	}
    	
    	return $result;
    }
    
    function setSigneDistinctif($signe_distinctif)
    {
    	$this->signe_distinctif = $signe_distinctif; // affectation inconditionnelle
    	
    	$result = ERROR_SIZE;
    	if (Tools::isStringSizeBetween($this->signe_distinctif, 0, 255)) {
    		$result = NO_ERROR;
    	}
    	 
    	return $result;
    }
    
    function setCommentaire($commentaire)
    {
    	$this->commentaire = $commentaire; // affectation inconditionnelle
    	
    	$result = ERROR_SIZE;
    	if (Tools::isStringSizeBetween($this->commentaire, 0, 255)) {
    		$result = NO_ERROR;
    	}
    	
    	return $result;
    }
   
    
    // AUTRES ACCESSEURS
    

    function setRace(Race $race)
    {
    	$this->race = $race;
    }
    
    function setEspece(Espece $espece)
    {
    	$this->espece = $espece;
    }
    
    function setInterventions($interventions)
    {
    	$this->interventions = $interventions;
    }
    
    function setProprietaire($proprietaire)
    {
    	$this->proprietaire = $proprietaire;
    }
    
    function getRace()
    {
    	return $this->race;
    }
    
    function getEspece()
    {
    	return $this->espece;
    }
    
    function getInterventions()
    {
    	return $this->interventions;
    }
    
    function getProprietaire()
    {
    	return $this->proprietaire;
    }
    
    
    
}

?>