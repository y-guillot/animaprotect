
<?php if (isset($form)) : ?>

	<form method="post" action="?page=proprietaire-animaux&id=<?php echo $form->getId(); ?>" class="defaultForm">
		<?php include 'vue/commun/form/animalForm.php';?>
			<p>
				<?php echo $form->printHiddenFiels(); ?>
				<input type='submit' value='Valider'/>
				<?php if ($form->getId()) : ?>
					<input type='button' value='Supprimer' onclick="window.location='?page=proprietaire-animaux&id=<?php echo $form->getId(); ?>&<?php echo SUPPRIMER?>';" />
				<?php endif; ?>
			</p>
		</div>
	</form>
	
<?php else : ?>
	<p>Aucun animal ne correspond à votre recherche</p>
<?php endif; ?>
