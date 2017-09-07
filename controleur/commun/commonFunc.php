<?php

	/**
	 * obtenir les informations sur l'ensemble des animaux possédés par le proprietaire
	 * 
	 * @param Proprietaire $proprietaire
	 * @param SgdbCtrl $sgdb
	 * @return multitype:AnimalForm
	 */
	function getProprietaireAnimaux(Proprietaire &$proprietaire, SgdbCtrl &$sgdb)
	{
		$animaux = $sgdb->listeAnimauxProprietaire($proprietaire);
		$forms = array();
		foreach ($animaux as $animal) {
			
			// obtenir la liste des interventions de l'animal
			$interventions = $sgdb->listeInterventions($animal);
			$animal->setInterventions($interventions);

			// préparation du modèle de formulaire
			$animalForm = new AnimalForm();
			$animalForm->setAnimal($animal);
			$forms[] = $animalForm;
		}
		return $forms;	
	}
	
	/**
	 * Upload generic .jpg Photo
	 * 
	 * @param unknown $dir
	 * @param unknown $name
	 * @param unknown $file
	 * @return string
	 */
	function uploadPhoto($dir, $name, $file)
	{	
		$maxSize = 100000;
		$size = filesize($file['tmp_name']);
		$extensions = array('.jpg', '.jpeg');
		$extension = strrchr($file['name'], '.');
		
		if (!in_array($extension, $extensions)) {
			$result = ERROR_EXTENSION;
		} elseif ($size > $maxSize) {
			$result = ERROR_SIZE;
		} else {
			$result = move_uploaded_file($file['tmp_name'], $dir . $name) ? NO_ERROR : ERROR_UPLOAD;
		}
		
		return $result;
	}
	
	/**
	 * Upload Photo and send result to JSON format
	 * 
	 * @param unknown $idUtilisateur
	 * @param unknown $file
	 * @return string
	 */
	function uploadPhotoToJson($dir, $name, $file) {
	
		$result = uploadPhoto($dir, $name, $file);
	
		if ($result == NO_ERROR) {
			$result = '{"file": {"url": "' . $dir . $name. '"}}'; // JSON format
		}
		return $result;
	}
	
	/**
	 * Upload user Photo and convert to JSON fomat
	 *
	 * @param unknown $file
	 * @param Utilisateur $user
	 * @return string
	 */
	function uploadUtilisateurPhotoToJson(&$file, Utilisateur &$user) {
	
		$dir = 'ressources/images/users/';
		$name = $user->getId() . ".jpg";
	
		return uploadPhotoToJson($dir, $name, $file);
	}
	
	/**
	 * Upload user Temporary Photo and convert to JSON fomat
	 *
	 * @param unknown $file
	 * @param Utilisateur $user
	 * @return string
	 */
	function uploadUtilisateurTempPhotoToJson(&$file, Utilisateur &$user) {
	
		$dir = 'ressources/images/temp/';
		$name = $user->getId() . ".jpg";

		return uploadPhotoToJson($dir, $name, $file);
	}
	
	/**
	 * Deplace la photo temporaire dans le bon dossier
	 *
	 * @param Utilisateur $user
	 * @return boolean
	 */
	function moveUtilisateurTempPhoto(Utilisateur &$source, Utilisateur &$dest)
	{
		$file = 'ressources/images/temp/' . $source->getId() . '.jpg';
		$dest = 'ressources/images/users/' . $dest->getId() . '.jpg';
	
		if (file_exists($file)) {
			copy($file, $dest);
			unlink($file);
			return true;
		}
		return false;
	}
	
	/**
	 * Upload Animal Photo and convert to JSON fomat
	 *
	 * @param unknown $file
	 * @param Animal $animal
	 * @return string
	 */
	function uploadAnimalPhotoToJson(&$file, Animal &$animal) {
	
		$dir = 'ressources/images/animaux/';
		$name = $animal->getId() . ".jpg";
	
		return uploadPhotoToJson($dir, $name, $file);
	}
	
	/**
	 * Upload Animal Temporary Photo and convert to JSON fomat
	 *
	 * @param unknown $file
	 * @param Utilisateur $user
	 * @return string
	 */
	function uploadAnimalTempPhotoToJson(&$file, Utilisateur &$user) {
	
		$dir = 'ressources/images/temp/';
		$name = $user->getId() . ".jpg";
	
		return uploadPhotoToJson($dir, $name, $file);
	}
	
	/**
	 * Deplace la photo temporaire dans le bon dossier
	 *
	 * @param Utilisateur $user
	 * @param Animal $animal
	 * @return boolean
	 */
	function moveAnimalTempPhoto(Utilisateur &$user, Animal &$animal)
	{
		$file = 'ressources/images/temp/' . $user->getId() . '.jpg';
		$dest = 'ressources/images/animaux/' . $animal->getId() . '.jpg';
	
		if (file_exists($file)) {
			copy($file, $dest);
			unlink($file);
			return true;
		}
		return false;
	}
	
	/**
	 * Upload Espece Photo and convert to JSON fomat
	 *
	 * @param unknown $file
	 * @param Espece $espece
	 * @return string
	 */
	function uploadEspecePhotoToJson(&$file, Espece &$espece) {
	
		$dir = 'ressources/images/animaux/default/';
		$name = $espece->getId() . ".jpg";
	
		return uploadPhotoToJson($dir, $name, $file);
	}
	
	
?>