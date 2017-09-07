<?php

include 'controleur/commun/proprietaireFunc.php';

// Si conneté : demande de se deconnecter avant de s'incrire
if (isset($_SESSION[SESSION_UTILISATEUR])) {
	$user = $_SESSION[SESSION_UTILISATEUR];
	include 'vue/inscription/deconnexion.php';
	
// Sinon :
} else {
	
	require_once 'modele/formulaires/proprietaireForm.class.php';
	$form = new ProprietaireForm();
	$form->addHidden(INSCRIPTION, null);
	
	// si des donnees sont postees
	if (isset($_POST[INSCRIPTION])) {

		// affectation des donnees postees au formulaire pour vérification
		insertPostDatasIntoForm($form, $this->sgdb);
		$form->setPassword(@$_POST['pass']);
		
		// vérifier l'existence d'une adresse mail similaire dans la base de données
		if ($form->isValid('mail')) {
			// générer un code d'erreur pour le formulaire
			if ($this->sgdb->isMailAlreadyExists($form->getUtilisateur())) {
				$form->setCodeError('mail', ERROR_EXISTS);
			}
		}
		// si valide : inscrire l'utilisateur dans la base puis le mettre en session afficher message OK sans le formulaire.
		if ($form->isValid()) {
			$lastInsertId = $this->sgdb->insererProprietaire($form->getProprietaire());
			// inserer dans la base de données le nouveau proprietaire
			if (isset($lastInsertId)) {
				$this->session->connecterUtilisateur($form->getUtilisateur());
				$success = true;
				include 'vue/inscription/succes.php';
			// afficher message d'eereur
			} else {
				include 'vue/inscription/error.php';
			}
		}
	}
	
	//afficher le formulaire
	if (!isset($success)) {
		include 'vue/inscription/inscriptionForm.php';
	}
}

?>