<?php

class Intervention {
	
	private $id;
	private $idVeterinaire;
	private $idAnimal;
	private $date;
	private $nature;
	private $tarif;
	private $compteRendu;

	private $animal;
	private $veterinaire;
	
	function __construct()
	{
		$this->animal = new Animal();
		$this->veterinaire = new Veterinaire();
	}

    // GETTERS
    
    function getId()
    {
    	return $this->id;
    }
    
    function getIdVeterinaire()
    {
    	return $this->idVeterinaire;
    }
    
    function getIdAnimal()
    {
    	return $this->idAnimal;
    }
    
    function getDate()
    {
    	return $this->date;
    }
    
	function getNature()
    {
    	return $this->nature;
    }

    function getTarif()
    {
    	return $this->tarif;
    }

	function getCompteRendu()
    {
    	return $this->compteRendu;
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
    
    function setIdVeterinaire($idVeterinaire)
    {
    	$this->idVeterinaire = $idVeterinaire; // affectation inconditionnelle
    	
    	$result = ERROR_INTERVAL;
    	if (!is_int($this->idVeterinaire)) {
    		$result = ERROR_TYPE;
    	} else {
	    	if ($this->idVeterinaire > 0) {
	    		$result = NO_ERROR;
	    	}
    	}
    	
    	return $result;
    }
    
    function setIdAnimal($idAnimal)
    {
    	$this->idAnimal = $idAnimal; // affectation inconditionnelle
    	
    	$result = ERROR_INTERVAL;
    	if (!is_int($this->idAnimal)) {
    		$result = ERROR_TYPE;
    	} else {
	    	if ($this->idAnimal > 0) {
	    		$result = NO_ERROR;
	    	}
    	}
    	
    	return $result;
    }
    
    function setDate($date)
    {
    	$this->date = $date; // affectation inconditionnelle
    	
    	$result = ERROR_DATE;
    	if (Tools::isDateValid($this->date)) {
    		$result = NO_ERROR;
    	}
    	
    	return $result;
    }
    
	function setNature($nature)
    {
    	$this->nature = $nature; // affectation inconditionnelle
		
		$result = ERROR_SIZE;
		if (Tools::isStringSizeBetween($this->nature, 1, 50)) {
			$result = NO_ERROR;
		}
		
		return $result;
    }

    function setTarif($tarif)
    {
    	$this->tarif = intval($tarif); // affectation inconditionnelle
    	
    	$result = ERROR_INTERVAL;
    	if (!is_int($this->tarif)) {
    		$result = ERROR_TYPE;
    	} else {
	    	if (Tools::isIntBetween($this->tarif, 0, 65534) ) { //smallint unsigned
	    		$result = NO_ERROR;
	    	}
    	}
    	
    	return $result;
    }

	function setCompteRendu($compteRendu)
    {
    	
    	$this->compteRendu = $compteRendu; // affectation inconditionnelle
		
		$result = ERROR_SIZE;
		if (Tools::isStringSizeBetween($this->compteRendu, 1, 1000)) {
			$result = NO_ERROR;
		}
		
		return $result;
    }
   
    
    // AUTRES ACCESSEURS
    
 
    function getVeterinaire()
    {
    	return $this->veterinaire;
    }
    
    function getAnimal()
    {
    	return $this->animal;
    }
    
    function setVeterinaire(Veterinaire $Veterinaire)
    {
    	$this->veterinaire = $Veterinaire;
    }
    
    function setProprietaire(Proprietaire $proprietaire)
    {
    	$this->animal->setProprietaire($proprietaire);
    }
    
    function setAnimal($animal)
    {
    	$this->animal = $animal;
    }
    
    function getNomVeterinaire()
    {
    	return $this->veterinaire->getUtilisateur()->getNom();
    }
    
    function getPrenomVeterinaire()
    {
    	return $this->veterinaire->getUtilisateur()->getPrenom();
    }
    
}

?>