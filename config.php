<?php

define("DB_DRIVER", 'mysql');
define("DB_HOST", 'localhost');
define("DB_NAME", 'anima_protect');
define("DB_USER", 'root');
define("DB_PASS", '');


define("HOMME", 1);
define("FEMME", 2);
define("DOCTEUR", 3);


define("ADMIN", 1);
define("VETERINAIRE", 2);
define("PROPRIETAIRE", 3);


define("AJOUTER", 'ajouter');
define("MODIFIER", 'modifier');
define("SUPPRIMER", 'supprimer');
define("EDITER", 'editer');
define("INSCRIPTION", 'inscription');
define("RECHERCHER", 'search');
define("FORBIDDEN", 'forbidden');


define("SESSION_PROPRIETAIRE", 'proprietaire');
define("SESSION_VETERINAIRE", 'veterinaire');
define("SESSION_ADMIN", 'administrateur');
define("SESSION_UTILISATEUR", 'utilisateur');
define("SESSION_ERROR", 'session_error');


define("ESPECE", 'espece');


define("NO_ERROR", -1); // pas d'erreur
define("ERROR_MISSING", 0); // code error manquant ou null
define("ERROR_SIZE", 1); // code error longueur non valide
define("ERROR_REGEX", 2); // code error syntaxe non valide
define("ERROR_INTERVAL", 3); // code error interval non valide
define("ERROR_EXISTS", 4); // code error donnee deja existante
define("ERROR_TYPE", 5); // code error type de donnée erronée
define("ERROR_DATE", 6); // code error date erronée
define("ERROR_EXTENSION", 7); // code error extension de fichier erronée
define("ERROR_UPLOAD", 8); // code error upload


?>