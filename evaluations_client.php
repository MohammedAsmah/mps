<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();	$user_name=GetUserName();
	$company="MPS";

	$error_message = "";$date="";$date_f="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;$escompte_exercice=0;
		$date="";$action="Recherche";	
	$profiles_list_vendeur = "";$vendeur="";
//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$user_login = $user_["login"];
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {$date = dateFrToUs($_REQUEST["date"]);$date_f = dateFrToUs($_REQUEST["date"]);
		
			
			// prepares data to simplify database insert or update
			$client = $_REQUEST["client"];$vendeur = $_REQUEST["vendeur"];$destination = $_REQUEST["destination"];
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
			if(isset($_REQUEST["bl"])) { $bl = 1; } else { $bl = 0; }
		$sql  = "SELECT * ";
		$sql .= "FROM clients WHERE client = '$client' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$remise10 = $user_["remise10"];
		$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];$secteur = $user_["ville"];$type_remise = $user_["type_remise"];$escompte = $user_["escompte"];
		$remise10_v = $user_["remise10_v"];$remise2_v = $user_["remise2_v"];$remise3_v = $user_["remise3_v"];$escompte2 = $user_["escompte2"];$plafond = $user_["minimum"];
		if ($remise10_v==0){$remise10=0;}
		if ($remise2_v==0){$remise2=0;}
		if ($remise3_v==0){$remise3=0;}
		
			
			}
		if($_REQUEST["action_"] == "update_user"){	
			$remise10 = $_REQUEST["remise10"];$remise2 = $_REQUEST["remise2"];$remise3 = $_REQUEST["remise3"];$destination = $_REQUEST["destination"];$escompte = $_REQUEST["escompte"];
			$client = $_REQUEST["client"];$vendeur = $_REQUEST["vendeur"];$bc = $_REQUEST["bc"];$piece = $_REQUEST["piece"];$encompte_client = $_REQUEST["encompte_client"];
			$encompte_avoir = $_REQUEST["encompte_avoir"];$votre_commande = $_REQUEST["votre_commande"];$notre_bl = $_REQUEST["notre_bl"];
			$numero_facture = $_REQUEST["numero_facture"];$date_facture = dateFrToUs($_REQUEST["date_facture"]);$en_lettres1 = $_REQUEST["en_lettres1"];$en_lettres2 = $_REQUEST["en_lettres2"];
					$remise10_v = $user_["remise10_v"];$remise2_v = $user_["remise2_v"];$remise3_v = $user_["remise3_v"];$escompte2 = $_REQUEST["escompte2"];$plafond = $_REQUEST["plafond"];
		if ($remise10_v==0){$remise10=0;}
		if ($remise2_v==0){$remise2=0;}
		if ($remise3_v==0){$remise3=0;}
		
			}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
				
				$date1 = dateFrToUs($_REQUEST["date1"]);$date2 = dateFrToUs($_REQUEST["date2"]);$date3 = dateFrToUs($_REQUEST["date3"]);
				$date4 = dateFrToUs($_REQUEST["date4"]);$date5 = dateFrToUs($_REQUEST["date5"]);
				$date6 = dateFrToUs($_REQUEST["date6"]);
				$date7 = dateFrToUs($_REQUEST["date7"]);
				$date8 = dateFrToUs($_REQUEST["date8"]);
				$date9 = dateFrToUs($_REQUEST["date9"]);
				$date10 = dateFrToUs($_REQUEST["date10"]);
				
				
				
				$client1 = $_REQUEST["client1"];$client2 = $_REQUEST["client2"];$client3 = $_REQUEST["client3"];$client4 = $_REQUEST["client4"];
				$client5 = $_REQUEST["client5"];$destination = $_REQUEST["destination"];
				$client6 = $_REQUEST["client6"];
				$client7 = $_REQUEST["client7"];
				$client8 = $_REQUEST["client8"];
				$client9 = $_REQUEST["client9"];
				$client10 = $_REQUEST["client10"];
				
				if(isset($_REQUEST["sans_remise1"])) { $sans_remise1 = 1; } else { $sans_remise1 = 0; }
				if(isset($_REQUEST["sans_remise2"])) { $sans_remise2 = 1; } else { $sans_remise2 = 0; }
				if(isset($_REQUEST["sans_remise3"])) { $sans_remise3 = 1; } else { $sans_remise3 = 0; }
				if(isset($_REQUEST["sans_remise4"])) { $sans_remise4 = 1; } else { $sans_remise4 = 0; }
				if(isset($_REQUEST["sans_remise5"])) { $sans_remise5 = 1; } else { $sans_remise5 = 0; }
				if(isset($_REQUEST["sans_remise6"])) { $sans_remise6 = 1; } else { $sans_remise6 = 0; }
				if(isset($_REQUEST["sans_remise7"])) { $sans_remise7 = 1; } else { $sans_remise7 = 0; }
				if(isset($_REQUEST["sans_remise8"])) { $sans_remise8 = 1; } else { $sans_remise8 = 0; }
				if(isset($_REQUEST["sans_remise9"])) { $sans_remise9 = 1; } else { $sans_remise9 = 0; }
				if(isset($_REQUEST["sans_remise10"])) { $sans_remise10 = 1; } else { $sans_remise10 = 0; }

				
				$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$dir = $row["commande"];
								
				$date = dateFrToUs($_REQUEST["date"]);
				list($annee1,$mois1,$jour1) = explode('-', $date); 
				$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
				$mois=date("M",$pdu);$annee=date("Y",$pdu);
				if ($mois=="May"){$mois1="MAI";}
				if ($mois=="Jun"){$mois1="JUIN";}
				if ($mois=="Jul"){$mois1="JUIL";}
				if ($mois=="Aug"){$mois1="AOUT";}
				if ($mois=="Sep"){$mois1="SEP";}
				if ($mois=="Oct"){$mois1="OCT";}
				if ($mois=="Nov"){$mois1="NOV";}
				if ($mois=="Dec"){$mois1="DEC";}
				if ($mois=="Jan"){$mois1="JAN";}
				if ($mois=="Feb"){$mois1="FEV";}
				if ($mois=="Mar"){$mois1="MARS";}
				if ($mois=="Apr"){$mois1="AVRIL";}
				$result = mysql_query("SELECT eval FROM commandes where (mois='$mois1' and annee='$annee') ORDER BY eval DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$dir_eval = $row["eval"]+1;
				if ($dir_eval<10){$dev="00".$dir_eval;}
				if ($dir_eval>9 and $dir_eval<100) {$dev="0".$dir_eval;}
				if ($dir_eval>=100){$dev=$dir_eval;}
				$encours=$mois1." ".$dev;$cde=$dir+1;$encours="encours";
				$sql  = "INSERT INTO commandes ( commande,date_e,client,secteur,company, type_remise,escompte,escompte2,plafond,vendeur, remise_10,remise_2,remise_3,evaluation,destination,sans_remise ) VALUES ( ";
				$sql .= "'" . $cde . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $client . "', ";$sql .= "'" . $secteur . "', ";$sql .= "'" . $company . "', ";
				$sql .= "'" . $type_remise . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";$sql .= "'" . $plafond . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $remise10 . "', ";
				$sql .= "'" . $remise2 . "', ";
				$sql .= "'" . $remise3 . "', ";
				$sql .= "'" . $encours . "', ";
				$sql .= "'" . $destination . "', ";
				$sql .= "'" . $sans_remise . "');";

				db_query($database_name, $sql);
		
				if ($client1<>""){
						$sql  = "SELECT * ";
						$sql .= "FROM clients WHERE client = '$client1' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$remise10 = $user_["remise10"];
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];$secteur1 = $user_["ville"];$type_remise1 = $user_["type_remise"];$escompte1 = $user_["escompte"];
						$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); $escompte1_2 = $user_["escompte2"];$plafond1 = $user_["plafond"];
						$row = mysql_fetch_array($result); 
						$dir = $row["commande"];
				$date = dateFrToUs($_REQUEST["date1"]);
				list($annee1,$mois1,$jour1) = explode('-', $date); 
				$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
				$mois=date("M",$pdu);$annee=date("Y",$pdu);
				if ($mois=="May"){$mois1="MAI";}
				if ($mois=="Jun"){$mois1="JUIN";}
				if ($mois=="Jul"){$mois1="JUIL";}
				if ($mois=="Aug"){$mois1="AOUT";}
				if ($mois=="Sep"){$mois1="SEP";}
				if ($mois=="Oct"){$mois1="OCT";}
				if ($mois=="Nov"){$mois1="NOV";}
				if ($mois=="Dec"){$mois1="DEC";}
				if ($mois=="Jan"){$mois1="JAN";}
				if ($mois=="Feb"){$mois1="FEV";}
				if ($mois=="Mar"){$mois1="MARS";}
				if ($mois=="Apr"){$mois1="AVRIL";}

				$result = mysql_query("SELECT eval FROM commandes where (mois='$mois1' and annee='$annee') ORDER BY eval DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$dir_eval = $row["eval"]+1;
				if ($dir_eval<10){$dev="00".$dir_eval;}
				if ($dir_eval>9 and $dir_eval<100) {$dev="0".$dir_eval;}
				if ($dir_eval>=100){$dev=$dir_eval;}
				$encours=$mois1." ".$dev;$cde=$dir+1;$encours="encours";
				$sql  = "INSERT INTO commandes ( commande,date_e,client,secteur, company,vendeur, remise_10,remise_2,remise_3,escompte,escompte2,plafond,evaluation,destination,sans_remise ) VALUES ( ";
						$sql .= "'" . $cde . "', ";
						$sql .= "'" . $date1 . "', ";
						$sql .= "'" . $client1 . "', ";$sql .= "'" . $secteur1 . "', ";$sql .= "'" . $company . "', ";
						$sql .= "'" . $vendeur . "', ";
						$sql .= "'" . $remise10 . "', ";
						$sql .= "'" . $remise2 . "', ";
						$sql .= "'" . $remise3 . "', ";$sql .= "'" . $escompte1 . "', ";$sql .= "'" . $escompte1_2 . "', ";$sql .= "'" . $plafond1 . "', ";
						$sql .= "'" . $encours . "', ";				$sql .= "'" . $destination . "', ";

						$sql .= "'" . $sans_remise1 . "');";
						db_query($database_name, $sql);
		
				}
				if ($client2<>""){
						$sql  = "SELECT * ";
						$sql .= "FROM clients WHERE client = '$client2' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$remise10 = $user_["remise10"];
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];$secteur2 = $user_["ville"];$type_remise2 = $user_["type_remise"];$escompte2 = $user_["escompte"];
						$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); $escompte2_2 = $user_["escompte2"];$plafond2 = $user_["plafond"];
						$row = mysql_fetch_array($result); 
						$dir = $row["commande"];
				$date = dateFrToUs($_REQUEST["date2"]);
				list($annee1,$mois1,$jour1) = explode('-', $date); 
				$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
				$mois=date("M",$pdu);$annee=date("Y",$pdu);
				if ($mois=="May"){$mois1="MAI";}
				if ($mois=="Jun"){$mois1="JUIN";}
				if ($mois=="Jul"){$mois1="JUIL";}
				if ($mois=="Aug"){$mois1="AOUT";}
				if ($mois=="Sep"){$mois1="SEP";}
				if ($mois=="Oct"){$mois1="OCT";}
				if ($mois=="Nov"){$mois1="NOV";}
				if ($mois=="Dec"){$mois1="DEC";}
				if ($mois=="Jan"){$mois1="JAN";}
				if ($mois=="Feb"){$mois1="FEV";}
				if ($mois=="Mar"){$mois1="MARS";}
				if ($mois=="Apr"){$mois1="AVRIL";}
				$result = mysql_query("SELECT eval FROM commandes where (mois='$mois1' and annee='$annee') ORDER BY eval DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$dir_eval = $row["eval"]+1;
				if ($dir_eval<10){$dev="00".$dir_eval;}
				if ($dir_eval>9 and $dir_eval<100) {$dev="0".$dir_eval;}
				if ($dir_eval>=100){$dev=$dir_eval;}
				$encours=$mois1." ".$dev;$cde=$dir+1;$encours="encours";
				$sql  = "INSERT INTO commandes ( commande,date_e,client,secteur, company,vendeur, remise_10,remise_2,remise_3,escompte,escompte2,plafond,evaluation,destination,sans_remise ) VALUES ( ";
						$sql .= "'" . $cde . "', ";
						$sql .= "'" . $date2 . "', ";
						$sql .= "'" . $client2 . "', ";$sql .= "'" . $secteur2 . "', ";$sql .= "'" . $company . "', ";
						$sql .= "'" . $vendeur . "', ";
						$sql .= "'" . $remise10 . "', ";
						$sql .= "'" . $remise2 . "', ";
						$sql .= "'" . $remise3 . "', ";$sql .= "'" . $escompte2 . "', ";$sql .= "'" . $escompte2_2 . "', ";$sql .= "'" . $plafond2 . "', ";
						$sql .= "'" . $encours . "', ";				$sql .= "'" . $destination . "', ";

						$sql .= "'" . $sans_remise2 . "');";
						db_query($database_name, $sql);
		
				}
				if ($client3<>""){
						$sql  = "SELECT * ";
						$sql .= "FROM clients WHERE client = '$client3' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$remise10 = $user_["remise10"];
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];$secteur3 = $user_["ville"];$type_remise3 = $user_["type_remise"];$escompte3 = $user_["escompte"];
						$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); $escompte3_2 = $user_["escompte2"];$plafond3 = $user_["plafond"];
						$row = mysql_fetch_array($result); 
						$dir = $row["commande"];
				$date = dateFrToUs($_REQUEST["date3"]);
				list($annee1,$mois1,$jour1) = explode('-', $date); 
				$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
				$mois=date("M",$pdu);$annee=date("Y",$pdu);
				if ($mois=="May"){$mois1="MAI";}
				if ($mois=="Jun"){$mois1="JUIN";}
				if ($mois=="Jul"){$mois1="JUIL";}
				if ($mois=="Aug"){$mois1="AOUT";}
				if ($mois=="Sep"){$mois1="SEP";}
				if ($mois=="Oct"){$mois1="OCT";}
				if ($mois=="Nov"){$mois1="NOV";}
				if ($mois=="Dec"){$mois1="DEC";}
				if ($mois=="Jan"){$mois1="JAN";}
				if ($mois=="Feb"){$mois1="FEV";}
				if ($mois=="Mar"){$mois1="MARS";}
				if ($mois=="Apr"){$mois1="AVRIL";}
				$result = mysql_query("SELECT eval FROM commandes where (mois='$mois1' and annee='$annee') ORDER BY eval DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$dir_eval = $row["eval"]+1;
				if ($dir_eval<10){$dev="00".$dir_eval;}
				if ($dir_eval>9 and $dir_eval<100) {$dev="0".$dir_eval;}
				if ($dir_eval>=100){$dev=$dir_eval;}
				$encours=$mois1." ".$dev;$cde=$dir+1;$encours="encours";
				$sql  = "INSERT INTO commandes ( commande,date_e,client,secteur,company, vendeur, remise_10,remise_2,remise_3,escompte,escompte2,plafond,evaluation,destination,sans_remise ) VALUES ( ";
						$sql .= "'" . $cde . "', ";
						$sql .= "'" . $date3 . "', ";
						$sql .= "'" . $client3 . "', ";$sql .= "'" . $secteur3 . "', ";$sql .= "'" . $company . "', ";
						$sql .= "'" . $vendeur . "', ";
						$sql .= "'" . $remise10 . "', ";
						$sql .= "'" . $remise2 . "', ";
						$sql .= "'" . $remise3 . "', ";$sql .= "'" . $escompte3 . "', ";$sql .= "'" . $escompte3_2 . "', ";$sql .= "'" . $plafond3 . "', ";
						$sql .= "'" . $encours . "', ";				$sql .= "'" . $destination . "', ";

						$sql .= "'" . $sans_remise3 . "');";
						db_query($database_name, $sql);
		
				}
				if ($client4<>""){
						$sql  = "SELECT * ";
						$sql .= "FROM clients WHERE client = '$client4' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$remise10 = $user_["remise10"];
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];$secteur4 = $user_["ville"];$type_remise4 = $user_["type_remise"];$escompte4 = $user_["escompte"];
						$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); $escompte4_2 = $user_["escompte2"];$plafond4 = $user_["plafond"];
						$row = mysql_fetch_array($result); 
						$dir = $row["commande"];
				$date = dateFrToUs($_REQUEST["date4"]);
				list($annee1,$mois1,$jour1) = explode('-', $date); 
				$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
				$mois=date("M",$pdu);$annee=date("Y",$pdu);
				if ($mois=="May"){$mois1="MAI";}
				if ($mois=="Jun"){$mois1="JUIN";}
				if ($mois=="Jul"){$mois1="JUIL";}
				if ($mois=="Aug"){$mois1="AOUT";}
				if ($mois=="Sep"){$mois1="SEP";}
				if ($mois=="Oct"){$mois1="OCT";}
				if ($mois=="Nov"){$mois1="NOV";}
				if ($mois=="Dec"){$mois1="DEC";}
				if ($mois=="Jan"){$mois1="JAN";}
				if ($mois=="Feb"){$mois1="FEV";}
				if ($mois=="Mar"){$mois1="MARS";}
				if ($mois=="Apr"){$mois1="AVRIL";}
				$result = mysql_query("SELECT eval FROM commandes where (mois='$mois1' and annee='$annee') ORDER BY eval DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$dir_eval = $row["eval"]+1;
				if ($dir_eval<10){$dev="00".$dir_eval;}
				if ($dir_eval>9 and $dir_eval<100) {$dev="0".$dir_eval;}
				if ($dir_eval>=100){$dev=$dir_eval;}
				$encours=$mois1." ".$dev;$cde=$dir+1;$encours="encours";
				$sql  = "INSERT INTO commandes ( commande,date_e,client,secteur,company, vendeur, remise_10,remise_2,remise_3,escompte,escompte2,plafond,evaluation,destination,sans_remise ) VALUES ( ";
						$sql .= "'" . $cde . "', ";
						$sql .= "'" . $date4 . "', ";
						$sql .= "'" . $client4 . "', ";$sql .= "'" . $secteur4 . "', ";$sql .= "'" . $company . "', ";
						$sql .= "'" . $vendeur . "', ";
						$sql .= "'" . $remise10 . "', ";
						$sql .= "'" . $remise2 . "', ";
						$sql .= "'" . $remise3 . "', ";$sql .= "'" . $escompte4 . "', ";$sql .= "'" . $escompte4_2 . "', ";$sql .= "'" . $plafond4 . "', ";
						$sql .= "'" . $encours . "', ";				$sql .= "'" . $destination . "', ";

						$sql .= "'" . $sans_remise4 . "');";
						db_query($database_name, $sql);
		
				}
				if ($client5<>""){
						$sql  = "SELECT * ";
						$sql .= "FROM clients WHERE client = '$client5' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$remise10 = $user_["remise10"];
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];$secteur5 = $user_["ville"];$type_remise5 = $user_["type_remise"];$escompte5 = $user_["escompte"];
						$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); $escompte5_2 = $user_["escompte2"];$plafond5 = $user_["plafond"];
						$row = mysql_fetch_array($result); 
						$dir = $row["commande"];
				$date = dateFrToUs($_REQUEST["date5"]);
				list($annee1,$mois1,$jour1) = explode('-', $date); 
				$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
				$mois=date("M",$pdu);$annee=date("Y",$pdu);
				if ($mois=="May"){$mois1="MAI";}
				if ($mois=="Jun"){$mois1="JUIN";}
				if ($mois=="Jul"){$mois1="JUIL";}
				if ($mois=="Aug"){$mois1="AOUT";}
				if ($mois=="Sep"){$mois1="SEP";}
				if ($mois=="Oct"){$mois1="OCT";}
				if ($mois=="Nov"){$mois1="NOV";}
				if ($mois=="Dec"){$mois1="DEC";}
				if ($mois=="Jan"){$mois1="JAN";}
				if ($mois=="Feb"){$mois1="FEV";}
				if ($mois=="Mar"){$mois1="MARS";}
				if ($mois=="Apr"){$mois1="AVRIL";}
				$result = mysql_query("SELECT eval FROM commandes where (mois='$mois1' and annee='$annee') ORDER BY eval DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$dir_eval = $row["eval"]+1;
				if ($dir_eval<10){$dev="00".$dir_eval;}
				if ($dir_eval>9 and $dir_eval<100) {$dev="0".$dir_eval;}
				if ($dir_eval>=100){$dev=$dir_eval;}
				$encours=$mois1." ".$dev;$cde=$dir+1;$encours="encours";
				$sql  = "INSERT INTO commandes ( commande,date_e,client,secteur,company, vendeur, remise_10,remise_2,remise_3,escompte,escompte2,plafond,evaluation,destination,sans_remise ) VALUES ( ";
						$sql .= "'" . $cde . "', ";
						$sql .= "'" . $date5 . "', ";
						$sql .= "'" . $client5 . "', ";$sql .= "'" . $secteur5 . "', ";$sql .= "'" . $company . "', ";
						$sql .= "'" . $vendeur . "', ";
						$sql .= "'" . $remise10 . "', ";
						$sql .= "'" . $remise2 . "', ";
						$sql .= "'" . $remise3 . "', ";$sql .= "'" . $escompte5 . "', ";$sql .= "'" . $escompte5_2 . "', ";$sql .= "'" . $plafond5 . "', ";
						$sql .= "'" . $encours . "', ";				$sql .= "'" . $destination . "', ";

						$sql .= "'" . $sans_remise5 . "');";
						db_query($database_name, $sql);
		
				}
				if ($client6<>""){
						$sql  = "SELECT * ";
						$sql .= "FROM clients WHERE client = '$client6' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$remise10 = $user_["remise10"];
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];$secteur6 = $user_["ville"];$type_remise6 = $user_["type_remise"];$escompte6 = $user_["escompte"];
						$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); $escompte6_2 = $user_["escompte2"];$plafond6 = $user_["plafond"];
						$row = mysql_fetch_array($result); 
						$dir = $row["commande"];
				$date = dateFrToUs($_REQUEST["date6"]);
				list($annee1,$mois1,$jour1) = explode('-', $date); 
				$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
				$mois=date("M",$pdu);$annee=date("Y",$pdu);
				if ($mois=="May"){$mois1="MAI";}
				if ($mois=="Jun"){$mois1="JUIN";}
				if ($mois=="Jul"){$mois1="JUIL";}
				if ($mois=="Aug"){$mois1="AOUT";}
				if ($mois=="Sep"){$mois1="SEP";}
				if ($mois=="Oct"){$mois1="OCT";}
				if ($mois=="Nov"){$mois1="NOV";}
				if ($mois=="Dec"){$mois1="DEC";}
				if ($mois=="Jan"){$mois1="JAN";}
				if ($mois=="Feb"){$mois1="FEV";}
				if ($mois=="Mar"){$mois1="MARS";}
				if ($mois=="Apr"){$mois1="AVRIL";}
				$result = mysql_query("SELECT eval FROM commandes where (mois='$mois1' and annee='$annee') ORDER BY eval DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$dir_eval = $row["eval"]+1;
				if ($dir_eval<10){$dev="00".$dir_eval;}
				if ($dir_eval>9 and $dir_eval<100) {$dev="0".$dir_eval;}
				if ($dir_eval>=100){$dev=$dir_eval;}
				$encours=$mois1." ".$dev;$cde=$dir+1;$encours="encours";
				$sql  = "INSERT INTO commandes ( commande,date_e,client,secteur, company,vendeur, remise_10,remise_2,remise_3,escompte,escompte2,plafond,evaluation,destination,sans_remise ) VALUES ( ";
						$sql .= "'" . $cde . "', ";
						$sql .= "'" . $date6 . "', ";
						$sql .= "'" . $client6 . "', ";$sql .= "'" . $secteur6 . "', ";$sql .= "'" . $company . "', ";
						$sql .= "'" . $vendeur . "', ";
						$sql .= "'" . $remise10 . "', ";
						$sql .= "'" . $remise2 . "', ";
						$sql .= "'" . $remise3 . "', ";$sql .= "'" . $escompte6 . "', ";$sql .= "'" . $escompte6_2 . "', ";$sql .= "'" . $plafond6 . "', ";
						$sql .= "'" . $encours . "', ";				$sql .= "'" . $destination . "', ";

						$sql .= "'" . $sans_remise6 . "');";
						db_query($database_name, $sql);
		
				}
				if ($client7<>""){
						$sql  = "SELECT * ";
						$sql .= "FROM clients WHERE client = '$client7' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$remise10 = $user_["remise10"];
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];$secteur7 = $user_["ville"];$type_remise7 = $user_["type_remise"];$escompte7 = $user_["escompte"];
						$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); $escompte7_2 = $user_["escompte2"];$plafond7 = $user_["plafond"];
						$row = mysql_fetch_array($result); 
						$dir = $row["commande"];
				$date = dateFrToUs($_REQUEST["date7"]);
				list($annee1,$mois1,$jour1) = explode('-', $date); 
				$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
				$mois=date("M",$pdu);$annee=date("Y",$pdu);
				if ($mois=="May"){$mois1="MAI";}
				if ($mois=="Jun"){$mois1="JUIN";}
				if ($mois=="Jul"){$mois1="JUIL";}
				if ($mois=="Aug"){$mois1="AOUT";}
				if ($mois=="Sep"){$mois1="SEP";}
				if ($mois=="Oct"){$mois1="OCT";}
				if ($mois=="Nov"){$mois1="NOV";}
				if ($mois=="Dec"){$mois1="DEC";}
				if ($mois=="Jan"){$mois1="JAN";}
				if ($mois=="Feb"){$mois1="FEV";}
				if ($mois=="Mar"){$mois1="MARS";}
				if ($mois=="Apr"){$mois1="AVRIL";}
				$result = mysql_query("SELECT eval FROM commandes where (mois='$mois1' and annee='$annee') ORDER BY eval DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$dir_eval = $row["eval"]+1;
				if ($dir_eval<10){$dev="00".$dir_eval;}
				if ($dir_eval>9 and $dir_eval<100) {$dev="0".$dir_eval;}
				if ($dir_eval>=100){$dev=$dir_eval;}
				$encours=$mois1." ".$dev;$cde=$dir+1;$encours="encours";
				$sql  = "INSERT INTO commandes ( commande,date_e,client,secteur,company, vendeur, remise_10,remise_2,remise_3,escompte,escompte2,plafond,evaluation,destination,sans_remise ) VALUES ( ";
						$sql .= "'" . $cde . "', ";
						$sql .= "'" . $date7 . "', ";
						$sql .= "'" . $client7 . "', ";$sql .= "'" . $secteur7 . "', ";$sql .= "'" . $company . "', ";
						$sql .= "'" . $vendeur . "', ";
						$sql .= "'" . $remise10 . "', ";
						$sql .= "'" . $remise2 . "', ";
						$sql .= "'" . $remise3 . "', ";$sql .= "'" . $escompte7 . "', ";$sql .= "'" . $escompte7_2 . "', ";$sql .= "'" . $plafond7 . "', ";
						$sql .= "'" . $encours . "', ";				$sql .= "'" . $destination . "', ";

						$sql .= "'" . $sans_remise7 . "');";
						db_query($database_name, $sql);
		
				}
				if ($client8<>""){
						$sql  = "SELECT * ";
						$sql .= "FROM clients WHERE client = '$client8' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$remise10 = $user_["remise10"];
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];$secteur8 = $user_["ville"];$type_remise8 = $user_["type_remise"];$escompte8 = $user_["escompte"];
						$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); $escompte8_2 = $user_["escompte2"];$plafond8 = $user_["plafond"];
						$row = mysql_fetch_array($result); 
						$dir = $row["commande"];
				$date = dateFrToUs($_REQUEST["date8"]);
				list($annee1,$mois1,$jour1) = explode('-', $date); 
				$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
				$mois=date("M",$pdu);$annee=date("Y",$pdu);
				if ($mois=="May"){$mois1="MAI";}
				if ($mois=="Jun"){$mois1="JUIN";}
				if ($mois=="Jul"){$mois1="JUIL";}
				if ($mois=="Aug"){$mois1="AOUT";}
				if ($mois=="Sep"){$mois1="SEP";}
				if ($mois=="Oct"){$mois1="OCT";}
				if ($mois=="Nov"){$mois1="NOV";}
				if ($mois=="Dec"){$mois1="DEC";}
				if ($mois=="Jan"){$mois1="JAN";}
				if ($mois=="Feb"){$mois1="FEV";}
				if ($mois=="Mar"){$mois1="MARS";}
				if ($mois=="Apr"){$mois1="AVRIL";}
				$result = mysql_query("SELECT eval FROM commandes where (mois='$mois1' and annee='$annee') ORDER BY eval DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$dir_eval = $row["eval"]+1;
				if ($dir_eval<10){$dev="00".$dir_eval;}
				if ($dir_eval>9 and $dir_eval<100) {$dev="0".$dir_eval;}
				if ($dir_eval>=100){$dev=$dir_eval;}
				$encours=$mois1." ".$dev;$cde=$dir+1;$encours="encours";
				$sql  = "INSERT INTO commandes ( commande,date_e,client,secteur, company,vendeur, remise_10,remise_2,remise_3,escompte,escompte2,plafond,evaluation,destination,sans_remise ) VALUES ( ";
						$sql .= "'" . $cde . "', ";
						$sql .= "'" . $date8 . "', ";
						$sql .= "'" . $client8 . "', ";$sql .= "'" . $secteur8 . "', ";$sql .= "'" . $company . "', ";
						$sql .= "'" . $vendeur . "', ";
						$sql .= "'" . $remise10 . "', ";
						$sql .= "'" . $remise2 . "', ";
						$sql .= "'" . $remise3 . "', ";$sql .= "'" . $escompte8 . "', ";$sql .= "'" . $escompte8_2 . "', ";$sql .= "'" . $plafond8 . "', ";
						$sql .= "'" . $encours . "', ";				$sql .= "'" . $destination . "', ";

						$sql .= "'" . $sans_remise8 . "');";
						db_query($database_name, $sql);
		
				}
				if ($client9<>""){
						$sql  = "SELECT * ";
						$sql .= "FROM clients WHERE client = '$client9' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$remise10 = $user_["remise10"];
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];$secteur9 = $user_["ville"];$type_remise9 = $user_["type_remise"];$escompte9 = $user_["escompte"];
						$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); $escompte9_2 = $user_["escompte2"];$plafond9 = $user_["plafond"];
						$row = mysql_fetch_array($result); 
						$dir = $row["commande"];
				$date = dateFrToUs($_REQUEST["date9"]);
				list($annee1,$mois1,$jour1) = explode('-', $date); 
				$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
				$mois=date("M",$pdu);$annee=date("Y",$pdu);
				if ($mois=="May"){$mois1="MAI";}
				if ($mois=="Jun"){$mois1="JUIN";}
				if ($mois=="Jul"){$mois1="JUIL";}
				if ($mois=="Aug"){$mois1="AOUT";}
				if ($mois=="Sep"){$mois1="SEP";}
				if ($mois=="Oct"){$mois1="OCT";}
				if ($mois=="Nov"){$mois1="NOV";}
				if ($mois=="Dec"){$mois1="DEC";}
				if ($mois=="Jan"){$mois1="JAN";}
				if ($mois=="Feb"){$mois1="FEV";}
				if ($mois=="Mar"){$mois1="MARS";}
				if ($mois=="Apr"){$mois1="AVRIL";}
				$result = mysql_query("SELECT eval FROM commandes where (mois='$mois1' and annee='$annee') ORDER BY eval DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$dir_eval = $row["eval"]+1;
				if ($dir_eval<10){$dev="00".$dir_eval;}
				if ($dir_eval>9 and $dir_eval<100) {$dev="0".$dir_eval;}
				if ($dir_eval>=100){$dev=$dir_eval;}
				$encours=$mois1." ".$dev;$cde=$dir+1;$encours="encours";
				$sql  = "INSERT INTO commandes ( commande,date_e,client,secteur, company,vendeur, remise_10,remise_2,remise_3,escompte,escompte2,plafond,evaluation,destination,sans_remise ) VALUES ( ";
						$sql .= "'" . $cde . "', ";
						$sql .= "'" . $date9 . "', ";
						$sql .= "'" . $client9 . "', ";$sql .= "'" . $secteur9 . "', ";$sql .= "'" . $company . "', ";
						$sql .= "'" . $vendeur . "', ";
						$sql .= "'" . $remise10 . "', ";
						$sql .= "'" . $remise2 . "', ";
						$sql .= "'" . $remise3 . "', ";$sql .= "'" . $escompte9 . "', ";$sql .= "'" . $escompte9_2 . "', ";$sql .= "'" . $plafond9 . "', ";
						$sql .= "'" . $encours . "', ";				$sql .= "'" . $destination . "', ";

						$sql .= "'" . $sans_remise9 . "');";
						db_query($database_name, $sql);
		
				}
				if ($client10<>""){
						$sql  = "SELECT * ";
						$sql .= "FROM clients WHERE client = '$client10' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$remise10 = $user_["remise10"];
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];$secteur10 = $user_["ville"];$type_remise10 = $user_["type_remise"];$escompte10 = $user_["escompte"];
						$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); $escompte10_2 = $user_["escompte"];$plafond10 = $user_["plafond"];
						$row = mysql_fetch_array($result); 
						$dir = $row["commande"];
				$date = dateFrToUs($_REQUEST["date10"]);
				list($annee1,$mois1,$jour1) = explode('-', $date); 
				$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
				$mois=date("M",$pdu);$annee=date("Y",$pdu);
				if ($mois=="May"){$mois1="MAI";}
				if ($mois=="Jun"){$mois1="JUIN";}
				if ($mois=="Jul"){$mois1="JUIL";}
				if ($mois=="Aug"){$mois1="AOUT";}
				if ($mois=="Sep"){$mois1="SEP";}
				if ($mois=="Oct"){$mois1="OCT";}
				if ($mois=="Nov"){$mois1="NOV";}
				if ($mois=="Dec"){$mois1="DEC";}
				if ($mois=="Jan"){$mois1="JAN";}
				if ($mois=="Feb"){$mois1="FEV";}
				if ($mois=="Mar"){$mois1="MARS";}
				if ($mois=="Apr"){$mois1="AVRIL";}
				$result = mysql_query("SELECT eval FROM commandes where (mois='$mois1' and annee='$annee') ORDER BY eval DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$dir_eval = $row["eval"]+1;
				if ($dir_eval<10){$dev="00".$dir_eval;}
				if ($dir_eval>9 and $dir_eval<100) {$dev="0".$dir_eval;}
				if ($dir_eval>=100){$dev=$dir_eval;}
				$encours=$mois1." ".$dev;$cde=$dir+1;$encours="encours";
				$sql  = "INSERT INTO commandes ( commande,date_e,client,secteur,company, vendeur, remise_10,remise_2,remise_3,escompte,escompte2,plafond,evaluation,destination,sans_remise ) VALUES ( ";
						$sql .= "'" . $cde . "', ";
						$sql .= "'" . $date10 . "', ";
						$sql .= "'" . $client10 . "', ";$sql .= "'" . $secteur10 . "', ";$sql .= "'" . $company . "', ";
						$sql .= "'" . $vendeur . "', ";
						$sql .= "'" . $remise10 . "', ";
						$sql .= "'" . $remise2 . "', ";
						$sql .= "'" . $remise3 . "', ";$sql .= "'" . $escompte10 . "', ";$sql .= "'" . $escompte10_2 . "', ";$sql .= "'" . $plafond10 . "', ";
						$sql .= "'" . $encours . "', ";				$sql .= "'" . $destination . "', ";

						$sql .= "'" . $sans_remise10 . "');";
						db_query($database_name, $sql);
		
				}
		
		//retour à liste triée par date
		$date=$_POST['date'];$vendeur=$_POST['vendeur'];$action="recherche";$destination=$_POST['destination'];
					

			break;

			case "update_user":
			
			if(isset($_REQUEST["escompte_exercice"])) { $escompte_exercice = 1; } else { $escompte_exercice = 0; }
			
			
			if(isset($_REQUEST["ev_pre"])) { $ev_pre = 1; } else { $ev_pre = 0; }
						if(isset($_REQUEST["piece"])) { $piece = 1; } else { $piece = 0; }
			
			//insertion  BL
			if($bl==1) { 	$commande=$_REQUEST["user_id"];	
			$sql  = "INSERT INTO bons_livraisons ( commande,date_e,client,secteur, vendeur, remise_10,remise_2,remise_3,evaluation,destination,sans_remise ) VALUES ( ";
						$sql .= "'" . $commande . "', ";
						
						$sql .= "'" . $date . "', ";
						$sql .= "'" . $client . "', ";
						$sql .= "'" . $secteur . "', ";
						$sql .= "'" . $vendeur . "', ";
						$sql .= "'" . $remise10 . "', ";
						$sql .= "'" . $remise2 . "', ";
						$sql .= "'" . $remise3 . "', ";
						$sql .= "'" . $encours . "', ";
						$sql .= "'" . $destination . "', ";
						$sql .= "'" . $sans_remise . "');";
						db_query($database_name, $sql); 
						$id_registre=mysql_insert_id();
						$numero_bl=0;
						$numero_bl=$id_registre+663;
						$sql = "UPDATE bons_livraisons SET ";
			$sql .= "numero_bl = '" . $numero_bl . "' ";
			$sql .= "WHERE id = " . $id_registre . ";";
			db_query($database_name, $sql);
						}	
			
			
			
			$net = $_REQUEST["net"];if(isset($_REQUEST["active"])) {$active = $_REQUEST["active"];}
				$date = dateFrToUs($_REQUEST["date"]);$evaluation = $_REQUEST["evaluation"];
				list($annee1,$mois1,$jour1) = explode('-', $date); 
				$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
				$mois=date("M",$pdu);$annee=date("Y",$pdu);
				if ($mois=="May"){$mois1="MAI";}
				if ($mois=="Jun"){$mois1="JUIN";}
				if ($mois=="Jul"){$mois1="JUIL";}
				if ($mois=="Aug"){$mois1="AOUT";}
				if ($mois=="Sep"){$mois1="SEP";}
				if ($mois=="Oct"){$mois1="OCT";}
				if ($mois=="Nov"){$mois1="NOV";}
				if ($mois=="Dec"){$mois1="DEC";}
				if ($mois=="Jan"){$mois1="JAN";}
				if ($mois=="Feb"){$mois1="FEV";}
				if ($mois=="Mar"){$mois1="MARS";}
				if ($mois=="Apr"){$mois1="AVRIL";}
				$result = mysql_query("SELECT eval FROM commandes where (mois='$mois1' and annee='$annee') and active=1 ORDER BY eval DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$dir_eval = $row["eval"]+1;
				if ($dir_eval<10){$dev="00".$dir_eval;}
				if ($dir_eval>9 and $dir_eval<100) {$dev="0".$dir_eval;}
				if ($dir_eval>=100){$dev=$dir_eval;}
				
						$active=0;
						if(isset($_REQUEST["active"])) { $active = 1;$encours=$mois1." ".$dev; } 
						else { $active = 0; $encours=$evaluation;}
			$sql = "UPDATE commandes SET ";
			$sql .= "client = '" . $client . "', ";
			$sql .= "secteur = '" . $secteur . "', ";
			$sql .= "type_remise = '" . $type_remise . "', ";
			$sql .= "votre_commande = '" . $votre_commande . "', ";
			$sql .= "numero_facture = '" . $numero_facture . "', ";
			$sql .= "notre_bl = '" . $notre_bl . "', ";
			$sql .= "date_facture = '" . $date_facture . "', ";
			$sql .= "en_lettres1 = '" . $en_lettres1 . "', ";
			$sql .= "en_lettres2 = '" . $en_lettres2 . "', ";
			$sql .= "date_e = '" . $date . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			$sql .= "evaluation = '" . $encours . "', ";
			if($user_login=="admin" or $user_login=="rakia")
			{$sql .= "escompte_exercice = '" . $escompte_exercice . "', ";$sql .= "escompte = '" . $escompte . "', ";$sql .= "escompte2 = '" . $escompte2 . "', ";$sql .= "plafond = '" . $plafond . "', ";}
			$sql .= "eval = '" . $dir_eval . "', ";
			$sql .= "mois = '" . $mois1 . "', ";
			$sql .= "annee = '" . $annee . "', ";
			$sql .= "active = '" . $active . "', ";
			$sql .= "remise_10 = '" . $remise10 . "', ";
			$sql .= "remise_2 = '" . $remise2 . "', ";
			$sql .= "remise_3 = '" . $remise3 . "', ";
			if($user_login=="admin" ){$sql .= "encompte_client = '" . $encompte_client . "', ";$sql .= "encompte_avoir = '" . $encompte_avoir . "', ";}
			$sql .= "net = '" . $net . "', ";
			$encaiss = $_REQUEST["encaiss"];
			if ($encaiss){}else{
			$sql .= "reliquat = '" . $net . "', ";}
			
			$sql .= "ev_pre = '" . $ev_pre . "', ";
			$sql .= "piece = '" . $piece . "', ";
			$sql .= "bl = '" . $bl . "', ";
			$sql .= "bc = '" . $numero_bl . "', ";
			$sql .= "sans_remise = '" . $sans_remise . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			$sql  = "SELECT * ";
			$sql .= "FROM commandes WHERE id = " . $_REQUEST["user_id"] . ";";
			$user = db_query($database_name, $sql); $users_ = fetch_array($user);
			$commande=$users_["commande"];
			$sql = "UPDATE detail_commandes SET ";$sql .= "escompte_exercice = '" . $escompte_exercice . "' ";$sql .= "WHERE commande = " . $commande . ";";
					db_query($database_name, $sql);
			
			if ($encours<>"" and $encours<>"encours")
				{
					$sql = "UPDATE detail_commandes SET ";
					$sql .= "date = '" . $date . "', ";
					$sql .= "evaluation = '" . $encours . "' ";
					
					$sql .= "WHERE commande = " . $commande . ";";
					db_query($database_name, $sql);
				}
		
			
			
			
			
			
			

			//revenir à liste
			$date=$_POST['date'];$vendeur=$_POST['vendeur'];$action="recherche";$destination=$_POST['destination'];
			


			break;
			
			case "delete_user":
			$sql  = "SELECT * ";
			$sql .= "FROM commandes WHERE id = " . $_REQUEST["user_id"] . ";";
			$user = db_query($database_name, $sql); $users_ = fetch_array($user);
			$commande=$users_["commande"];$destination=$users_["destination"];
			$sql = "DELETE FROM commandes WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			$sql = "DELETE FROM detail_commandes WHERE commande = " . $commande . ";";
			db_query($database_name, $sql);
			$sql = "DELETE FROM detail_commandes_pro WHERE commande = " . $commande . ";";
			db_query($database_name, $sql);
			
			$profile_id = GetUserProfile();	$user_name=GetUserName();$date_time=date("y-m-d h:m:s");
			$table_name="commandes";$record=$_REQUEST["user_id"];
				$sql  = "INSERT INTO deleted_files ( user,date_time,table_name,record ) VALUES ( ";
				$sql .= "'" . $user_name . "', ";
				$sql .= "'" . $date_time . "', ";
				$sql .= "'" . $table_name . "', ";
				$sql .= "'" . $record . "');";

				db_query($database_name, $sql);
			
			break;


		} //switch
	} //if
	

	$sql1 = "SELECT * FROM vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_vendeur .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$profiles_list_vendeur .= $temp_["vendeur"];
		$profiles_list_vendeur .= "</OPTION>";
	}
		$profiles_list_ville = "";$destination="";
	$sql1 = "SELECT * FROM rs_data_villes ORDER BY ville;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($destination == $temp_["ville"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_ville .= "<OPTION VALUE=\"" . $temp_["ville"] . "\"" . $selected . ">";
		$profiles_list_ville .= $temp_["ville"];
		$profiles_list_ville .= "</OPTION>";
	}

		if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="evaluations_client.php">
	<table><td><?php echo "Date: "; ?><input onClick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Vendeur: "; ?></td><td><select id="vendeur" name="vendeur"><?php echo $profiles_list_vendeur; ?></select></td>
	<tr><td></td><td><?php echo "Destination :"; ?></td><td><select id="destination" name="destination"><?php echo $profiles_list_ville; ?></select></td>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{$date=dateFrToUs($_POST['date']);$date_f=dateFrToUs($_POST['date']);$vendeur=$_POST['vendeur'];$destination=$_POST['destination'];
		
		$sql  = "SELECT * ";
		if ($user_login=="admin" or $user_login=="rakia"){
		$sql .= "FROM commandes where vendeur='$vendeur' and date_e='$date' ORDER BY date_e;";
		}else
		{
		$sql .= "FROM commandes where vendeur='$vendeur' and date_e='$date' and escompte_exercice=0 ORDER BY date_e;";
		}
		$users = db_query($database_name, $sql);
		}
		
		else
			
		{
		@$vendeur=$_GET['vendeur'];@$date=$_GET['date'];@$destination=$_GET['destination'];
		$sql  = "SELECT * ";
		if ($user_login=="admin" or $user_login=="rakia"){
		$sql .= "FROM commandes where vendeur='$vendeur' and date_e='$date' ORDER BY date_e;";
		}else
		{
		$sql .= "FROM commandes where vendeur='$vendeur' and date_e='$date' and escompte_exercice=0 ORDER BY date_e;";
		}
		$users = db_query($database_name, $sql);}
		
	if(isset($_REQUEST["action_"]))
	{	$date=dateFrToUs($_POST['date']);$date_f=dateFrToUs($_POST['date']);$vendeur=$_POST['vendeur'];
		
		$sql  = "SELECT * ";
		if ($user_login=="admin" or $user_login=="rakia"){
				$sql .= "FROM commandes where vendeur='$vendeur' and date_e='$date' ORDER BY date_e;";
		}else
		{
				$sql .= "FROM commandes where vendeur='$vendeur' and date_e='$date' and escompte_exercice=0 ORDER BY date_e;";
		}
		$users = db_query($database_name, $sql);
		}
		
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Commandes Clients"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "evaluation_client.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo ""; ?></span>
<tr>
<td><?php echo dateUsToFr($date_f); ;?></td>
</tr><tr><? echo "<td><a href=\"evaluation_client.php?vendeur=$vendeur&destination=$destination&date=$date_f&user_id=0\">Ajout Commandes des Clients</a></td>";?>

