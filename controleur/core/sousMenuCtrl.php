<?php

	if (isset($_SESSION['utilisateur'])){
		
		$user = $_SESSION['utilisateur'];
		$user->getIdRole();
		
		switch ($user->getIdRole()){
			
			case PROPRIETAIRE :
				include 'vue/commun/menu/menuProprietaire.php' ;
				break;
			
			case VETERINAIRE :
				include 'vue/commun/menu/menuVeterinaire.php' ;
				break;
			
			case ADMIN :
				include 'vue/commun/menu/menuAdmin.php' ;
				break;
		}

	} else {
		include 'vue/commun/menu/menuVisiteur.php' ;
	}
?>