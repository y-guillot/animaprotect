<div class="defaultForm">
	<div class="infosUtilisateur">
		<?php include 'vue/commun/fiche/proprietaireFiche.php';?>
		<p>
			<br/><a href="?page=veterinaire-proprietaires&id=<?php echo $form->getProprietaire()->getIdUtilisateur(); ?>&<?php echo EDITER; ?>">Modifier</a>
		</p>
	</div>
</div>

<form method="get" class="ajoutAnimal">
	<input name="page" type="hidden" value="veterinaire-animaux" />
	<input name="id" type="hidden" value="<?php echo $form->getProprietaire()->getIdUtilisateur(); ?>" />
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
				<a class="modifierInfosAnimal" href="?page=veterinaire-animaux&id=<?php echo $form->getId(); ?>&<?php echo EDITER; ?>">Modifier</a>
			</div>
			<?php include 'vue/commun/fiche/animalFiche.php';?>
		</div>
		
	<?php endforeach; ?>
<?php endif; ?>