</tr>
<tr><? ?>
<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo "Ajout Articles";?></th>
	<th><?php echo "Importation";?></th>
	<th><?php echo "Imprimer";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Net";?></th>
	
</tr>

<?php 

$total_g=0;
$date_jour=date("Y-m-d");
while($users_ = fetch_array($users)) { 

$numero=$users_["commande"];

/*$result=mysql_query("SELECT count(*) as total from detail_commandes where commande='$numero' ");
$data=mysql_fetch_assoc($result);*/
//echo $data['total'];

$date_evaluation=$users_["date_e"];$nbjours = round(strtotime($date_jour)-strtotime($date_evaluation))/(60*60*24)-1 ;
if ($nbjours<=3 or $user_login == "najat" or $user_login == "Radia" or $user_login == "rakia" or $user_login == "admin" or $user_login == "mghari"){?><tr>
<? $commande=$users_["commande"];$bln=$users_["bl"];$bcn=$users_["bc"];$evaluation=$users_["evaluation"];$client=$users_["client"];$date_e=dateUsToFr($users_["date_e"]);
$vendeur=$users_["vendeur"];$numero=$users_["commande"];$controle=$users_["controle"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];$net_com=$users_["net"];
$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$id=$users_["id"]; $date_en=dateFrToUs($users_["date"]);$ev_pre=$users_["ev_pre"];
echo "<td><a href=\"evaluation_client.php?date=$date_e&user_id=$id\">$evaluation</a></td>";$ref=$users_["vendeur"];?>
<? echo "<td><a href=\"enregistrer_panier.php?vendeur=$vendeur&client=$client&date=$date_e&numero=$commande\">$evaluation </a></td>";?>
<? //if ($data['total']==0){echo "<td><a href=\"import\index.php?vendeur=$vendeur&client=$client&date=$date_e&numero=$commande\" target=\"_blank\">Importation </a></td>";}else{echo "<td></td>";}?>
<? echo "<td><a href=\"editer_evaluation_c.php?vendeur=$vendeur&client=$client&date=$date_e&numero=$commande\">---> Imprimer</a></td>";?>
<td><?php echo $date_e; ?></td>
<td><?php if ($users_["votre_commande"]<>""){$vc=$users_["votre_commande"];}else {$vc="";} echo $users_["client"]." ".$vc; ?></td>
<? ///////////////

	/*$sql1  = "SELECT * ";$m=0;$total=0;
	$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=0 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];

		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}

		$p=$users1_["prix_unit"];$total=$total+$m;
	}?>

<?
if ($sans_remise==1){$t=$total;$net=$total;} else {$t=$total;$remise_1=0;$remise_2=0;$remise_3=0;
if ($remise10>0){$remise_1=$total*$remise10/100;}?>
<? if ($remise2>0){$remise_2=($total-$remise_1)*$remise2/100;}?>
<? if ($remise3>0){$remise_3=($total-$remise_1-$remise_2)*$remise3/100;} ?>
<? }*/?>

<?	
	
	/*$sql1  = "SELECT * ";$total1=0;
	$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=1 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];

		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE ref = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}

$p=$users1_["prix_unit"];$total1=$total1+$m;}?>

<?php $net=$total+$total1-$remise_1-$remise_2-$remise_3; */

/////////////////?>

<td style="text-align:Right"><?php $total_g=$total_g+$net_com;echo number_format($net_com,2,',',' '); ?></td>
<td><?php if($ev_pre) { echo " inclus"; } else {echo " non inclus";}?></td>
<? if ($bln<>0)
{echo "<td><a href=\"editer_bl_total.php?destination=$destination&numero=$commande&client=$client&bl=$bln&bc=$bcn\"> BL1</a></td>";}?>

<? if ($bln<>0)
{echo "<td><a href=\"editer_bl_total_prix.php?destination=$destination&numero=$commande&client=$client&bl=$bln&bc=$bcn\"> FA1</a></td>";}?>

<? if ($bln<>0)
{echo "<td><a href=\"editer_bl_total_prix_aswak.php?destination=$destination&numero=$commande&client=$client&bl=$bln&bc=$bcn\"> BL3</a></td>";}?>
<?php } ?>

<?php } ?>
<tr><td></td><td></td><td></td><td></td><td></td>
<td style="text-align:Right"><?php echo number_format($total_g,2,',',' '); ?></td>
</tr>

