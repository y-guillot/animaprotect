<?php
class AffichagePageCtrl {
	
	private $sgdb;
	private $session;
	
	// Tableau des pages du site
	// url => contr�leur
	private $pages = array(
			// page par d�faut
			"accueil" => "accueil",
			// pages du menu pincipal
			"inscription" => "inscription",
			"la-clinique" => "clinique",
			"nos-veterinaires" => "veterinaires",
			"nos-patients" => "patients",
			// pages du menu admin
			"admin-informations" => "adminInformations",
			"admin-veterinaires" => "adminVeterinaires",
			// pages du menu veterinaire
			"veterinaire-informations" => "veterinaireInformations",
			"veterinaire-interventions" => "veterinaireInterventions",
			"veterinaire-proprietaires" => "veterinaireProprietaires",
			"veterinaire-animaux" => "veterinaireAnimaux",
			"veterinaire-bestiaire" => "veterinaireBestiaire",
			// pages du menu proprietaire
			"proprietaire-informations" => "proprietaireInformations",
			"proprietaire-animaux" => "proprietaireAnimaux"
	);
	
	
	function __construct(SgdbCtrl &$sgdb, SessionCtrl &$session)
	{
		$this->sgdb =& $sgdb;
		$this->session =& $session;
	}
		
	// scipt principal
	function execute()
	{
		$pageUri = isset($_GET['page']) ? $_GET['page'] : null;
		
		// Si une page specifique est demand�e
		if ($pageUri != null) {
			// Verifier si il existe un controlleur dans le tableau $pages pour la page demand�e
			if (array_key_exists($pageUri, $this->pages)) {
		
				// bufferisation du controlleur de la page demand�e
				ob_start();
				include "controleur/" .  $this->pages[$pageUri] . "Ctrl.php";
				$output = ob_get_contents(); // r�cup�re ce qui a �t� ex�cut� � partir de ob_start()
				ob_end_clean();
					
				// affichage de l'ensemble du document
				include('vue/commun/header.php');
				echo $output;
				include('vue/commun/footer.php');
					
			// sinon redirection vers la page d'accueil ou page 404
			} else {
				include 'vue/commun/404.php';
			}
			// Sinon aficher la page d'accueil
		} else {
			include 'vue/commun/header.php';
			include 'controleur/accueilCtrl.php';
			include 'vue/commun/footer.php';
		}
	}
}
?>
