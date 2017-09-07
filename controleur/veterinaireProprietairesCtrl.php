<?php

	include 'controleur/commun/proprietaireFunc.php';
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
			include 'vue/veterinaireProprietaires/succes.php';
		} elseif(isset($error)) {
			include 'vue/veterinaireProprietaires/error.php';
		}
	}

	
	/*
	 * SCRIPT PRINCPAL
	 */
	if (isset($_SESSION[SESSION_VETERINAIRE])) {
	
		$success = null;
		$error = null;
		require_once 'modele/formulaires/proprietaireForm.class.php';
		require_once 'modele/formulaires/animalForm.class.php';
		
		// inclusion inconditionnelle du moteur de recherche
		include 'vue/veterinaireProprietaires/search.php';
	
		if (isset($_GET[SUPPRIMER]) && !isset($_GET['id'])) {
			$success = SUPPRIMER;
			printMessage($success, $error);
		}
		
		/*
		 * Ajout d'un nouveau client
		 */
		if (isset($_POST[AJOUTER])) {
			
			$form = new ProprietaireForm();
			$form->addHidden(AJOUTER, null);
			$form->setPassword(@$_POST['pass']);
			insertPostDatasIntoForm($form);
			
			if ($this->sgdb->isMailAlreadyExists($form->getProprietaire()->getUtilisateur())) {
				$form->setCodeError('mail', ERROR_EXISTS);
			}

			if ($form->isValid()) {
				$lastInsertId = $this->sgdb->insererProprietaire($form->getProprietaire());
				if ($lastInsertId > 0) {
					$redirect = Tools::replaceOrAddUriParameter(AJOUTER, AJOUTER, null, Tools::getUri());
					$redirect = Tools::replaceOrAddUriParameter('id', 'id', $lastInsertId, $redirect);
					Tools::redirect($redirect);
				} else {
					$error = AJOUTER;
				}
			}
			
			printMessage($success, $error);
			include('vue/veterinaireProprietaires/informationsForm.php');

		/*
		 * Modifier les informations d'un client
		 */
		} elseif (isset($_POST[MODIFIER])) {
			
			// recuperer toutes les infos du proprietaire depuis la base de données
			$user = new Utilisateur();
			$user->setId($_POST[MODIFIER]);
			$proprieraire = $this->sgdb->getInformationsProprietaire($user);
			
			// le proprietaire existe
			if ($proprieraire->getId()) {
				$form = new ProprietaireForm();
				$form->setProprietaire($proprieraire);

				$oldForm = $form;
				$form = new ProprietaireForm();

				$form->addHidden(MODIFIER, $proprieraire->getIdUtilisateur());
				compileFormDatas($form, $oldForm);
				verifierDuplicataMail($form, $oldForm, $this->sgdb);
				insertPostDatasIntoForm($form);
				
				// mettre à jour les informations (si nécessaire)
				if ($form->isValid()) {
					// obtenir les informations sur l'ensemble des animaux possédés par le proprietaire
					$forms = getProprietaireAnimaux($proprieraire, $this->sgdb);
					// récupérer la liste de toutes les especes existantes
					$especes = $this->sgdb->getEspeces();
					// Comparaion des nouvelles données avec les anciennes pour mise à jour éventuelle
					if ($proprieraire != $form->getProprietaire()) {
						// Mise à jour des données du proprietaire ( et utitisateur si besoin )
						if ($this->sgdb->updateProprietaire($form->getProprietaire()) > 0) {
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
					include 'vue/veterinaireProprietaires/informations.php';
				} else {
					include('vue/veterinaireProprietaires/informationsForm.php');
				}
				
			// le proprietaire n'existe pas
			} else {
				$error = ERROR_EXISTS;
				printMessage($success, $error);
			}
		}
		
		/*
		 * Rechercher un client
		 */
		elseif (isset($_GET[RECHERCHER])) {
			
			$proprietaires = $this->sgdb->getProprietaires($_GET[RECHERCHER]);
			
			$forms = array();
			foreach ($proprietaires as $proprieraire) {
				$form = new ProprietaireForm();
				$form->setProprietaire($proprieraire);
				$forms[] = $form;
			}
			include 'vue/veterinaireProprietaires/veterinaireProprietaires.php';
			
		/*
		 * Client identifié
		 */	
		} elseif (isset($_GET['id'])) {
			
			// recuperer toutes les infos du proprietaire depuis la base de données
			$user = new Utilisateur();
			$user->setId($_GET['id']);
			$proprieraire = $this->sgdb->getInformationsProprietaire($user);
	
			// le proprietaire existe
			if ($proprieraire->getId()) {
				
				$form = new ProprietaireForm();
				$form->setProprietaire($proprieraire);
				$form->addHidden(MODIFIER, $form->getIdUtilisateur());
				
				/*
				 * Supprimer un client
				 */
				if (isset($_GET[SUPPRIMER])) {
					if ($this->sgdb->supprimerUtilisateur($form->getUtilisateur()) > 0) {
						// redirction sur la liste des clients avec confirmation de suppression dans l'url
						$redirect = Tools::replaceOrAddUriParameter('id', null, null, Tools::getUri());
						$redirect = Tools::replaceOrAddUriParameter(EDITER, null, null, $redirect);
						$redirect = Tools::replaceOrAddUriParameter(SUPPRIMER, SUPPRIMER, null, $redirect);
						Tools::redirect($redirect);
					} else {
						$error = SUPPRIMER;
						printMessage($success, $error);
						include 'vue/veterinaireProprietaires/informationsForm.php';
					}
				
				/*
				 * Editer la fiche d'un client
				 */
				} elseif (isset($_GET[EDITER])) {
					include 'vue/veterinaireProprietaires/informationsForm.php';
				
				/*
				 * Fiche détail du client
				 */
				} else {
					// récupérer la liste de toutes les especes existantes
					$especes = $this->sgdb->getEspeces();
					// obtenir les informations sur l'ensemble des animaux possédés par le proprietaire
					$forms = getProprietaireAnimaux($proprieraire, $this->sgdb);
					
					if (isset($_GET[AJOUTER])) { // suite à l'ajout d'un client
						$success = AJOUTER;
					}
					printMessage($success, $error);
					include 'vue/veterinaireProprietaires/informations.php';
				}

			// le proprietaire n'existe pas
			} else {
				$error = ERROR_EXISTS;
				printMessage($success, $error);
			}
		
		/*
		 * Nouvelle Fiche client
		 */
		} elseif (isset($_GET[AJOUTER])) {
			
			$form = new ProprietaireForm();
			$form->addHidden(AJOUTER, null);
			
			include 'vue/veterinaireProprietaires/informationsForm.php';
		}
	}
	
?>