<?php

class Proprietaire {
	
	private $id;
	private $idUtilisateur;
	private $adresse;
	private $cp;
	private $ville;
	
	private $utilisateur;
	
	
 	function __construct()
 	{
       $this->utilisateur = new Utilisateur();
    }
	
    function __destruct()
    {
    	 
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
    
    function getAdresse()
    {
    	return $this->adresse;
    }
    
    function getCp()
    {
    	return $this->cp;
    }
    
    function getVille()
    {
    	return $this->ville;
    }
    
    function getUtilisateur()
    {
    	return $this->utilisateur;
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
   
    function setAdresse($adresse)
    {
    	$this->adresse = strtolower(trim($adresse)); // affectation inconditionnelle
		
		$result = ERROR_SIZE;
		if (Tools::isStringSizeBetween($this->adresse, 1, 255)) {
			$result = NO_ERROR;
		}
		
		return $result;
    }
    
    function setCp($cp)
    {
    	$this->cp = $cp;  // affectation inconditionnelle
    	
    	$result = ERROR_INTERVAL;
    	if (Tools::isPostCode($this->cp)) {
    		$result = NO_ERROR;
    	}
    	
    	return $result;
    }
    
    function setVille($ville)
    {
    	$this->ville = ucfirst(strtolower(trim($ville))); // affectation inconditionnelle
		
		$result = ERROR_SIZE;
		if (Tools::isStringSizeBetween($this->ville, 1, 30)) {
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