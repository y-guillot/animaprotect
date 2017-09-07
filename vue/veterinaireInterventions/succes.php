<div class="formSuccess">
	<?php switch ($success) {
		case MODIFIER :
			echo "L'intervention a été mise à jour.";
			break;
		case AJOUTER :
			echo "L'intervention a été enregistrée.";
			break;
		case SUPPRIMER :
			echo "L'intervention a été supprimée.";
			break;
	}?>	
</div>