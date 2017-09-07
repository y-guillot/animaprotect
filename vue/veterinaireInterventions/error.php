<div class="formError">
	<?php switch ($error) {
		case ERROR_EXISTS :
			echo "Il n'existe aucune intervention associée à votre recherche.";
			break;
		case MODIFIER :
			echo "Une erreur est survenue durant la mise à jour de l'intervention : opération annulée.";
			break;
		case FORBIDDEN :
			echo "Vous n'avez pas les authorisations requises pour effectuer cette opération.";
			break;
	}?>	
</div>