<img id="portraitAnimal" src="<?php echo Tools::getAnimalPhoto($form->getAnimal()) . '?' . time();  ?>" />

<?php if (isset($_SESSION[SESSION_VETERINAIRE])) : ?>
	<a href="?page=veterinaire-interventions&<?php echo AJOUTER ?>=<?php echo $form->getId(); ?>" class="ajouterIntervention">
		Nouvelle intervention
	</a>
<?php endif; ?>

<div class="infosAnimal">
	<p><label>Race : </label><?php echo $form->getNomRace(); ?>&nbsp;</p>
	<p><label>N° de puce : </label><?php echo $form->getPuce(); ?>&nbsp;</p>
	<p><label>Date de naissance : </label><?php echo Tools::convertDateToFrenchStyle($form->getDateNaissance()); ?>&nbsp;</p>
	<p><label>Signes distinctifs : </label><?php echo nl2br($form->getSigneDistinctif()); ?>&nbsp;</p>
	<p><label>Commentaires : </label><?php echo nl2br($form->getCommentaire()); ?>&nbsp;</p>
</div>

<?php if (count($form->getInterventions()) > 0) : ?>
	<div class="animalInterventions">
		<?php foreach ($form->getInterventions() as $intervention) : ?>
			<p>

				<?php if (isset($_SESSION[SESSION_VETERINAIRE])) : ?>
					<?php if ($intervention->getIdVeterinaire() == $_SESSION[SESSION_VETERINAIRE]->getId()) : ?>
						<a href="?page=veterinaire-interventions&id=<?php echo $intervention->getId(); ?>&<?php echo EDITER; ?>" class="modifierIntervention">
							Modifier
						</a>
					<?php endif; ?>
				<?php endif; ?>
				
				<span class="intervention"><?php echo Tools::convertDateToFrenchStyle($intervention->getDate()); ?></span>
				<label>Praticien : </label>Dr. <?php echo $intervention->getNomVeterinaire() . " " . $intervention->getPrenomVeterinaire(); ?> <br/>
				<label>Nature de l'intervention : </label><?php echo $intervention->getNature(); ?><br/>
				<label>Tarif : </label><?php echo $intervention->getTarif(); ?> €<br/>
				<label>Compte rendu : </label><?php echo nl2br($intervention->getCompteRendu()); ?>
			</p>
		<?php endforeach; ?>
	</div>
<?php endif; ?>