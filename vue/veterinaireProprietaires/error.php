<div class="formError">
	<?php switch ($error) {
		case ERROR_EXISTS :
			echo "Il n'existe aucun client associ� � votre recherche.";
			break;
		case MODIFIER :
			echo "Une erreur est survenue durant la mise � jour des informatiions du client : op�ration annul�e.";
			break;
		case SUPPRIMER :
			echo "La suppression d'un client est impossible tant qu'il dispose d'un patient enregistr� sur le site.";
			break;
		
	}?>	
</div>