<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
		//sub
	
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 
		
		if($_REQUEST["action_"] != "delete_user") {$numero =$_REQUEST["numero"];$client =$_REQUEST["client"];
		$id = $_REQUEST["numero"];$id_c = $_REQUEST["numero"];
		$sql  = "SELECT * ";
		$sql .= "FROM avoirs WHERE id = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_e"]);$montant_f=$user_["net"];$date_sortie = $user_["date_e"];
		$client = $user_["client"];
		$vendeur = $user_["vendeur"];$date_a=$user_["date_e"];
		$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
			
			// prepares data to simplify database insert or update
			$produit =$_REQUEST["produit"];$quantite = $_REQUEST["quantite"];$prix =$_REQUEST["prix"];$barecode =$_REQUEST["barecode"];
			if ($_REQUEST["action_"]=="insert_new_user"){
			$produit1 =$_REQUEST["produit1"];$quantite1 = $_REQUEST["quantite1"];$prix1 =$_REQUEST["prix1"];
			$produit2 =$_REQUEST["produit2"];$quantite2 = $_REQUEST["quantite2"];$prix2 =$_REQUEST["prix2"];
			$produit3 =$_REQUEST["produit3"];$quantite3 = $_REQUEST["quantite3"];$prix3 =$_REQUEST["prix3"];
			$produit4 =$_REQUEST["produit4"];$quantite4 = $_REQUEST["quantite4"];$prix4 =$_REQUEST["prix4"];
			$produit5 =$_REQUEST["produit5"];$quantite5 = $_REQUEST["quantite5"];$prix5 =$_REQUEST["prix5"];
			$produit6 =$_REQUEST["produit6"];$quantite6 = $_REQUEST["quantite6"];$prix6 =$_REQUEST["prix6"];
			$produit7 =$_REQUEST["produit7"];$quantite7 = $_REQUEST["quantite7"];$prix7 =$_REQUEST["prix7"];
			$produit8 =$_REQUEST["produit8"];$quantite8 = $_REQUEST["quantite8"];$prix8 =$_REQUEST["prix8"];
			$produit9 =$_REQUEST["produit9"];$quantite9 = $_REQUEST["quantite9"];$prix9 =$_REQUEST["prix9"];
			$produit10 =$_REQUEST["produit10"];$quantite10 = $_REQUEST["quantite10"];$prix10 =$_REQUEST["prix10"];
			$produit11 =$_REQUEST["produit11"];$quantite11 = $_REQUEST["quantite11"];$prix11 =$_REQUEST["prix11"];
			$produit12 =$_REQUEST["produit12"];$quantite12 = $_REQUEST["quantite12"];$prix12 =$_REQUEST["prix12"];
			$produit13 =$_REQUEST["produit13"];$quantite13 = $_REQUEST["quantite13"];$prix13 =$_REQUEST["prix13"];
			$produit14 =$_REQUEST["produit14"];$quantite14 = $_REQUEST["quantite14"];$prix14 =$_REQUEST["prix14"];
			$produit15 =$_REQUEST["produit15"];$quantite15 = $_REQUEST["quantite15"];$prix15 =$_REQUEST["prix15"];
			$produit16 =$_REQUEST["produit16"];$quantite16 = $_REQUEST["quantite16"];$prix16 =$_REQUEST["prix16"];
			$produit17 =$_REQUEST["produit17"];$quantite17 = $_REQUEST["quantite17"];$prix17 =$_REQUEST["prix17"];
			$produit18 =$_REQUEST["produit18"];$quantite18 = $_REQUEST["quantite18"];$prix18 =$_REQUEST["prix18"];
			$produit19 =$_REQUEST["produit19"];$quantite19 = $_REQUEST["quantite19"];$prix19 =$_REQUEST["prix19"];
			$produit20 =$_REQUEST["produit20"];$quantite20 = $_REQUEST["quantite20"];$prix20 =$_REQUEST["prix20"];
			
			
			
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
		
		
		
		//changement de prix unit
		if ($prix<>""){$prix_unit=$prix;}
		if ($prix1<>""){$prix_unit1=$prix1;}
		if ($prix2<>""){$prix_unit2=$prix2;}
		if ($prix3<>""){$prix_unit3=$prix3;}
		if ($prix4<>""){$prix_unit4=$prix4;}
		if ($prix5<>""){$prix_unit5=$prix5;}
		if ($prix6<>""){$prix_unit6=$prix6;}
		if ($prix7<>""){$prix_unit7=$prix7;}
		if ($prix8<>""){$prix_unit8=$prix8;}
		if ($prix9<>""){$prix_unit9=$prix9;}
		if ($prix10<>""){$prix_unit10=$prix10;}
		if ($prix11<>""){$prix_unit11=$prix11;}
		if ($prix12<>""){$prix_unit12=$prix12;}
		if ($prix13<>""){$prix_unit13=$prix13;}
		if ($prix14<>""){$prix_unit14=$prix14;}
		if ($prix15<>""){$prix_unit15=$prix15;}
		if ($prix16<>""){$prix_unit16=$prix16;}
		if ($prix17<>""){$prix_unit17=$prix17;}
		if ($prix18<>""){$prix_unit18=$prix18;}
		if ($prix19<>""){$prix_unit19=$prix19;}
		if ($prix20<>""){$prix_unit20=$prix20;}
		
		
		
		}
		}	
		
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
				if ($produit<>"-"){
				
				$sql  = "INSERT INTO detail_avoirs ( commande,client,vendeur,date, produit, barecode,quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $barecode . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $prix_unit . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
				
				}
				
				
				
				
				
				if ($produit1<>"-"){
				$sql  = "INSERT INTO detail_avoirs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit1 . "', ";
				$sql .= "'" . $quantite1 . "', ";
				$sql .= "'" . $prix_unit1 . "', ";
				$sql .= "'" . $condit1 . "');";
				db_query($database_name, $sql);
												
				}
				if ($produit2<>"-"){
				$sql  = "INSERT INTO detail_avoirs ( commande,client,vendeur,date,  produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit2 . "', ";
				$sql .= "'" . $quantite2 . "', ";
				$sql .= "'" . $prix_unit2 . "', ";
				$sql .= "'" . $condit2 . "');";
				db_query($database_name, $sql);
				
				}
				
				if ($produit3<>"-"){
				$sql  = "INSERT INTO detail_avoirs ( commande,client,vendeur,date,  produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit3 . "', ";
				$sql .= "'" . $quantite3 . "', ";
				$sql .= "'" . $prix_unit3 . "', ";
				$sql .= "'" . $condit3 . "');";
				db_query($database_name, $sql);
				}
				
				if ($produit4<>"-"){
				$sql  = "INSERT INTO detail_avoirs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit4 . "', ";
				$sql .= "'" . $quantite4 . "', ";
				$sql .= "'" . $prix_unit4 . "', ";
				$sql .= "'" . $condit4 . "');";
				db_query($database_name, $sql);
				
				}
				
				if ($produit5<>"-"){
				$sql  = "INSERT INTO detail_avoirs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit5 . "', ";
				$sql .= "'" . $quantite5 . "', ";
				$sql .= "'" . $prix_unit5 . "', ";
				$sql .= "'" . $condit5 . "');";
				db_query($database_name, $sql);
				
				}
				
				if ($produit6<>"-"){
				$sql  = "INSERT INTO detail_avoirs ( commande,client,vendeur,date,  produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit6 . "', ";
				$sql .= "'" . $quantite6 . "', ";
				$sql .= "'" . $prix_unit6 . "', ";
				$sql .= "'" . $condit6 . "');";
				db_query($database_name, $sql);
				
				}
				if ($produit7<>"-"){
				$sql  = "INSERT INTO detail_avoirs ( commande,client,vendeur,date,  produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit7 . "', ";
				$sql .= "'" . $quantite7 . "', ";
				$sql .= "'" . $prix_unit7 . "', ";
				$sql .= "'" . $condit7 . "');";
				db_query($database_name, $sql);
				
				}
				if ($produit8<>"-"){
				$sql  = "INSERT INTO detail_avoirs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit8 . "', ";
				$sql .= "'" . $quantite8 . "', ";
				$sql .= "'" . $prix_unit8 . "', ";
				$sql .= "'" . $condit8 . "');";
				db_query($database_name, $sql);
				
				}
				if ($produit9<>"-"){
				$sql  = "INSERT INTO detail_avoirs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit9 . "', ";
				$sql .= "'" . $quantite9 . "', ";
				$sql .= "'" . $prix_unit9 . "', ";
				$sql .= "'" . $condit9 . "');";
				db_query($database_name, $sql);
				
				}
				if ($produit10<>"-"){
				$sql  = "INSERT INTO detail_avoirs ( commande,client,vendeur,date,  produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit10 . "', ";
				$sql .= "'" . $quantite10 . "', ";
				$sql .= "'" . $prix_unit10 . "', ";
				$sql .= "'" . $condit10 . "');";
				db_query($database_name, $sql);
				
				}
			
				if ($produit11<>"-"){
				$sql  = "INSERT INTO detail_avoirs ( commande,client,vendeur,date,  produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit11 . "', ";
				$sql .= "'" . $quantite11 . "', ";
				$sql .= "'" . $prix_unit11 . "', ";
				$sql .= "'" . $condit11 . "');";
				db_query($database_name, $sql);
				
				}
				if ($produit12<>"-"){
				$sql  = "INSERT INTO detail_avoirs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit12 . "', ";
				$sql .= "'" . $quantite12 . "', ";
				$sql .= "'" . $prix_unit12 . "', ";
				$sql .= "'" . $condit12 . "');";
				db_query($database_name, $sql);
				
				}
				if ($produit13<>"-"){
				$sql  = "INSERT INTO detail_avoirs ( commande,client,vendeur,date,  produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit13 . "', ";
				$sql .= "'" . $quantite13 . "', ";
				$sql .= "'" . $prix_unit13 . "', ";
				$sql .= "'" . $condit13 . "');";
				db_query($database_name, $sql);
				}
				
				if ($produit14<>"-"){
				$sql  = "INSERT INTO detail_avoirs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit14 . "', ";
				$sql .= "'" . $quantite14 . "', ";
				$sql .= "'" . $prix_unit14 . "', ";
				$sql .= "'" . $condit14 . "');";
				db_query($database_name, $sql);
				
				}
				if ($produit15<>"-"){
				$sql  = "INSERT INTO detail_avoirs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit15 . "', ";
				$sql .= "'" . $quantite15 . "', ";
				$sql .= "'" . $prix_unit15 . "', ";
				$sql .= "'" . $condit15 . "');";
				db_query($database_name, $sql);
				
				}
				if ($produit16<>"-"){
				$sql  = "INSERT INTO detail_avoirs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit16 . "', ";
				$sql .= "'" . $quantite16 . "', ";
				$sql .= "'" . $prix_unit16 . "', ";
				$sql .= "'" . $condit16 . "');";
				db_query($database_name, $sql);
				
				}
				if ($produit17<>"-"){
				$sql  = "INSERT INTO detail_avoirs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit17 . "', ";
				$sql .= "'" . $quantite17 . "', ";
				$sql .= "'" . $prix_unit17 . "', ";
				$sql .= "'" . $condit17 . "');";
				db_query($database_name, $sql);
				
				}
				if ($produit18<>"-"){
				$sql  = "INSERT INTO detail_avoirs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit18 . "', ";
				$sql .= "'" . $quantite18 . "', ";
				$sql .= "'" . $prix_unit18 . "', ";
				$sql .= "'" . $condit18 . "');";
				db_query($database_name, $sql);
				
				}
				if ($produit19<>"-"){
				$sql  = "INSERT INTO detail_avoirs ( commande,client,vendeur,date,  produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit19 . "', ";
				$sql .= "'" . $quantite19 . "', ";
				$sql .= "'" . $prix_unit19 . "', ";
				$sql .= "'" . $condit19 . "');";
				db_query($database_name, $sql);
				
				}
				if ($produit20<>"-"){
				$sql  = "INSERT INTO detail_avoirs ( commande, client,vendeur,date, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date_a . "', ";
				$sql .= "'" . $produit20 . "', ";
				$sql .= "'" . $quantite20 . "', ";
				$sql .= "'" . $prix_unit20 . "', ";
				$sql .= "'" . $condit20 . "');";
				db_query($database_name, $sql);
				
				}
			$vide="";	
			$sql = "DELETE FROM detail_avoirs WHERE produit = '" . $vide . "';";
			db_query($database_name, $sql);
						
			
			
			break;

			case "update_user":
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
			$condit=$_REQUEST["condit"];$prix_unit = $_REQUEST["prix_unit"];
			$sql = "UPDATE detail_avoirs SET ";
			$sql .= "produit = '" . $produit . "', ";
			$sql .= "quantite = '" . $quantite . "', ";
			$sql .= "prix_unit = '" . $prix_unit . "', ";
			$sql .= "sans_remise = '" . $sans_remise . "', ";
			$sql .= "condit = '" . $condit . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
						//promotions
						$sql = "DELETE FROM detail_avoirs_pro WHERE produit='$produit' and commande = " . $numero . ";";
			db_query($database_name, $sql);

				$sql1  = "SELECT * ";$date_sortie=$user_["date_e"];
				$sql1 .= "FROM liste_promotions where article='$produit' and date_fin>='$date_sortie' and base<=$quantite ORDER BY date;";
				$users1p = db_query($database_name, $sql1);$users1_p = fetch_array($users1p);$base=$users1_p["base"];
				if ($base>0){
				$taux=round($quantite/$base);
				$promotion=$users1_p["promotion"]*$taux;$type="promotion";$date_p=$users1_p["date"];
				$sql  = "INSERT INTO detail_avoirs_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $promotion . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= "'" . $date_p . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);}

			break;
			
			case "delete_user":
			
		$sql  = "SELECT * ";
		$sql .= "FROM detail_avoirs WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$numero = $user_["commande"];$produit = $user_["produit"];
		

			$sql = "DELETE FROM detail_avoirs WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
						$sql = "DELETE FROM detail_avoirs_pro WHERE produit='$produit' and commande = " . $numero . ";";
			db_query($database_name, $sql);

		$id = $numero;$id_c = $numero;
		$sql  = "SELECT * ";
		$sql .= "FROM avoirs WHERE id = " . $id . ";";
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
		$sql .= "FROM avoirs WHERE id = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_e"]);$client = $user_["client"];
		$client = $user_["client"];$montant_f = $user_["net"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
	}
	$vide="";	
			$sql = "DELETE FROM detail_avoirs WHERE produit = '" . $vide . "';";
			db_query($database_name, $sql);
	
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

