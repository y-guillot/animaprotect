<form method="post" action="?page=veterinaire-informations&<?php echo EDITER; ?>" class="defaultForm">
		<?php include 'vue/commun/form/veterinaireForm.php';?>
		<p>
			<?php $form->printHiddenFiels(); ?>
			<input name='bouton' type='submit' value='Valider'/>
		</p>
	</div>
</form>

<script >
	/*
	 * Check if passwords are matching
	 */
	$(".defaultForm").submit(function( event ) {
		if ($("#pass").val() != $("#conf").val()) {
			$("#conf_error").removeClass("hide");
			event.preventDefault();
	 	}
	}); 
</script>