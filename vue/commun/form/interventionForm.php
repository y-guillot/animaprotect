<p>
	<label>Praticien :</label>
	<input readonly value="Dr. <?php echo $form->getNomVeterinaire() . " " . $form->getPrenomVeterinaire(); ?>"/>
</p>
<p>
	<label>Intervention du : </label>
	<input name="date" type="date" readonly value="<?php echo $form->getDate(); ?>"/>
	<?php if (!$form->isValid('date')) : ?>
		<span class="error">date non valide</span>
	<?php endif; ?>
</p>
<p>
	<label>Nature : </label>
	<input name="nature" pattern=".{1,50}" required placeholder="50 caratères max." value="<?php echo $form->getNature(); ?>"/>
	<?php if (!$form->isValid('nature')) : ?>
		<span class="error">champ requis ( 50 caratères max. )</span>
	<?php endif; ?>
</p>
<p>
	<label>Tarif : </label>
	<input type="number" name="tarif" pattern=".{1,5}" required placeholder="65 K€ max." value="<?php echo $form->getTarif(); ?>"/>
	<?php if (!$form->isValid('tarif')) : ?>
		<span class="error">champ requis ( 65 K€ max. )</span>
	<?php endif; ?>
</p>
<p>
	<label>Compte rendu : </label>
	<textarea name='compte_rendu' rows=7  pattern=".{1,1000}" required placeholder="1000 caratères max."><?php echo $form->getCompteRendu(); ?></textarea>
	<?php if (!$form->isValid('compte_rendu')) : ?>
		<span class="error">champ requis ( 1000 caratères max. )</span>
	<?php endif; ?>
</p>