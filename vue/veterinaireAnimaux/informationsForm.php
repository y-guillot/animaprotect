<form method="post" action="?page=veterinaire-animaux&id=<?php echo $form->getId(); ?>&<?php echo EDITER; ?>" class="defaultForm">
	<?php include 'vue/commun/form/animalForm.php';?>
		<p>
			<?php $form->printHiddenFiels(); ?>
			<input name='bouton' type='submit' value='Valider'/>
			<?php if ($form->getId()) : ?>
				<input type='button' value='Supprimer' onclick="window.location='?page=veterinaire-animaux&id=<?php echo $form->getId(); ?>&<?php echo SUPPRIMER?>';" />
			<?php endif; ?>
		</p>
	</div>
</form>