<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

	<HEAD>
		<meta http-equiv="X-UA-Compatible" content="IE=8" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</HEAD>
	<BODY>
<?php


echo "test";

	//Version du 22 fevrier 2013
	//Fonction créer tableau JavaScript à partir d'une requete SQL
	
	//Définition des constantes
	define("SQLServerName","datamjpmps.mysql.db");
	define("sqldbname","datamjpmps");
	define("sqllogin","datamjpmps");
	define("sqlpass","Marwane06");

	function ConvertMySQLRequestToJavascriptArray($Resultat,$NomTableauJavaScript,$CreerBalisesJavaScript)
	{
		//Version du 22 fevrier 2013
		//Fonction créer un tableau JavaScript à partir d'un jeu d'enregistrement SQL passé en paramètres.
		//La connexion à la base de données et la requête SQL a donc déjà été envoyée au préalable à la base de données.

		//Récupération d'informations sur les champs
		//http://php.net/manual/en/function.mysql-fetch-field.php
		$CompteurChamp = 0;

		if ($CreerBalisesJavaScript == 1){
			echo "<SCRIPT TYPE=\"text/javascript\">\n";
		}

		echo "//Création du tableau JavaScript\n";
		echo $NomTableauJavaScript."=new Array();\n";
		echo "\n";
		
		//Création du tableau PHP qui va contenir les noms des champs de la requêtes SQL
		while ($CompteurChamp < mysql_num_fields($Resultat)) {
			$meta = mysql_fetch_field($Resultat, $CompteurChamp);
			if (!$meta) {
				//echo "No information available<br />\n";
			}
			//echo "$meta->name<br />";
			$ChampsDeLaRequeteSQL[$CompteurChamp] = $meta->name;
			$CompteurChamp++;
		}

		//Création des différents champs dans le tableau en JavaScript
		echo "//Création des différents champs du tableau JavaScript\n";
		$count = count($ChampsDeLaRequeteSQL);
		for ($CompteurChampsDeLaRequete = 0; $CompteurChampsDeLaRequete < $count; $CompteurChampsDeLaRequete++) {
			//echo $ChampsDeLaRequeteSQL[$CompteurChampsDeLaRequete]."\n";
			echo $NomTableauJavaScript."['".$ChampsDeLaRequeteSQL[$CompteurChampsDeLaRequete]."']=new Array();\n";
		}
		echo "\n";

		mysql_data_seek($Resultat, 0); //On revient au début de l'enregistrement
		$CompteurResultats = 1; //Initialisation
		echo "//Copie des valeurs dans les différents champs du tableau JavaScript\n";
		while ($MaLigne=mysql_fetch_array($Resultat, MYSQL_ASSOC)){
			for ($CompteurChampsDeLaRequete = 0; $CompteurChampsDeLaRequete < $count; $CompteurChampsDeLaRequete++) {
				$onevalue = $MaLigne[$ChampsDeLaRequeteSQL[$CompteurChampsDeLaRequete]];
				if (mb_detect_encoding($onevalue, 'UTF-8', true) === false) {$onevalue = utf8_encode($onevalue);}
				echo $NomTableauJavaScript."['".$ChampsDeLaRequeteSQL[$CompteurChampsDeLaRequete]."'][".$CompteurResultats."] = \"".$onevalue."\";\n";
			}
			$CompteurResultats++;
		}

		if ($CreerBalisesJavaScript == 1){
			echo "</SCRIPT>\n";
		}		

		/* Types de méta possibles :
		blob:         $meta->blob
		max_length:   $meta->max_length
		multiple_key: $meta->multiple_key
		name:         $meta->name
		not_null:     $meta->not_null
		numeric:      $meta->numeric
		primary_key:  $meta->primary_key
		table:        $meta->table
		type:         $meta->type
		unique_key:   $meta->unique_key
		unsigned:     $meta->unsigned
		zerofill:     $meta->zerofill
		*/
	}
		
	$MaConnection = mysql_connect(constant('SQLServerName'),constant('sqllogin'),constant('sqlpass')); //Création de la connexion à la base de données
	if ($MaConnection) {
		mysql_select_db(constant('sqldbname'), $MaConnection); //Sélection de la base
		mysql_query("SET NAMES UTF8"); //On utilise le codage UTF8

		$sqlrequest = "SELECT * FROM produits order by produit";
		if (strlen($sqlrequest) > 0){
			$Resultat = mysql_query($sqlrequest, $MaConnection); //Passage d'une requête à la base de données
			$num_rows = mysql_num_rows($Resultat); //Récupération du nombre de lignes en réponse
			if ($num_rows > 0){ //Si on a des lignes en réponse
				ConvertMySQLRequestToJavascriptArray($Resultat,"TabSQL2JavaScript",1); //Appel de la fonction
			}
		}
		mysql_free_result($Resultat);
		mysql_close($MaConnection);
	}
	else{
		die('Connexion impossible : ' . mysql_error());
	}

?>
	</BODY>
</HTML>