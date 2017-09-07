<div class="formError">
	<?php switch ($error) {
		case AJOUTER :
			echo "Une erreur est survenue lors de l'ajout du praticien : opération annulée.";
			break;
		case MODIFIER :
			echo "Une erreur est survenue durant la mise à jour des informatiions du praticien : opération annulée.";
			break;
		case SUPPRIMER :
			echo "La suppresion d'un praticien ne peut être effectuée s'il a déjà réalisé des interventions.";
			break;
		case ERROR_EXISTS :
			echo "Aucun praticien ne correspond à votre demande.";
			break;
	}?>	
</div>