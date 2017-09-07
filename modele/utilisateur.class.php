<?php

class Utilisateur {
	
	private $id;
	private $idRole;
	private $civilite;
	private $nom;
	private $prenom;
	private $mail;
	private $password;
	private $tel;
	
 	function __construct()
 	{
 		require_once 'tools/tools.class.php';
    }
	
    function __destruct()
    {
    	 
    }
    
    // GETTERS
    
    function getId()
    {
    	return $this->id;
    }
    
    function getIdRole()
    {
    	return $this->idRole;
    }
    
    function getMail()
    {
    	return $this->mail;
    }
    
    function getPassword()
    {
    	return $this->password;
    }
    
	function getNom()
    {
    	return $this->nom;
    }
    
    function getPrenom()
    {
    	return $this->prenom;
    }
    
    function getTel()
    {
    	return $this->tel;
    }
    
    function getCivilite()
    {
    	return $this->civilite;
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
    
    function setIdRole($idRole)
    {
    	$this->idRole = $idRole; // affectation inconditionnelle
    	
    	$result = ERROR_INTERVAL;
    	if (!is_int($this->idRole)) {
    		$result = ERROR_TYPE;
    	} else {
    		if (Tools::isIntBetween($this->idRole, 1, 3)) {
	    		$result = NO_ERROR;
	    	}
    	}
    	
    	return $result;
    }
    
    function setNom($nom)
    {
		$this->nom = strtoupper(trim($nom)); // affectation inconditionnelle
		
		$result = ERROR_SIZE;
		if (Tools::isStringSizeBetween($this->nom, 2, 50)) {
			$result = NO_ERROR;
		}
		
		return $result;
    }
    
    function setPrenom($prenom)
    {
    	$this->prenom = ucfirst(strtolower(trim($prenom))); // affectation inconditionnelle
    	$result = ERROR_SIZE;
    	if (Tools::isStringSizeBetween($this->prenom, 2, 50)) {
    		$result = NO_ERROR;
    	}
    	
    	return $result;
    }
    
    function setMail($mail)
    {
    	$this->mail = strtolower(trim($mail)); // affectation inconditionnelle
    	
    	$result = ERROR_SIZE;
    	if (Tools::isStringSizeBetween($this->mail, 7, 100)) {
    		if (filter_var($this->mail, FILTER_VALIDATE_EMAIL)) {
    			$result = NO_ERROR;
    		} else {
    			$result = ERROR_REGEX;
    		}
    	}
    	
    	return $result;	
    }
    
    function setPassword($password, $crypt = true)
    {
    	$original = $password;
    	if (isset($password) && $crypt) {
    		$password = sha1($password);
    	}
    	$this->password = isset($password) ? $password : null; // affectation inconditionnelle
    	
    	$result = ERROR_REGEX;
    	if (Tools::isPasswordSecured($original)) {
	    	$result = NO_ERROR;
    	}
    	
    	return $result;
    }
    
    function setTel($tel)
    {
    	
    	$this->tel = Tools::convertToPhoneNumber($tel); // affectation inconditionnelle
    	
    	$result = ERROR_REGEX;
    	if (Tools::isPhoneNumber($this->tel)) {
    		$result = NO_ERROR;
    	}
    	 
    	return $result;
    }
    
    function setCivilite($civ)
    {
    	$this->civilite = $civ; // affectation inconditionnelle
    	 
    	$result = ERROR_INTERVAL;
    	if (!is_int($this->civilite)) {
    		$result = ERROR_TYPE;
    	} else {
	    	if (Tools::isIntBetween($this->civilite, 1, 3)) {
	    		$result = NO_ERROR;
	    	}
    	}
    	 
    	return $result;
    }
    
}

?>