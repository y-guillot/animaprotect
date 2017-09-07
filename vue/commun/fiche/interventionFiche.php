<p>
	<label>Intervention du :</label>
	<?php echo Tools::convertDateToFrenchStyle($intervention->getDate()); ?>
</p>
<p>
	<label>Praticien :</label>
	Dr. <?php echo $intervention->getNomVeterinaire() . " " . $intervention->getPrenomVeterinaire(); ?>
</p>
<p>
	<label>Nature :</label>
	<?php echo $intervention->getNature(); ?>
</p>
<p>
	<label>Tarif :</label>
	<?php echo $intervention->getTarif(); ?>
</p>
<p>
	<label>Compte rendu :</label>
	<?php echo nl2br($intervention->getCompteRendu()); ?>
</p>