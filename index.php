<?php

	include 'config.php';
	include 'controleur/core/sgdbCtrl.class.php';
	include 'controleur/core/sessionCtrl.class.php';
	include 'controleur/core/affichagePageCtrl.class.php';
	
	// Connexion � la base de donn�es
	$sgdb = new SgdbCtrl();
	$sgdb->connexion();
	
	// controleur session
	$session = new SessionCtrl($sgdb);
	$session->execute();
	
	// controleur d'affichage de la page
	$page = new AffichagePageCtrl($sgdb, $session);
	$page->execute();

?>
