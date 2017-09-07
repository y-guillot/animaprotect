<?php

class Form {
	
	protected $errors; // array : erreurs renvoyées par les modèles
	protected $requis; // array : champ requis
	protected $hidden; // array : champ masqués devant être ajoutés au formulaire
	
	function __construct()
	{
		$this->errors = array();
		$this->requis = array();
		$this->hidden = array();
	}
	
	// GETTERS
	
	function getErrors()
	{
		return $this->errors;
	}
	
	function getCodeError($champ)
	{
		if (array_key_exists($champ, $this->errors)) {
			return $this->errors[$champ];
		}
	}
	
	function getHidden($key = null)
	{
		$hidden = $this->hidden;
		if (isset($key)) {
			if (array_key_exists($key, $this->hidden)) {
				$hidden = $this->hidden[$key];
			} else {
				$hidden = null;
			}
		}
		return $hidden;
	}
	
	// SETTERS
	
	function setCodeError($champ, $val)
	{
		$this->errors[$champ] = $val;
	}
	
	function setHidden($hidden)
	{
		$this->hidden = $hidden;
	}
	
	function addHidden($key, $value)
	{
		$this->hidden[$key] = $value;
	}
	
	function delHidden($key)
	{
		unset($this->hidden[array_search($key, $this->hidden)]);
	}
	
	/**
	 * Vérification des erreurs du formulaire
	 * 
	 * @param string $champ
	 * @return boolean
	 */
	function isValid($champ = null) // champ optionnel avec valeur par defaut
	{
		// verifier si une entrée spécifique est conforme
		if (isset($champ)) {
			return $this->isError($champ) ? false : true;
	
		// vérifier l'intégralié du formulaire : champs requis et erreurs eventuelles
		} else {
			foreach($this->requis as $champ) { // parcours les champs requis
				if (!array_key_exists($champ, $this->errors)) { // si le champ n'a pas été testé
					return false;
				}
			}
			foreach($this->errors as $error) { // parcours les champs qui ont été remplis
				if ($error != NO_ERROR ) { // en cas d'erreur
					return false;
				}
			}
			return true;
		}
	}
	
	/**
	 * Vérification du contenu d'une entrée dans le tableau des erreurs
	 * 
	 * @param $champ
	 * @return boolean
	 */
	private function isError($champ)
	{
		$result = false;
		if (array_key_exists($champ, $this->errors)) {
			if ($this->errors[$champ] != NO_ERROR) {
				$result = true;
			}
		}
		return $result;
	}
	
	
	function printHiddenFiels()
	{
		foreach($this->hidden as $key => $value) {
			
			$value = isset($value) ? 'value="' . $value . '"' : null;
			echo '<input type="hidden" name="' . $key .'" ' . $value . '/>';
		}
	}
	
}