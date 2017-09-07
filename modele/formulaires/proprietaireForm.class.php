<?php

require_once 'modele/formulaires/form.php';

class ProprietaireForm extends Form {

 	private $proprietaire;
 	private $animaux;
 	
 	function __construct()
 	{
 		require_once 'modele/proprietaire.class.php';
 		require_once 'modele/utilisateur.class.php';
 		
 		parent::__construct();
 		$this->proprietaire = new Proprietaire();
		$this->requis = array('civilite', 'nom', 'prenom', 'tel', 'mail', 'password', 'adresse', 'cp', 'ville' );
    }
	
    function __destruct()
    {
    	 
    }
 	
    // GETTERS
    
    function getNom()
    {
    	return $this->proprietaire->getUtilisateur()->getNom();
    }
    
    function getPrenom()
    {
    	return $this->proprietaire->getUtilisateur()->getPrenom();
    }
    
    function getTel()
    {
    	return $this->proprietaire->getUtilisateur()->getTel();
    }
    
    function getMail()
    {
    	return $this->proprietaire->getUtilisateur()->getMail();
    }
    
    function getPassword()
    {
    	return $this->proprietaire->getUtilisateur()->getPassword();
    }
    
    function getAdresse()
    {
    	return $this->proprietaire->getAdresse();
    }
    
    function getCp()
    {
    	return $this->proprietaire->getCp();
    }
    
    function getVille()
    {
    	return $this->proprietaire->getVille();
    }
    
    function getCivilite()
    {
    	return $this->proprietaire->getUtilisateur()->getCivilite();
    }
    
    function getProprietaire()
    {
    	return $this->proprietaire;
    }
    
    function getUtilisateur()
    {
    	return $this->proprietaire->getUtilisateur();
    }
    
    function getIdUtilisateur()
    {
    	return $this->proprietaire->getUtilisateur()->getId();
    }
    
    function getAnimaux()
    {
    	return $this->animaux;
    }

    
    // SETTERS
    
    function setNom($nom)
    {
    	$this->errors['nom'] = $this->proprietaire->getUtilisateur()->setNom($nom);
    }
    
    function setPrenom($prenom)
    {
    	$this->errors['prenom'] = $this->proprietaire->getUtilisateur()->setPrenom($prenom);
    }
    
    function setTel($tel)
    {
    	$this->errors['tel'] = $this->proprietaire->getUtilisateur()->setTel($tel);
    }
    
    function setMail($mail)
    {
    	$this->errors['mail'] = $this->proprietaire->getUtilisateur()->setMail($mail);
    }
    
    function setPassword($password, $crypt = true)
    {
    	$this->errors['password'] = $this->proprietaire->getUtilisateur()->setPassword($password, $crypt);
    }
    
    function setAdresse($adresse)
    {
    	$this->errors['adresse'] =  $this->proprietaire->setAdresse($adresse);
    }
    
    function setCp($cp)
    {
    	$this->errors['cp'] = $this->proprietaire->setCp($cp);
    }
    
    function setVille($ville)
    {
    	$this->errors['ville'] =  $this->proprietaire->setVille($ville);
    }
    
    function setCivilite($civ)
    {
    	$civ = intval($civ);
    	$this->errors['civilite'] =  $this->proprietaire->getUtilisateur()->setCivilite($civ);
    }
    
    function setProprietaire(Proprietaire $proprietaire)
    {
    	$this->proprietaire = $proprietaire;
    }
    
    function setAnimaux($animaux)
    {
    	$this->animaux = $animaux;
    }
 
 }