<div class="formSuccess">
	<?php switch ($success) {
		case MODIFIER :
			echo "L'intervention a �t� mise � jour.";
			break;
		case AJOUTER :
			echo "L'intervention a �t� enregistr�e.";
			break;
		case SUPPRIMER :
			echo "L'intervention a �t� supprim�e.";
			break;
	}?>	
</div>