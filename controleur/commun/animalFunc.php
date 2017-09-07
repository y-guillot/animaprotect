<?php


	/**
	 * Compilation de données : réattribution des informations au nouveau formulaire
	 *
	 * @param AnimalForm $form
	 * @param AnimalForm $oldForm
	 */
	function compileFormDatas(AnimalForm &$form, AnimalForm $oldForm)
	{
		// réattribution des informations au nouveau formulaire
		$form->setId($oldForm->getId());
		$form->setIdProprietaire($oldForm->getIdProprietaire());
		$form->setRaces($oldForm->getRaces());
		$form->getAnimal()->setRace($oldForm->getAnimal()->getRace());
		$form->getAnimal()->setEspece($oldForm->getAnimal()->getEspece());
	}
	
	/**
	 * affectation des donnees postees au formulaire
	 * 
	 * @param AnimalForm $form
	 */
	function insertPostDatasIntoForm(AnimalForm &$form)
	{
		$form->setNom(@$_POST['nom']);
		$form->setIdRace(@$_POST['race']);
		$form->setPuce(@$_POST['puce']);
		$form->setDateNaissance(@$_POST['dob']);
		$form->setsigneDistinctif(@$_POST['signe']);
		$form->setCommentaire(@$_POST['commentaire']);
	}
	
	

?>