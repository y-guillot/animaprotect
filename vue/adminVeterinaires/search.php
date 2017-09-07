<form method="get" class="search veterinaire">
	<input name="page" type="hidden" value="admin-veterinaires" />
	Rechercher un praticien :
	<input name="<?php echo RECHERCHER; ?>" required />
	<input type='submit' value=' OK '/>
	<a href="?page=admin-veterinaires&<?php echo AJOUTER; ?>">Nouveau praticien</a>
</form>
