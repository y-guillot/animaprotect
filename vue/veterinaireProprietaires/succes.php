<div class="formSuccess">
	<?php switch ($success) {
		case MODIFIER :
			echo "Les informations du client ont été mises à jour.";
			break;
		case AJOUTER :
			echo "Le client est désormais inscrit.";
			break;
		case SUPPRIMER :
			echo "Le client et toutes ses données ont été supprimés.";
			break;
	}?>	
</div>