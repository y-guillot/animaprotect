<?php

	/**
	 * Compilation de données postées
	 * 
	 * @param InterventionForm $form
	 * @param InterventionForm $oldForm
	 */
	function compileFormDatas(InterventionForm &$form, InterventionForm $oldForm)
	{
		// réattribution des informations au nouveau formulaire
		$form->setId($oldForm->getId());
		$form->setIdAnimal($oldForm->getIdAnimal());
		$form->setIdVeterinaire($oldForm->getIdVeterinaire());
		$form->setVeterinaire($oldForm->getVeterinaire());
	}
	
	/**
	 * affectation des donnees postees au formulaire
	 * 
	 * @param InterventionForm $form
	 */
	function insertPostDatasIntoForm(InterventionForm &$form)
	{
		$form->setDate(@$_POST['date']);
		$form->setTarif(@$_POST['tarif']);
		$form->setNature(@$_POST['nature']);
		$form->setCompteRendu(@$_POST['compte_rendu']);
	}
	
?>