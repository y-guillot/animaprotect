<p>
	<label>Civilité :</label>
	<select name="civilite">
		<option value="<?php echo HOMME; ?>" <?php if ($form->getCivilite() == HOMME) : ?>selected <?php endif; ?>>M</option>
		<option value="<?php echo FEMME; ?>" <?php if ($form->getCivilite() == FEMME) : ?>selected <?php endif; ?>>Mme</option>
	</select>
</p>
<p>
	<label>Nom : </label>
	<input name='nom' pattern=".{2,50}" required placeholder="2 à 50 caratères max." value="<?php echo $form->getNom(); ?>"/>
	<?php if (!$form->isValid('nom')) : ?>
		<span class="error">champ requis ( de 2 à 50 caratères max. )</span>
	<?php endif; ?>
</p>
<p>
	<label>Prénom : </label>
	<input name='prenom' pattern=".{2,50}" required placeholder="2 à 50 caratères max." value="<?php echo $form->getPrenom(); ?>"/>
	<?php if (!$form->isValid('prenom')) : ?>
		<span class="error">champ requis ( de 2 à 50 caratères max. )</span>
	<?php endif; ?>
</p>
<p>
	<label>E-mail : </label>
	<input name='mail' pattern=".{5,100}" required placeholder="100 caratères max." type="email" value="<?php echo $form->getMail(); ?>"/>
	<?php if (!$form->isValid('mail')) : ?>
		<span class="error">
			<?php
				switch($form->getCodeError('mail')) {
					case ERROR_REGEX :
						echo "adresse email non conforme ";
						break;
					case ERROR_SIZE :
						echo "champ requis ";
						break;
					case ERROR_EXISTS :
						echo "cette adresse email est déjà utilisée ";
						break;
				}
			?>
		( 100 caratères max. )</span>
	<?php endif; ?>
</p>
<p>
	<label>Téléphone : </label>
	<input name='tel' pattern=".{10}" required placeholder="numéro sur 10 chiffres" type="tel" value="<?php echo $form->getTel(); ?>"/>
	<?php if (!$form->isValid('tel')) : ?>
		<span class="error">numéro invalide</span>
	<?php endif; ?>
</p>
<p>
	<label>Adresse : </label>
	<input name='adresse' pattern=".{1,255}" required placeholder="255 caratères max." value="<?php echo $form->getAdresse(); ?>"/>
	<?php if (!$form->isValid('adresse')) : ?>
		<span class="error">champ requis ( 255 caratères max. )</span>
	<?php endif; ?>
</p>
<p>
	<label>Ville : </label>
	<input name='ville' pattern=".{1,30}" required placeholder="30 caratères max." value="<?php echo$form->getVille(); ?>"/>
	<?php if (!$form->isValid('ville')) : ?>
		<span class="error">champ requis ( 30 caratères max. )</span>
	<?php endif; ?>
</p>
<p>
	<label>Code postal : </label>
	<input name='cp' pattern=".{5}" required placeholder="numéro sur 5 chiffres" value="<?php echo $form->getCp(); ?>"/>
	<?php if (!$form->isValid('cp')) : ?>
		<span class="error">code postal non valide</span>
	<?php endif; ?>
</p>
<p>
	<label>Mot de passe : </label>
	<input id="pass" name='pass' <?php if (!$form->getHidden(MODIFIER)) : ?>pattern=".{8,100}" required placeholder="8 caractères min." <?php endif; ?> type='password'/>
	<?php if (!$form->isValid('password')) : ?>
		<span class="error">mot de passe non séurisé ( 8 caractères minimum )</span>
	<?php endif; ?>
</p>
<p>
	<label>Confirmation : </label>
	<input id="conf" name='conf' <?php if (!$form->getHidden(MODIFIER)) : ?>pattern=".{8,100}" required placeholder="8 caractères min." <?php endif; ?> type='password'/>
	<span id="conf_error" class="error hide">Le mot de passe n'est pas identique.</span>
</p>