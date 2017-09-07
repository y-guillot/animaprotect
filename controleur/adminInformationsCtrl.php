<?php
	
	include_once 'controleur/commun/utilisateurFunc.php';
	
	/**
	 * Affichage des vues relatives aux messages de succès et erreurs
	 *
	 * @param unknown $success
	 * @param unknown $error
	 */
	function printMessage(&$success, &$error)
	{
		if(isset($success)) {
			include 'vue/adminInformations/succes.php';
		} elseif(isset($error)) {
			include 'vue/adminInformations/error.php';
		}
	}

	/*
	 * SCRIPT PRINCPAL
	 */
	if (isset($_SESSION[SESSION_ADMIN])) {
		
		$success = null;
		$error = null;
		
		// recuperer toutes les infos de l'administrateur depuis la base de données
		$user = $this->sgdb->getInformationsAdmin($_SESSION[SESSION_ADMIN]);
		
		// admnistrateur existant
		if ($user->getId() > 0) {
			
			require_once 'modele/formulaires/utilisateurForm.class.php';
			$form = new UtilisateurForm();
			$form->addHidden(MODIFIER, MODIFIER);
			$form->setUtilisateur($user);
			
			/*
			 * Modification des informations
			 */
			if (isset($_POST[MODIFIER])) {
			
				$oldForm = $form;
				$form = new UtilisateurForm();
				$form->addHidden(MODIFIER, MODIFIER);
				compileFormDatas($form, $oldForm);
				insertPostDatasIntoForm($form);
				verifierDuplicataMail($form, $oldForm, $this->sgdb);
	
				// mettre à jour des information (si nécessaire)
				if ($form->isValid()) {
					// Comparaion des nouvelles données avec les anciennes pour mise à jour éventuelle
					if ($user != $form->getUtilisateur()) {
						// Mise à jour des données
						if ($this->sgdb->updateUtilisateur($form->getUtilisateur()) > 0) {
							// TODO mettre à jour les données en SESSION
							$success = MODIFIER;
						// erreur de mise à jour
						} else {
							$error = MODIFIER;
						}
					// mise à jour inutile
					} else {
						$success = MODIFIER;
					}
				}
				
				printMessage($success, $error);
				if ($success) {
					include('vue/adminInformations/informations.php');
				} else {
					include('vue/adminInformations/informationsForm.php');
				}
			
			/*
			 * Mode Edition
			 */
			} elseif (isset($_GET[EDITER])) {
				printMessage($success, $error);
				include('vue/adminInformations/informationsForm.php');
			
			/*
			 * Mode Résumé
			 */
			} else {
				printMessage($success, $error);
				include('vue/adminInformations/informations.php');
			}
			
		} else {
			$error = ERROR_EXISTS;
			printMessage($success, $error);
		}
	}
?>