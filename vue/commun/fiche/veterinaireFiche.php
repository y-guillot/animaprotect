<img id="portraitPraticien" src="<?php echo Tools::getPraticienPhoto($form->getUtilisateur()) . '?' . time(); ?>" />

<div class="infosPraticien">

	<?php include 'vue/commun/fiche/utilisateurFiche.php';?>
	<p>
		<label>Date d'arrivée :</label>
		<?php echo Tools::convertDateToFrenchStyle($form->getDateArrivee()); ?>
	</p>
	<p>
		<label>Code praticien :</label>
		<?php echo $form->getCodePraticien(); ?>
	</p>
