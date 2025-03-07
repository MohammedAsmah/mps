<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];$base=0;
	$base1=0;
	$base2=0;
	$base3=0;
	$base4=0;
	$base5=0;
	$base6=0;
	$base7=0;
	$base8=0;
	$base9=0;
	$base10=0;
	$base11=0;
	$base12=0;
	$base13=0;
	$base14=0;
	$base15=0;
	$base16=0;
	$base17=0;
	$base18=0;
	$base19=0;
	$base20=0;
	$base21=0;	
		//sub
	
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 
		
		if($_REQUEST["action_"] != "delete_user") {$numero =$_REQUEST["numero"];$client =$_REQUEST["client"];
		$id = $_REQUEST["numero"];$id_c = $_REQUEST["numero"];
		$sql  = "SELECT * ";
		$sql .= "FROM commandes WHERE commande = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_e"]);$montant_f=$user_["net"];$date_sortie = $user_["date_e"];$escompte_exercice = $user_["escompte_exercice"];
		$client = $user_["client"];$piece = $user_["piece"];$controle = $user_["controle"];$escompte = $user_["escompte"];$escompte2 = $user_["escompte2"];
		$vendeur = $user_["vendeur"];$id_registre = $user_["id_registre"];
		$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];$minimum = $user_["plafond"];$encaiss = $user_["encaiss"];
			
			$sql  = "SELECT * ";
			$sql .= "FROM clients WHERE client = '$client' ;";
			$user1 = db_query($database_name, $sql);
			$user_1 = fetch_array($user1);$ville = $user_1["ville"];$prix_grille = $user_1["prix1"];
			$sql  = "SELECT * ";
			$sql .= "FROM rs_data_villes WHERE ville = '$ville' ;";
			$user2 = db_query($database_name, $sql);
			$user_2 = fetch_array($user2);$region = $user_2["secteur"];
			
			
			
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


//recherche doublons
		$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes WHERE commande=$numero and produit = '$produit' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit="";}


