<div class="formError">
	<?php switch ($error) {
		case ERROR_EXISTS :
			echo "Il n'existe aucun patient associ� � votre recherche.";
			break;
		case MODIFIER :
			echo "Une erreur est survenue durant la mise � jour des informatiions du patient : op�ration annul�e.";
			break;
		case SUPPRIMER :
			echo "La suppression d'un animal est interdite s'il a d�j� eu recours � des interventions.";
			break;
	}?>	
</div>