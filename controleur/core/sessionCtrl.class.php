<?php

include_once 'modele/utilisateur.class.php';
include_once 'tools/tools.class.php';

class SessionCtrl {
	
	private $sgdb;

	function __construct(SgdbCtrl &$sgdb)
	{
		$this->sgdb =& $sgdb;
	}
	
	function __destruct()
	{
	
	}
	
	/**
	 * Script principal
	 */
	public function execute()
	{
		session_start();
		$this->demandeAuthentificationRecue();
		$this->demandeDeconnexionRecue();
	}
	
	
	/**
	 * verifier si une demande d'authentification a été faite,
	 * puis vérifier si l'utilisateur existe dans la base
	 * et le mettre dans la session
	 */
	private function demandeAuthentificationRecue()
	{
		if (isset($_POST['authentification'])) {
		
			$errors = array();
			$user = new Utilisateur();
			
			$errors['mail'] = $user->setMail(@$_POST['email']);
			$errors['password'] = $user->setPassword(@$_POST['pass']);
			
			if (!Tools::isErrorFounded($errors)) {
				$_SESSION[SESSION_ERROR] = $this->connecterUtilisateur($user) ? NO_ERROR : ERROR_EXISTS;
			} else {
				$_SESSION[SESSION_ERROR] = ERROR_REGEX;
			}
		}
	}
	
	/**
	 * fermeture session utilisateur
	 */
	private function demandeDeconnexionRecue()
	{
		if (isset($_GET['deconnexion'])) {
			unset($_SESSION[SESSION_UTILISATEUR]);
			unset($_SESSION[SESSION_ADMIN]);
			unset($_SESSION[SESSION_VETERINAIRE]);
			unset($_SESSION[SESSION_PROPRIETAIRE]);
			unset($_SESSION[SESSION_ERROR]);
			session_destroy();
		}
	}
	
	/**
	 * Connecter un utilisateur
	 * 
	 * @param Utilisateur $user
	 * @return boolean
	 */
	function connecterUtilisateur(Utilisateur $user)
	{
		$result = false;

		if ($this->sgdb->authentifierUtilisateur($user)) {
			
			switch($user->getIdRole()) {	
				case ADMIN :
					$admin = $this->sgdb->getInformationsAdmin($user);
					$_SESSION[SESSION_ADMIN] = $admin; // veterinaire en session
					break;	
				case VETERINAIRE :
					$veterinaire = $this->sgdb->getInformationsVeterinaire($user);
					$_SESSION[SESSION_VETERINAIRE] = $veterinaire; // veterinaire en session
					break;	
				case PROPRIETAIRE :
					$propietaire = $this->sgdb->getInformationsProprietaire($user);
					$_SESSION[SESSION_PROPRIETAIRE] = $propietaire; // proprietaire en session
					break;
			}
			
			$_SESSION[SESSION_UTILISATEUR] = $user; // utilisateur en session pour accès rapide
			$result = true;
		}
		return $result;
	}
	
}

?>