<div class="formError">
	<?php switch ($error) {
		case ERROR_EXISTS :
			echo "Il n'existe aucun patient associé à votre recherche.";
			break;
		case MODIFIER :
			echo "Une erreur est survenue durant la mise à jour des informatiions du patient : opération annulée.";
			break;
		case SUPPRIMER :
			echo "La suppression d'un animal est interdite s'il a déjà eu recours à des interventions.";
			break;
	}?>	
</div>