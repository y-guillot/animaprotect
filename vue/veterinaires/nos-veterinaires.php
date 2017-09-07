
<h1>Nos Vétérinaires</h1>
<p>L'équipe d'Anima Protect compte actuellement <?php echo count($listeVeterinaires); ?> chirurgiens vétérinaires.</p>

<?php if (count($listeVeterinaires) > 0) : ?>
	<?php foreach($listeVeterinaires as $veterinaire) : ?>
		<div class="veterinaires">
			Dr. <?php echo $veterinaire->getNom() . " " . $veterinaire->getPrenom() ; ?><br/>
			<img class="photoPraticien" src="<?php echo Tools::getPraticienPhoto($veterinaire->getUtilisateur()); ?>" />
			Date d'arrivée : <?php echo $veterinaire->getDateArrivee(); ?>
		</div>
	<?php endforeach; ?>
<?php else : ?>
	Il n'y a pas de practicien
<?php endif; ?>
