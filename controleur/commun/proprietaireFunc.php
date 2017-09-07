<?php

	/**
	 * Compilation de donn�es post�es
	 *
	 * @param ProprietaireForm $form
	 * @param ProprietaireForm $oldForm
	 */
	function compileFormDatas(ProprietaireForm &$form, ProprietaireForm $oldForm)
	{
		
		// r�attribution des informations au nouveau formulaire
		$form->getProprietaire()->getUtilisateur()->setId($oldForm->getProprietaire()->getIdUtilisateur());
		$form->getProprietaire()->getUtilisateur()->setIdRole($oldForm->getProprietaire()->getUtilisateur()->getIdRole());
		$form->getProprietaire()->setId($oldForm->getProprietaire()->getId());
		$form->getProprietaire()->setIdUtilisateur($oldForm->getProprietaire()->getIdUtilisateur());
			
		// r�attribuer le mot de passe si l'utiisateur n'a rien rempli
		if (empty($_POST['pass'])) {
			$oldPass = $oldForm->getProprietaire()->getUtilisateur()->getPassword();
			$form->setPassword($oldPass, false); // sans conversion sha1 (sinon il va s'appliquer une 2�me fois, puisque c'est le pass actuel dans la BDD)
		} else {
			$form->setPassword(@$_POST['pass']); // nouveau mot de passe saisi
		}
	}
	
	/**
	 * affectation des donnees postees au formulaire
	 * 
	 * @param ProprietaireForm $form
	 */
	function insertPostDatasIntoForm(ProprietaireForm &$form)
	{
		$form->setCivilite(@$_POST['civilite']);
		$form->setNom(@$_POST['nom']);
		$form->setPrenom(@$_POST['prenom']);
		$form->setMail(@$_POST['mail']);
		$form->setTel(@$_POST['tel']);
		$form->setAdresse(@$_POST['adresse']);
		$form->setVille(@$_POST['ville']);
		$form->setCp(@$_POST['cp']);
	}
	
	/**
	 * v�rifier l'existence d'une adresse mail similaire dans la base de donn�es
	 * 
	 * @param ProprietaireForm $form
	 * @param ProprietaireForm $oldForm
	 * @param SgdbCtrl $sgdb
	 */
	function verifierDuplicataMail(ProprietaireForm &$form, ProprietaireForm $oldForm, SgdbCtrl &$sgdb)
	{
		if ($form->getMail() != $oldForm->getMail()) {
			if ($form->isValid('mail')) {
				// g�n�rer un code d'erreur pour le formulaire
				if ($sgdb->isMailAlreadyExists($form->getProprietaire()->getUtilisateur())) {
					$form->setCodeError('mail', ERROR_EXISTS);
				}
			}
		}
	}
	
?>