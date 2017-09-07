<?php

class Veterinaire {
	
	private $id;
	private $idUtilisateur;
	private $dateArrivee;
	private $codePracticien;
	
	private $utilisateur;
	
	
 	function __construct()
 	{
       $this->utilisateur = new Utilisateur();
    }
    
    // GETTERS
    
    function getId()
    {
    	return $this->id;
    }
    
    function getIdUtilisateur()
    {
    	return $this->idUtilisateur;
    }
    
    function getDateArrivee()
    {
    	return $this->dateArrivee;
    }
    
    function getCodePraticien()
    {
    	return $this->codePracticien;
    }
   
    function getUtilisateur()
    {
    	return $this->utilisateur;
    }
    
    function getNom()
    {
    	return $this->utilisateur->getNom();
    }
    
    function getPrenom()
    {
    	return $this->utilisateur->getPrenom();
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
    
    function setIdUtilisateur($idUtilisateur)
    {
    	$this->idUtilisateur = $idUtilisateur; // affectation inconditionnelle
    	
    	$result = ERROR_INTERVAL;
    	if (!is_int($this->idUtilisateur)) {
    		$result = ERROR_TYPE;
    	} else {
	    	if ($this->idUtilisateur > 0) {
	    		$result = NO_ERROR;
	    	}
    	}
    	
    	return $result;
    }
   
    function setDateArrivee($dateArrivee)
    {
    	$this->dateArrivee = $dateArrivee; // affectation inconditionnelle
    	
    	$result = ERROR_DATE;
    	if (Tools::isDateValid($this->dateArrivee)) {
    		$result = NO_ERROR;
    	}
    	
    	return $result;
    }
    
    function setCodePraticien($codePracticien)
    {
    	$this->codePracticien = $codePracticien; // affectation inconditionnelle
		
		$result = ERROR_SIZE;
		if (Tools::isStringSizeBetween($this->codePracticien, 1, 16)) {
			$result = NO_ERROR;
		}
		
		return $result;
    }
    
    function setUtilisateur(Utilisateur &$utilisateur)
    {
    	$this->utilisateur = $utilisateur;
    }
     
}

?>