<?php

class Espece {
	
	private $id;
	private $nom;
    
    // GETTERS
    
    function getId()
    {
    	return $this->id;
    }
    
    function getNom()
    {
    	return $this->nom;
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

    function setNom($nom)
    {
    	$this->nom = ucfirst(strtolower(trim($nom))); // affectation inconditionnelle
		
		$result = ERROR_SIZE;
		if (Tools::isStringSizeBetween($this->nom, 1, 30)) {
			$result = NO_ERROR;
		}
		
		return $result;
    }

}

?>