//////////////////////////////
			}

			if(isset($_REQUEST["sans_remise"]) and $produit<>"") { $sans_remise = 1; } else { $sans_remise = 0; }
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit = $user_["condit"];$designation = $user_["designation"];if ($prix_grille==1){$prix_unit = $user_["prix"];}else{$prix_unit = $user_["asswak"];}

			if ($_REQUEST["action_"]=="insert_new_user"){
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit1' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit1 = $user_["condit"];$designation1 = $user_["designation"];if ($prix_grille==1){$prix_unit1 = $user_["prix"];}else{$prix_unit1 = $user_["asswak"];}
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit2' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit2 = $user_["condit"];$designation2 = $user_["designation"];if ($prix_grille==1){$prix_unit2 = $user_["prix"];}else{$prix_unit2 = $user_["asswak"];}
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit3' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit3 = $user_["condit"];$designation3 = $user_["designation"];if ($prix_grille==1){$prix_unit3 = $user_["prix"];}else{$prix_unit3 = $user_["asswak"];}
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit4' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit4 = $user_["condit"];$designation4 = $user_["designation"];if ($prix_grille==1){$prix_unit4 = $user_["prix"];}else{$prix_unit4 = $user_["asswak"];}
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit5' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit5 = $user_["condit"];$designation5 = $user_["designation"];if ($prix_grille==1){$prix_unit5 = $user_["prix"];}else{$prix_unit5 = $user_["asswak"];}
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit6' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit6 = $user_["condit"];$designation6 = $user_["designation"];if ($prix_grille==1){$prix_unit6 = $user_["prix"];}else{$prix_unit6 = $user_["asswak"];}
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit7' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit7 = $user_["condit"];$designation7 = $user_["designation"];if ($prix_grille==1){$prix_unit7 = $user_["prix"];}else{$prix_unit7 = $user_["asswak"];}
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit8' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit8 = $user_["condit"];$designation8 = $user_["designation"];if ($prix_grille==1){$prix_unit8 = $user_["prix"];}else{$prix_unit8 = $user_["asswak"];}
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit9' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit9 = $user_["condit"];$designation9 = $user_["designation"];if ($prix_grille==1){$prix_unit9 = $user_["prix"];}else{$prix_unit9 = $user_["asswak"];}
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit10' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit10 = $user_["condit"];$designation10 = $user_["designation"];if ($prix_grille==1){$prix_unit10 = $user_["prix"];}else{$prix_unit10 = $user_["asswak"];}
		
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit11' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit11 = $user_["condit"];$designation11 = $user_["designation"];if ($prix_grille==1){$prix_unit11 = $user_["prix"];}else{$prix_unit11 = $user_["asswak"];}
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit12' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit12 = $user_["condit"];$designation12 = $user_["designation"];if ($prix_grille==1){$prix_unit12 = $user_["prix"];}else{$prix_unit12 = $user_["asswak"];}
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit13' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit13 = $user_["condit"];$designation13 = $user_["designation"];if ($prix_grille==1){$prix_unit13 = $user_["prix"];}else{$prix_unit13 = $user_["asswak"];}
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit14' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit14 = $user_["condit"];$designation14 = $user_["designation"];if ($prix_grille==1){$prix_unit14 = $user_["prix"];}else{$prix_unit14 = $user_["asswak"];}
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit15' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit15 = $user_["condit"];$designation15 = $user_["designation"];if ($prix_grille==1){$prix_unit15 = $user_["prix"];}else{$prix_unit15 = $user_["asswak"];}
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit16' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit16 = $user_["condit"];$designation16 = $user_["designation"];if ($prix_grille==1){$prix_unit16 = $user_["prix"];}else{$prix_unit16 = $user_["asswak"];}
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit17' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit17 = $user_["condit"];$designation17 = $user_["designation"];if ($prix_grille==1){$prix_unit17 = $user_["prix"];}else{$prix_unit17 = $user_["asswak"];}
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit18' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit18 = $user_["condit"];$designation18 = $user_["designation"];if ($prix_grille==1){$prix_unit18 = $user_["prix"];}else{$prix_unit18 = $user_["asswak"];}
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit19' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit19 = $user_["condit"];$designation19 = $user_["designation"];if ($prix_grille==1){$prix_unit19 = $user_["prix"];}else{$prix_unit19 = $user_["asswak"];}
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit20' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit20 = $user_["condit"];$designation20 = $user_["designation"];if ($prix_grille==1){$prix_unit20 = $user_["prix"];}else{$prix_unit20 = $user_["asswak"];}
		
		
		}
		}	
		if ($piece==1){
		$condit=1;$condit1=1;$condit2=1;$condit3=1;$condit4=1;$condit5=1;$condit6=1;$condit7=1;$condit8=1;$condit9=1;$condit10=1;$condit11=1;
		$condit12=1;$condit13=1;$condit14=1;$condit15=1;$condit16=1;$condit17=1;$condit18=1;$condit19=1;$condit20=1;}
		
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
				
				if ($produit<>""){
				
				$sql  = "INSERT INTO detail_commandes ( commande, id_registre,produit,designation, quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit . "', ";$sql .= "'" . $designation . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $prix_unit . "', ";
				$sql .= "'" . $date_sortie . "', ";$sql .= "'" . $evaluation . "', ";$sql .= "'" . $escompte_exercice . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $region . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit' and date_fin>='$date_sortie' and base<=$quantite ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit . "');";
							db_query($database_name, $sql);
						} 
					}
				}
				
				}

				
				
		$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes WHERE commande=$numero and produit = '$produit1' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit1="";}
				
				
				
				
				if ($produit1<>""){
				$sql  = "INSERT INTO detail_commandes ( commande, id_registre,produit,designation, quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit1 . "', ";$sql .= "'" . $designation1 . "', ";
				$sql .= "'" . $quantite1 . "', ";
				$sql .= "'" . $prix_unit1 . "', ";$sql .= "'" . $date_sortie . "', ";$sql .= "'" . $evaluation . "', ";$sql .= "'" . $escompte_exercice . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $region . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $condit1 . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit1' and date_fin>='$date_sortie' and base<=$quantite1 ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit1 . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit1 . "');";
							db_query($database_name, $sql);
						} 
					}
				}				
				
				

				
				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes WHERE commande=$numero and produit = '$produit2' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit2="";}

				if ($produit2<>""){
				$sql  = "INSERT INTO detail_commandes ( commande, id_registre,produit,designation, quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit2 . "', ";$sql .= "'" . $designation2 . "', ";
				$sql .= "'" . $quantite2 . "', ";
				$sql .= "'" . $prix_unit2 . "', ";$sql .= "'" . $date_sortie . "', ";$sql .= "'" . $evaluation . "', ";$sql .= "'" . $escompte_exercice . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $region . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $condit2 . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit2' and date_fin>='$date_sortie' and base<=$quantite2 ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit2 . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit2 . "');";
							db_query($database_name, $sql);
						} 
					}
				}
				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes WHERE commande=$numero and produit = '$produit3' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit3="";}

				if ($produit3<>""){
				$sql  = "INSERT INTO detail_commandes ( commande, id_registre,produit,designation, quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit3 . "', ";$sql .= "'" . $designation3 . "', ";
				$sql .= "'" . $quantite3 . "', ";
				$sql .= "'" . $prix_unit3 . "', ";$sql .= "'" . $date_sortie . "', ";$sql .= "'" . $evaluation . "', ";$sql .= "'" . $escompte_exercice . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $region . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $condit3 . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit3' and date_fin>='$date_sortie' and base<=$quantite3 ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit3 . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit3 . "');";
							db_query($database_name, $sql);
						} 
					}
				}
				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes WHERE commande=$numero and produit = '$produit4' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit4="";}

				if ($produit4<>""){
				$sql  = "INSERT INTO detail_commandes ( commande, id_registre,produit,designation, quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit4 . "', ";$sql .= "'" . $designation4 . "', ";
				$sql .= "'" . $quantite4 . "', ";
				$sql .= "'" . $prix_unit4 . "', ";$sql .= "'" . $date_sortie . "', ";$sql .= "'" . $evaluation . "', ";$sql .= "'" . $escompte_exercice . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $region . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $condit4 . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit4' and date_fin>='$date_sortie' and base<=$quantite4 ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit4 . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit4 . "');";
							db_query($database_name, $sql);
						} 
					}
				}

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes WHERE commande=$numero and produit = '$produit5' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit5="";}

				if ($produit5<>""){
				$sql  = "INSERT INTO detail_commandes ( commande, id_registre,produit,designation, quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit5 . "', ";$sql .= "'" . $designation5 . "', ";
				$sql .= "'" . $quantite5 . "', ";
				$sql .= "'" . $prix_unit5 . "', ";$sql .= "'" . $date_sortie . "', ";$sql .= "'" . $evaluation . "', ";$sql .= "'" . $escompte_exercice . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $region . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $condit5 . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit5' and date_fin>='$date_sortie' and base<=$quantite5 ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit5 . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit5 . "');";
							db_query($database_name, $sql);
						} 
					}
				}
				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes WHERE commande=$numero and produit = '$produit6' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit6="";}

				if ($produit6<>""){
				$sql  = "INSERT INTO detail_commandes ( commande, id_registre,produit,designation, quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit6 . "', ";$sql .= "'" . $designation6 . "', ";
				$sql .= "'" . $quantite6 . "', ";
				$sql .= "'" . $prix_unit6 . "', ";$sql .= "'" . $date_sortie . "', ";$sql .= "'" . $evaluation . "', ";$sql .= "'" . $escompte_exercice . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $region . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $condit6 . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit6' and date_fin>='$date_sortie' and base<=$quantite6 ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit6 . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit6 . "');";
							db_query($database_name, $sql);
						} 
					}
				}

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes WHERE commande=$numero and produit = '$produit7' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit7="";}

				if ($produit7<>""){
				$sql  = "INSERT INTO detail_commandes ( commande, id_registre,produit,designation, quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit7 . "', ";$sql .= "'" . $designation7 . "', ";
				$sql .= "'" . $quantite7 . "', ";
				$sql .= "'" . $prix_unit7 . "', ";$sql .= "'" . $date_sortie . "', ";$sql .= "'" . $evaluation . "', ";$sql .= "'" . $escompte_exercice . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $region . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $condit7 . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit7' and date_fin>='$date_sortie' and base<=$quantite7 ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit7 . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit7 . "');";
							db_query($database_name, $sql);
						} 
					}
				}

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes WHERE commande=$numero and produit = '$produit8' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit8="";}

				if ($produit8<>""){
				$sql  = "INSERT INTO detail_commandes ( commande,id_registre, produit, designation,quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit8 . "', ";$sql .= "'" . $designation8 . "', ";
				$sql .= "'" . $quantite8 . "', ";
				$sql .= "'" . $prix_unit8 . "', ";$sql .= "'" . $date_sortie . "', ";$sql .= "'" . $evaluation . "', ";$sql .= "'" . $escompte_exercice . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $region . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $condit8 . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit8' and date_fin>='$date_sortie' and base<=$quantite8 ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit8 . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit8 . "');";
							db_query($database_name, $sql);
						} 
					}
				}

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes WHERE commande=$numero and produit = '$produit9' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit9="";}

				if ($produit9<>""){
				$sql  = "INSERT INTO detail_commandes ( commande,id_registre, produit, designation,quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit9 . "', ";$sql .= "'" . $designation9 . "', ";
				$sql .= "'" . $quantite9 . "', ";
				$sql .= "'" . $prix_unit9 . "', ";$sql .= "'" . $date_sortie . "', ";$sql .= "'" . $evaluation . "', ";$sql .= "'" . $escompte_exercice . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $region . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $condit9 . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit9' and date_fin>='$date_sortie' and base<=$quantite9 ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit9 . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit9 . "');";
							db_query($database_name, $sql);
						} 
					}
				}

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes WHERE commande=$numero and produit = '$produit10' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit10="";}

				if ($produit10<>""){
				$sql  = "INSERT INTO detail_commandes ( commande, id_registre,produit,designation, quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit10 . "', ";$sql .= "'" . $designation10 . "', ";
				$sql .= "'" . $quantite10 . "', ";
				$sql .= "'" . $prix_unit10 . "', ";$sql .= "'" . $date_sortie . "', ";$sql .= "'" . $evaluation . "', ";$sql .= "'" . $escompte_exercice . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $region . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $condit10 . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit10' and date_fin>='$date_sortie' and base<=$quantite10 ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit10 . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit10 . "');";
							db_query($database_name, $sql);
						} 
					}
				}

				}
					$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes WHERE commande=$numero and produit = '$produit11' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit11="";}

				if ($produit11<>""){
				$sql  = "INSERT INTO detail_commandes ( commande, id_registre,produit,designation, quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit11 . "', ";$sql .= "'" . $designation11 . "', ";
				$sql .= "'" . $quantite11 . "', ";
				$sql .= "'" . $prix_unit11 . "', ";$sql .= "'" . $date_sortie . "', ";$sql .= "'" . $evaluation . "', ";$sql .= "'" . $escompte_exercice . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $region . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $condit11 . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit11' and date_fin>='$date_sortie' and base<=$quantite11 ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit11 . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit11 . "');";
							db_query($database_name, $sql);
						} 
					}
				}

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes WHERE commande=$numero and produit = '$produit12' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit12="";}

				if ($produit12<>""){
				$sql  = "INSERT INTO detail_commandes ( commande, id_registre,produit, designation,quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit12 . "', ";$sql .= "'" . $designation12 . "', ";
				$sql .= "'" . $quantite12 . "', ";
				$sql .= "'" . $prix_unit12 . "', ";$sql .= "'" . $date_sortie . "', ";$sql .= "'" . $evaluation . "', ";$sql .= "'" . $escompte_exercice . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $region . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $condit12 . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit12' and date_fin>='$date_sortie' and base<=$quantite12 ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit12 . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit12 . "');";
							db_query($database_name, $sql);
						} 
					}
				}

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes WHERE commande=$numero and produit = '$produit13' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit13="";}

				if ($produit13<>""){
				$sql  = "INSERT INTO detail_commandes ( commande, id_registre,produit, designation,quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit13 . "', ";$sql .= "'" . $designation13 . "', ";
				$sql .= "'" . $quantite13 . "', ";
				$sql .= "'" . $prix_unit13 . "', ";$sql .= "'" . $date_sortie . "', ";$sql .= "'" . $evaluation . "', ";$sql .= "'" . $escompte_exercice . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $region . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $condit13 . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit13' and date_fin>='$date_sortie' and base<=$quantite13 ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit13 . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit13 . "');";
							db_query($database_name, $sql);
						} 
					}
				}

				}		$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes WHERE commande=$numero and produit = '$produit14' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit14="";}

				if ($produit14<>""){
				$sql  = "INSERT INTO detail_commandes ( commande, id_registre,produit,designation, quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit14 . "', ";$sql .= "'" . $designation14 . "', ";
				$sql .= "'" . $quantite14 . "', ";
				$sql .= "'" . $prix_unit14 . "', ";$sql .= "'" . $date_sortie . "', ";$sql .= "'" . $evaluation . "', ";$sql .= "'" . $escompte_exercice . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $region . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $condit14 . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit14' and date_fin>='$date_sortie' and base<=$quantite14 ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit14 . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit14 . "');";
							db_query($database_name, $sql);
						} 
					}
				}

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes WHERE commande=$numero and produit = '$produit15' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit15="";}

				if ($produit15<>""){
				$sql  = "INSERT INTO detail_commandes ( commande, id_registre,produit,designation, quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit15 . "', ";$sql .= "'" . $designation15 . "', ";
				$sql .= "'" . $quantite15 . "', ";
				$sql .= "'" . $prix_unit15 . "', ";$sql .= "'" . $date_sortie . "', ";$sql .= "'" . $evaluation . "', ";$sql .= "'" . $escompte_exercice . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $region . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $condit15 . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit15' and date_fin>='$date_sortie' and base<=$quantite15 ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit15 . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit15 . "');";
							db_query($database_name, $sql);
						} 
					}
				}

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes WHERE commande=$numero and produit = '$produit16' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit16="";}

				if ($produit16<>""){
				$sql  = "INSERT INTO detail_commandes ( commande, id_registre,produit, designation,quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit16 . "', ";$sql .= "'" . $designation16 . "', ";
				$sql .= "'" . $quantite16 . "', ";
				$sql .= "'" . $prix_unit16 . "', ";$sql .= "'" . $date_sortie . "', ";$sql .= "'" . $evaluation . "', ";$sql .= "'" . $escompte_exercice . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $region . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $condit16 . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit16' and date_fin>='$date_sortie' and base<=$quantite16 ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit16 . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit16 . "');";
							db_query($database_name, $sql);
						} 
					}
				}

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes WHERE commande=$numero and produit = '$produit17' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit17="";}

				if ($produit17<>""){
				$sql  = "INSERT INTO detail_commandes ( commande, id_registre,produit,designation, quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit17 . "', ";$sql .= "'" . $designation17 . "', ";
				$sql .= "'" . $quantite17 . "', ";
				$sql .= "'" . $prix_unit17 . "', ";$sql .= "'" . $date_sortie . "', ";$sql .= "'" . $evaluation . "', ";$sql .= "'" . $escompte_exercice . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $region . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $condit17 . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit17' and date_fin>='$date_sortie' and base<=$quantite17 ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit17 . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit17 . "');";
							db_query($database_name, $sql);
						} 
					}
				}

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes WHERE commande=$numero and produit = '$produit18' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit18="";}

				if ($produit18<>""){
				$sql  = "INSERT INTO detail_commandes ( commande,id_registre, produit,designation, quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit18 . "', ";$sql .= "'" . $designation18 . "', ";
				$sql .= "'" . $quantite18 . "', ";
				$sql .= "'" . $prix_unit18 . "', ";$sql .= "'" . $date_sortie . "', ";$sql .= "'" . $evaluation . "', ";$sql .= "'" . $escompte_exercice . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $region . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $condit18 . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit18' and date_fin>='$date_sortie' and base<=$quantite18 ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit18 . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit18 . "');";
							db_query($database_name, $sql);
						} 
					}
				}
				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes WHERE commande=$numero and produit = '$produit19' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit19="";}

				if ($produit19<>""){
				$sql  = "INSERT INTO detail_commandes ( commande, id_registre,produit,designation, quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit19 . "', ";$sql .= "'" . $designation19 . "', ";
				$sql .= "'" . $quantite19 . "', ";
				$sql .= "'" . $prix_unit19 . "', ";$sql .= "'" . $date_sortie . "', ";$sql .= "'" . $evaluation . "', ";$sql .= "'" . $escompte_exercice . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $region . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $condit19 . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit19' and date_fin>='$date_sortie' and base<=$quantite19 ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit19 . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit19 . "');";
							db_query($database_name, $sql);
						} 
					}
				}

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes WHERE commande=$numero and produit = '$produit20' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit20="";}

				if ($produit20<>""){
				$sql  = "INSERT INTO detail_commandes ( commande, id_registre,produit, designation,quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit20 . "', ";$sql .= "'" . $designation20 . "', ";
				$sql .= "'" . $quantite20 . "', ";
				$sql .= "'" . $prix_unit20 . "', ";$sql .= "'" . $date_sortie . "', ";$sql .= "'" . $evaluation . "', ";$sql .= "'" . $escompte_exercice . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $region . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $condit20 . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit20' and date_fin>='$date_sortie' and base<=$quantite20 ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit20 . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit20 . "');";
							db_query($database_name, $sql);
						} 
					}
				}

				}
			
			break;

			case "update_user":
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
			$sql  = "SELECT * ";
			$sql .= "FROM produits WHERE produit = '$produit' ;";
			$user = db_query($database_name, $sql);
			$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit = $user_["condit"];$prix_unit = $user_["prix"];$designation = $user_["designation"];
			$couleurs = $user_["couleurs"];$p_marron = $user_["p_marron"];$p_beige = $user_["p_beige"];$p_gris = $user_["p_gris"];
			if ($login=="admin" or $login=="rakia" or $login=="mghari")	{$prix_unit = $_REQUEST["prix_unit"];}
			
			//////////couleurs
			if ($couleurs==1){$marron = $_REQUEST["marron"];$beige = $_REQUEST["beige"];$gris = $_REQUEST["gris"];}
			else{$marron=0;$beige=0;$gris=0;}
			
			
			
			$sql = "UPDATE detail_commandes SET ";
			$sql .= "produit = '" . $produit . "', ";$sql .= "designation = '" . $designation . "', ";$sql .= "escompte = '" . $escompte . "', ";$sql .= "escompte2 = '" . $escompte2 . "', ";
			$sql .= "quantite = '" . $quantite . "', ";$sql .= "marron = '" . $marron . "', ";$sql .= "beige = '" . $beige . "', ";$sql .= "gris = '" . $gris . "', ";
			$sql .= "prix_unit = '" . $prix_unit . "', ";
			$sql .= "sans_remise = '" . $sans_remise . "', ";
			$sql .= "condit = '" . $condit . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			
						
						$sql = "DELETE FROM detail_commandes_pro WHERE produit='$produit' and commande = " . $numero . ";";
					db_query($database_name, $sql);$date_sortie=$user_["date_e"];

				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit' and date_fin>='$date_sortie' and base<=$quantite ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $numero . "', ";
							$sql .= "'" . $produit . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit . "');";
							db_query($database_name, $sql);
						} 
					}
				}

			break;
			
			case "delete_user":
			
		$sql  = "SELECT * ";
		$sql .= "FROM detail_commandes WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$numero = $user_["commande"];$produit = $user_["produit"];
		

			$sql = "DELETE FROM detail_commandes WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
						$sql = "DELETE FROM detail_commandes_pro WHERE produit='$produit' and commande = " . $numero . ";";
			db_query($database_name, $sql);

		$id = $numero;$id_c = $numero;
		$sql  = "SELECT * ";
		$sql .= "FROM commandes WHERE commande = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_e"]);$id_registre = $user_["id_registre"];$escompte = $user_["escompte"];
		$client = $user_["client"];$montant_f = $user_["net"];$controle = $user_["controle"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
			
			
			break;


		} //switch
		
	} //if
	else
	{
	
	$numero=$_GET['numero'];$client=$_GET['client'];
	$sql  = "SELECT * ";
			$sql .= "FROM clients WHERE client = '$client' ;";
			$user1 = db_query($database_name, $sql);
			$user_1 = fetch_array($user1);$ville = $user_1["ville"];$prix1 = $user_1["prix1"];$prix2 = $user_1["prix2"];$minimum = $user_1["minimum"];
			$sql  = "SELECT * ";
			$sql .= "FROM rs_data_villes WHERE ville = '$ville' ;";
			$user2 = db_query($database_name, $sql);
			$user_2 = fetch_array($user2);$region = $user_2["secteur"];
			
	
	
	$montant_f=0;$vendeur=$_GET['vendeur'];$id_c=$_GET['numero'];
	$id = $numero;
		$sql  = "SELECT * ";
		$sql .= "FROM commandes WHERE commande = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_e"]);$client = $user_["client"];$controle = $user_["controle"];$escompte = $user_["escompte"];$escompte2 = $user_["escompte2"];
		$client = $user_["client"];$montant_f = $user_["net"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];$minimum = $user_["plafond"];$encaiss = $user_["encaiss"];
	}
	$vide="";	
			$sql = "DELETE FROM detail_commandes WHERE produit = '" . $vide . "';";
			db_query($database_name, $sql);
	