<table class="table2">
<td><?php echo $client;?></td><td><?php $montant1=number_format($montant_f,2,',',' ');
echo "Avoir : ".$evaluation."---->Date : $date --->";?></td>
</table>
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
	$sql1 .= "FROM detail_avoirs where commande='$numero' and sans_remise=0 ORDER BY id;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
//
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}

echo "<td><a href=\"remplir_panier_avoir.php?numero=$numero&user_id=$id&client=$client&montant=$m\">$id</a></td>";
echo "<td><a href=\"remplir_panier_avoir_barcode.php?numero=$numero&user_id=$id&client=$client&montant=$m\">$id</a></td>";

?>
<td><?php echo $produit; ?></td>
<td align="center"><?php echo $users1_["quantite"]; ?></td>
<td align="center"><?php echo $users1_["condit"]; ?></td>
<td align="right"><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<td align="right"><?php $total=$total+$m;echo number_format($m,2,',',' '); ?></td>
</tr>
<?	}?>

<?
if ($sans_remise==1){?>
<td></td><td></td><td></td><td></td>
<td>Net à payer</td>
<td align="right"><?php $t=$total;$net=$total;echo number_format($t,2,',',' '); ?></td>
<? } else {?>

<td></td><td></td><td></td><td></td>
<td>Total</td>
<td align="right"><?php $t=$total;echo number_format($t,2,',',' '); ?></td>
<? 		
		$remise_1=0;$remise_2=0;$remise_3=0;
?>
<tr>
<td></td>
<td></td>
<td></td><td></td>
<? if ($remise10>0){?>
<td>Remise 10%</td>
<td align="right"><?php $remise_1=$total*$remise10/100; echo number_format($remise_1,2,',',' ');?></td>
</tr>
<tr>
<td></td>
<td></td>
<td></td><td></td>
<? }?>
<? if ($remise2>0){?>
<td><? if ($remise2==2){echo "Remise 2%";}?></td>
<td align="right"><?php $remise_2=($total-$remise_1)*$remise2/100; echo number_format($remise_2,2,',',' ');?></td>
</tr>
<tr>
<td></td>
<td></td>
<td></td><td></td>
<? }?>
<? if ($remise3>0){?>
<td><? if ($remise3==2){echo "Remise 2%";}else{echo "Remise 3%";}?></td>
<td align="right"><?php $remise_3=($total-$remise_1-$remise_2)*$remise3/100; echo number_format($remise_3,2,',',' ');?></td>
</tr>
<? }?>

<tr>
<td></td>
<td></td>
<td></td><td></td>

<td>Net</td>
<td align="right"><?php $net=$total-$remise_1-$remise_2-$remise_3; echo number_format($net,2,',',' ');?></td>

</tr>


<?	
	
	$sql1  = "SELECT * ";$total1=0;
	$sql1 .= "FROM detail_avoirs where commande='$numero' and sans_remise=1 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
//
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE ref = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}

