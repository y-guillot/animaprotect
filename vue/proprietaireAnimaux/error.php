<div class="formError">
	<?php switch ($error) {
		case MODIFIER :
			echo "Une erreur est survenue pendant la mise � jour des informations sur l'animal.";
			break;
		case AJOUTER :
			echo "Une erreur est survenue pour l'inscription de votre animal : op�ration annul�e.";
			break;
		case SUPPRIMER :
			echo "Vous ne pouvez pas supprimer un animal ayant d�j� re�u une intervention : op�ration annul�e.";
			break;
		case ERROR_EXISTS:
			echo "Aucun patient ne correspond � votre s�lection.";
			break;
	}?>	
</div>