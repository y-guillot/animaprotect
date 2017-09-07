<div class="formSuccess">
	<?php switch ($success) {
		case MODIFIER :
			echo "Les informations du praticien ont été mises à jour.";
			break;
		case AJOUTER :
			echo "Le praticien est désormais inscrit.";
			break;
		case SUPPRIMER :
			echo "Le praticien et toutes ses données ont été supprimés.";
			break;
	}?>	
</div>