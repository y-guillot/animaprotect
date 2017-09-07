<?php

	include 'controleur/commun/animalFunc.php';
	include 'controleur/commun/commonFunc.php';

	/**
	 * Affichage des vues relatives aux messages de succès et erreurs
	 *
	 * @param unknown $success
	 * @param unknown $error
	 */
	function printMessage(&$success, &$error)
	{
		if (isset($success)) {
			include 'vue/veterinaireAnimaux/succes.php';
		} elseif (isset($error)) {
			include 'vue/veterinaireAnimaux/error.php';
		}
	}
	
	/**
	 * Fiche détail de l'animal
	 * 
	 * @param AnimalForm $form
	 * @param SgdbCtrl $sgdb
	 */
	function ficheDetailAnimal(AnimalForm &$form, SgdbCtrl &$sgdb)
	{
		$animal = $form->getAnimal();
		// obtenir la liste des interventions de l'animal
		$interventions = $sgdb->listeInterventions($animal);
		$animal->setInterventions($interventions);
		include 'vue/veterinaireAnimaux/informations.php';
		// obtenir a fiche détail du propritaire
		$proprietaire = new Proprietaire();
		$proprietaire->setId($animal->getIdProprietaire());
		$sgdb->getProprietaire($proprietaire);
		$form = new ProprietaireForm();
		$form->setProprietaire($proprietaire);
		include 'vue/veterinaireAnimaux/informationsProprietaire.php';	
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
		if (!isset($_FILES['file'])) {
			include 'vue/veterinaireAnimaux/search.php';
		}
		
		// message lors des suppressions correctement effectuees
		if (isset($_GET[SUPPRIMER]) && !isset($_GET['id'])) {
			$success = SUPPRIMER;
			printMessage($success, $error);
		}
		
		
		/*
		 * Ajout d'un nouveau patient
		 */
		if (isset($_POST[AJOUTER])) {
			
			$utiliateur = new Utilisateur();
			$utiliateur->setId(intval($_POST[AJOUTER]));
			
			/*
			 * Upload Photo Animal
			 */
			if (isset($_FILES['file'])) {
				echo uploadAnimalTempPhotoToJson($_FILES['file'], $utiliateur);
				exit();
			}
			
			// Recuperer l'identifiant du proprietaire et insérer les données postées
			$form = new AnimalForm();
			$form->addHidden(AJOUTER, $utiliateur->getId());
			$proprieraire = $this->sgdb->getInformationsProprietaire($utiliateur);
			$form->setIdProprietaire($proprieraire->getId());
			insertPostDatasIntoForm($form);
			
			if ($form->isValid()) {
				$lastInsertId = $this->sgdb->insererAnimal($form->getAnimal());
				
				// déplacment photo uploadée si existante et redirection sur la fiche détail
				if (isset($lastInsertId)) {
					
					$animal = new Animal();
					$animal->setId($lastInsertId);
					moveAnimalTempPhoto($utiliateur, $animal);
						
					$redirect = Tools::replaceOrAddUriParameter(AJOUTER, AJOUTER, null, Tools::getUri());
					$redirect = Tools::replaceOrAddUriParameter(ESPECE, null, null, $redirect);
					$redirect = Tools::replaceOrAddUriParameter(EDITER, null, null, $redirect);
					$redirect = Tools::replaceOrAddUriParameter('id', 'id', $lastInsertId, $redirect);
					Tools::redirect($redirect);
				} else {
					$error = AJOUTER;
				}
			}
			
			// récupérer l'espece et la race de l'animal
			$race = new Race();
			$race->setId($form->getIdRace());
			$espece = $this->sgdb->getEspeceFromRace($race);
			$form->getAnimal()->setEspece($espece);
			// récupérer la liste de toutes le races disponibles pour l'espèce en question
			$races = $this->sgdb->listeRacesFromEspece($espece);
			$form->setRaces($races);
			
			printMessage($success, $error);
			include 'vue/veterinaireAnimaux/informationsForm.php';


		/*
		 * Modifier les informations d'un patient
		 */
		} elseif (isset($_POST[MODIFIER])) {
			
			// recuperer toutes les infos du patient depuis la base de données
			$animal = new Animal();
			$animal->setId($_POST[MODIFIER]);
			$this->sgdb->getInformationsAnimal($animal);
			
			// le patient existe
			if ($animal->getId()) {
				
				/*
				 * Upload Photo Animal
				 */
				if (isset($_FILES['file'])) {
					echo uploadAnimalPhotoToJson($_FILES['file'], $animal);
					exit();
				}
				
				
				$form = new AnimalForm();
				$form->setAnimal($animal);

				$oldForm = $form;

				$form = new AnimalForm();
				$form->addHidden(MODIFIER, $animal->getId());
				// récupérer la liste de toutes le races disponibles pour l'espèce en question
				$races = $this->sgdb->listeRacesFromEspece($animal->getEspece());
				compileFormDatas($form, $oldForm);
				insertPostDatasIntoForm($form);
				
				// mettre à jour des information (si nécessaire)
				if ($form->isValid()) {
					// Comparaion des nouvelles données avec les anciennes pour mise à jour éventuelle
					if ($animal != $form->getAnimal()) {
						// Mise à jour des données du patient
						if ($this->sgdb->updateAnimal($form->getAnimal()) > 0) {
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
					ficheDetailAnimal($form, $this->sgdb);
				} else {
					include 'vue/veterinaireAnimaux/informationsForm.php' ;
				}
				
			// le patient n'existe pas
			} else {
				$error = ERROR_EXISTS;
				printMessage($success, $error);
			}
			
		/*
		 * Rechercher un patient
		 */
		} elseif (isset($_GET[RECHERCHER])) {
			
			$veterinaires = $this->sgdb->getAnimaux($_GET[RECHERCHER]);
			$forms = array();
			foreach ($veterinaires as $animal) {
				$form = new AnimalForm();
				$form->setAnimal($animal);
				$forms[] = $form;
			}
			include 'vue/veterinaireAnimaux/veterinaireAnimaux.php';

		/*
		 * Nouvelle Fiche patient
		 */
		} elseif (isset($_GET[ESPECE]) && isset($_GET['id'])) {
				
			$form = new AnimalForm();
			$espece = new Espece();
			$espece->setId($_GET[ESPECE]);

			$form->addHidden(AJOUTER, $_GET['id']);  // idetifiant utilisateur
			
			$form->getAnimal()->setEspece($espece);
			// récupérer la liste de toutes le races disponibles pour l'espèce en question
			$races = $this->sgdb->listeRacesFromEspece($espece);
			$form->setRaces($races);
			include 'vue/veterinaireAnimaux/informationsForm.php';
		
		/*
		 * Animal identifié
		 */	
		} elseif (isset($_GET['id'])) {

			// recuperer toutes les infos du proprietaire depuis la base de données
			$animal = new Animal();
			$animal->setId($_GET['id']);
			$this->sgdb->getInformationsAnimal($animal);
	
			// l'animal existe
			if ($animal->getId()) {
				
				$form = new AnimalForm();
				$form->setAnimal($animal);
				
				/*
				 * Supprimer un animal
				 */
				if (isset($_GET[SUPPRIMER])) {
					if ($this->sgdb->supprimerAnimal($animal) > 0) {
						// redirction sur la liste des animaux avec confirmation de suppression dans l'url
						$redirect = Tools::replaceOrAddUriParameter('id', null, null, Tools::getUri());
						$redirect = Tools::replaceOrAddUriParameter(ESPECE, null, null, $redirect);
						$redirect = Tools::replaceOrAddUriParameter(EDITER, null, null, $redirect);
						$redirect = Tools::replaceOrAddUriParameter(SUPPRIMER, SUPPRIMER, null, $redirect);
						Tools::redirect($redirect);
					} else {
						$error = SUPPRIMER;
						printMessage($success, $error);
						ficheDetailAnimal($form, $this->sgdb);
					}
				
				/*
				 * Editer la fiche d'un animal
				 */
				} elseif (isset($_GET[EDITER])) {
					$form->addHidden(MODIFIER, $animal->getId());
					// récupérer la liste de toutes le races disponibles pour l'espèce en question
					$races = $this->sgdb->listeRacesFromEspece($animal->getEspece());
					$form->setRaces($races);
					include 'vue/veterinaireAnimaux/informationsForm.php';
				
				/*
				 * Consulter la fiche détail d'un animal
				 */
				} else {
					if (isset($_GET[AJOUTER])) {
						$success = AJOUTER;
					}
					printMessage($success, $error);
					ficheDetailAnimal($form, $this->sgdb);
				}

			// l'animal n'existe pas
			} else {
				$error = ERROR_EXISTS;
				printMessage($success, $error);
			}
		}
	}
	
?>