<div class="formError">
	<?php switch ($error) {
		case MODIFIER :
			echo "Une erreur est survenue pendant la mise � jour de vos informations : op�ration annul�e.";
			break;
		case ERROR_EXISTS :
			echo "Aucun propri�taire ne correspond � votre s�lection.";
			break;
	}?>	
</div>