echo "<tr><td><a href=\"remplir_panier_avoir.php?numero=$numero&user_id=$id&client=$client&montant=$m\">$id</a></td>";
?>
<td><?php echo $produit; ?></td>
<td><?php echo $users1_["quantite"]; ?></td>
<td><?php echo $users1_["condit"]; ?></td>
<td><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<td><?php $total1=$total1+$m;echo number_format($m,2,',',' '); ?></td>
</tr>
<?	}?>

<tr>
<td></td>
<td></td>
<td></td><td></td>

<td>Net à payer</td>
<td align="right"><?php $net=$total+$total1-$remise_1-$remise_2-$remise_3; echo number_format($net,2,',',' ');?></td>
</tr>

<?
			$sql = "UPDATE avoirs SET ";
			$sql .= "net = '" . $net . "' ";
			$sql .= "WHERE id = " . $id_c . ";";
			db_query($database_name, $sql);
?>


<tr>
<td></td>
<td></td>
<td></td><td></td>

<? }?>

</table>
<table>
<tr>
<? echo "<td><a href=\"remplir_panier_avoir.php?numero=$numero&user_id=0&client=$client\">Ajout Article dans Avoir</a></td>";
//echo "<td><a href=\"remplir_panier_avoir_barcode.php?numero=$numero&user_id=0&client=$client\">Ajout Article dans Avoir</a></td>";
?>
</tr><tr>
<tr>
<? echo "<td><a href=\"editer_avoir_client.php?numero=$numero&user_id=0&client=$client\">Imprimer Avoir</a></td>";?>
</tr><tr>
<? $date1=dateFrToUs($date);echo "<td><a href=\"avoirs_client.php?vendeur=$vendeur&date=$date1\">Retour dans Liste Avoirs</a></td>";?>
</tr>
<tr>
<? $non_favoris_f= number_format($non_favoris,2,',',' ');$diff=$net-$montant_f;?>
</tr>

<tr><td><? $non_favoris=$non_favoris+$diff;$non_favoris_f= number_format($non_favoris,2,',',' ');
$m2=$montant_f-$net+$non_favoris;?></td></tr>
</table>

<p style="text-align:center">


</body>

</html>