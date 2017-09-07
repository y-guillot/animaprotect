<?php

require_once 'modele/formulaires/form.php';
require_once 'tools/tools.class.php';

class AnimalForm extends Form {

 	private $animal;
 	private $races; // taleau : contient la liste des races disponibles pour l'espece
 	private $especes; // tableau : contient la liste de toutes les especes
 	
 	function __construct()
 	{
 		require_once 'modele/animal.class.php';
 		require_once 'modele/race.class.php';
 		require_once 'modele/espece.class.php';
 		
 		parent::__construct();
 		$this->animal = new Animal();
		$this->races = array();
		$this->especes = array();
		$this->requis = array('nom', 'date', 'idRace');
    }
 	
    // GETTERS
    
    function getId()
    {
    	return $this->animal->getId();
    }
    
    function getIdProprietaire()
    {
    	return $this->animal->getIdProprietaire();
    }
    
    function getNom()
    {
    	return $this->animal->getNom();
    }
    
    function getIdRace()
    {
    	return $this->animal->getIdRace();
    }
    
    function getPuce()
    {
    	return $this->animal->getPuce();
    }
    
    function getDateNaissance()
    {
    	return $this->animal->getDateNaissance();
    }
    
    function getSigneDistinctif()
    {
    	return $this->animal->getSigneDistinctif();
    }
    
    function getCommentaire()
    {
    	return $this->animal->getCommentaire();
    }
    
    function getRaces()
    {
    	return $this->races;
    }
    
    function getEspeces()
    {
    	return $this->especes;
    }
    
    function getNomEspece()
    {
    	return $this->animal->getEspece()->getNom();
    }
    
    function getIdEspece()
    {
    	return $this->animal->getEspece()->getId();
    }
    
    function getAnimal()
    {
    	return $this->animal;
    }
    
    function getInterventions()
    {
    	return $this->animal->getInterventions();
    }
    
    function getProprietaire()
    {
    	return $this->animal->getProprietaire();
    }
     
    function getNomRace()
    {
    	return $this->animal->getRace()->getNom();
    }
   
    
    // SETTERS
    
 	function setId($id)
    {
    	$this->errors['id'] = $this->animal->setId($id);
    }
    
    function setIdProprietaire($idProprietaire)
    {
    	$this->errors['idProprietaire'] = $this->animal->setIdProprietaire($idProprietaire);
    }
    
    function setNom($nom)
    {
    	$this->errors['nom'] = $this->animal->setNom($nom);
    }
    
    function setIdRace($idRace)
    {
    	$idRace = intval($idRace);
    	$this->errors['idRace'] = $this->animal->setIdRace($idRace);
    }
    
    function setPuce($puce)
    {
    	$this->errors['puce'] = $this->animal->setPuce($puce);
    }
    
    function setDateNaissance($date)
    {
    	$this->errors['date'] = $this->animal->setDateNaissance($date);
    }
    
    function setSigneDistinctif($signe)
    {
    	$this->errors['signe'] =  $this->animal->setSigneDistinctif($signe);
    }
    
    function setCommentaire($commentaire)
    {
    	$this->errors['commentaire'] = $this->animal->setCommentaire($commentaire);
    }
    
    function setRaces($races)
    {
    	$this->races = $races;
    }
    
    function setEspeces($especes)
    {
    	$this->especes = $especes;
    }
    
    function setAnimal(Animal $animal)
    {
    	$this->animal = $animal;
    }

 
 }