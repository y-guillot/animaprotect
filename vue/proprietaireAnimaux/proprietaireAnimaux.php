<form method="get" class="ajoutAnimal">
	<input name="page" type="hidden" value="proprietaire-animaux" />
	Inscrire un nouvel animal : 
	<select name="<?php echo ESPECE; ?>" required>
		<?php foreach ($especes as $espece) :?>
			<option value="<?php echo $espece->getId(); ?>" >
				<?php echo $espece->getNom(); ?>
			</option>
		<?php endforeach; ?>
	</select>
	<input type='submit' value=' OK '/>
</form>

<?php if (count($forms) > 0) : ?>
	<?php foreach($forms as $form) : ?>

		<div class="defaultForm">
			<div class="enteteInfosAnimal">
				<?php echo $form->getNom(); ?><?php echo '<br/>' ?>
				<a class="modifierInfosAnimal" href="?page=proprietaire-animaux&id=<?php echo $form->getId(); ?>">Modifier</a>
			</div>
			<?php include 'vue/commun/fiche/animalFiche.php';?>
		</div>

	<?php endforeach; ?>
<?php else : ?>
	<p>Vous n'avez pas encore inscrit d'animaux</p>
<?php endif; ?>