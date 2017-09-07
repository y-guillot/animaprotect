<?php
	
	include_once 'controleur/commun/proprietaireFunc.php';
	
	/**
	 * Affichage des vues relatives aux messages de succès et erreurs
	 *
	 * @param unknown $success
	 * @param unknown $error
	 */
	function printMessage(&$success, &$error)
	{
		if(isset($success)) {
			include 'vue/proprietaireInformations/succes.php';
		} elseif(isset($error)) {
			include 'vue/proprietaireInformations/error.php';
		}
	}

	/*
	 * SCRIPT PRINCPAL
	 */
	if (isset($_SESSION[SESSION_PROPRIETAIRE])) {
		
		$success = null;
		$error = null;
		
		// recuperer toutes les infos du proprietaire depuis la base de données
		$user = $_SESSION[SESSION_PROPRIETAIRE]->getUtilisateur();
		$proprietaire = $this->sgdb->getInformationsProprietaire($user);
		
		// proprietaire existant
		if ($proprietaire->getId() > 0) {
				
			require_once 'modele/formulaires/proprietaireForm.class.php';
			$form = new ProprietaireForm();
			$form->addHidden(MODIFIER, MODIFIER);
			$form->setProprietaire($proprietaire);
			
			/*
			 * Modification des données
			 */
			if (isset($_POST[MODIFIER])) {
			
				$oldForm = $form;
				$form = new ProprietaireForm();
				$form->addHidden(MODIFIER, MODIFIER);
				compileFormDatas($form, $oldForm);
				insertPostDatasIntoForm($form);
				verifierDuplicataMail($form, $oldForm, $this->sgdb);
					
				// mettre à jour des information (si nécessaire)
				if ($form->isValid()) {
					// Comparaion des nouvelles données avec les anciennes pour mise à jour éventuelle
					if ($proprietaire != $form->getProprietaire()) {
						// Mise à jour des données du proprietaire ( et utiisateur si besoin )
						if ($this->sgdb->updateProprietaire($form->getProprietaire()) > 0) {
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
					include('vue/proprietaireInformations/informations.php');
				} else {
					include('vue/proprietaireInformations/informationsForm.php');
				}
			
			/*
			 * Mode Edition
			 */
			} elseif (isset($_GET[EDITER])) {
				printMessage($success, $error);
				include('vue/proprietaireInformations/informationsForm.php');
			
			/*
			 * Mode Résumé
			 */
			} else {
				printMessage($success, $error);
				include('vue/proprietaireInformations/informations.php');
			}
			
		} else {
			$error = ERROR_EXISTS;
			printMessage($success, $error);
		}
	}
?>