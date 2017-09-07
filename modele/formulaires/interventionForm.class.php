<?php

require_once 'modele/formulaires/form.php';
require_once 'tools/tools.class.php';

class InterventionForm extends Form {

 	private $intervention;
 	
 	function __construct()
 	{
 		require_once 'modele/animal.class.php';
 		
 		parent::__construct();
		$this->intervention = new Intervention();
		$this->requis = array('date', 'nature', 'tarif', 'compte_rendu');
    }
    
 	
    // GETTERS
    
    function getDate()
    {
    	return $this->intervention->getDate();
    }
    
    function getNature()
    {
    	return $this->intervention->getNature();
    }
    
    function getTarif()
    {
    	return $this->intervention->getTarif();
    }
    
    function getCompteRendu()
    {
    	return $this->intervention->getCompteRendu();
    }
    
    function getIntervention()
    {
    	return $this->intervention;
    }
    
    function getId()
    {
    	return $this->intervention->getId();
    }
    
    function getNomVeterinaire()
    {
    	return $this->intervention->getNomVeterinaire();
    }
    
    function getVeterinaire()
    {
    	return $this->intervention->getVeterinaire();
    }
    
    function getPrenomVeterinaire()
    {
    	return $this->intervention->getPrenomVeterinaire();
    }
    
    function getAnimal()
    {
    	return $this->intervention->getAnimal();
    }
    
    function getIdAnimal()
    {
    	return $this->intervention->getIdAnimal();
    }
    
    function getIdVeterinaire()
    {
    	return $this->intervention->getIdVeterinaire();
    }
    
    function getNomAnimal()
    {
    	return $this->intervention->getAnimal()->getNom();
    }
    
    function getNomRace()
    {
    	return $this->intervention->getAnimal()->getRace()->getNom();
    }
    
    function getPuce()
    {
    	return $this->intervention->getAnimal()->getPuce();
    }
    
    function getDateNaissance()
    {
    	return $this->intervention->getAnimal()->getDateNaissance();
    }
    
    function getSigneDistinctif()
    {
    	return $this->intervention->getAnimal()->getSigneDistinctif();
    }
    
    function getCommentaire()
    {
    	return $this->intervention->getAnimal()->getCommentaire();
    }
    
    function getInterventions()
    {
    	return $this->intervention->getAnimal()->getInterventions();
    }
    
    function getCivilite()
    {
    	return $this->intervention->getAnimal()->getProprietaire()->getUtilisateur()->getCivilite();
    }
    
    function getNom()
    {
    	return $this->intervention->getAnimal()->getProprietaire()->getUtilisateur()->getNom();
    }
    
    function getPrenom()
    {
    	return $this->intervention->getAnimal()->getProprietaire()->getUtilisateur()->getPrenom();
    }
    
    function getMail()
    {
    	return $this->intervention->getAnimal()->getProprietaire()->getUtilisateur()->getMail();
    }
    
    function getTel()
    {
    	return $this->intervention->getAnimal()->getProprietaire()->getUtilisateur()->getTel();
    }
    
    function getAdresse()
    {
    	return $this->intervention->getAnimal()->getProprietaire()->getAdresse();
    }
    
    function getVille()
    {
    	return $this->intervention->getAnimal()->getProprietaire()->getVille();
    }
    
    function getCp()
    {
    	return $this->intervention->getAnimal()->getProprietaire()->getCp();
    }
    
    function getIdUtilisateur()
    {
    	return $this->intervention->getAnimal()->getProprietaire()->getIdUtilisateur();
    }
    
    
     
    // SETTERS
    
    function setDate($date)
    {
    	$this->errors['date'] =  $this->intervention->setDate($date);
    }
    
    function setNature($nature)
    {
    	$this->errors['nature'] =  $this->intervention->setNature($nature);
    }
    
    function setTarif($tarif)
    {
    	$this->errors['tarif'] =  $this->intervention->setTarif($tarif);
    }
    
    function setCompteRendu($compteRendu)
    {
    	$this->errors['compte_rendu'] =  $this->intervention->setCompteRendu($compteRendu);
    }
    
    function setIntervention(Intervention $intervention)
    {
    	$this->intervention = $intervention;
    }
    
    function setAnimal(Animal $animal)
    {
    	$this->intervention->setAnimal($animal);
    }
    
    function setIdVeterinaire($id)
    {
    	$id = intval($id);
    	$this->intervention->setIdVeterinaire($id);
    }
    
    function setVeterinaire(Veterinaire $veterinaire)
    {
    	$this->intervention->setVeterinaire($veterinaire);
    }
    
    function setId($id)
    {
    	$id = intval($id);
    	$this->intervention->setId($id);
    }
    
    function setIdAnimal($id)
    {
    	$id = intval($id);
    	$this->intervention->setIdAnimal($id);
    }
 
   
 }