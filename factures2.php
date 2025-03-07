<?php

		//path to the bookings application folders (used for email validation system)
	$app_path = "http://www.data2mjp.com";
	
	// Database Settings
	
	// Name or IP adress of the mysql server (default : "localhost" if both database and web server are installed on the same machine)
	$db_server_address = "mysql5-1.business";
	
	// Name of the MySQL database or ODBC source (default : "openbookings")
	$database_name = "datamjpmps-n";
	
	// Store once your database connection credentials here
	$db_user = "datamjpmps";
	$db_password = "Marwane06";
	
	// Choose your connection mode ("mysql" or "odbc")
	$db_connection_type = "mysql"; // "odbc";

	// Use this setting to correct timezone troubles (ie your server is not in you country)
	// time offset = (Server timezone - User timezone) * 3600
	// You live in Paris (GMT+1) and the server is in Moscow (GMT+3)
	// time offset = (3 - 1) * 3600
	// default is 0 if your server is local
	$time_offset = 0; // seconds
	
	
	
	require "connect_db.php";
	require "functions.php";
$valeur=3600;
set_time_limit($valeur);
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];
	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"])) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$date =dateFrToUs($_REQUEST["date"]);
			$client = $_REQUEST["client"];$montant=$_REQUEST["montant"];$numero_f=$_REQUEST["user_id"]+9040;
			$ev1 = $_REQUEST["ev1"];$ev2 = $_REQUEST["ev2"];$ev3 = $_REQUEST["ev3"];$ev4 = $_REQUEST["ev4"];$ev5 = $_REQUEST["ev5"];
			$ev6 = $_REQUEST["ev6"];$ev9 = $_REQUEST["ev9"];$ev7 = $_REQUEST["ev7"];$ev8 = $_REQUEST["ev8"];$ev10 = $_REQUEST["ev10"];
			$ev1_07 = $_REQUEST["ev1_07"];$ev2_07 = $_REQUEST["ev2_07"];$ev3_07 = $_REQUEST["ev3_07"];$ev4_07 = $_REQUEST["ev4_07"];
			$ev5_07 = $_REQUEST["ev5_07"];
			$ev6_07 = $_REQUEST["ev6_07"];$ev9_07 = $_REQUEST["ev9_07"];$ev7_07 = $_REQUEST["ev7_07"];$ev8_07 = $_REQUEST["ev8_07"];
			$ev10_07 = $_REQUEST["ev10_07"];
				if ($_REQUEST["action_"]=="insert_new_user"){

		$sql  = "SELECT * ";
		$sql .= "FROM clients WHERE client = '$client' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$remise10 = $user_["remise10"];
		$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];$vendeur=$user_["vendeur_nom"];}
			
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
		if ($_REQUEST["action_"]=="update_user"){
		$remise10=$_REQUEST["remise10"];$remise2=$_REQUEST["remise2"];$remise3=$_REQUEST["remise3"];
				$sql  = "SELECT * ";
		$sql .= "FROM clients WHERE client = '$client' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$vendeur = $user_["vendeur_nom"];

		
		}
		
		}
		
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
		
				/*for ($i=1;$i<=5000;$i++){
				$sql  = "INSERT INTO factures 
				( date_f, valide,client, vendeur,remise_10,remise_2,remise_3,montant,ev1,ev2,ev3,ev4,ev5,ev6,ev7,ev8,ev9,ev10,ev1_07
				,ev2_07,ev3_07,ev4_07,ev5_07,ev6_07,ev7_07,ev8_07,ev9_07,ev10_07 ) VALUES ( ";
				$sql .= "'" . $date . "', ";$valide=1;
				$sql .= "'" . $valide . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $remise10 . "', ";
				$sql .= "'" . $remise2 . "', ";
				$sql .= "'" . $remise3 . "', ";
				$sql .= "'" . $montant . "', ";
				$sql .= "'" . $ev1 . "', ";
				$sql .= "'" . $ev2 . "', ";
				$sql .= "'" . $ev3 . "', ";
				$sql .= "'" . $ev4 . "', ";
				$sql .= "'" . $ev5 . "', ";
				$sql .= "'" . $ev6 . "', ";
				$sql .= "'" . $ev7 . "', ";
				$sql .= "'" . $ev8 . "', ";
				$sql .= "'" . $ev9 . "', ";
				$sql .= "'" . $ev10 . "', ";
				$sql .= "'" . $ev1_07 . "', ";
				$sql .= "'" . $ev2_07 . "', ";
				$sql .= "'" . $ev3_07 . "', ";
				$sql .= "'" . $ev4_07 . "', ";
				$sql .= "'" . $ev5_07 . "', ";
				$sql .= "'" . $ev6_07 . "', ";
				$sql .= "'" . $ev7_07 . "', ";
				$sql .= "'" . $ev8_07 . "', ";
				$sql .= "'" . $ev9_07 . "', ";
				$sql .= "'" . $ev10_07 . "');";
				db_query($database_name, $sql);$numero_f=mysql_insert_id()+9040;$numero_id=mysql_insert_id();

///////regrouper evaluations
			$sql = "UPDATE factures SET ";$valider_f=1;$v=1;
			$sql .= "numero = '" . $numero_f . "', ";
			$sql .= "valide = '" . $v . "' ";
			$sql .= "WHERE id = " . $numero_id . ";";
			db_query($database_name, $sql);}*/
			

			if ($ev1<>""){
			$sql = "UPDATE commandes SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev1'" . ";";
			db_query($database_name, $sql);
		$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation='$ev1' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];$date_e=$users_["date_e"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];
		if ($date_e>="2008-06-01"){$condit=$users_["condit"];}else
		{$sql  = "SELECT * ";
		$sql .= "FROM produits where produit='$produit' ORDER BY produit;";
		$users = db_query($database_name, $sql);$condit=$users_["condit"];}
	
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";
		$sql .= "'" . $date . "', ";
		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
		 }
			}
			if ($ev2<>""){
			$sql = "UPDATE commandes SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev2'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation='$ev2' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev3<>""){
			$sql = "UPDATE commandes SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev3'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation='$ev3' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev4<>""){
			$sql = "UPDATE commandes SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev4'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation='$ev4' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev5<>""){
			$sql = "UPDATE commandes SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev5'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation='$ev5' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev6<>""){
			$sql = "UPDATE commandes SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev6'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation='$ev6' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev7<>""){
			$sql = "UPDATE commandes SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev7'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation='$ev7' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev8<>""){
			$sql = "UPDATE commandes SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev8'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation='$ev8' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev9<>""){
			$sql = "UPDATE commandes SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev9'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation='$ev9' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev10<>""){
			$sql = "UPDATE commandes SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev10'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation='$ev10' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
/////
			if ($ev1_07<>""){
			$sql = "UPDATE commandes_07 SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev1_07'" . ";";
			db_query($database_name, $sql);
		$sql  = "SELECT * ";
	$sql .= "FROM commandes_07 where client='$client' and evaluation='$ev1_07' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_07 where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
		 }
			}
			if ($ev2_07<>""){
			$sql = "UPDATE commandes_07 SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev2_07'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation='$ev2_07' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_07 where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev3_07<>""){
			$sql = "UPDATE commandes_07 SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev3_07'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes_07 where client='$client' and evaluation='$ev3_07' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_07 where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev4_07<>""){
			$sql = "UPDATE commandes_07 SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev4_07'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes_07 where client='$client' and evaluation='$ev4_07' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_07 where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev5_07<>""){
			$sql = "UPDATE commandes_07 SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev5_07'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes_07 where client='$client' and evaluation='$ev5_07' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_07 where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev6_07<>""){
			$sql = "UPDATE commandes_07 SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev6_07'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes_07 where client='$client' and evaluation='$ev6_07' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_07 where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev7_07<>""){
			$sql = "UPDATE commandes_07 SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev7_07'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes_07 where client='$client' and evaluation='$ev7_07' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_07 where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev8_07<>""){
			$sql = "UPDATE commandes_07 SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev8_07'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes_07 where client='$client' and evaluation='$ev8_07' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_07 where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev9_07<>""){
			$sql = "UPDATE commandes_07 SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev9_07'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes_07 where client='$client' and evaluation='$ev9_07' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_07 where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev10_07<>""){
			$sql = "UPDATE commandes_07 SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev10_07'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes_07 where client='$client' and evaluation='$ev10_07' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_07 where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}


////////

			break;
		$sql  = "SELECT * ";
		$sql .= "FROM clients WHERE client = '$client' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);
		$vendeur=$user_["vendeur_nom"];

			case "update_user":
			$sql = "UPDATE factures SET ";
			$sql .= "date_f = '" . $date . "', ";
			$sql .= "client = '" . $client . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			if ($ev1<>"" or $ev1_07<>""){$v=1;$sql .= "valide = '" . $v . "', ";}
			$sql .= "sans_remise = '" . $sans_remise . "', ";
			$sql .= "remise_10 = '" . $remise10 . "', ";
			$sql .= "remise_2 = '" . $remise2 . "', ";
			$sql .= "remise_3 = '" . $remise3 . "', ";
			$sql .= "montant = '" . $_REQUEST["montant"] . "', ";
			$sql .= "ev1 = '" . $ev1 . "', ";
			$sql .= "ev2 = '" . $ev2 . "', ";
			$sql .= "ev3 = '" . $ev3 . "', ";
			$sql .= "ev4 = '" . $ev4 . "', ";
			$sql .= "ev5 = '" . $ev5 . "', ";
			$sql .= "ev6 = '" . $ev6 . "', ";
			$sql .= "ev7 = '" . $ev7 . "', ";
			$sql .= "ev8 = '" . $ev8 . "', ";
			$sql .= "ev9 = '" . $ev9 . "', ";
			$sql .= "ev10 = '" . $ev10 . "', ";
			$sql .= "ev1_07 = '" . $ev1_07 . "', ";
			$sql .= "ev2_07 = '" . $ev2_07 . "', ";
			$sql .= "ev3_07 = '" . $ev3_07 . "', ";
			$sql .= "ev4_07 = '" . $ev4_07 . "', ";
			$sql .= "ev5_07 = '" . $ev5_07 . "', ";
			$sql .= "ev6_07 = '" . $ev6_07 . "', ";
			$sql .= "ev7_07 = '" . $ev7_07 . "', ";
			$sql .= "ev8_07 = '" . $ev8_07 . "', ";
			$sql .= "ev9_07 = '" . $ev9_07 . "', ";
			
			$sql .= "ev10_07 = '" . $ev10_07 . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
/// update evaluations

			$sql = "UPDATE commandes SET ";$valider_nf=0;$nf=0;
			$sql .= "facture = '" . $nf . "', ";
			$sql .= "valider_f = '" . $valider_nf . "' ";
			$sql .= "WHERE facture = '$numero_f' " . ";";
			db_query($database_name, $sql);
			$sql = "DELETE FROM detail_factures WHERE facture = " . $numero_f . ";";
			db_query($database_name, $sql);
			$null=0;
			
			if ($ev1<>""){
			$sql = "UPDATE commandes SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and facture='$null' and evaluation = '$ev1'" . ";";
			db_query($database_name, $sql);
		$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation='$ev1' and facture='$numero_f' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
		 }
			}
			if ($ev2<>""){
			$sql = "UPDATE commandes SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and facture='$null' and evaluation = '$ev2'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation='$ev2' and facture='$numero_f' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev3<>""){
			$sql = "UPDATE commandes SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and facture='$null' and evaluation = '$ev3'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation='$ev3' and facture='$numero_f' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev4<>""){
			$sql = "UPDATE commandes SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and facture='$null' and evaluation = '$ev4'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation='$ev4' and facture='$numero_f' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev5<>""){
			$sql = "UPDATE commandes SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and facture='$null' and evaluation = '$ev5'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation='$ev5' and facture='$numero_f' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev6<>""){
			$sql = "UPDATE commandes SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and facture='$null' and evaluation = '$ev6'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation='$ev6' and facture='$numero_f' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev7<>""){
			$sql = "UPDATE commandes SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and facture='$null' and evaluation = '$ev7'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation='$ev7' and facture='$numero_f' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev8<>""){
			$sql = "UPDATE commandes SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and facture='$null' and evaluation = '$ev8'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation='$ev8' and facture='$numero_f' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev9<>""){
			$sql = "UPDATE commandes SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and facture='$null' and evaluation = '$ev9'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation='$ev9' and facture='$numero_f' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev10<>""){
			$sql = "UPDATE commandes SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and facture='$null' and evaluation = '$ev10'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation='$ev10' and facture='$numero_f' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}

			if ($ev1_07<>""){
			$sql = "UPDATE commandes_07 SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev1_07'" . ";";
			db_query($database_name, $sql);
		$sql  = "SELECT * ";
	$sql .= "FROM commandes_07 where client='$client' and evaluation='$ev1_07' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_07 where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
		 }
			}
			if ($ev2_07<>""){
			$sql = "UPDATE commandes_07 SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev2_07'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes_07 where client='$client' and evaluation='$ev2_07' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_07 where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev3_07<>""){
			$sql = "UPDATE commandes_07 SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev3_07'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes_07 where client='$client' and evaluation='$ev3_07' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_07 where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev4_07<>""){
			$sql = "UPDATE commandes_07 SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev4_07'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes_07 where client='$client' and evaluation='$ev4_07' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_07 where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev5_07<>""){
			$sql = "UPDATE commandes_07 SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev5_07'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes_07 where client='$client' and evaluation='$ev5_07' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_07 where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev6_07<>""){
			$sql = "UPDATE commandes_07 SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev6_07'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes_07 where client='$client' and evaluation='$ev6_07' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_07 where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev7_07<>""){
			$sql = "UPDATE commandes_07 SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev7_07'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes_07 where client='$client' and evaluation='$ev7_07' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_07 where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev8_07<>""){
			$sql = "UPDATE commandes_07 SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev8_07'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes_07 where client='$client' and evaluation='$ev8_07' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_07 where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev9_07<>""){
			$sql = "UPDATE commandes_07 SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev9_07'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes_07 where client='$client' and evaluation='$ev9_07' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_07 where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			if ($ev10_07<>""){
			$sql = "UPDATE commandes_07 SET ";$valider_f=1;
			$sql .= "facture = '" . $numero_f . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE client='$client' and evaluation = '$ev10_07'" . ";";
			db_query($database_name, $sql);
				$sql  = "SELECT * ";
	$sql .= "FROM commandes_07 where client='$client' and evaluation='$ev10_07' ORDER BY evaluation;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$commande=$users_["commande"];
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_07 where commande='$commande' ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	while($users_ = fetch_array($users1)) { 
		$ref=$users_["produit"];$commande=$users_["commande"];$prix_unit=$users_["prix_unit"];$quantite=$users_["quantite"];
		$produit=$users_["produit"];$condit=$users_["condit"];
		$sql  = "INSERT INTO detail_factures ( commande,produit,prix_unit,quantite,condit,date_f,facture ) VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $produit . "', ";
		$sql .= "'" . $prix_unit . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $condit . "', ";		$sql .= "'" . $date . "', ";

		$sql .= $numero_f . ");";
		db_query($database_name, $sql);
	 }

			}
			
			break;
			
			case "delete_user":
			
			break;


		} //switch
	} //if
	
	$du="";$au="";$action="Recherche";
	$profiles_list_mois = "";$mois="";
	$sql1 = "SELECT * FROM mois_rak_08 ORDER BY id;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($mois == $temp_["mois"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_mois .= "<OPTION VALUE=\"" . $temp_["mois"] . "\"" . $selected . ">";
		$profiles_list_mois .= $temp_["mois"];
		$profiles_list_mois .= "</OPTION>";
	}
	
	
	?>
	
	<form id="form" name="form" method="post" action="factures.php">
	
	<td><?php echo "Du : "; ?><input type="text" id="du" name="du" value="<?php echo $du; ?>" size="15"></td>
	<td><?php echo "Au : "; ?><input type="text" id="au" name="au" value="<?php echo $au; ?>" size="15"></td>
	<tr>
	
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? $du = "2014-01-01";$au = "2014-12-31";
	if(isset($_REQUEST["action"]))
	{
	 $du=dateFrToUs($_POST['du']);$au=dateFrToUs($_POST['au']);
	$sql  = "SELECT * ";
	$sql .= "FROM factures where  date_f between '$du' and '$au' ORDER BY id;";
	$users = db_query($database_name, $sql);
	}
	else
	{
	$du = "2014-01-01";$au = "2014-12-31";
	$sql  = "SELECT * ";
	$sql .= "FROM factures where  date_f between '$du' and '$au' ORDER BY id;";
	$users = db_query($database_name, $sql);
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Factures"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "facture.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Factures"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Numero";?></th>
	<th><?php echo "Date";?></th>
	<th width="200"><?php echo "Client";?></th>
	<th width="150"><?php echo "Vendeur";?></th>
	<th width="100"><?php echo "Montant";?></th>
	<th width="100"><?php echo "Reglements";?></th>
	
	<th><?php echo "Valide";?></th>
	<th><?php echo "Regrouper";?></th>
</tr>

<?php $ca=0;while($users_ = fetch_array($users)) { ?><tr>

<? $client=$users_["client"];$id=$users_["id"];$f=$users_["numero"];$d=$users_["date_f"];$client_se=Trim($client);

	/*$sql1  = "SELECT * ";$f1=$users_["id"]+9040;$vide="0000-00-00";
	$sql1 .= "FROM detail_factures where facture='$f' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { $id1=$users1_["id"];
			$sql = "UPDATE detail_factures SET ";
			$sql .= "date_f = '" . $d . "' ";
			$sql .= "WHERE date_f='$vide' and id = " . $id1 . ";";
			db_query($database_name, $sql);}*/
			
			


?>

<? if ($users_["client"]<>"FACTURE EN INSTANCE"){?>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];$user_id=$users_["id"];$facture=$users_["id"]+9040;
echo "<td><a href=\"facture.php?user_id=$user_id&client=$client&facture=$facture&du=$du&au=$au\">$facture</a></td>";?>
<td bgcolor="#33CCFF"><?php $date=dateUsToFr($users_["date_f"]);$d=dateUsToFr($users_["date_f"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td bgcolor="#33CCFF"><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?> </td>
<td bgcolor="#33CCFF"><?php $v=$users_["vendeur"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$v </font>"); ?> </td>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];?>
<td bgcolor="#33CCFF" align="right" width="150"><?php $ca=$ca+$users_["montant"];$m=number_format($users_["montant"],2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");?></td>

<? /*echo "<td><a href=\"detail_regl_fact.php?numero=$facture\">R</a></td>";*/?>
<? echo "<td><a href=\"historique_reglements_factures.php?numero=$facture\">R</a></td>";?>
 
<td bgcolor="#33CCFF"><?php if ($users_["valide"]==1){$oui="oui";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$oui </font>");
}else{$non="non";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$non </font>");
} ?></td>
<? echo "<td><a href=\"detail_evaluation_regroupe.php?numero=$facture&client=$client\">Regrouper</a></td>";?>
<? } else {?>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];$user_id=$users_["id"];$facture=$users_["id"]+9040;
echo "<td><a href=\"facture.php?user_id=$user_id&client=$client&facture=$facture&du=$du&au=$au\">$facture</a></td>";?>
<td><?php $date=dateUsToFr($users_["date_f"]);$d=dateUsToFr($users_["date_f"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?> </td>
<td><?php $v=$users_["vendeur"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$v </font>"); ?> </td>

<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];?>
<td align="right" width="150"><?php $ca=$ca+$users_["montant"];$m=number_format($users_["montant"],2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");
 ?></td>
 <? /*echo "<td><a href=\"detail_regl_fact.php?numero=$facture\"></a></td>";*/?>
 <? echo "<td><a href=\"historique_reglements_factures.php?numero=$facture\"></a></td>";?>

<td><?php if ($users_["valide"]==1){$oui="oui";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$oui </font>");
}else{$non="non";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$non </font>");
} ?></td>
<? echo "<td><a href=\"detail_evaluation_regroupe.php?numero=$facture&client=$client\">Regrouper</a></td>";?>
<? }?>

<?php } ?>
<tr><td></td><td></td><td></td><td></td>
<td align="right"><?php $ca=number_format($ca,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ca </font>");?></td><td></td><td></td></tr>
</table>

<p style="text-align:center">

<? if ($login=="admin"){echo "<td><a href=\"facture.php?user_id=0&du=$du&au=$au\">Nouvelle Facture</a></td>";}?>
</body>

</html>