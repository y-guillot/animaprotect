<form method="post" action="?page=veterinaire-proprietaires" class="defaultForm">
	<div class="infosUtilisateur">
		<?php include 'vue/commun/form/proprietaireForm.php';?>
		<p>
			<?php $form->printHiddenFiels(); ?>
			<input name='bouton' type='submit' value='Valider'/>
			<?php if ($form->getIdUtilisateur()) : ?>
				<input type='button' value='Supprimer' onclick="window.location='?page=veterinaire-proprietaires&id=<?php echo $form->getIdUtilisateur(); ?>&<?php echo SUPPRIMER?>';" />
			<?php endif; ?>
		</p>
	</div>
</form>