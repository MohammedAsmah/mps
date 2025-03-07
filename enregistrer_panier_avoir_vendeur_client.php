<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
		//sub
	
	if(isset($_REQUEST["action_"]) ) { 
		
		if($_REQUEST["action_"] != "delete_user") {$numero =$_REQUEST["numero"];$client =$_REQUEST["client"];
		$id = $_REQUEST["numero"];$id_c = $_REQUEST["numero"];
		$sql  = "SELECT * ";
		$sql .= "FROM avoirs_vendeurs WHERE id = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_e"]);$montant_f=$user_["net"];$date_sortie = $user_["date_e"];
		$client = $user_["client"];
		$vendeur = $user_["vendeur"];$date_a=$user_["date_e"];
		$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
			
			// prepares data to simplify database insert or update
			$produit =$_REQUEST["produit"];$quantite = $_REQUEST["quantite"];
			if ($_REQUEST["action_"]=="insert_new_user"){
			$produit1 =$_REQUEST["produit1"];$quantite1 = $_REQUEST["quantite1"];
			$produit2 =$_REQUEST["produit2"];$quantite2 = $_REQUEST["quantite2"];
			$produit3 =$_REQUEST["produit3"];$quantite3 = $_REQUEST["quantite3"];
			$produit4 =$_REQUEST["produit4"];$quantite4 = $_REQUEST["quantite4"];
			$produit5 =$_REQUEST["produit5"];$quantite5 = $_REQUEST["quantite5"];
			$produit6 =$_REQUEST["produit6"];$quantite6 = $_REQUEST["quantite6"];
			$produit7 =$_REQUEST["produit7"];$quantite7 = $_REQUEST["quantite7"];
			$produit8 =$_REQUEST["produit8"];$quantite8 = $_REQUEST["quantite8"];
			$produit9 =$_REQUEST["produit9"];$quantite9 = $_REQUEST["quantite9"];
			$produit10 =$_REQUEST["produit10"];$quantite10 = $_REQUEST["quantite10"];
			$produit11 =$_REQUEST["produit11"];$quantite11 = $_REQUEST["quantite11"];
			$produit12 =$_REQUEST["produit12"];$quantite12 = $_REQUEST["quantite12"];
			$produit13 =$_REQUEST["produit13"];$quantite13 = $_REQUEST["quantite13"];
			$produit14 =$_REQUEST["produit14"];$quantite14 = $_REQUEST["quantite14"];
			$produit15 =$_REQUEST["produit15"];$quantite15 = $_REQUEST["quantite15"];
			$produit16 =$_REQUEST["produit16"];$quantite16 = $_REQUEST["quantite16"];
			$produit17 =$_REQUEST["produit17"];$quantite17 = $_REQUEST["quantite17"];
			$produit18 =$_REQUEST["produit18"];$quantite18 = $_REQUEST["quantite18"];
			$produit19 =$_REQUEST["produit19"];$quantite19 = $_REQUEST["quantite19"];
			$produit20 =$_REQUEST["produit20"];$quantite20 = $_REQUEST["quantite20"];
			
			
			
			}

			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit = 1;$prix_unit = $user_["prix"];

			if ($_REQUEST["action_"]=="insert_new_user"){
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit1' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit1 = 1;$prix_unit1 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit2' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit2 = 1;$prix_unit2 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit3' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit3 = 1;$prix_unit3 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit4' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit4 = 1;$prix_unit4 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit5' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit5 = 1;$prix_unit5 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit6' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit6 = 1;$prix_unit6 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit7' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit7 = 1;$prix_unit7 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit8' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit8 = 1;$prix_unit8 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit9' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit9 = 1;$prix_unit9 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit10' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit10 = 1;$prix_unit10 = $user_["prix"];
		
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit11' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit11 = 1;$prix_unit11 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit12' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit12 = 1;$prix_unit12 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit13' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit13 = 1;$prix_unit13 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit14' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit14 = 1;$prix_unit14 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit15' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit15 = 1;$prix_unit15 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit16' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit16 = 1;$prix_unit16 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit17' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit17 = 1;$prix_unit17 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit18' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit18 = 1;$prix_unit18 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit19' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit19 = 1;$prix_unit19 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit20' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit20 = 1;$prix_unit20 = $user_["prix"];
		
		
		}
		}	
		
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
				if ($produit<>""){
				
				$sql  = "INSERT INTO detail_avoirs_vendeurs ( commande,client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
	
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $prix_unit . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);}
								
				
				
				if ($produit1<>""){
				$sql  = "INSERT INTO detail_avoirs_vendeurs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit1 . "', ";
				$sql .= "'" . $quantite1 . "', ";
				$sql .= "'" . $prix_unit1 . "', ";
				$sql .= "'" . $condit1 . "');";
				db_query($database_name, $sql);
								
				}
				
				if ($produit2<>""){
				$sql  = "INSERT INTO detail_avoirs_vendeurs ( commande,client,vendeur,date,  produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit2 . "', ";
				$sql .= "'" . $quantite2 . "', ";
				$sql .= "'" . $prix_unit2 . "', ";
				$sql .= "'" . $condit2 . "');";
				db_query($database_name, $sql);
				
				}
				
				if ($produit3<>""){
				$sql  = "INSERT INTO detail_avoirs_vendeurs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit3 . "', ";
				$sql .= "'" . $quantite3 . "', ";
				$sql .= "'" . $prix_unit3 . "', ";
				$sql .= "'" . $condit3 . "');";
				db_query($database_name, $sql);
				
				}
				
				if ($produit4<>""){
				$sql  = "INSERT INTO detail_avoirs_vendeurs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit4 . "', ";
				$sql .= "'" . $quantite4 . "', ";
				$sql .= "'" . $prix_unit4 . "', ";
				$sql .= "'" . $condit4 . "');";
				db_query($database_name, $sql);
				

				}
				
				if ($produit5<>""){
				$sql  = "INSERT INTO detail_avoirs_vendeurs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit5 . "', ";
				$sql .= "'" . $quantite5 . "', ";
				$sql .= "'" . $prix_unit5 . "', ";
				$sql .= "'" . $condit5 . "');";
				db_query($database_name, $sql);
					
				}
				
				if ($produit6<>""){
				$sql  = "INSERT INTO detail_avoirs_vendeurs ( commande,client,vendeur,date,  produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit6 . "', ";
				$sql .= "'" . $quantite6 . "', ";
				$sql .= "'" . $prix_unit6 . "', ";
				$sql .= "'" . $condit6 . "');";
				db_query($database_name, $sql);
				

				}
				if ($produit7<>""){
				$sql  = "INSERT INTO detail_avoirs_vendeurs ( commande,client,vendeur,date,  produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit7 . "', ";
				$sql .= "'" . $quantite7 . "', ";
				$sql .= "'" . $prix_unit7 . "', ";
				$sql .= "'" . $condit7 . "');";
				db_query($database_name, $sql);
				

				}
				if ($produit8<>""){
				$sql  = "INSERT INTO detail_avoirs_vendeurs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit8 . "', ";
				$sql .= "'" . $quantite8 . "', ";
				$sql .= "'" . $prix_unit8 . "', ";
				$sql .= "'" . $condit8 . "');";
				db_query($database_name, $sql);
				

				}
				if ($produit9<>""){
				$sql  = "INSERT INTO detail_avoirs_vendeurs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit9 . "', ";
				$sql .= "'" . $quantite9 . "', ";
				$sql .= "'" . $prix_unit9 . "', ";
				$sql .= "'" . $condit9 . "');";
				db_query($database_name, $sql);
				

				}
				if ($produit10<>""){
				$sql  = "INSERT INTO detail_avoirs_vendeurs ( commande,client,vendeur,date,  produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit10 . "', ";
				$sql .= "'" . $quantite10 . "', ";
				$sql .= "'" . $prix_unit10 . "', ";
				$sql .= "'" . $condit10 . "');";
				db_query($database_name, $sql);
				

				}
			
				if ($produit11<>""){
				$sql  = "INSERT INTO detail_avoirs_vendeurs ( commande,client,vendeur,date,  produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit11 . "', ";
				$sql .= "'" . $quantite11 . "', ";
				$sql .= "'" . $prix_unit11 . "', ";
				$sql .= "'" . $condit11 . "');";
				db_query($database_name, $sql);
				

				}
				if ($produit12<>""){
				$sql  = "INSERT INTO detail_avoirs_vendeurs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit12 . "', ";
				$sql .= "'" . $quantite12 . "', ";
				$sql .= "'" . $prix_unit12 . "', ";
				$sql .= "'" . $condit12 . "');";
				db_query($database_name, $sql);
				

				}
				if ($produit13<>""){
				$sql  = "INSERT INTO detail_avoirs_vendeurs ( commande,client,vendeur,date,  produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit13 . "', ";
				$sql .= "'" . $quantite13 . "', ";
				$sql .= "'" . $prix_unit13 . "', ";
				$sql .= "'" . $condit13 . "');";
				db_query($database_name, $sql);
				

				}
				if ($produit14<>""){
				$sql  = "INSERT INTO detail_avoirs_vendeurs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit14 . "', ";
				$sql .= "'" . $quantite14 . "', ";
				$sql .= "'" . $prix_unit14 . "', ";
				$sql .= "'" . $condit14 . "');";
				db_query($database_name, $sql);
				

				}
				if ($produit15<>""){
				$sql  = "INSERT INTO detail_avoirs_vendeurs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit15 . "', ";
				$sql .= "'" . $quantite15 . "', ";
				$sql .= "'" . $prix_unit15 . "', ";
				$sql .= "'" . $condit15 . "');";
				db_query($database_name, $sql);
				
				}
				if ($produit16<>""){
				$sql  = "INSERT INTO detail_avoirs_vendeurs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit16 . "', ";
				$sql .= "'" . $quantite16 . "', ";
				$sql .= "'" . $prix_unit16 . "', ";
				$sql .= "'" . $condit16 . "');";
				db_query($database_name, $sql);
				

				}
				if ($produit17<>""){
				$sql  = "INSERT INTO detail_avoirs_vendeurs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit17 . "', ";
				$sql .= "'" . $quantite17 . "', ";
				$sql .= "'" . $prix_unit17 . "', ";
				$sql .= "'" . $condit17 . "');";
				db_query($database_name, $sql);
				

				}
				if ($produit18<>""){
				$sql  = "INSERT INTO detail_avoirs_vendeurs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit18 . "', ";
				$sql .= "'" . $quantite18 . "', ";
				$sql .= "'" . $prix_unit18 . "', ";
				$sql .= "'" . $condit18 . "');";
				db_query($database_name, $sql);
				

				}
				if ($produit19<>""){
				$sql  = "INSERT INTO detail_avoirs_vendeurs ( commande,client,vendeur,date,  produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit19 . "', ";
				$sql .= "'" . $quantite19 . "', ";
				$sql .= "'" . $prix_unit19 . "', ";
				$sql .= "'" . $condit19 . "');";
				db_query($database_name, $sql);
				}
				
				if ($produit20<>""){
				$sql  = "INSERT INTO detail_avoirs_vendeurs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit20 . "', ";
				$sql .= "'" . $quantite20 . "', ";
				$sql .= "'" . $prix_unit20 . "', ";
				$sql .= "'" . $condit20 . "');";
				db_query($database_name, $sql);}
							
			
			break;

			case "update_user":
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
			$condit=$_REQUEST["condit"];$prix_unit = $_REQUEST["prix_unit"];
			$sql = "UPDATE detail_avoirs_vendeurs SET ";
			$sql .= "produit = '" . $produit . "', ";
			$sql .= "quantite = '" . $quantite . "', ";
			$sql .= "prix_unit = '" . $prix_unit . "', ";
			$sql .= "sans_remise = '" . $sans_remise . "', ";
			$sql .= "condit = '" . $condit . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
						

			break;
			
			case "delete_user":
			
		$sql  = "SELECT * ";
		$sql .= "FROM detail_avoirs_vendeurs WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$numero = $user_["commande"];$produit = $user_["produit"];
		

			$sql = "DELETE FROM detail_avoirs_vendeurs WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
						
		$id = $numero;$id_c = $numero;
		$sql  = "SELECT * ";
		$sql .= "FROM avoirs_vendeurs WHERE id = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_e"]);$id_registre = $user_["id_registre"];
		$client = $user_["client"];$montant_f = $user_["net"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
			
			
			break;


		} //switch
		
	} //if
	else
	{
	
	$numero=$_GET['numero'];$client=$_GET['client'];$montant_f=0;$vendeur=$_GET['vendeur'];$id_c=$_GET['numero'];
	$id = $numero;
		$sql  = "SELECT * ";
		$sql .= "FROM avoirs_vendeurs WHERE id = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_e"]);$client = $user_["client"];
		$client = $user_["client"];$montant_f = $user_["net"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
		
		
		$client1 = $user_["client1"];
		$client2 = $user_["client2"];
		$client3 = $user_["client3"];
		
		
	}
	
	
