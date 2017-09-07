<div class="defaultForm">
		<?php include 'vue/commun/fiche/veterinaireFiche.php';?>
		<p>
			<br/><a href="?page=admin-veterinaires&id=<?php echo $form->getIdUtilisateur(); ?>&<?php echo EDITER; ?>">Modifier</a>
		</p>
	</div>
</div>

<div class="infos intervention">
	Liste des interventions du praticien :
</div>

<div class="defaultForm">
<?php if (count($form->getInterventions()) > 0) : ?>
	<div class="listInterventions">
		<?php foreach ($form->getInterventions() as $intervention) : ?>
			<p>
				<span class="intervention"><?php echo Tools::convertDateToFrenchStyle($intervention->getDate()); ?></span>
				<label>Praticien : </label>Dr. <?php echo $intervention->getNomVeterinaire() . " " . $intervention->getPrenomVeterinaire(); ?> <br/>
				<label>Nature de l'intervention : </label><?php echo $intervention->getNature(); ?><br/>
				<label>Tarif : </label><?php echo $intervention->getTarif(); ?> €<br/>
				<label>Compte rendu : </label><?php echo nl2br($intervention->getCompteRendu()); ?>
			</p>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
</div>