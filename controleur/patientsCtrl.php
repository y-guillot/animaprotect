<?php
	
	// acquérir la liste des animaux	
	$listeAnimaux = $this->sgdb->listeAnimaux();
	include 'vue/patients/nos-patients.php';
?>