?>
</table>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Avoirs Client"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "detail_facture_pro.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>


<? if ($client1<>""){
		$sql  = "SELECT * ";
		$sql .= "FROM clients WHERE client = " . $client1 . ";";
		$userc = db_query($database_name, $sql); $user_c = fetch_array($userc);

		$remise10 = $user_c["remise10"];$remise2 = $user_c["remise2"];
		$sans_remise = $user_c["sans_remise"];$remise3 = $user_c["remise3"];


?>
<tr>


<table class="table2">

<tr>
	<th><?php $total=0;echo "Ref";?></th>
	<th><?php $total=0;echo "Produit";?></th>
	<th><?php echo "Quantité";?></th>
	<th><?php echo "Paquets";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Total";?></th>
</tr>

<?	
	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_avoirs_vendeurs where commande='$numero' and sans_remise=0 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["qte1"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
//
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}

echo "<td><a href=\"remplir_panier_avoir_vendeur_client.php?numero=$numero&user_id=$id&vendeur=$vendeur&montant=$m\">$id</a></td>";?>
<td><?php echo $produit; ?></td>
<td align="center"><?php echo $users1_["qte1"]; ?></td>
<td align="center"><?php echo $users1_["condit"]; ?></td>
<td align="right"><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<td align="right"><?php $total=$total+$m;echo number_format($m,2,',',' '); ?></td>
</tr>
<?	}?>

