<div class="formSuccess">
	<?php switch ($success) {
		case MODIFIER :
			echo "Les informations du client ont �t� mises � jour.";
			break;
		case AJOUTER :
			echo "Le client est d�sormais inscrit.";
			break;
		case SUPPRIMER :
			echo "Le client et toutes ses donn�es ont �t� supprim�s.";
			break;
	}?>	
</div>