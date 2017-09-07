<?php

class Tools {
	
	static function isIntBetween($int, $min, $max)
	{
		$result = false;
		if (is_int($int) && is_int($min) && is_int($max) && $min < $max ) {
			if ($int >= $min && $int <= $max) {
				$result = true;
			}
		}
		return $result;
	}

	static function isStringSizeBetween($string, $min, $max, $trim = true)
	{
		
		$result = false;
		if ($trim) {
			$string = trim($string);
		}
		
		if (isset($string) && is_int($min) && is_int($max) && $min < $max ) {
			if (strlen($string) >= $min && strlen($string) <= $max) {
				return true;
			}
		}
		
		return $result;
	}
	
	static function isPasswordSecured($pass)
	{
		if (strlen($pass) >= 8) {
			// TODO complexifier l'analyse
			return true;
		}

		return false;
	}
	
	static function isPhoneNumber($phone)
	{
		// TODO gérer le (+33)
		$phone = str_replace(" ", "", $phone);
		if (preg_match('/^[[:digit:]]{10}$/', $phone)) {
			return true;
		} else {
			return false;
		}
	}
	
	static function convertToPhoneNumber($phone)
	{
		// TODO gérer le (+33)
		$phone = str_replace(" ", "", $phone);
		return $phone;
	}
	
	static function isPostCode($cp)
	{
		if (preg_match('/^[[:digit:]]{5}$/', $cp)) {
			return true;
		} else {
			return false;
		}
	}
	
	static function isErrorFounded($errors)
	{
		$result = false;
		if (is_array($errors)) {
			foreach($errors as $value) {
				if ($value != NO_ERROR) {
					$result = true;
					break;
				}
			}
		}
		return $result;
		
	}
	
	static function convertCiviliteFromId($id)
	{
		switch($id){
			case HOMME :
				$id = "M";
				break;
			case FEMME :
				$id = "Mme";
				break;
			case DOCTEUR :
				$id = "Dr";
				break;
		}
		return $id;
	}
	
	static function convertDateToFrenchStyle($date)
	{
		return date('d / m / Y', strtotime($date));
	}
	
	static function isDateValid($date)
	{
		$j = date('j', strtotime($date));
		$m = date('n', strtotime($date));
		$y = date('Y', strtotime($date));

		return checkdate($m, $j, $y);
	}
	
	static function getAnimalPhoto(Animal $animal)
	{		
		if (is_int($animal->getId())) {
			$filename = 'ressources/images/animaux/' . $animal->getId() . '.jpg';
			if (!file_exists($filename)) {
				$filename = Tools::getDefaultAnimalPhoto($animal);
			}
		} else {
			$filename = Tools::getDefaultAnimalPhoto($animal);
		}
			
		return $filename;
	}
	
	static function getPraticienPhoto(Utilisateur $user)
	{
		$filename = 'ressources/images/users/default/default.jpg';
		if (is_int($user->getId())) {
			$test = 'ressources/images/users/' . $user->getId() . '.jpg';
			if (file_exists($test)) {
				$filename = $test;
			}
		}
			
		return $filename;
	}
	
	static function getDefaultAnimalPhoto(Animal $animal){
		
		$filename = 'ressources/images/animaux/default/' . $animal->getEspece()->getId() . '.jpg';
		if (!file_exists($filename)) {
			$filename = 'ressources/images/animaux/default/default.jpg';
		}
		
		return $filename;
	}
	
	static function getEspecePhoto(Espece $espece){
	
		$dir = 'ressources/images/animaux/default/';
		$filename = $dir . $espece->getId() . '.jpg';
		if (!file_exists($filename)) {
			$filename = $dir . 'default.jpg';
		}
	
		return $filename;
	}
	
	static function redirect($page)
	{
		header('Location: ' . $page);
	}
	
	static function getUri()
	{
		return "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	}
	
	static function replaceOrAddUriParameter($search, $replacement, $value, $subject)
	{
		if (isset($search)) {
			$subject = preg_replace("/&$search=?[^&]*/", "", $subject);
		}
		if (isset($replacement)) {
			$subject = $subject . "&" . $replacement ."=" . $value;
		}
		return $subject;
	}
	
	static function supprimerPhotoAnimal(Animal $animal)
	{
		$file = 'ressources/images/animaux/' . $animal->getId() . '.jpg';
		if (file_exists($file)) {
			unlink($file);
		}
	}
	
	static function supprimerPhotoUtilisateur(Utilisateur $user)
	{
		$file = 'ressources/images/users/' . $user->getId() . '.jpg';
		if (file_exists($file)) {
			unlink($file);
		}
	}
	
	static function supprimerPhotoEspece(Espece $espece)
	{
		$file = 'ressources/images/animaux/default/' . $espece->getId() . '.jpg';
		if (file_exists($file)) {
			unlink($file);
		}
	}
}

?>