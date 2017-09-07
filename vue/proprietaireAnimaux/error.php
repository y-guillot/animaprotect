<div class="formError">
	<?php switch ($error) {
		case MODIFIER :
			echo "Une erreur est survenue pendant la mise à jour des informations sur l'animal.";
			break;
		case AJOUTER :
			echo "Une erreur est survenue pour l'inscription de votre animal : opération annulée.";
			break;
		case SUPPRIMER :
			echo "Vous ne pouvez pas supprimer un animal ayant déjà reçu une intervention : opération annulée.";
			break;
		case ERROR_EXISTS:
			echo "Aucun patient ne correspond à votre sélection.";
			break;
	}?>	
</div>