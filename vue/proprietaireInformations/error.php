<div class="formError">
	<?php switch ($error) {
		case MODIFIER :
			echo "Une erreur est survenue pendant la mise à jour de vos informations : opération annulée.";
			break;
		case ERROR_EXISTS :
			echo "Aucun propriétaire ne correspond à votre sélection.";
			break;
	}?>	
</div>