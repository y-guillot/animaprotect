<div class="defaultForm">
	<div class="infosIntervention">

		<?php if ($intervention->getIdVeterinaire() == $_SESSION[SESSION_VETERINAIRE]->getId()) : ?>
			<a href="?page=veterinaire-interventions&id=<?php echo $intervention->getId(); ?>&<?php echo EDITER; ?>" class="modifierIntervention">
				Modifier
			</a>
		<?php endif; ?>
		
		<?php include 'vue/commun/fiche/interventionFiche.php';?>
	</div>
</div>

<?php include 'vue/veterinaireInterventions/informationsAnimal.php';?>
<?php include 'vue/veterinaireInterventions/informationsProprietaire.php';?>