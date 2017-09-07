<div class="defaultForm">
	<div class="enteteInfosAnimal">
		<?php echo $form->getNom(); ?><br/>
		<a class="modifierInfosAnimal" href="?page=veterinaire-animaux&id=<?php echo $form->getAnimal()->getId(); ?>&<?php echo EDITER; ?>">Modifier</a>
	</div>
	<?php include 'vue/commun/fiche/animalFiche.php';?>
</div>