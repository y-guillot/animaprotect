
<?php if (count($forms) > 0) : ?>
	<div class="listing">
		<table>
			<caption><?php echo count($forms); ?> propri�taires correspondent � vos crit�res.</caption>
			<tr>
			    <th>Client</th>
			    <th>T�l�phone<th>
			    <th>Email<th>
	    	</tr>
			<?php foreach($forms as $form) : ?>
				<tr>
				    <td><?php echo Tools::convertCiviliteFromId($form->getCivilite()) . " " . $form->getNom() . " " . $form->getPrenom(); ?></td>
				    <td><?php echo $form->getTel(); ?><td>
				    <td><?php echo $form->getMail(); ?><td>
				    <td><a href="?page=veterinaire-proprietaires&id=<?php echo $form->getProprietaire()->getIdUtilisateur(); ?>">Consulter</a><td>
		    	</tr>
			<?php endforeach; ?>
		</table>
	</div>
<?php else : ?>
	<p>Aucun client ne correpond � vos crit�res de recherche.</p>
<?php endif; ?>