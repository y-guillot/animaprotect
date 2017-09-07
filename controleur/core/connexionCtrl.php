<?php
	if (isset($_SESSION["utilisateur"])) {
		$user = $_SESSION["utilisateur"];
		include 'vue/commun/deconnexion.php';
	} else {
		include 'vue/commun/connexion.php';
	}
	
	include 'vue/commun/connexionMessage.php';
?>
