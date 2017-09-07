<h1>Nos Patients</h1>
<p>Nos vétérinaires ont pris en charge <?php echo count($listeAnimaux); ?> animaux </p>

<?php if (count($listeAnimaux) > 0) : ?>
	<?php foreach($listeAnimaux as $animal) : ?>
		<div class="animaux">
			<?php echo $animal->getNom(); ?>
			<img class="photoAnimal" src="<?php echo Tools::getAnimalPhoto($animal); ?>" />
		</div>
	<?php endforeach; ?>
<?php else : ?>
	Il n'y a pas d'animaux
<?php endif; ?>


