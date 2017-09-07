<p>
	<label>Civilité :</label>
	<?php echo Tools::convertCiviliteFromId($form->getCivilite()) ?>
</p>
<p>
	<label>Nom :</label>
	<?php echo $form->getNom(); ?>
</p>
<p>
	<label>Prénom :</label>
	<?php echo $form->getPrenom(); ?>
</p>
<p>
	<label>E-mail :</label>
	<?php echo $form->getMail(); ?>
</p>
<p>
<label>Téléphone :</label>
	<?php echo $form->getTel(); ?>
</p>