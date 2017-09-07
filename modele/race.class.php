<?php

class Race {
	
	private $id;
	private $idEspece;
	private $nom;
	
	private $espece;
    
    // GETTERS
    
    function getId()
    {
    	return $this->id;
    }
    
    function getIdEspece()
    {
    	return $this->idEspece;
    }
    
    function getNom()
    {
    	return $this->nom;
    }
    
    function getEspece()
    {
    	return $this->espece;
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
    
    function setIdEspece($idEspece)
    {
    	$this->idEspece = $idEspece; // affectation inconditionnelle
    	
    	$result = ERROR_INTERVAL;
    	if (!is_int($this->idEspece)) {
    		$result = ERROR_TYPE;
    	} else {
	    	if ($this->idEspece > 0) {
	    		$result = NO_ERROR;
	    	}
    	}
    	
    	return $result;
    }
    
    function setNom($nom)
    {
    	$this->nom = ucfirst(strtolower(trim($nom))); // affectation inconditionnelle
		
		$result = ERROR_SIZE;
		if (Tools::isStringSizeBetween($this->nom, 1, 30)) {
			$result = NO_ERROR;
		}
		
		return $result;
    }
    
    function setEspece(Espece $espece)
    {
    	$this->espece = $espece;
    }
 
}

?>