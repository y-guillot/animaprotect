<form method="post" action="?page=veterinaire-interventions&id=<?php echo $form->getId(); ?>" class="defaultForm">
	<div class="infosIntervention">
		<?php include 'vue/commun/form/interventionForm.php';?>
		<p>
			<?php $form->printHiddenFiels(); ?>
			<input name='bouton' type='submit' value='Valider'/>
		</p>
	</div>
</form>