<?php

	include 'controleur/commun/commonFunc.php';
	include 'controleur/commun/interventionFunc.php';
	
	/**
	 * Affichage des vues relatives aux messages de succès et erreurs
	 *
	 * @param unknown $success
	 * @param unknown $error
	 */
	function printMessage(&$success, &$error)
	{
		if(isset($success)) {
			include 'vue/veterinaireInterventions/succes.php';
		} elseif(isset($error)) {
			include 'vue/veterinaireInterventions/error.php';
		}
	}
	
	/**
	 * Obtenir les informations sur le patient et le client
	 * 
	 * @param Intervention $intervention
	 * @param SgdbCtrl $sgdb
	 * @return Intervention
	 */
	function getExtraInformations(Intervention &$intervention, SgdbCtrl &$sgdb)
	{
		// récupérer les informations sur l'animal
		$animal = new Animal();
		$animal->setId($intervention->getIdAnimal());
		$sgdb->getInformationsAnimal($animal);
		$intervention->setAnimal($animal);
		// récupérer les informations sur le proprietaire
		$proprietaire = new Proprietaire();
		$proprietaire->setId($animal->getIdProprietaire());
		$sgdb->getProprietaire($proprietaire);
		$intervention->setProprietaire($proprietaire);
		
		return $intervention;
	}
	
	/*
	 * SCRIPT PRINCPAL
	 */
	if (isset($_SESSION[SESSION_VETERINAIRE])) {
	
		$success = null;
		$error = null;
		require_once 'modele/formulaires/proprietaireForm.class.php';
		require_once 'modele/formulaires/animalForm.class.php';
		require_once 'modele/formulaires/interventionForm.class.php';
		
		// inclusion inconditionnelle du moteur de recherche
		include 'vue/veterinaireInterventions/search.php';
		
		/*
		 * Ajout d'une nouvelle intervention
		 */
		if (isset($_POST[AJOUTER])) {
				
			$form = new InterventionForm();
			$form->addHidden(AJOUTER, $_POST[AJOUTER]);
			$form->setIdAnimal($_POST[AJOUTER]);
			$form->setIdVeterinaire($_SESSION[SESSION_VETERINAIRE]->getId());
			$form->setVeterinaire($_SESSION[SESSION_VETERINAIRE]);
			insertPostDatasIntoForm($form);

			if ($form->isValid()) {
				$lastInsertId = $this->sgdb->insererIntervention($form->getIntervention());
				if ($lastInsertId > 0) {
					$redirect = Tools::replaceOrAddUriParameter(AJOUTER, AJOUTER, null, Tools::getUri());
					$redirect = Tools::replaceOrAddUriParameter(EDITER, null, null, $redirect);
					$redirect = Tools::replaceOrAddUriParameter('id', 'id', $lastInsertId, $redirect);
					Tools::redirect($redirect);
				} else {
					$error = AJOUTER;
				}
			}
				
			printMessage($success, $error);
			include('vue/veterinaireInterventions/informationsForm.php');
		
		/*
		 * Modifier les informations d'une intervention
		*/
		} elseif (isset($_POST[MODIFIER])) {
				
			// recuperer toutes les infos de l'intervention depuis la base de données
			$intervention = new Intervention();
			$intervention->setId($_POST[MODIFIER]);
			$this->sgdb->getInformationsIntervention($intervention);
				
			// l'intervention existe
			if ($intervention->getId()) {
				
				$form = new InterventionForm();
				$form->setIntervention($intervention);
		
				$oldForm = $form;
				$form = new InterventionForm();
		
				$form->addHidden(MODIFIER, $intervention->getId());
				compileFormDatas($form, $oldForm);
				insertPostDatasIntoForm($form);
		
				// mettre à jour les informations (si nécessaire)
				if ($form->isValid()) {
					// Comparaion des nouvelles données avec les anciennes pour mise à jour éventuelle
					if ($intervention != $form->getIntervention()) {
						// Mise à jour des données
						if ($this->sgdb->updateIntervention($form->getIntervention()) > 0) {
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
					// informations complémentaires sur le patient et le client
					$intervention = $form->getIntervention();
					getExtraInformations($intervention, $this->sgdb);

					include 'vue/veterinaireInterventions/informations.php';
				} else {
					include 'vue/veterinaireInterventions/informationsForm.php' ;
				}
		
				// l'intevention n'existe pas
			} else {
				$error = ERROR_EXISTS;
				printMessage($success, $error);
			}
		}
		
		/*
		 * Rechercher un client
		 */
		elseif (isset($_GET[RECHERCHER])) {
				
			$interventions = $this->sgdb->getInterventions($_GET[RECHERCHER]);
				
			$forms = array();
			foreach ($interventions as $proprieraire) {
				$form = new InterventionForm();
				$form->setIntervention($proprieraire);
				$forms[] = $form;
			}
			include 'vue/veterinaireInterventions/veterinaireInterventions.php';
				
		/*
		 * Intervention selectionnée
		 */
		} elseif (isset($_GET['id'])) {
				
			// recuperer toutes les infos de l'intervention depuis la base de données
			$intervention = new Intervention();
			$intervention->setId($_GET['id']);
			$this->sgdb->getInformationsIntervention($intervention);
		
			// l'intervention existe
			if ($intervention->getId()) {
		
				$form = new InterventionForm();
				$form->setIntervention($intervention);
				$form->addHidden(MODIFIER, $form->getId());
		
				/*
				 * Supprimer une intervention : INTERDIT pour tous
				*/
				if (isset($_GET[SUPPRIMER])) {
					$error = FORBIDDEN;
					printMessage($success, $error);
		
				/*
				 * Editer l'intervention
				 */
				} elseif (isset($_GET[EDITER])) {
					// informations complémentaires sur le patient et le client
					getExtraInformations($intervention, $this->sgdb);
					
					if ($intervention->getIdVeterinaire() == $_SESSION[SESSION_VETERINAIRE]->getId()) {
						include 'vue/veterinaireInterventions/informationsForm.php';
					} else {
						$error = FORBIDDEN;
						printMessage($success, $error);
					}
		
				/*
				 * Fiche détail de l'intervention
				 */
				} else {
					// informations complémentaires sur le patient et le client
					getExtraInformations($intervention, $this->sgdb);
					
					if (isset($_GET[AJOUTER])) { // suite à 'jout d'une intervention
						$success = AJOUTER;
					}

					printMessage($success, $error);
					include 'vue/veterinaireInterventions/informations.php';
				}
		
			// l'intervetion n'existe pas
			} else {
				$error = ERROR_EXISTS;
				printMessage($success, $error);
			}
		
		/*
		 * Nouvelle Intervention
		 */
		} elseif (isset($_GET[AJOUTER])) {
				
			$form = new InterventionForm();
			$form->setVeterinaire($_SESSION[SESSION_VETERINAIRE]);
			$form->setDate(date("Y-m-d"));
			$form->addHidden(AJOUTER, $_GET[AJOUTER]); // idntifiant de l'animal
				
			include 'vue/veterinaireInterventions/informationsForm.php';

		/*
		 * Liste des interventions du vétérinaire uniquement
		 */
		} else {
		
			$interventions = $this->sgdb->listInterventions($_SESSION[SESSION_VETERINAIRE]);
			
			$forms = array();
			foreach ($interventions as $intervention) {
				$form = new InterventionForm();
				$form->setIntervention($intervention);
				$forms[] = $form;
			}
			include 'vue/veterinaireInterventions/veterinaireInterventions.php';
		}
	}
	
?>