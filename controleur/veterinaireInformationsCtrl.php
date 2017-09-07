<?php
	
	include_once 'controleur/commun/veterinaireFunc.php';
	include_once 'controleur/commun/commonFunc.php';
	
	/**
	 * Affichage des vues relatives aux messages de succ�s et erreurs
	 *
	 * @param unknown $success
	 * @param unknown $error
	 */
	function printMessage(&$success, &$error)
	{
		if(isset($success)) {
			include 'vue/veterinaireInformations/succes.php';
		} elseif(isset($error)) {
			include 'vue/veterinaireInformations/error.php';
		}
	}
	

	/*
	 * SCRIPT PRINCPAL
	 */
	if (isset($_SESSION[SESSION_VETERINAIRE])) {
		
		$success = null;
		$error = null;
		
		// recuperer toutes les infos du v�t�rinaire depuis la base de donn�es
		$user = $_SESSION[SESSION_VETERINAIRE]->getUtilisateur();
		$veterinaire = $this->sgdb->getInformationsVeterinaire($user);
		
		// veterinaire existant
		if ($veterinaire->getId()) {
	
			require_once 'modele/formulaires/veterinaireForm.class.php';
			$form = new VeterinaireForm();
			$form->addHidden(MODIFIER, MODIFIER);
			$form->setVeterinaire($veterinaire);
			
			// si des donnees sont postees
			if (isset($_POST[MODIFIER])) {
				
				/*
				 * Upload Photo Utilisateur
				 */
				if (isset($_FILES['file'])) {
					$user = $veterinaire->getUtilisateur();
					echo uploadUtilisateurPhotoToJson($_FILES['file'], $user);
					exit();
				}
				
				$oldForm = $form;
				$form = new VeterinaireForm();
				$form->addHidden(MODIFIER, MODIFIER);
				compileFormDatas($form, $oldForm);
				insertPostDatasIntoForm($form);
				verifierDuplicataMail($form, $oldForm, $this->sgdb);
					
				// mettre � jour des information (si n�cessaire)
				if ($form->isValid()) {
					// Comparaion des nouvelles donn�es avec les anciennes pour mise � jour �ventuelle
					if ($veterinaire != $form->getVeterinaire()) {
						// Mise � jour des donn�es du proprietaire ( et utiisateur si besoin )
						if ($this->sgdb->updateVeterinaire($form->getVeterinaire()) > 0) {
							$success = MODIFIER;
						// erreur de mise � jour
						} else {
							$error = MODIFIER;
						}
					// mise � jour inutile
					} else {
						$success = MODIFIER;
					}
				}
				
				printMessage($success, $error);
				if ($success) {
					include('vue/veterinaireInformations/informations.php');
				} else {
					include('vue/veterinaireInformations/informationsForm.php');
				}
		
			/*
			 * Mode Edition
			 */
			} elseif (isset($_GET[EDITER])) {
				printMessage($success, $error);
				include 'vue/veterinaireInformations/informationsForm.php';
				
			/*
			 * Mode R�sum�
			 */
			} else {
				printMessage($success, $error);
				include('vue/veterinaireInformations/informations.php');
			}
			
		} else {
			$error = ERROR_EXISTS;
			printMessage($success, $error);
		}
	}
?>