?>
</table>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Commandes Clients"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "detail_facture_pro.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<table class="table2">
<td><?php echo $client;?></td><td><?php $montant1=number_format($montant_f,2,',',' ');
echo "Commandes Clients : ".$evaluation."---->Date : $date --->";?></td>
</table>
<tr>
<table class="table2">

<tr>
	<th><?php $total=0;echo "Ref";?></th>
	<th><?php $total=0;echo "Produit";?></th>
	<th><?php $total=0;echo "CodeBare";?></th>
	<th><?php echo "Quantité";?></th>
	<th><?php echo "Paquets";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Total";?></th>
</tr>

<?	
	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=0 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];$marron=$users1_["marron"];$beige=$users1_["beige"];$gris=$users1_["gris"];
//
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];$couleurs = $user_["couleurs"];$designation=$user_["designation"];$asswak=$user_["asswak"];
		$barecode_piece=$user_["barecode_piece"];$designation_client=$user_["designation_client"];
		$sql = "UPDATE detail_commandes SET ";
			/*if ($prix2==1){
			$sql .= "prix_unit = '" . $asswak . "', ";}*/
			
		
		$sql .= "designation = '" . $designation . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
		
		//$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		
		
		
		
		if ($favoris==0){$non_favoris=$non_favoris+$m;}
