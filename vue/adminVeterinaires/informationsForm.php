<form method="post" action="?page=admin-veterinaires" class="defaultForm">
		<?php include 'vue/commun/form/veterinaireForm.php';?>
		<p>
			<?php $form->printHiddenFiels(); ?>
			<input name='bouton' type='submit' value='Valider'/>
			<?php if ($form->getIdUtilisateur()) : ?>
				<input type='button' value='Supprimer' onclick="window.location='?page=admin-veterinaires&id=<?php echo $form->getIdUtilisateur(); ?>&<?php echo SUPPRIMER?>';" />
			<?php endif; ?>
		</p>
	</div>
</form>