<?	
	
	$sql1  = "SELECT * ";$total1=0;
	$sql1 .= "FROM detail_avoirs_vendeurs where commande='$numero' and sans_remise=1 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["qte1"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
//
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE ref = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}

echo "<tr><td><a href=\"remplir_panier_avoir_vendeur.php?numero=$numero&user_id=$id&vendeur=$vendeur&montant=$m\">$id</a></td>";
?>
<td><?php echo $produit; ?></td>
<td><?php echo $users1_["qte1"]; ?></td>
<td><?php echo $users1_["condit"]; ?></td>
<td><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<td><?php $total1=$total1+$m;echo number_format($m,2,',',' '); ?></td>
</tr>
<?	}?>

<?	}?> 


<? if ($client2<>""){
		$sql  = "SELECT * ";
		$sql .= "FROM clients WHERE client = " . $client2 . ";";
		$userc = db_query($database_name, $sql); $user_c = fetch_array($userc);

		$remise10 = $user_c["remise10"];$remise2 = $user_c["remise2"];
		$sans_remise = $user_c["sans_remise"];$remise3 = $user_c["remise3"];


?>
<tr>


<table class="table2">

<tr>
	<th><?php $total=0;echo "Ref";?></th>
	<th><?php $total=0;echo "Produit";?></th>
	<th><?php echo "Quantité";?></th>
	<th><?php echo "Paquets";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Total";?></th>
</tr>

<?	
	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_avoirs_vendeurs where commande='$numero' and sans_remise=0 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["qte2"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
//
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}

echo "<td><a href=\"remplir_panier_avoir_vendeur_client.php?numero=$numero&user_id=$id&vendeur=$vendeur&montant=$m\">$id</a></td>";?>
<td><?php echo $produit; ?></td>
<td align="center"><?php echo $users1_["qte2"]; ?></td>
<td align="center"><?php echo $users1_["condit"]; ?></td>
<td align="right"><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<td align="right"><?php $total=$total+$m;echo number_format($m,2,',',' '); ?></td>
</tr>
<?	}?>