if ($controle==0){
echo "<td><a href=\"remplir_panier.php?numero=$numero&user_id=$id&client=$client&montant=$m\">$id</a></td>";
}else
{echo "<td>$id</td>";}
?>
<td><?php echo $produit; 

if ($couleurs==1){$cc= "   | M:".$marron."  B:".$beige."  G:".$gris;
$t_couleurs=$marron+$beige+$gris;if ($t_couleurs<>$users1_["quantite"]){
//print("<font size=\"2\" face=\"Comic sans MS\" color=\"#FF3300\">$cc</font>");
}
else
{
//print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000000\">$cc</font>");
}
}?></td>
<td align="center"><?php echo $barecode_piece; ?></td>
<td align="center"><?php echo $users1_["quantite"]; ?></td>
<td align="center"><?php echo $users1_["condit"]; ?></td>
<td align="right"><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<td align="right"><?php $total=$total+$m;echo number_format($m,2,',',' '); ?></td>
</tr>
<?	}?>

<?
if ($sans_remise==1){?>
<td></td><td></td><td></td><td></td><td></td>
<td>Net à payer</td>
<td align="right"><?php $t=$total;$net=$total;echo number_format($t,2,',',' '); ?></td>
<? } else {?>

<td></td><td></td><td></td><td></td><td></td>
<td>Total</td>
<td align="right"><?php $t=$total;echo number_format($t,2,',',' '); ?></td>
<? 		
		$remise_1=0;$remise_2=0;$remise_3=0;
?>
<tr>
<td></td>
<td></td>
<td></td><td></td><td></td>
<? if ($remise10>0){?>
<td><? echo 'Remise'.$remise10.' %';?></td>
<td align="right"><?php $remise_1=$total*$remise10/100; echo number_format($remise_1,2,',',' ');?></td>
</tr>
<tr>
<td></td>
<td></td>
<td></td><td></td><td></td>
<? }?>
<? if ($remise2>0){?>
<td><? if ($remise2==2){echo "Remise ".$remise2."%";}?></td>
<td align="right"><?php $remise_2=($total-$remise_1)*$remise2/100; echo number_format($remise_2,2,',',' ');?></td>
</tr>
<tr>
<td></td>
<td></td>
<td></td><td></td><td></td>
<? }?>
<? if ($remise3>0){?>
<td><? if ($remise3==2){echo "Remise ".$remise3."%";}else{echo "Remise ".$remise3."%";}?></td>
<td align="right"><?php $remise_3=($total-$remise_1-$remise_2)*$remise3/100; echo number_format($remise_3,2,',',' ');?></td>
</tr>
<? }?>
<tr>
<? if ($escompte>0 and $total>=$minimum){?>
<td></td>
<td></td>
<td></td><td></td><td></td><td><? echo "Escompte ".$escompte."%";?></td>
<td align="right"><?php $escompte_m=($total-$remise_1-$remise_2-$remise_3)*$escompte/100; echo number_format($escompte_m,2,',',' ');?></td>
</tr>
<? }?>
<? if ($escompte2>0 and $total>=$minimum){?>
<td></td>
<td></td>
<td></td><td></td><td></td><td><? echo "2eme Escompte ".$escompte2."%";?></td>
<td align="right"><?php $escompte_m2=($total-$remise_1-$remise_2-$remise_3-$escompte_m)*$escompte2/100; echo number_format($escompte_m2,2,',',' ');?></td>
</tr>
<? }?>
<tr>
<td></td>
<td></td>
<td></td><td></td><td></td>

<td>Net</td>
<td align="right"><?php $net=$total-$remise_1-$remise_2-$remise_3-$escompte_m-$escompte_m2; echo number_format($net,2,',',' ');?></td>

</tr>


<?	
	
	$sql1  = "SELECT * ";$total1=0;
	$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=1 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
//
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE ref = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		$barecode_piece=$user_["barecode_piece"];$designation_client=$user_["designation_client"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}
if ($controle==0){
echo "<tr><td><a href=\"remplir_panier.php?numero=$numero&user_id=$id&client=$client&montant=$m\">$id</a></td>";}else
{echo "<tr><td>$id</td>";}
?>
<td><?php echo $produit; ?></td>
<td><?php echo $barecode_piece; ?></td>
<td><?php echo $users1_["quantite"]; ?></td>
<td><?php echo $users1_["condit"]; ?></td>
<td><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<td><?php $total1=$total1+$m;echo number_format($m,2,',',' '); ?></td>
</tr>
<?	}?>

