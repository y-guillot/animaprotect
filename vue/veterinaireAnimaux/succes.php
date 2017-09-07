<div class="formSuccess">
	<?php switch ($success) {
		case MODIFIER :
			echo "Les informations du patient ont été mises à jour.";
			break;
		case AJOUTER :
			echo "Le patient est désormais inscrit.";
			break;
		case SUPPRIMER :
			echo "Le patient et toutes ses données ont été supprimés.";
			break;
	}?>	
</div>