<?	
	
	$sql1  = "SELECT * ";$total1=0;
	$sql1 .= "FROM detail_avoirs_vendeurs where commande='$numero' and sans_remise=1 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["qte2"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
//
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE ref = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}

echo "<tr><td><a href=\"remplir_panier_avoir_vendeur.php?numero=$numero&user_id=$id&vendeur=$vendeur&montant=$m\">$id</a></td>";
?>
<td><?php echo $produit; ?></td>
<td><?php echo $users1_["qte2"]; ?></td>
<td><?php echo $users1_["condit"]; ?></td>
<td><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<td><?php $total1=$total1+$m;echo number_format($m,2,',',' '); ?></td>
</tr>
<?	}?>

<?	}?>

<? if ($client3<>""){
		$sql  = "SELECT * ";
		$sql .= "FROM clients WHERE client = " . $client3 . ";";
		$userc = db_query($database_name, $sql); $user_c = fetch_array($userc);

		$remise10 = $user_c["remise_10"];$remise2 = $user_c["remise2"];
		$sans_remise = $user_c["sans_remise"];$remise3 = $user_c["remise3"];


?>
<tr>


<table class="table2">

<tr>
	<th><?php $total=0;echo "Ref";?></th>
	<th><?php $total=0;echo "Produit";?></th>
	<th><?php echo "Quantité";?></th>
	<th><?php echo "Paquets";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Total";?></th>
</tr>

<?	
	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_avoirs_vendeurs where commande='$numero' and sans_remise=0 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["qte3"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
//
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}

echo "<td><a href=\"remplir_panier_avoir_vendeur_client.php?numero=$numero&user_id=$id&vendeur=$vendeur&montant=$m\">$id</a></td>";?>
<td><?php echo $produit; ?></td>
<td align="center"><?php echo $users1_["qte3"]; ?></td>
<td align="center"><?php echo $users1_["condit"]; ?></td>
<td align="right"><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<td align="right"><?php $total=$total+$m;echo number_format($m,2,',',' '); ?></td>
</tr>
<?	}?>

<?	
	
	$sql1  = "SELECT * ";$total1=0;
	$sql1 .= "FROM detail_avoirs_vendeurs where commande='$numero' and sans_remise=1 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["qte3"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
//
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE ref = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}

echo "<tr><td><a href=\"remplir_panier_avoir_vendeur.php?numero=$numero&user_id=$id&vendeur=$vendeur&montant=$m\">$id</a></td>";
?>
<td><?php echo $produit; ?></td>
<td><?php echo $users1_["qte3"]; ?></td>
<td><?php echo $users1_["condit"]; ?></td>
<td><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<td><?php $total1=$total1+$m;echo number_format($m,2,',',' '); ?></td>
</tr>
<?	}?>

<? }?>
			

</table>


<p style="text-align:center">


</body>

</html>