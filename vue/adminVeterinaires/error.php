<div class="formError">
	<?php switch ($error) {
		case AJOUTER :
			echo "Une erreur est survenue lors de l'ajout du praticien : op�ration annul�e.";
			break;
		case MODIFIER :
			echo "Une erreur est survenue durant la mise � jour des informatiions du praticien : op�ration annul�e.";
			break;
		case SUPPRIMER :
			echo "La suppresion d'un praticien ne peut �tre effectu�e s'il a d�j� r�alis� des interventions.";
			break;
		case ERROR_EXISTS :
			echo "Aucun praticien ne correspond � votre demande.";
			break;
	}?>	
</div>