<tr>
<td></td>
<td></td>
<td></td><td></td><td></td>

<td>Net à payer</td>
<td align="right"><?php $net=$total+$total1-$remise_1-$remise_2-$remise_3-$escompte_m-$escompte_m2; echo number_format($net,2,',',' ');$esc_plafond=$escompte_m-$escompte_m2;?></td>
</tr>

<?
			$sql = "UPDATE commandes SET ";
			$sql .= "net = '" . $net . "', ";
			if ($encaiss){}else{
			$sql .= "reliquat = '" . $net . "', ";}
			$sql .= "esc_plafond = '" . $esc_plafond . "' ";
			$sql .= "WHERE commande = " . $id_c . ";";
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
<? 
/*if ($login=="admin"){echo "<td><a href=\"remplir_panier_ajax.php?numero=$numero&user_id=0&client=$client\">Ajout Article dans Evaluation</a></td>";
}else{*/
if ($controle==0){
echo "<td><a href=\"remplir_panier.php?numero=$numero&user_id=0&client=$client\">Ajout Article </a></td>";
}?>
</tr><tr>
<? $date1=dateFrToUs($date);echo "<td><a href=\"evaluations_client.php?vendeur=$vendeur&date=$date1\">Liste Commandes</a></td>";?>
</tr>
<tr>
<? $non_favoris_f= number_format($non_favoris,2,',',' ');$diff=$net-$montant_f;?>
</tr>

