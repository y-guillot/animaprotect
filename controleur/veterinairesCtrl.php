<?php
	
	// acqu�rir la liste des veterinaire	
	$listeVeterinaires = $this->sgdb->listeVeterinaires();

	include 'vue/veterinaires/nos-veterinaires.php';
?>