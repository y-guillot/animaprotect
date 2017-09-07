<?php

	include 'controleur/commun/animalFunc.php';
	include 'controleur/commun/commonFunc.php';
	
	/**
	 * Obtenir les informations de l'animal
	 * 
	 * @param SgdbCtrl $sgdb
	 * @return Animal
	 */
	function getAnimalInformations(SgdbCtrl &$sgdb)
	{
		// obtenir les informations sur l'animal
		$animal = new Animal();
		$animal->setId(intval($_GET['id']));
		$animal->setIdProprietaire($_SESSION[SESSION_PROPRIETAIRE]->getId());
		$sgdb->getInformationsAnimal($animal);
		
		return $animal;
	}
	
	/**
	 * Initialiser un mod�le de formulaire � partir d'un animal
	 * 
	 * @param Animal $animal
	 * @param SgdbCtrl $sgdb
	 * @return AnimalForm
	 */
	function newFormFromAnimal(Animal &$animal, SgdbCtrl &$sgdb)
	{
		$form = new AnimalForm();
		$form->setAnimal($animal);
		// r�cup�rer la liste de toutes le races disponibles pour l'esp�ce en question
		$races = $sgdb->listeRacesFromEspece($animal->getEspece());
		$form->setRaces($races);
		// r�cup�rer la liste de toutes les especes existantes
		$especes = $sgdb->getEspeces();
		$form->setEspeces($especes);
		return $form;
	}
	
	/**
	 * Creation d'un nouveau mod�le de formulaire � partir de l'espece choisie
	 * 
	 * @param SgdbCtrl $sgdb
	 * @return AnimalForm
	 */
	function newFormFromEspece(SgdbCtrl &$sgdb)
	{
		$form = null;
		$idEspece = isset($_POST[ESPECE]) ? $_POST[ESPECE] : (isset($_GET[ESPECE]) ? $_GET[ESPECE] : null);
		
		if (isset($idEspece)) {
			$espece = $sgdb->getEspeceFromId($idEspece);
			if (isset($espece)) {
				$animal = new Animal();
				$animal->setEspece($espece);
				$form = newFormFromAnimal($animal, $sgdb);
				$form->addHidden(AJOUTER, null); // action principale
				$form->addHidden(ESPECE, $idEspece); // permet de rester en mode "ajout" si des erreurs surviennent
			}
		}
		return $form;
	}
	
	/**
	 * Verification de l'appartenance de l'animal � l'utilisateur en session
	 * 
	 * @param Animal $animal
	 * @return boolean
	 */
	function animalIsMine(Animal &$animal)
	{
		return $animal->getId() && $animal->getIdProprietaire() == $_SESSION[SESSION_PROPRIETAIRE]->getId() ? true : false;
	}
	
	/**
	 * Affichage des vues relatives aux messages de succ�s et erreurs
	 *
	 * @param unknown $success
	 * @param unknown $error
	 */
	function printMessage(&$success, &$error)
	{
		if (isset($success)) {
			include 'vue/proprietaireAnimaux/succes.php';
		} elseif (isset($error)) {
			include 'vue/proprietaireAnimaux/error.php';
		}
	}
	
	
	/**
	 * SCRIPT PRINCIPAL
	 */
	if (isset($_SESSION[SESSION_PROPRIETAIRE])) {
	
		require_once 'modele/formulaires/animalForm.class.php';
		require_once 'modele/formulaires/proprietaireForm.class.php';
		$success = null;
		$error = null;
		
		/*
		 * Insertion d'un nouvel animal dans la base
		 */
		if (isset($_POST[AJOUTER])) {
		
			/*
			 * Upload Photo Animal
			 */
			if (isset($_FILES['file'])) {
				$user = $_SESSION[SESSION_PROPRIETAIRE]->getUtilisateur();
				echo uploadAnimalTempPhotoToJson($_FILES['file'], $user);
				exit();
			}
			
			/*
			 * Insertion veritable des donn�es
			 */
			$form = newFormFromEspece($this->sgdb);
			if (isset($form)) {
				
				$form->getAnimal()->setIdProprietaire($_SESSION[SESSION_PROPRIETAIRE]->getId());
				insertPostDatasIntoForm($form);
				
				// insertion dans la base si valide
				if ($form->isValid()) {
					$lastInsertId = $this->sgdb->insererAnimal($form->getAnimal());
					
					// d�placment photo upload�e si existante et redirection sur la fiche d�tail
					if (isset($lastInsertId)) {
						
						$animal = new Animal();
						$animal->setId($lastInsertId);
						$user = $_SESSION[SESSION_PROPRIETAIRE]->getUtilisateur();
						moveAnimalTempPhoto($user, $animal);
						
						$redirect = Tools::replaceOrAddUriParameter('id', 'id', $lastInsertId, Tools::getUri());
						$redirect = Tools::replaceOrAddUriParameter(null, AJOUTER, null, $redirect);
						$redirect = Tools::replaceOrAddUriParameter(ESPECE, null, null, $redirect);
						Tools::redirect($redirect);
					
					// en cas d'erreur d'ajout de l'animal
					} else {
						$error = AJOUTER;
					}
				}
				
				printMessage($success, $error);
				include 'vue/proprietaireAnimaux/proprietaireAnimauxForm.php';
			}

		/*
		 * Mise � jour des informations sur l'animal
		 */
		} elseif (isset($_POST[MODIFIER])) {

	
			// recuperer toutes les infos du patient depuis la base de donn�es
			$animal = new Animal();
			$animal->setId($_POST[MODIFIER]);
			$this->sgdb->getInformationsAnimal($animal);
			
			// le patient existe et j'en suis le propri�taire
			if (animalIsMine($animal)) {
				
				/*
				 * Upload Photo Animal
				 */
				if (isset($_FILES['file'])) {
					echo uploadAnimalPhotoToJson($_FILES['file'], $animal);
					exit();
				}
				
				$form = newFormFromAnimal($animal, $this->sgdb);
				$oldForm = $form; // backup 
				$form = new AnimalForm();
				$form->addHidden(MODIFIER, $animal->getId());
				compileFormDatas($form, $oldForm);
				insertPostDatasIntoForm($form);


				// mettre � jour des information (si n�cessaire)
				if ($form->isValid()) {
					// Comparaion des nouvelles donn�es avec les anciennes pour mise � jour �ventuelle
					if ($animal != $form->getAnimal()) {
						// Mise � jour des donn�es de l'animal
						if ($this->sgdb->updateAnimal($form->getAnimal()) > 0) {
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
				include 'vue/proprietaireAnimaux/proprietaireAnimauxForm.php' ;
				
			// le patient n'existe pas
			} else {
				$error = ERROR_EXISTS;
				printMessage($success, $error);
			}
		
		/*
		 * Fiche pour un nouvel animal
		 */
		} elseif (isset($_GET[ESPECE])) {
			
			$form = newFormFromEspece($this->sgdb);
			include 'vue/proprietaireAnimaux/proprietaireAnimauxForm.php';
			
		/*
		 * Animal identifi�
		 */
		} elseif (isset($_GET['id'])) {


			// recuperer toutes les infos de l'animal depuis la base de donn�es
			$animal = new Animal();
			$animal->setId($_GET['id']);
			$this->sgdb->getInformationsAnimal($animal);
			
			// l'animal existe et j'en suis le proprietaire
			if (animalIsMine($animal)) {

				$form = newFormFromAnimal($animal, $this->sgdb);
				$form->addHidden(MODIFIER, $animal->getId());
				
				/*
				 * Upload Photo Animal
				 */
				if (isset($_FILES['file']) ) {
					echo '{"file": {"url": "42"}}';
					
					//echo uploadAnimalPhoto($_FILES['file'], $animal);
					exit();
				
				/*
				 * Suppression d'un animal
				 */
				} elseif (isset($_GET[SUPPRIMER])) {
						
					if ($this->sgdb->supprimerAnimal($animal) > 0) {
						// redirction sur la liste des animaux avec confirmation de suppression dans l'url
						$redirect = Tools::replaceOrAddUriParameter('id', null, null, Tools::getUri());
						$redirect = Tools::replaceOrAddUriParameter(ESPECE, null, null, $redirect);
						$redirect = Tools::replaceOrAddUriParameter(SUPPRIMER, SUPPRIMER, null, $redirect);
						Tools::redirect($redirect);
					} else {
						$error = SUPPRIMER;
					}
					
				/*
				 * Editer la fiche d'un animal
				 */
				} else {
					if(isset($_GET[AJOUTER])) {
						$success = AJOUTER;
					}
				}
				
				printMessage($success, $error);
				include 'vue/proprietaireAnimaux/proprietaireAnimauxForm.php';
				
			// l'animal n'existe pas
			} else {
				$error = ERROR_EXISTS;
				printMessage($success, $error);
			}
				
		/*
		 * Liste des animaux
		 */
		} else {
			// r�cup�rer la liste de toutes les especes existantes
			$especes = $this->sgdb->getEspeces();
			// obtenir les informations sur l'ensemble des animaux poss�d�s par le proprietaire
			$forms = getProprietaireAnimaux($_SESSION[SESSION_PROPRIETAIRE], $this->sgdb);

			// indicateur de succ�s suite � une suppression r�cente
			if(isset($_GET[SUPPRIMER])) {
				$success = SUPPRIMER;
			}
			printMessage($success, $error);
			include 'vue/proprietaireAnimaux/proprietaireAnimaux.php';
		}
	}
?>