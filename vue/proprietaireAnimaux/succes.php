<div class="formSuccess">
	<?php switch ($success) {
		case MODIFIER :
			echo "Les informations de votre animal ont �t� mises � jour.";
			break;
		case AJOUTER :
			echo "Votre nouvel animal est d�sormais inscrit sur le site.";
			break;
		case SUPPRIMER :
			echo "L'animal a �t� supprim� de votre compte.";
			break;
	}?>	
</div>