<div class="formError">
	<?php switch ($error) {
		case ERROR_EXISTS :
			echo "Il n'existe aucune intervention associ�e � votre recherche.";
			break;
		case MODIFIER :
			echo "Une erreur est survenue durant la mise � jour de l'intervention : op�ration annul�e.";
			break;
		case FORBIDDEN :
			echo "Vous n'avez pas les authorisations requises pour effectuer cette op�ration.";
			break;
	}?>	
</div>