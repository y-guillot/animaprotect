<div class="defaultForm">
	<div class="enteteInfosAnimal">
		<?php echo $form->getAnimal()->getNom(); ?><br/>
		<a class="modifierInfosAnimal" href="?page=veterinaire-animaux&id=<?php echo $form->getAnimal()->getId(); ?>">Consulter</a>
	</div>
	<?php include 'vue/commun/fiche/animalFiche.php';?>
</div>