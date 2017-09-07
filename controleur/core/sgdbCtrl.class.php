<?php

include 'modele/utilisateur.class.php';
include 'modele/veterinaire.class.php';
include 'modele/proprietaire.class.php';
include 'modele/intervention.class.php';
include 'modele/animal.class.php';
include 'modele/race.class.php';
include 'modele/espece.class.php';

class SgdbCtrl {
	
	private $pdo;

	public function getPdo()
	{
		return $this->pdo;
	}
	
	/**
	 * Connexion a la base
	 * 
	 * @return PDO
	 */
	public function connexion()
	{
		$dsn = DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME;
		$this->pdo = new PDO($dsn, DB_USER, DB_PASS, array(PDO::ATTR_PERSISTENT => true));
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $this->pdo;
	}

	/**
	 * Authentifier utilisateur
	 * 
	 * @param Utilisateur $user
	 * @return boolean
	 */
	public function authentifierUtilisateur(Utilisateur &$user)
	{
		// la requete
		$req = $this->pdo->prepare('SELECT id, idRole, civilite, nom, prenom
    		FROM utilisateur
   			WHERE mail = ? AND password = ?');
		
		// l'exécution de la requete avec les paramètres
		$req->execute(array($user->getMail(), $user->getPassword()));
		
		// l'extraction des résultats dans un tableau
		$tabUsers = $req->fetchAll();
		
		// aucun utilisateur ou plusieurs utilisateurs 
		if (count($tabUsers) == 0 || count($tabUsers) > 1) return false ;
			
		// utilisateur authentifié
		$user->setId($tabUsers[0]['id']);
		$user->setIdRole($tabUsers[0]['idRole']);
		$user->setNom($tabUsers[0]['nom']);
		$user->setCivilite($tabUsers[0]['civilite']);
		$user->setPrenom($tabUsers[0]['prenom']);
		
		return true;
	}
	
	/**
	 * Récuperer la liste des animaux
	 * 
	 * @return array
	 */
	 public function listeAnimaux()
	 {
	 	// la requete
	 	$req = $this->pdo->query('SELECT A.id, A.idProprietaire, A.idRace, A.nom, A.puce, A.date_naissance, A.signe_distinctif, A.commentaire,
	 			R.nom AS nomRace, R.idEspece, E.nom AS nomEspece
		 		FROM animal A
		 		JOIN race R ON A.idRace = R.id
		 		JOIN espece E ON E.id = R.idEspece
	   			ORDER BY A.nom');
	 	
	 	$tab = $req->fetchAll(); // l'extraction des résultats dans un tableau
	 	$tabAnimaux = array();
	 	 
	 	// pacours des résultats
	 	foreach($tab as $row) {
	 		$animal = new Animal();
	 		$this->peuplerAnimal($animal, $row);
	 		$tabAnimaux[] = $animal;
	 	}
	 	
	 	return $tabAnimaux;
	 }
	 
	 /**
	  * Récuperer la liste des animaux d'un utilisateur particulier
	  *
	  * @return array
	  */
	 public function listeAnimauxProprietaire(Proprietaire $proprietaire)
	 {
	 	// la requete
	 	$req = $this->pdo->prepare('SELECT
	 			A.id, A.idProprietaire, A.idRace, A.nom, A.puce, A.date_naissance, A.signe_distinctif, A.commentaire,
	 			R.nom AS nomRace, R.idEspece, E.nom AS nomEspece
		 		FROM animal A
		 		JOIN race R ON A.idRace = R.id
		 		JOIN espece E ON E.id = R.idEspece
		 		WHERE A.idProprietaire = ?
	   			ORDER BY A.nom');
	 	
	 	$req->execute(array($proprietaire->getId())); // Exécution de la reqête paramétrée
	 	$tab = $req->fetchAll(); // l'extraction des résultats dans un tableau
	 	$tabAnimaux = array();
	 	
	 	// pacours des résultats
	 	foreach($tab as $row) {
 			$animal = new Animal();
 			$this->peuplerAnimal($animal, $row);
 			$tabAnimaux[] = $animal;
	 	}
	 	 
	 	return $tabAnimaux;
	 }
	 
	 
	 /**
	  * Recherche les animaux en fonction d'un parametre
	  *
	  * @return array
	  */
	 public function getAnimaux($param)
	 {
	 	// la requete
	 	$req = $this->pdo->prepare('SELECT
	 			A.id, A.idProprietaire, A.idRace, A.nom, A.puce, A.date_naissance, A.signe_distinctif, A.commentaire,
	 			R.nom AS nomRace, R.idEspece, E.nom AS nomEspece
		 		FROM animal A
		 		JOIN race R ON A.idRace = R.id
		 		JOIN espece E ON E.id = R.idEspece
	 			WHERE LOWER(A.nom) LIKE ? OR LOWER(A.puce) LIKE ?
	   			ORDER BY A.nom');
	 	 
	 	$param = '%' . strtolower(trim($param)) .'%';
	 	$req->execute(array($param, $param)); // execution de la requete
	 	$tab =$req->fetchAll(); // l'extraction des résultats dans un tableau
	 	$tabAnimaux = array();
	 
	 	// pacours des résultats
	 	foreach($tab as $row) {
	 		$animal = new Animal();
	 		$this->peuplerAnimal($animal, $row);
	 		$tabAnimaux[] = $animal;
	 	}
	 	 
	 	return $tabAnimaux;
	 }
	 
	 /**
	  * Peupler un animal à partir d'un tableau issu de la base de données
	  *
	  * @param Utilisateur $intervention
	  * @param unknown $array
	  */
	 private function peuplerAnimal(Animal &$animal, $array)
	 {
	 	$animal->setId(intval($array['id']));
	 	$animal->setidRace(intval($array['idRace']));
 		$animal->setIdProprietaire(intval($array['idProprietaire']));
 		$animal->setPuce($array['puce']);
 		$animal->setNom($array['nom']);
 		$animal->setDateNaissance($array['date_naissance']);
 		$animal->setSigneDistinctif($array['signe_distinctif']);
 		$animal->setCommentaire($array['commentaire']);
 		
 		$race = new Race();
 		$race->setId(intval($array['idRace']));
 		$race->setIdEspece(intval($array['idEspece']));
 		$race->setNom($array['nomRace']);
 		$animal->setRace($race);
 		
 		$espece = new Espece();
 		$espece->setId(intval($array['idEspece']));
 		$espece->setNom($array['nomEspece']);
 		$animal->setEspece($espece);
	 }
	 
	 
	 
	 /**
	  * Obtenir l'espèce à partir d'une race donnée
	  * 
	  * @param Race $race
	  * @return Ambigous <NULL, Espece>
	  */
	 public function getEspeceFromRace(Race &$race)
	 {
	 	// la requete
	 	$req = $this->pdo->prepare('SELECT E.id, E.nom
	 			FROM espece E
	 			JOIN race R ON E.id = R.idEspece
	 			WHERE R.id = ?');
	 	 
	 	$req->execute(array($race->getId())); // Exécution de la reqête paramétrée
	 	$tab = $req->fetchAll(); // l'extraction des résultats dans un tableau
	 	
	 	$espece = null;
	 	if (count($tab) == 1) {
	 		$espece = new Espece();
	 		$espece->setId(intval($tab[0]['id']));
	 		$espece->setNom($tab[0]['nom']);
	 	}
	 	
	 	return $espece;
	 }
	 
	 /**
	  * Obtenir l'espèce à partir de son identifiant
	  *
	  * @param $id
	  * @return Ambigous <NULL, Espece>
	  */
	 public function getEspeceFromId($id)
	 {
	 	$id = intval($id);
	 	
	 	// la requete
	 	$req = $this->pdo->prepare('SELECT * FROM espece WHERE id = ?');
	 	$req->execute(array($id)); // Exécution de la reqête paramétrée
	 	$tab = $req->fetchAll(); // l'extraction des résultats dans un tableau
	 	 
	 	$espece = null;
	 	if (count($tab) == 1) {
	 		$espece = new Espece();
	 		$espece->setId(intval($tab[0]['id']));
	 		$espece->setNom($tab[0]['nom']);
	 	}
	 	 
	 	return $espece;
	 }
	 
	 /**
	  * Obtenir la liste de toutes les especes
	  *
	  * @return Ambigous <NULL, Espece>
	  */
	 public function getEspeces()
	 {
	 	// la requete
	 	$req = $this->pdo->query('SELECT * FROM espece ORDER BY nom');
	 
	 	// pacours des résultats
	 	$tabEspeces = array();
	 	if ($req) {
	 		foreach($req as $row) {
	 			$espece = new Espece();
	 			$espece->setId(intval($row['id']));
	 			$espece->setNom($row['nom']);
	 			$tabEspeces[] = $espece;
	 		}
	 	}

	 	return $tabEspeces;
	 }
	 
	 
	 /**
	  * Récuperer la liste des races possibles pour une espece donnée
	  *
	  * @return array
	  */
	 public function listeRacesFromEspece(Espece $espece)
	 {
	 	// la requete
	 	$req = $this->pdo->prepare('SELECT * FROM race WHERE idEspece = ? ORDER BY nom');
	 	$req->execute(array($espece->getId())); // Exécution de la reqête paramétrée
	 	$tab = $req->fetchAll(); // l'extraction des résultats dans un tableau
	 	 
	 	$races = array();
	 	
	 	foreach($tab as $row) {
	 		$race = new Race();
	 		$race->setId(intval($row['id']));
	 		$race->setIdEspece(intval($row['idEspece']));
	 		$race->setNom($row['nom']);
	 		$races[] = $race;
	 	}
	 	 
	 	return $races;
	 }
	 
	 
	 /**
	  * Liste des interventions effectuées sur un animal
	  * 
	  * @param Animal $animal
	  * @return multitype:Intervention
	  */
	 public function listeInterventions(Animal $animal)
	 {
	 	// la requete
	 	$req = $this->pdo->prepare('SELECT
	 			I.id, I.idVeterinaire, I.idAnimal, I.date, I.nature, I.tarif, I.compte_rendu,
	 			U.civilite, U.nom, U.prenom,
	 			A.nom AS nomAnimal
		 		FROM intervention I
		 		JOIN veterinaire V ON I.idVeterinaire = V.id
		 		JOIN utilisateur U ON V.idUtilisateur = U.id
	 			JOIN animal A ON I.idAnimal = A.id
		 		WHERE I.idAnimal = ?
	   			ORDER BY I.id DESC');
	 	 
	 	$req->execute(array($animal->getId()));	// Exécution de la reqête paramétrée
	 	$tab = $req->fetchAll(); // l'extraction des résultats dans un tableau
	 	$tabInterventions = array();
	 	
	 	if ($req) {
	 		foreach($tab as $row) {
	 			$intervention = new Intervention();
	 			$animal->setNom($row['nomAnimal']);
	 			$intervention->setAnimal($animal);
	
	 			$this->peuplerIntervention($intervention, $row);
	 			$tabInterventions[] = $intervention;
	 		}
	 	}

	 	return $tabInterventions;
	 }
	
	 
	 /**
	  * Récuperer toutes les informations de l'intervention
	  *
	  * @return array
	  */
	 public function getInformationsIntervention(Intervention &$intervention)
	 {
	 	//la requete
	 	$req = $this->pdo->prepare('SELECT
	 			I.id, I.idVeterinaire, I.idAnimal, I.date, I.nature, I.tarif, I.compte_rendu,
	 			U.civilite, U.nom, U.prenom
	 			FROM intervention I
	 			JOIN veterinaire V ON I.idVeterinaire = V.id
		 		JOIN utilisateur U ON V.idUtilisateur = U.id
	 			WHERE I.id = ?');
	 	 
	 	$req->execute(array($intervention->getId())); // execution de la requete
	 	$tabInterventions = $req->fetchAll(); // l'extraction des résultats dans un tableau
	 	 
	 	$intervention = new Intervention();
	 	// Il ne doit exister qu'une seule intervention
	 	if (count($tabInterventions) == 1) {
	 		$this->peuplerIntervention($intervention, $tabInterventions[0]);
	 	}
	 
	 	return $intervention;
	 }
	 
 

	 /**
	  * Peupler une intervention à partir d'un tableau issu de la base de données
	  *
	  * @param Intervention $animal
	  * @param unknown $array
	  */
	 private function peuplerIntervention(Intervention &$intervention, $row)
	 {
	 	
	 	$veterinaire = new Veterinaire();
	 	$veterinaire->setId($row['idVeterinaire']);
	 	$veterinaire->getUtilisateur()->setCivilite($row['civilite']);
	 	$veterinaire->getUtilisateur()->setNom($row['nom']);
	 	$veterinaire->getUtilisateur()->setPrenom($row['prenom']);
	 	$intervention->setVeterinaire($veterinaire);

	 	$intervention->setId($row['id']);
		$intervention->setIdVeterinaire($row['idVeterinaire']);
		$intervention->setIdAnimal($row['idAnimal']);
		$intervention->setDate($row['date']);
		$intervention->setNature($row['nature']);
		$intervention->setTarif($row['tarif']);
		$intervention->setCompteRendu($row['compte_rendu']);
	 }
	 
	 
	 /**
	  * Récuperer la liste des vétérinaires
	  *
	  * @return array
	  */
	 public function listeVeterinaires()
	 {
	 	// l'exécution de la requete
	 	$req = $this->pdo->query('SELECT
	 			U.id AS idU, U.idRole, U.civilite, U.mail, U.nom, U.prenom, U.tel, U.password,
	 			V.id AS idV, V.date_arrivee, V.code_praticien
    			FROM veterinaire V
	 			JOIN utilisateur U ON V.idUtilisateur = U.id
	 			JOIN role R ON R.id = U.idRole AND R.id = 2
   				ORDER BY V.date_arrivee, U.nom');

	 	// pacours des résultats
	 	$tabVeterinaire = array();
	 	if ($req) {
	 		foreach($req as $row) {
	 			
	 			$veterinaire = new Veterinaire();
	 			$user = $veterinaire->getUtilisateur();

	 			$this->peuplerUtilisateur($user, $row);
	 			$this->peuplerVeterinaire($veterinaire, $row);

	 			$tabVeterinaire[] = $veterinaire;
	 		}
	 	}
	 	return $tabVeterinaire;
	 }
	 
	 /**
	  * Verifier l'existance d'une adresse mail dans la base
	  * 
	  * @param Utilisateur $user
	  * @return boolean
	  */
	 public function isMailAlreadyExists(Utilisateur $user)
	 {

	 	$sql = 'SELECT COUNT(*) FROM utilisateur WHERE mail = ? ';
	 	
	 	if ($user->getId() != null) {
	 		$req = $this->pdo->prepare($sql . ' AND id != ?'); // permet de vérifier qu'une adresse mail autre que la sienne existe (pour s'exlure de la requete en cas de mise à jour des données)
	 		$req->execute(array($user->getMail(), $user->getId()));
	 		
	 	} else {
	 		$req = $this->pdo->prepare($sql);
	 		$req->execute(array($user->getMail()));
	 	}
	 	
	 	// lecture du nombre de résultats
	 	$trouve = $req->fetchColumn();
	 	
	 	return $trouve > 0 ? true : false;
	 }
	 
	 /**
	  * Supprimer une race
	  *
	  * @param Race $race
	  * @return number
	  */
	 public function delRace(Race $race)
	 {
	 	$req = $this->pdo->prepare('DELETE FROM race WHERE id= ?');
	 	try {
	 		$req->execute(array($race->getId()));
	 		return $req->rowCount();
	 	} catch (Exception $e) {
	 		return 0;
	 	}
	 }
	 
	 /**
	  * Supprimer une espece
	  *
	  * @param Espece $espece
	  * @return number
	  */
	 public function delEspece(Espece $espece)
	 {
	 	$req = $this->pdo->prepare('DELETE FROM espece WHERE id= ?');
	 	try {
	 		$req->execute(array($espece->getId()));
	 		Tools::supprimerPhotoEspece($espece);
	 		return $req->rowCount();
	 	} catch (Exception $e) {
	 		return 0;
	 	}
	 }
	
	 /**
	  * Supprier un animal
	  * 
	  * @param Animal $animal
	  * @return number
	  */
	 public function supprimerAnimal(Animal $animal)
	 {
	 	$req = $this->pdo->prepare('DELETE FROM animal WHERE id= ?');
	 	try {
	 		$req->execute(array($animal->getId()));
	 		Tools::supprimerPhotoAnimal($animal);
	 		return $req->rowCount();
	 	} catch (Exception $e) {
	 		return 0;
	 	}
	 }
	 
	 /**
	  * Supprimer un utilisateur
	  *
	  * @param Utilisateur $user
	  * @return number
	  */
	 public function supprimerUtilisateur(Utilisateur $user)
	 {
	 	$req = $this->pdo->prepare('DELETE FROM utilisateur WHERE id= ?');
	 	try {
		 	$req->execute(array($user->getId()));
		 	Tools::supprimerPhotoUtilisateur($user);
		 	return $req->rowCount();
	 	} catch (Exception $e) {
	 		return 0;
	 	}
	 }
	 
	 /**
	  * Ajouter un animal
	  * 
	  * @param Animal $animal
	  * @return Ambigous <boolean, string>
	  */
	 public function insererAnimal(Animal $animal)
	 {
	 	$req = $this->pdo->prepare('INSERT INTO animal (idRace, idProprietaire, nom, puce, date_naissance, signe_distinctif, commentaire)
	 			VALUES ( ?, ?, ?, ?, ?, ?, ? )');
	 	
	 	$result = $req->execute(array(
		 			$animal->getIdRace(),
		 			$animal->getIdProprietaire(),
		 			$animal->getNom(),
		 			$animal->getPuce(),
		 			$animal->getDateNaissance(),
		 			$animal->getSigneDistinctif(),
		 			$animal->getCommentaire()
	 	));
	 	
	 	return $result ? $this->pdo->lastInsertId() : null;
	 }
	 
	/**
	 * Ajouter une nouvelle espece et une race par defaut
	 * 
	 * @param Espece $espece
	 * @param string $new
	 * @return string|NULL
	 */
	 public function insererEspece(Espece $espece)
	 {
	 	$req = $this->pdo->prepare('INSERT INTO espece (nom) VALUES ( ? )');
	 	
	 	try {
	 		$this->pdo->beginTransaction();
	 		
	 		$req->execute(array($espece->getNom()));
	 		$lastInsertId = $this->pdo->lastInsertId();
	 		
	 		$race = new Race();
	 		$race->setNom("NC");
	 		$race->setIdEspece(intval($lastInsertId));
	 		
	 		if ($this->insererRace($race)) {
		 		$this->pdo->commit();
		 		return $lastInsertId;
	 		} else {
	 			$this->pdo->rollBack();
	 			return null;
	 		}
	 		
	 	} catch(Exception $e) {
	 		$this->pdo->rollBack();
	 		return null;
	 	}
	 }
	 
	 /**
	  * Ajouter une race
	  *
	  * @param Espece $race
	  * @return Ambigous <boolean, string>
	  */
	 public function insererRace(Race $race)
	 {
	 	$req = $this->pdo->prepare('INSERT INTO race (idEspece, nom) VALUES ( ?, ? )');
	 	 
	 	try {
	 		$req->execute(array($race->getIdEspece(), $race->getNom()));
	 		return $this->pdo->lastInsertId();
	 	} catch(Exception $e) {
	 		return null;
	 	}
	 }
	 
	 
	 /**
	  * Ajouter une intervention
	  *
	  * @param Intervention $intervention
	  * @return Ambigous <boolean, string>
	  */
	 public function insererIntervention(Intervention $intervention)
	 {
	 	$req = $this->pdo->prepare('INSERT INTO intervention (idVeterinaire, idAnimal, date, tarif, nature, compte_rendu)
	 			VALUES ( ?, ?, ?, ?, ?, ? )');
	 	 
	 	$result = $req->execute(array(
	 			$intervention->getIdVeterinaire(),
	 			$intervention->getIdAnimal(),
	 			$intervention->getDate(),
	 			$intervention->getTarif(),
	 			$intervention->getNature(),
	 			$intervention->getCompteRendu()
	 	));
	 	 
	 	return $result ? $this->pdo->lastInsertId() : null;
	 }
	 
	 /**
	  * Insérer un proprietaire
	  *
	  * @param Proprietaire $proprietaire
	  * @return boolean
	  */
	 public function insererProprietaire(Proprietaire $proprietaire)
	 {
	 	
	 	$reqU = $this->pdo->prepare('INSERT INTO utilisateur (nom, prenom, mail, tel, password, civilite, idRole)
	 			VALUES ( ?, ?, ?, ?, ?, ?, ? )');
  
	 	$reqP = $this->pdo->prepare('INSERT INTO proprietaire (ville, adresse, cp, idUtilisateur)
	 			VALUES ( ?, ?, ?, ?)');
	 	
	 	$user = $proprietaire->getUtilisateur();
	 	$user->setIdRole(3); // forcer le role
	 	
	 	try {
	 		$this->pdo->beginTransaction();
	 		
	 		$reqU->execute(array(
	 				$user->getNom(),
	 				$user->getPrenom(),
	 				$user->getMail(),
	 				$user->getTel(),
	 				$user->getPassword(),
	 				$user->getCivilite(),
	 				$user->getIdRole()
	 		));
	 		
	 		$idUtlisateur = $this->pdo->lastInsertId();
	 		$proprietaire->setIdUtilisateur(intval($idUtlisateur));
	 		
	 		$reqP->execute(array(
	 				$proprietaire->getVille(),
	 				$proprietaire->getAdresse(),
	 				$proprietaire->getCp(),
	 				$proprietaire->getIdUtilisateur()
	 		));
	 		
	 		$this->pdo->commit();
	 		return $idUtlisateur;
	 	
	 	} catch (Exception $e) {
	 		$this->pdo->rollBack();
	 		return false;
	 	}
	 }
	 
	 /**
	  * Insérer un veterinaire
	  *
	  * @param Veterinaire $veterinaire
	  * @return boolean
	  */
	 public function insererVeterinaire(Veterinaire $veterinaire)
	 {
	 	 
	 	$reqU = $this->pdo->prepare('INSERT INTO utilisateur (nom, prenom, mail, tel, password, civilite, idRole)
	 			VALUES ( ?, ?, ?, ?, ?, ?, ? )');
	 
	 	$reqV = $this->pdo->prepare('INSERT INTO veterinaire (idUtilisateur, code_praticien, date_arrivee)
	 			VALUES ( ?, ?, ? )');
	 	 
	 	$user = $veterinaire->getUtilisateur();
	 	$user->setIdRole(2); // forcer le role
	 	 
	 	try {
	 		$this->pdo->beginTransaction();
	 
	 		$reqU->execute(array(
	 				$user->getNom(),
	 				$user->getPrenom(),
	 				$user->getMail(),
	 				$user->getTel(),
	 				$user->getPassword(),
	 				$user->getCivilite(),
	 				$user->getIdRole()
	 		));
	 
	 		$idUtlisateur = $this->pdo->lastInsertId();
	 		$veterinaire->setIdUtilisateur(intval($idUtlisateur));
	 		
	 		$reqV->execute(array(
	 				$veterinaire->getIdUtilisateur(),
	 				$veterinaire->getCodePraticien(),
	 				$veterinaire->getDateArrivee()
	 		));
	 
	 		$this->pdo->commit();
	 		return $idUtlisateur;
	 		 
	 	} catch (Exception $e) {
	 		$this->pdo->rollBack();
	 		return false;
	 	}
	 }
	 
	 /**
	  * Récuperer toutes les informations du proprietaire
	  *
	  * @return array
	  */
	 public function getInformationsProprietaire(Utilisateur &$user)
	 {
	 	//la requete
	 	$req = $this->pdo->prepare('SELECT
	 			U.id AS idU, U.idRole, U.civilite, U.mail, U.nom, U.prenom, U.tel, U.password,
	 			P.id AS idP, P.adresse, P.ville, P.cp
    			FROM utilisateur U
	 			JOIN proprietaire P ON P.idUtilisateur = U.id
	 			WHERE U.id = ?');
	 	
	 	$req->execute(array($user->getId())); // execution de la requete
	 	$tabUsers = $req->fetchAll(); // l'extraction des résultats dans un tableau
	 	
	 	$proprietaire = new Proprietaire();
	 	$proprietaire->setUtilisateur($user);
	 	
	 	// Il ne doit exister qu'un seul utilisateur
	 	if (count($tabUsers) == 1) {
	 		$this->peuplerUtilisateur($user, $tabUsers[0]);
	 		$this->peuplerProprietaire($proprietaire, $tabUsers[0]);
	 	}

	 	return $proprietaire;
	 }
	 
	 
	 /**
	  * Récuperer toutes les informations du proprietaire
	  *
	  * @return array
	  */
	 public function getProprietaire(Proprietaire &$proprietaire)
	 {
	 	//la requete
	 	$req = $this->pdo->prepare('SELECT
	 			U.id AS idU, U.idRole, U.civilite, U.mail, U.nom, U.prenom, U.tel, U.password,
	 			P.id AS idP, P.adresse, P.ville, P.cp
    			FROM utilisateur U
	 			JOIN proprietaire P ON P.idUtilisateur = U.id
	 			WHERE P.id = ?');
	 	 
	 	$req->execute(array($proprietaire->getId())); // execution de la requete
	 	$tabUsers = $req->fetchAll(); // l'extraction des résultats dans un tableau
	 	 
	 	$user = new Utilisateur();
	 	$proprietaire->setUtilisateur($user);
	 	 
	 	// Il ne doit exister qu'un seul utilisateur
	 	if (count($tabUsers) == 1) {
	 		$this->peuplerUtilisateur($user, $tabUsers[0]);
	 		$this->peuplerProprietaire($proprietaire, $tabUsers[0]);
	 	}
	 
	 	return $proprietaire;
	 }
	 
	 
	 /**
	  * Récuperer toutes les informations du veterinaire
	  *
	  * @return array
	  */
	 public function getInformationsVeterinaire(Utilisateur &$user)
	 {
	 	//la requete
	 	$req = $this->pdo->prepare('SELECT
	 			U.id AS idU, U.idRole, U.civilite, U.mail, U.nom, U.prenom, U.tel, U.password,
	 			V.id AS idV, V.date_arrivee, V.code_praticien
    			FROM utilisateur U
	 			JOIN veterinaire V ON V.idUtilisateur = U.id
	 			WHERE U.id = ?');
	 	 
	 	$req->execute(array($user->getId())); // execution de la requete
	 	$tabUsers = $req->fetchAll(); // l'extraction des résultats dans un tableau
	 	 
	 	$veterinaire = new Veterinaire();
	 	$veterinaire->setUtilisateur($user);
	 	 
	 	// Il ne doit exister qu'un seul utilisateur
	 	if (count($tabUsers) == 1) {
	 		$this->peuplerUtilisateur($user, $tabUsers[0]);
	 		$this->peuplerVeterinaire($veterinaire, $tabUsers[0]);
	 	}
	 
	 	return $veterinaire;
	 }
	 
	 /**
	  * Récuperer toutes les informations de l'administrateur
	  *
	  * @return array
	  */
	 public function getInformationsAdmin(Utilisateur &$user)
	 {
	 	//la requete
	 	$req = $this->pdo->prepare('SELECT
	 			U.id AS idU, U.idRole, U.civilite, U.mail, U.nom, U.prenom, U.tel, U.password
	 			FROM utilisateur U
	 			WHERE id = ?');
	 
	 	$req->execute(array($user->getId())); // execution de la requete
	 	$tabUsers = $req->fetchAll(); // l'extraction des résultats dans un tableau
	 
	 	// Il ne doit exister qu'un seul admin
	 	if (count($tabUsers) == 1) {
	 		$this->peuplerUtilisateur($user, $tabUsers[0]);
	 	}
	 
	 	return $user;
	 }
	 

	 /**
	  * Peupler un utilisateur à partir d'un tableau issu de la bae de données
	  *
	  * @param Utilisateur $user
	  * @param unknown $array
	  */
	 private function peuplerUtilisateur(Utilisateur &$user, $array)
	 {
	 	$user->setId(intval($array['idU']));
	 	$user->setIdRole(intval($array['idRole']));
	 	$user->setCivilite(intval($array['civilite']));
	 	$user->setMail($array['mail']);
	 	$user->setNom($array['nom']);
	 	$user->setPrenom($array['prenom']);
	 	$user->setTel($array['tel']);
	 	$user->setPassword($array['password'], false); // pas de conversion sha1
	 }
	 
	 /**
	  * Peupler un proprietaire à partir d'un tableau issu de la bae de données
	  *
	  * @param Proprietaire $proprietaire
	  * @param unknown $array
	  */
	 private function peuplerProprietaire(Proprietaire &$proprietaire, $array)
	 {
	 	$proprietaire->setId(intval($array['idP']));
 		$proprietaire->setIdUtilisateur(intval($array['idU']));
 		$proprietaire->setAdresse($array['adresse']);
 		$proprietaire->setVille($array['ville']);
 		$proprietaire->setCp($array['cp']);
	 }
	 
	 /**
	  * Peupler un veterinaire à partir d'un tableau issu de la bae de données
	  *
	  * @param Veterinaire $veterinqire
	  * @param unknown $array
	  */
	 private function peuplerVeterinaire(Veterinaire &$veterinaire, $array)
	 {
	 	$veterinaire->setId(intval($array['idV']));
 		$veterinaire->setIdUtilisateur(intval($array['idU']));
 		$veterinaire->setDateArrivee($array['date_arrivee']);
 		$veterinaire->setCodePraticien($array['code_praticien']);
	 }
	 
	 /**
	  * Récuperer les informations d'un animal
	  *
	  * @return array
	  */
	 public function getInformationsAnimal(Animal &$animal)
	 {
	 	
	 	$sql = 'SELECT A.id, A.idProprietaire, A.idRace, A.nom, A.puce, A.date_naissance, A.signe_distinctif, A.commentaire, 
	 			R.nom AS nomRace, R.idEspece, E.nom AS nomEspece
	 			FROM animal A
	 			JOIN race R ON R.id = A.idRace
	 			JOIN espece E ON E.id = R.idEspece
	 			WHERE A.id = ?';
	 	$execute = array($animal->getId());
	 	
	 	if ($animal->getIdProprietaire()) {
	 		$sql .= ' && A.idProprietaire = ?';
	 		$execute[] =  $animal->getIdProprietaire();
	 	}

	 	$req = $this->pdo->prepare($sql); // la requete
	 	$req->execute($execute); // Exécution de la reqête paramétrée
	 	$tab = $req->fetchAll(); // l'extraction des résultats dans un tableau
	 	 
	 	// Il ne doit exister qu'un seul animal
	 	if (count($tab) == 1) {
	 		$this->peuplerAnimal($animal, $tab[0]);
	 	} else {
	 		$animal = null;
	 	}
	 
	 	return $animal;
	 }
	 

	 /**
	  * Mise à jour des informations d'une espece
	  *
	  * @param Espece $espece
	  * @return number
	  */
	 public function updateEspece(Espece $espece)
	 {
	 	try {
		 	$req = $this->pdo->prepare('UPDATE espece SET nom = ? WHERE id = ?');
		 	$req->execute(array($espece->getNom(), $espece->getId()));
		 	return  NO_ERROR;
		 	
	 	} catch (Exception $e) {
	 		return ERROR_EXISTS;
		 }
	 }
	 
	 /**
	  * Mise à jour des informations d'une race
	  *
	  * @param Race $race
	  * @return number
	  */
	 public function updateRace(Race $race)
	 {
	 	
	 	try {
	 		$req = $this->pdo->prepare('UPDATE race SET nom = ? WHERE id = ?');
		 	$req->execute(array($race->getNom(), $race->getId()));
		 	return  NO_ERROR;
		 	
	 	} catch (Exception $e) {
	 		return ERROR_EXISTS;
	 	}
	 }
	 
	 
	 /**
	  * Mise à jour des informations de l'utiisateur
	  * 
	  * @param Utilisateur $animal
	  * @return number
	  */
	 public function updateUtilisateur(Utilisateur $user)
	 {
	 	// la requete
	 	$req = $this->pdo->prepare('UPDATE utilisateur SET
	 			nom = ?, prenom = ?, mail = ?, tel = ?, password = ?, civilite = ?, idRole = ?
	 			WHERE id = ?');
	 	
	 	// execution de la requete
	 	$req->execute(array(
	 			$user->getNom(),
	 			$user->getPrenom(),
	 			$user->getMail(),
	 			$user->getTel(),
	 			$user->getPassword(),
	 			$user->getCivilite(),
	 			$user->getIdRole(),
	 			$user->getId()
	 	));
	 	
	 	return $req->rowCount(); // retourne le nombre de lignes affectées
	 }
	 
	 /**
	  * Mise à jour des informations de l'animal
	  *
	  * @param Animal $animal
	  * @return number
	  */
	 public function updateAnimal(Animal $animal)
	 {
	 	// la requete
	 	$req = $this->pdo->prepare('UPDATE animal SET
	 			nom = ?, idRace = ?, puce = ?, date_naissance = ?, signe_distinctif = ?, commentaire = ?
	 			WHERE id = ?');
	 	 
	 	// execution de la requete
	 	$req->execute(array(
	 			$animal->getNom(),
	 			$animal->getIdRace(),
	 			$animal->getPuce(),
	 			$animal->getDateNaissance(),
	 			$animal->getSigneDistinctif(),
	 			$animal->getCommentaire(),
	 			$animal->getId()
	 	));
	 	 
	 	return $req->rowCount(); // retourne le nombre de lignes affectées
	 }
	 
	 /**
	  * Mise à jour des informations d'uneintervention
	  *
	  * @param Intervention $intervention
	  * @return number
	  */
	 public function updateIntervention(Intervention $intervention)
	 {
	 	// la requete
	 	$req = $this->pdo->prepare('UPDATE intervention SET nature = ?, tarif = ?, compte_rendu = ? WHERE id = ?');
	 
	 	// execution de la requete
	 	$req->execute(array(
	 			$intervention->getNature(),
	 			$intervention->getTarif(),
	 			$intervention->getCompteRendu(),
	 			$intervention->getId()
	 	));
	 
	 	return $req->rowCount(); // retourne le nombre de lignes affectées
	 }
	 
	/**
	 * Mise à jour des informations du propriétaire ( et utilisateur )
	 * 
	 * @param Proprietaire $proprietaire
	 * @return boolean
	 */
	 public function updateProprietaire(Proprietaire $proprietaire)
	 {
	 	// // la requete
	 	$req = $this->pdo->prepare('UPDATE proprietaire SET
	 			ville = ?, adresse = ?, cp = ?, idUtilisateur = ?
	 			WHERE id = ?');
	 	
	 	$rowCount = 0;

	 	try {
	 		$this->pdo->beginTransaction();
	 		$rowCount += $this->updateUtilisateur($proprietaire->getUtilisateur()); // maj utiliateur
	 		
	 		// execution de la requete
	 		$req->execute(array(
	 				$proprietaire->getVille(),
	 				$proprietaire->getAdresse(),
	 				$proprietaire->getCp(),
	 				$proprietaire->getIdUtilisateur(),
	 				$proprietaire->getId()
	 		));
	 		
	 		$rowCount += $req->rowCount();
 			$this->pdo->commit();
 			 
 		} catch (Exception $e) {
 			$rowCount = 0;
 			$this->pdo->rollBack();
	 	}

	 	return $rowCount; // retourne le cumul du nombre de lignes affectées
	 }
	 
	 /**
	  * Mise à jour des informations du veterinaire ( et utilisateur )
	  *
	  * @param Veterinaire $veterinaire
	  * @return boolean
	  */
	 public function updateVeterinaire(Veterinaire $veterinaire)
	 {
	 	// // la requete
	 	$req = $this->pdo->prepare('UPDATE veterinaire SET
	 			date_arrivee = ?, code_praticien = ?, idUtilisateur = ? 
	 			WHERE id = ?');

	 	$rowCount = 0;
	 
	 	try {
	 		$this->pdo->beginTransaction();
	 		$rowCount += $this->updateUtilisateur($veterinaire->getUtilisateur()); // maj utiliateur

	 		// execution de la requete
	 		$req->execute(array(
	 				$veterinaire->getDateArrivee(),
	 				$veterinaire->getCodePraticien(),
	 				$veterinaire->getIdUtilisateur(),
	 				$veterinaire->getId()
	 		));
	 		
	 		$rowCount += $req->rowCount();
	 		$this->pdo->commit();
	 			
	 	} catch (Exception $e) {
	 		$rowCount = 0;
	 		$this->pdo->rollBack();
	 	}
	 
	 	return $rowCount; // retourne le cumul du nombre de lignes affectées
	 }
	 
	 /**
	  * Lister les proprietaires selon des critères de recherche
	  *
	  * @return array
	  */
	 public function getProprietaires($param)
	 {
	 	//la requete
	 	$req = $this->pdo->prepare('SELECT
	 			U.id AS idU, U.idRole, U.civilite, U.mail, U.nom, U.prenom, U.tel, U.password,
	 			P.id AS idP, P.adresse, P.ville, P.cp
    			FROM utilisateur U
	 			JOIN proprietaire P ON P.idUtilisateur = U.id
	 			WHERE LOWER(U.nom) LIKE ? OR LOWER(U.mail) LIKE ? OR LOWER(U.tel) LIKE ?
	 			ORDER BY U.nom');
	 	
	 	$param = '%' . strtolower(trim($param)) .'%';
	 	$req->execute(array($param, $param, $param)); // execution de la requete
	 	$tabUsers = $req->fetchAll(); // l'extraction des résultats dans un tableau
	 	$tabProprietaires = array();
	 	
 		foreach ($tabUsers as $row) {
 			
	 		$user = new Utilisateur();
	 		$proprietaire = new Proprietaire();
	 		$proprietaire->setUtilisateur($user);

	 		$this->peuplerUtilisateur($user, $row);
	 		$this->peuplerProprietaire($proprietaire, $row);
		 	
		 	$tabProprietaires[] = $proprietaire;
 		}

	 	return $tabProprietaires;
	 }
	 
	 /**
	  * Lister les veterinaires selon des critères de recherche
	  *
	  * @return array
	  */
	 public function getVeterinaires($param)
	 {
	 	//la requete
	 	$req = $this->pdo->prepare('SELECT
	 			U.id AS idU, U.idRole, U.civilite, U.mail, U.nom, U.prenom, U.tel, U.password,
	 			V.id AS idV, V.date_arrivee, V.code_praticien
    			FROM utilisateur U
	 			JOIN veterinaire V ON V.idUtilisateur = U.id
	 			WHERE LOWER(U.nom) LIKE ? OR LOWER(U.mail) LIKE ? OR LOWER(U.tel) LIKE ?
	 			ORDER BY U.nom');
	 	 
	 	$param = '%' . strtolower(trim($param)) .'%';
	 	$req->execute(array($param, $param, $param)); // execution de la requete
	 	$tabUsers = $req->fetchAll(); // l'extraction des résultats dans un tableau
	 	$tabVeterinaires = array();
	 	 
	 	foreach ($tabUsers as $row) {
	 
	 		$user = new Utilisateur();
	 		$veterinaire = new Veterinaire();
	 		$veterinaire->setUtilisateur($user);
	 
	 		$this->peuplerUtilisateur($user, $row);
	 		$this->peuplerVeterinaire($veterinaire, $row);
	 
	 		$tabVeterinaires[] = $veterinaire;
	 	}
	 
	 	return $tabVeterinaires;
	 }
	 
	 /**
	  * Lister les interventions selon des critères de recherche
	  * 
	  * @param unknown $param
	  * @return multitype:Proprietaire
	  */
	 public function getInterventions($param)
	 {
	 	//la requete
	 	$req = $this->pdo->prepare('SELECT
	 			I.id, I.idVeterinaire, I.idAnimal, I.date, I.nature, I.tarif, I.compte_rendu,
	 			U.civilite, U.nom, U.prenom,
	 			A.nom AS nomAnimal
    			FROM intervention I
	 			JOIN veterinaire V ON I.idVeterinaire = V.id
	 			JOIN utilisateur U ON V.idUtilisateur = U.id
	 			JOIN animal A ON I.idAnimal = A.id
	 			WHERE LOWER(U.nom) LIKE ? OR LOWER(A.nom) LIKE ? OR LOWER(A.puce) LIKE ?
	 			ORDER BY I.date DESC');
	 	 
	 	$param = '%' . strtolower(trim($param)) .'%';
	 	$req->execute(array($param, $param, $param)); // execution de la requete
	 	$tabUsers = $req->fetchAll(); // l'extraction des résultats dans un tableau
	 	$tabInterventions = array();
	 	
	 	foreach ($tabUsers as $row) {
	 		
	 		$intervention = new Intervention();
	 		$animal = new Animal();
	 		$animal->setNom($row['nomAnimal']);
	 		$animal->setId($row['idAnimal']);
	 		$intervention->setAnimal($animal);
	 		$this->peuplerIntervention($intervention, $row);
	 		$tabInterventions[] = $intervention;
	 	}
	 	return $tabInterventions;
	 }
	 
	 /**
	  * Lister les interventions du vétérinaire
	  * 
	  * @param Veterinaire $veterinaire
	  * @return multitype:Intervention
	  */
	 public function listInterventions(Veterinaire $veterinaire)
	 {
	 	//la requete
	 	$req = $this->pdo->prepare('SELECT
	 			I.id, I.idVeterinaire, I.idAnimal, I.date, I.nature, I.tarif, I.compte_rendu,
	 			U.civilite, U.nom, U.prenom,
	 			A.nom AS nomAnimal
    			FROM intervention I
	 			JOIN veterinaire V ON I.idVeterinaire = V.id
	 			JOIN utilisateur U ON V.idUtilisateur = U.id
	 			JOIN animal A ON I.idAnimal = A.id
	 			WHERE I.idVeterinaire = ?
	 			ORDER BY I.date DESC');
	 
	 	$req->execute(array($veterinaire->getId())); // execution de la requete
	 	$tabUsers = $req->fetchAll(); // l'extraction des résultats dans un tableau
	 	$tabInterventions = array();
	 	
	 	foreach ($tabUsers as $row) {
	 
	 		$intervention = new Intervention();
	 		$animal = new Animal();
	 		$animal->setNom($row['nomAnimal']);
	 		$animal->setId($row['idAnimal']);
	 		$intervention->setAnimal($animal);
	 		$this->peuplerIntervention($intervention, $row);
	 		$tabInterventions[] = $intervention;
	 	}

	 	return $tabInterventions;
	 }
	
}
	
?>