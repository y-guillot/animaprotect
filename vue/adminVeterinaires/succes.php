<div class="formSuccess">
	<?php switch ($success) {
		case MODIFIER :
			echo "Les informations du praticien ont �t� mises � jour.";
			break;
		case AJOUTER :
			echo "Le praticien est d�sormais inscrit.";
			break;
		case SUPPRIMER :
			echo "Le praticien et toutes ses donn�es ont �t� supprim�s.";
			break;
	}?>	
</div>