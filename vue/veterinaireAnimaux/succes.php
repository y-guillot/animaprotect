<div class="formSuccess">
	<?php switch ($success) {
		case MODIFIER :
			echo "Les informations du patient ont �t� mises � jour.";
			break;
		case AJOUTER :
			echo "Le patient est d�sormais inscrit.";
			break;
		case SUPPRIMER :
			echo "Le patient et toutes ses donn�es ont �t� supprim�s.";
			break;
	}?>	
</div>