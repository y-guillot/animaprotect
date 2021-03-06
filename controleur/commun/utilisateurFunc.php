<?php

	/**
	 * Compilation de donn�es post�es
	 *
	 * @param UtilisateurForm $form
	 * @param UtilisateurForm $oldForm
	 */
	function compileFormDatas(UtilisateurForm &$form, UtilisateurForm $oldForm)
	{
		
		// r�attribution des informations au nouveau formulaire
		$form->setId($oldForm->getId());
		$form->setIdRole($oldForm->getIdRole());
			
		// r�attribuer le mot de passe si l'utiisateur n'a rien rempli
		if (empty($_POST['pass'])) {
			$oldPass = $oldForm->getPassword();
			$form->setPassword($oldPass, false); // sans conversion sha1 (sinon il va s'appliquer une 2�me fois, puisque c'est le pass actuel dans la BDD)
		} else {
			$form->setPassword(@$_POST['pass']); // nouveau mot de passe saisi
		}
	}
	
	/**
	 * affectation des donnees postees au formulaire
	 * 
	 * @param UtilisateurForm $form
	 */
	function insertPostDatasIntoForm(UtilisateurForm &$form)
	{
		$form->setCivilite(@$_POST['civilite']);
		$form->setNom(@$_POST['nom']);
		$form->setPrenom(@$_POST['prenom']);
		$form->setMail(@$_POST['mail']);
		$form->setTel(@$_POST['tel']);
	}
	
	/**
	 * v�rifier l'existence d'une adresse mail similaire dans la base de donn�es
	 * 
	 * @param UtilisateurForm $form
	 * @param UtilisateurForm $oldForm
	 * @param SgdbCtrl $sgdb
	 */
	function verifierDuplicataMail(UtilisateurForm &$form, UtilisateurForm $oldForm, SgdbCtrl &$sgdb)
	{
		if ($form->getMail() != $oldForm->getMail()) {
			if ($form->isValid('mail')) {
				// g�n�rer un code d'erreur pour le formulaire
				if ($sgdb->isMailAlreadyExists($form->getUtilisateur())) {
					$form->setCodeError('mail', ERROR_EXISTS);
				}
			}
		}
	}
	
?>