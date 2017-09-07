<?php

	/**
	 * Compilation de donn�es post�es
	 * 
	 * @param VeterinaireForm $form
	 * @param VeterinaireForm $oldForm
	 */
	function compileFormDatas(VeterinaireForm &$form, VeterinaireForm $oldForm)
	{
		// r�attribution des informations au nouveau formulaire
		$form->getVeterinaire()->getUtilisateur()->setId($oldForm->getVeterinaire()->getIdUtilisateur());
		$form->getVeterinaire()->getUtilisateur()->setIdRole($oldForm->getVeterinaire()->getUtilisateur()->getIdRole());
		$form->getVeterinaire()->setId($oldForm->getVeterinaire()->getId());
		$form->getVeterinaire()->setIdUtilisateur($oldForm->getVeterinaire()->getIdUtilisateur());
		$form->setInterventions($oldForm->getInterventions());
		
		// r�attribuer le mot de passe si l'utiisateur n'a rien rempli
		if (empty($_POST['pass'])) {
			$oldPass = $oldForm->getVeterinaire()->getUtilisateur()->getPassword();
			$form->setPassword($oldPass, false); // sans conversion sha1 (sinon il va s'appliquer une 2�me fois, puisque c'est le pass actuel dans la BDD)
		} else {
			$form->setPassword(@$_POST['pass']); // nouveau mot de passe saisi
		}
	}
	
	/**
	 * affectation des donnees postees au formulaire
	 * 
	 * @param VeterinaireForm $form
	 */
	function insertPostDatasIntoForm(VeterinaireForm &$form)
	{
		$form->setCivilite(@$_POST['civilite']);
		$form->setNom(@$_POST['nom']);
		$form->setPrenom(@$_POST['prenom']);
		$form->setMail(@$_POST['mail']);
		$form->setTel(@$_POST['tel']);
		$form->setDateArrivee(@$_POST['date_arrivee']);
		$form->setCodePraticien(@$_POST['code_praticien']);
	}
	
	/**
	 * v�rifier l'existence d'une adresse mail similaire dans la base de donn�es
	 * 
	 * @param VeterinaireForm $form
	 * @param VeterinaireForm $oldForm
	 * @param SgdbCtrl $sgdb
	 */
	function verifierDuplicataMail(VeterinaireForm &$form, VeterinaireForm $oldForm, SgdbCtrl &$sgdb)
	{
		if ($form->getMail() != $oldForm->getMail()) {
			if ($form->isValid('mail')) {
				// g�n�rer un code d'erreur pour le formulaire
				if ($sgdb->isMailAlreadyExists($form->getVeterinaire()->getUtilisateur())) {
					$form->setCodeError('mail', ERROR_EXISTS);
				}
			}
		}
	}
?>