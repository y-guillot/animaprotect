<?php

	include 'controleur/commun/veterinaireFunc.php';
	include 'controleur/commun/commonFunc.php';

	/**
	 * Affichage des vues relatives aux messages de succès et erreurs
	 *
	 * @param unknown $success
	 * @param unknown $error
	 */
	function printMessage(&$success, &$error)
	{
		if(isset($success)) {
			include 'vue/adminVeterinaires/succes.php';
		} elseif(isset($error)) {
			include 'vue/adminVeterinaires/error.php';
		}
	}
	
	/*
	 * SCRIPT PRINCPAL
	 */
	if (isset($_SESSION[SESSION_ADMIN])) {
	
		$success = null;
		$error = null;
		require_once 'modele/formulaires/veterinaireForm.class.php';
		require_once 'modele/formulaires/animalForm.class.php';
		
		// inclusion inconditionnelle du moteur de recherche
		if (!isset($_FILES['file'])) {
			include 'vue/adminVeterinaires/search.php';
		}
	
		// messages de suppression reussi
		if (isset($_GET[SUPPRIMER]) && !isset($_GET['id'])) {
			$success = SUPPRIMER;
			printMessage($success, $error);
		}
		
		/*
		 * Ajout d'un nouveau praticien
		 */
		if (isset($_POST[AJOUTER])) {
			
			/*
			 * Upload Photo praticien
			 */
			if (isset($_FILES['file'])) {
				echo uploadUtilisateurTempPhotoToJson($_FILES['file'], $_SESSION[SESSION_ADMIN]);
				exit();
			}
			
			$form = new VeterinaireForm();
			$form->addHidden(AJOUTER, null);
			$form->setPassword(@$_POST['pass']);
			insertPostDatasIntoForm($form);
			
			if ($this->sgdb->isMailAlreadyExists($form->getUtilisateur())) {
				$form->setCodeError('mail', ERROR_EXISTS);
			}

			if ($form->isValid()) {
				$lastInsertId = $this->sgdb->insererVeterinaire($form->getVeterinaire());
				
				// déplacment photo uploadée si existante et redirection sur la fiche détail
				if ($lastInsertId > 0) {
					
					$user = new Utilisateur();
					$user->setId($lastInsertId);
					moveUtilisateurTempPhoto($_SESSION[SESSION_ADMIN], $user);
					
					$redirect = Tools::replaceOrAddUriParameter(AJOUTER, AJOUTER, null, Tools::getUri());
					$redirect = Tools::replaceOrAddUriParameter('id', 'id', $lastInsertId, $redirect);
					Tools::redirect($redirect);
				} else {
					$error = AJOUTER;
				}
			}
			
			printMessage($success, $error);
			include('vue/adminVeterinaires/informationsForm.php');

		/*
		 * Modifier les informations d'un client
		 */
		} elseif (isset($_POST[MODIFIER])) {
			
			// recuperer toutes les infos du veterinaire depuis la base de données
			$user = new Utilisateur();
			$user->setId($_POST[MODIFIER]);
			$veterinaire = $this->sgdb->getInformationsVeterinaire($user);

			// le veterinaire existe
			if ($veterinaire->getId()) {
				
				/*
				 * Upload Photo Utilisateur
				 */
				if (isset($_FILES['file'])) {
					echo uploadUtilisateurPhotoToJson($_FILES['file'], $user);
					exit();
				}
				
				
				$form = new VeterinaireForm();
				$form->setVeterinaire($veterinaire);
				
				// recuperer la liste des interventions du praticien
				$interventions = $this->sgdb->listInterventions($veterinaire);
				$form->setInterventions($interventions);

				$oldForm = $form;
				$form = new VeterinaireForm();

				$form->addHidden(MODIFIER, $veterinaire->getIdUtilisateur());
				compileFormDatas($form, $oldForm);
				verifierDuplicataMail($form, $oldForm, $this->sgdb);
				insertPostDatasIntoForm($form);
				
				// mettre à jour les informations (si nécessaire)
				if ($form->isValid()) {
					// Comparaion des nouvelles données avec les anciennes pour mise à jour éventuelle
					if ($veterinaire != $form->getVeterinaire()) {
						// Mise à jour des données du proprietaire ( et utiisateur si besoin )
						if ($this->sgdb->updateVeterinaire($form->getVeterinaire()) > 0) {
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
				if (isset($success)) {
					include 'vue/adminVeterinaires/informations.php';
				} else {
					include('vue/adminVeterinaires/informationsForm.php');
				}
				
			// le veterinaire n'existe pas
			} else {
				$error = ERROR_EXISTS;
				printMessage($success, $error);
			}
		}
		
		/*
		 * Rechercher un veterinaire
		 */
		elseif (isset($_GET[RECHERCHER])) {
			
			$veterinaires = $this->sgdb->getVeterinaires($_GET[RECHERCHER]);
			
			$forms = array();
			foreach ($veterinaires as $veterinaire) {
				$form = new VeterinaireForm();
				$form->setVeterinaire($veterinaire);
				$forms[] = $form;
			}
			include 'vue/adminVeterinaires/adminVeterinaires.php';
			
		/*
		 * Client identifié
		 */	
		} elseif (isset($_GET['id'])) {
			
			//recuperer toutes les infos du p depuis la base de données
			$user = new Utilisateur();
			$user->setId($_GET['id']);
			$veterinaire = $this->sgdb->getInformationsVeterinaire($user);
	
			// le veterinaire existe
			if ($veterinaire->getId()) {
				
				$form = new VeterinaireForm();
				$form->setVeterinaire($veterinaire);
				$form->addHidden(MODIFIER, $form->getIdUtilisateur());
				
				// recuperer la liste des interventions du praticien
				$interventions = $this->sgdb->listInterventions($veterinaire);
				$form->setInterventions($interventions);
				
				/*
				 * Supprimer un praticien
				 */
				if (isset($_GET[SUPPRIMER])) {
					if ($this->sgdb->supprimerUtilisateur($form->getUtilisateur()) > 0) {
						// redirction sur la liste des praticiens avec confirmation de suppression dans l'url
						$redirect = Tools::replaceOrAddUriParameter('id', null, null, Tools::getUri());
						$redirect = Tools::replaceOrAddUriParameter(EDITER, null, null, $redirect);
						$redirect = Tools::replaceOrAddUriParameter(SUPPRIMER, SUPPRIMER, null, $redirect);
						Tools::redirect($redirect);
					} else {
						$error = SUPPRIMER;
						printMessage($success, $error);
						include 'vue/adminVeterinaires/informationsForm.php';
					}
				
				/*
				 * Editer la fiche d'un veterinaire
				 */
				} elseif (isset($_GET[EDITER])) {
					include 'vue/adminVeterinaires/informationsForm.php';
				
				/*
				 * Fiche détail du veterinaire
				 */
				} else {
					if (isset($_GET[AJOUTER])) { // suite à 'jout d'un praticien
						$success = AJOUTER;
					}
					printMessage($success, $error);
					include 'vue/adminVeterinaires/informations.php';
				}

			// le veterinaire n'existe pas
			} else {
				$error = ERROR_EXISTS;
				printMessage($success, $error);
			}
		
		/*
		 * Nouvelle Fiche client
		 */
		} elseif (isset($_GET[AJOUTER])) {
			
			$form = new VeterinaireForm();
			$form->setDateArrivee(date('Y-m-d'));
			$form->addHidden(AJOUTER, null);
			
			include 'vue/adminVeterinaires/informationsForm.php';
		}
	}
	
?>