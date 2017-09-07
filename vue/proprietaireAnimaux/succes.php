<div class="formSuccess">
	<?php switch ($success) {
		case MODIFIER :
			echo "Les informations de votre animal ont été mises à jour.";
			break;
		case AJOUTER :
			echo "Votre nouvel animal est désormais inscrit sur le site.";
			break;
		case SUPPRIMER :
			echo "L'animal a été supprimé de votre compte.";
			break;
	}?>	
</div>