</table>
<tr>
</tr>

<p style="text-align:center">

<? echo "<tr><table><td><a href=\"evaluation_simulation.php?date=$date&vendeur=$vendeur&destination=$destination&montant=$total_g\">Imprimer Evaluation Prealable Vendeur</a></td></table></tr>";?>
<? echo "<tr><table><td><a href=\"evaluation_simulation.php?date=$date&vendeur=$vendeur&destination=$destination&montant=$total_g\"></a></td></table></tr>";?>
<? echo "<tr><table><td><a href=\"evaluation_simulation.php?date=$date&vendeur=$vendeur&destination=$destination&montant=$total_g\"></a></td></table></tr>";?>
<? echo "<tr><table><td><a href=\"evaluation_simulation.php?date=$date&vendeur=$vendeur&destination=$destination&montant=$total_g\"></a></td></table></tr>";?>
<? echo "<tr><table><td><a href=\"evaluation_simulation.php?date=$date&vendeur=$vendeur&destination=$destination&montant=$total_g\"></a></td></table></tr>";?>
<? echo "<tr><table><td><a href=\"evaluation_simulation.php?date=$date&vendeur=$vendeur&destination=$destination&montant=$total_g\"></a></td></table></tr>";?>
<? echo "<tr><table><td><a href=\"evaluation_simulation.php?date=$date&vendeur=$vendeur&destination=$destination&montant=$total_g\"></a></td></table></tr>";?>

<? 

echo "<tr><table><td><a href=\"evaluation_simulation_valider.php?date=$date&vendeur=$vendeur&destination=$destination&montant=$total_g\">Valider Evaluation Prealable Vendeur</a></td></table></tr>";

?>
</body>

</html>