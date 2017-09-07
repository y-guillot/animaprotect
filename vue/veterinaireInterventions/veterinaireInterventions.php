
<?php if (count($forms) > 0) : ?>
	<div class="listing">
		<table>
			<caption><?php echo count($forms); ?> interventions correspondent à vos critères.</caption>
			<tr>
			    <th>Praticien</th>
			    <th>Animal<th>
			    <th>Nature<th>
	    	</tr>
			<?php foreach($forms as $form) : ?>
				<tr>
				    <td>Dr. <?php echo $form->getNomVeterinaire() . " " . $form->getPrenomVeterinaire(); ?></td>
				    <td><?php echo $form->getNomAnimal(); ?><td>
				    <td><?php echo $form->getNature(); ?><td>
				    <td><a href="?page=veterinaire-interventions&id=<?php echo $form->getId(); ?>">Consulter</a><td>
		    	</tr>
			<?php endforeach; ?>
		</table>
	</div>
<?php else : ?>
	<p>Aucune intervention ne correpond à vos critères de recherche.</p>
<?php endif; ?>

