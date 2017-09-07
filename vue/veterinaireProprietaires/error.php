<div class="formError">
	<?php switch ($error) {
		case ERROR_EXISTS :
			echo "Il n'existe aucun client associé à votre recherche.";
			break;
		case MODIFIER :
			echo "Une erreur est survenue durant la mise à jour des informatiions du client : opération annulée.";
			break;
		case SUPPRIMER :
			echo "La suppression d'un client est impossible tant qu'il dispose d'un patient enregistré sur le site.";
			break;
		
	}?>	
</div>