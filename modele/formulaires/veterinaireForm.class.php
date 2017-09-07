<?php

require_once 'modele/formulaires/form.php';

class VeterinaireForm extends Form {

 	private $veterinaire;
 	private $interventions;
 	
 	function __construct()
 	{
 		require_once 'modele/veterinaire.class.php';
 		require_once 'modele/utilisateur.class.php';
 		
 		parent::__construct();
 		$this->veterinaire = new Veterinaire();
		$this->requis = array('civilite', 'nom', 'prenom', 'tel', 'mail', 'password', 'date_arrivee', 'code_praticien');
    }
	
    function __destruct()
    {
    	 
    }
 	
    // GETTERS
    
    function getNom()
    {
    	return $this->veterinaire->getUtilisateur()->getNom();
    }
    
    function getPrenom()
    {
    	return $this->veterinaire->getUtilisateur()->getPrenom();
    }
    
    function getTel()
    {
    	return $this->veterinaire->getUtilisateur()->getTel();
    }
    
    function getMail()
    {
    	return $this->veterinaire->getUtilisateur()->getMail();
    }
    
    function getPassword()
    {
    	return $this->veterinaire->getUtilisateur()->getPassword();
    }
    
    function getDateArrivee()
    {
    	return $this->veterinaire->getDateArrivee();
    }
    
    function getCodePraticien()
    {
    	return $this->veterinaire->getCodePraticien();
    }
    
    function getCivilite()
    {
    	return $this->veterinaire->getUtilisateur()->getCivilite();
    }

    function getVeterinaire()
    {
    	return $this->veterinaire;
    }
    
    function getUtilisateur()
    {
    	return $this->veterinaire->getUtilisateur();
    }
    
    function getIdVeterinaire()
    {
    	return $this->veterinaire->getId();
    }
    
    function getIdUtilisateur()
    {
    	return $this->veterinaire->getIdUtilisateur();
    }
    
    function getInterventions()
    {
    	return $this->interventions;
    }

    
    // SETTERS
    
    function setNom($nom)
    {
    	$this->errors['nom'] = $this->veterinaire->getUtilisateur()->setNom($nom);
    }
    
    function setPrenom($prenom)
    {
    	$this->errors['prenom'] = $this->veterinaire->getUtilisateur()->setPrenom($prenom);
    }
    
    function setTel($tel)
    {
    	$this->errors['tel'] = $this->veterinaire->getUtilisateur()->setTel($tel);
    }
    
    function setMail($mail)
    {
    	$this->errors['mail'] = $this->veterinaire->getUtilisateur()->setMail($mail);
    }
    
    function setPassword($password, $crypt = true)
    {
    	$this->errors['password'] = $this->veterinaire->getUtilisateur()->setPassword($password, $crypt);
    }
    
    function setDateArrivee($date)
    {
    	$this->errors['date_arrivee'] =  $this->veterinaire->setDateArrivee($date);
    }
    
    function setCodePraticien($code)
    {
    	$this->errors['code_praticien'] = $this->veterinaire->setCodePraticien($code);
    }
    
    function setCivilite($civ)
    {
    	$civ = intval($civ);
    	$this->errors['civilite'] =  $this->veterinaire->getUtilisateur()->setCivilite($civ);
    }
    
    function setVeterinaire(Veterinaire $veterinaire)
    {
    	$this->veterinaire = $veterinaire;
    }
    
    function setInterventions($interventions)
    {
    	$this->interventions = $interventions;
    }
 
 }