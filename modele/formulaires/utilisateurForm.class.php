<?php

require_once 'modele/formulaires/form.php';

class UtilisateurForm extends Form {

 	private $utilisateur;
 	
 	function __construct()
 	{
 		require_once 'modele/utilisateur.class.php';
 		
 		parent::__construct();
 		$this->utilisateur = new Utilisateur();
		$this->requis = array('civilite', 'nom', 'prenom', 'tel', 'mail', 'password');
    }
 	
    // GETTERS
    
    function getNom()
    {
    	return $this->utilisateur->getNom();
    }
    
    function getPrenom()
    {
    	return $this->utilisateur->getPrenom();
    }
    
    function getTel()
    {
    	return $this->utilisateur->getTel();
    }
    
    function getMail()
    {
    	return $this->utilisateur->getMail();
    }
    
    function getPassword()
    {
    	return $this->utilisateur->getPassword();
    }

    function getCivilite()
    {
    	return $this->utilisateur->getCivilite();
    }
    
    function getUtilisateur()
    {
    	return $this->utilisateur;
    }
    
    function getId()
    {
    	return $this->utilisateur->getId();
    }
    
    function getIdRole()
    {
    	return $this->utilisateur->getIdRole();
    }

    
    // SETTERS
    
    function setNom($nom)
    {
    	$this->errors['nom'] = $this->utilisateur->setNom($nom);
    }
    
    function setPrenom($prenom)
    {
    	$this->errors['prenom'] = $this->utilisateur->setPrenom($prenom);
    }
    
    function setTel($tel)
    {
    	$this->errors['tel'] = $this->utilisateur->setTel($tel);
    }
    
    function setMail($mail)
    {
    	$this->errors['mail'] = $this->utilisateur->setMail($mail);
    }
    
    function setPassword($password, $crypt = true)
    {
    	$this->errors['password'] = $this->utilisateur->setPassword($password, $crypt);
    }
 
    function setCivilite($civ)
    {
    	$civ = intval($civ);
    	$this->errors['civilite'] =  $this->utilisateur->setCivilite($civ);
    }
    
    function setId($id)
    {
    	$id = intval($id);
    	$this->utilisateur->setId($id);
    }
    
    function setIdRole($id)
    {
    	$id = intval($id);
    	$this->utilisateur->setIdRole($id);
    }
    
    function setUtilisateur(Utilisateur $utilisateur)
    {
    	$this->utilisateur = $utilisateur;
    }
 
 }