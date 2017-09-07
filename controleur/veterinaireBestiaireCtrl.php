<?php

	include 'controleur/commun/commonFunc.php';

	function especesToJSON(SgdbCtrl &$sgdb)
	{
		$especes = $sgdb->getEspeces();
		
		$json = array();
		foreach ($especes as $espece) {
			$arr = array();
			$arr["name"] = $espece->getNom();
			$arr["id"] = $espece->getId();
			$arr["photo"] = Tools::getEspecePhoto($espece);
			$json[] = $arr;
		}
		return json_encode($json);
	}
	
	function racesToJSON(Espece &$espece, SgdbCtrl &$sgdb)
	{
		$races = $sgdb->listeRacesFromEspece($espece);
		$json = array();
		foreach ($races as $race) {
			$arr = array();
			$arr["name"] = $race->getNom();
			$arr["id"] = $race->getId();
			$json[] = $arr;
		}
		return json_encode($json);
	}
	
	function newEspece(Espece &$espece, SgdbCtrl &$sgdb)
	{
		$result = $sgdb->insererEspece($espece);
		return isset($result) ? NO_ERROR : ERROR_EXISTS;
	}
	
	function addRace(Race &$race, SgdbCtrl &$sgdb)
	{
		$result = $sgdb->insererRace($race);
		return isset($result) ? NO_ERROR : ERROR_EXISTS;
	}

	
	/*
	 * SCRIPT PRINCPAL
	 */
	if (isset($_SESSION[SESSION_VETERINAIRE])) {
	
		/*
		 * JSON request : mettre la photo de l'espece à jour
		 */
		if (isset($_FILES['file']) && isset($_POST['especes']) )
		{
			$espece = new Espece();
			$espece->setId(intval($_POST['especes']));
			echo uploadEspecePhotoToJson($_FILES['file'], $espece);
			exit();
		
		/*
		 * JSON request : obtenir les races associées à l'espece choisie
		 */
		} elseif (isset($_GET['races'])) {
			$espece = new Espece();
			$espece->setId($_GET['races']);
			echo racesToJSON($espece, $this->sgdb);
			exit();
		
		/*
		 * JSON request : obtenir les especes
		 */
		} elseif (isset($_GET['especes'])) {
			echo especesToJSON($this->sgdb);
			exit();
			
		/*
		 * JSON request : ajouter une espece
		 */
		} elseif (isset($_GET['new_espece'])) {
			$espece = new Espece();
			$result = $espece->setNom($_GET['new_espece']);
			
			if ($result == NO_ERROR) {
				echo newEspece($espece, $this->sgdb);
			} else {
				echo $result;
			}
			exit();
			
		/*
		 * JSON request : modifier le nom d'une espece
		 */
		} elseif (isset($_GET['alter_espece']) && isset($_GET['nom'])) {
			$espece = new Espece();
			$errors = array();
			$errors[] = $espece->setId(intval($_GET['alter_espece']));
			$errors[] = $espece->setNom(($_GET['nom']));
			if (Tools::isErrorFounded($errors)) {
				echo ERROR_REGEX;
			} else {
				echo $this->sgdb->updateEspece($espece);
			}
			exit();
			
		/*
		 * JSON request : supprimer une race
		 */
		} elseif (isset($_GET['del_race'])) {
			$race = new Race();
			$race->setId(intval($_GET['del_race']));
			echo $this->sgdb->delRace($race) > 0 ?  NO_ERROR : ERROR_EXISTS;
			exit();
			
		/*
		 * JSON request : supprimer une espece
		 */
		} elseif (isset($_GET['del_espece'])) {
			$espece = new Espece();
			$espece->setId(intval($_GET['del_espece']));
			echo $this->sgdb->delEspece($espece) > 0 ?  NO_ERROR : ERROR_EXISTS;
			exit();
			
		/*
		 * JSON request : ajouter une race
		 */
		} elseif (isset($_GET['new_race']) && isset($_GET['nom'])) {
			$race = new Race();
			$errors = array();
			$errors[] = $race->setIdEspece(intval($_GET['new_race']));
			$errors[] = $race->setNom(($_GET['nom']));
			if (Tools::isErrorFounded($errors)) {
				echo ERROR_REGEX;
			} else {
				echo addRace($race, $this->sgdb);
			}
			exit();
			
		/*
		 * JSON request : modifier le nom d'une race
		 */
		} elseif (isset($_GET['alter_race']) && isset($_GET['nom'])) {
			$race = new Race();
			$errors = array();
			$errors[] = $race->setId(intval($_GET['alter_race']));
			$errors[] = $race->setNom(($_GET['nom']));
			if (Tools::isErrorFounded($errors)) {
				echo ERROR_REGEX;
			} else {
				echo $this->sgdb->updateRace($race);
			}
			exit();
			
		/*
		 * Page unique
		 */
		} else {
			include 'vue/veterinaireBestiaire/bestiaire.php';
		}
	}
	
?>