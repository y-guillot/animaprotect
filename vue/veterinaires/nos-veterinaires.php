
<h1>Nos V�t�rinaires</h1>
<p>L'�quipe d'Anima Protect compte actuellement <?php echo count($listeVeterinaires); ?> chirurgiens v�t�rinaires.</p>

<?php if (count($listeVeterinaires) > 0) : ?>
	<?php foreach($listeVeterinaires as $veterinaire) : ?>
		<div class="veterinaires">
			Dr. <?php echo $veterinaire->getNom() . " " . $veterinaire->getPrenom() ; ?><br/>
			<img class="photoPraticien" src="<?php echo Tools::getPraticienPhoto($veterinaire->getUtilisateur()); ?>" />
			Date d'arriv�e : <?php echo $veterinaire->getDateArrivee(); ?>
		</div>
	<?php endforeach; ?>
<?php else : ?>
	Il n'y a pas de practicien
<?php endif; ?>
