
<?php if (count($forms) > 0) : ?>
	<div class="listing">
		<table>
			<caption><?php echo count($forms); ?> patients correspondent � vos crit�res.</caption>
			<tr>
			    <th>Patient</th>
			    <th>N� puce<th>
			    <th>Date de naissance<th>
	    	</tr>
			<?php foreach($forms as $form) : ?>
				<tr>
				    <td><?php echo $form->getNom(); ?></td>
				    <td><?php echo $form->getPuce(); ?><td>
				    <td><?php echo $form->getDateNaissance(); ?><td>
				    <td><a href="?page=veterinaire-animaux&id=<?php echo $form->getId(); ?>">Consulter</a><td>
		    	</tr>
			<?php endforeach; ?>
		</table>
	</div>
<?php else : ?>
	<p>Aucun patient ne correpond � vos crit�res de recherche.</p>
<?php endif; ?>