<tr><td><? $non_favoris=$non_favoris+$diff;$non_favoris_f= number_format($non_favoris,2,',',' ');
$m2=$montant_f-$net+$non_favoris;?></td></tr>
</table>
<tr>
<table class="table2">
<td> <? echo "Promotions :";?></td>
<tr>
<?
	
	$sqlp  = "SELECT * ";
	$sqlp .= "FROM detail_commandes where commande='$numero' ORDER BY produit;";
	$usersp = db_query($database_name, $sqlp);
	while($users_p = fetch_array($usersp)) { 
				$produit=$users_p["produit"];$quantite=$users_p["quantite"];$condit=$users_p["condit"];
				
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit' and date_fin>='$date_sortie' and base<=$quantite ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
					$base=$users11_pp["base"];
					$promotion=$users11_pp["promotion"];
					$date_pp=$users11_pp["date"];
				if ($base>0){$trouve=1;
				@$taux=intval($quantite/$base);
				$promotion=$promotion*$taux;
				?>
				<tr>
				<td><?php echo $produit; ?></td>
				<td><?php echo $promotion."  x  ".$condit; ?></td>
				</tr>
				<? } 
				}
				
				}
				
				
				
				}
				
				?>
			




<?	
	/*
	$sql1  = "SELECT * ";$total1=0;
	$sql1 .= "FROM detail_commandes_pro where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
 $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];

		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE ref = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}
	
	

<td><?php echo $produit; ?></td>
<td><?php echo $users1_["quantite"]."  x  ".$users1_["condit"]; ?></td>

</tr>
<?	}

*/

?>
</table>


<p style="text-align:center">


</body>

</html>