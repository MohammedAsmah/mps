<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();	$user_name=GetUserName();


	$error_message = "";$date="";$date_f="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;
		$date="";$action="Recherche";	
	$profiles_list_vendeur = "";$vendeur="";

	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {$date = dateFrToUs($_REQUEST["date"]);$date_f = dateFrToUs($_REQUEST["date"]);
		
			
			// prepares data to simplify database insert or update
			$client = $_REQUEST["client"];$vendeur = $_REQUEST["vendeur"];$destination = $_REQUEST["destination"];
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
		$sql  = "SELECT * ";
		$sql .= "FROM clients WHERE client = '$client' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$remise10 = $user_["remise10"];
		$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];
			
			}
		if($_REQUEST["action_"] == "update_user"){	
			$remise10 = $_REQUEST["remise10"];$remise2 = $_REQUEST["remise2"];$remise3 = $_REQUEST["remise3"];$destination = $_REQUEST["destination"];
			$client = $_REQUEST["client"];$vendeur = $_REQUEST["vendeur"];$bl = $_REQUEST["bl"];$bc = $_REQUEST["bc"];$piece = $_REQUEST["piece"];
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
				$sql  = "INSERT INTO commandes ( commande,date_e,client, vendeur, remise_10,remise_2,remise_3,evaluation,destination,sans_remise ) VALUES ( ";
				$sql .= "'" . $cde . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $client . "', ";
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
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];
						$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); 
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
				$sql  = "INSERT INTO commandes ( commande,date_e,client, vendeur, remise_10,remise_2,remise_3,evaluation,destination,sans_remise ) VALUES ( ";
						$sql .= "'" . $cde . "', ";
						$sql .= "'" . $date1 . "', ";
						$sql .= "'" . $client1 . "', ";
						$sql .= "'" . $vendeur . "', ";
						$sql .= "'" . $remise10 . "', ";
						$sql .= "'" . $remise2 . "', ";
						$sql .= "'" . $remise3 . "', ";
						$sql .= "'" . $encours . "', ";				$sql .= "'" . $destination . "', ";

						$sql .= "'" . $sans_remise1 . "');";
						db_query($database_name, $sql);
		
				}
				if ($client2<>""){
						$sql  = "SELECT * ";
						$sql .= "FROM clients WHERE client = '$client2' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$remise10 = $user_["remise10"];
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];
						$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); 
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
				$sql  = "INSERT INTO commandes ( commande,date_e,client, vendeur, remise_10,remise_2,remise_3,evaluation,destination,sans_remise ) VALUES ( ";
						$sql .= "'" . $cde . "', ";
						$sql .= "'" . $date2 . "', ";
						$sql .= "'" . $client2 . "', ";
						$sql .= "'" . $vendeur . "', ";
						$sql .= "'" . $remise10 . "', ";
						$sql .= "'" . $remise2 . "', ";
						$sql .= "'" . $remise3 . "', ";
						$sql .= "'" . $encours . "', ";				$sql .= "'" . $destination . "', ";

						$sql .= "'" . $sans_remise2 . "');";
						db_query($database_name, $sql);
		
				}
				if ($client3<>""){
						$sql  = "SELECT * ";
						$sql .= "FROM clients WHERE client = '$client3' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$remise10 = $user_["remise10"];
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];
						$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); 
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
				$sql  = "INSERT INTO commandes ( commande,date_e,client, vendeur, remise_10,remise_2,remise_3,evaluation,destination,sans_remise ) VALUES ( ";
						$sql .= "'" . $cde . "', ";
						$sql .= "'" . $date3 . "', ";
						$sql .= "'" . $client3 . "', ";
						$sql .= "'" . $vendeur . "', ";
						$sql .= "'" . $remise10 . "', ";
						$sql .= "'" . $remise2 . "', ";
						$sql .= "'" . $remise3 . "', ";
						$sql .= "'" . $encours . "', ";				$sql .= "'" . $destination . "', ";

						$sql .= "'" . $sans_remise3 . "');";
						db_query($database_name, $sql);
		
				}
				if ($client4<>""){
						$sql  = "SELECT * ";
						$sql .= "FROM clients WHERE client = '$client4' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$remise10 = $user_["remise10"];
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];
						$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); 
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
				$sql  = "INSERT INTO commandes ( commande,date_e,client, vendeur, remise_10,remise_2,remise_3,evaluation,destination,sans_remise ) VALUES ( ";
						$sql .= "'" . $cde . "', ";
						$sql .= "'" . $date4 . "', ";
						$sql .= "'" . $client4 . "', ";
						$sql .= "'" . $vendeur . "', ";
						$sql .= "'" . $remise10 . "', ";
						$sql .= "'" . $remise2 . "', ";
						$sql .= "'" . $remise3 . "', ";
						$sql .= "'" . $encours . "', ";				$sql .= "'" . $destination . "', ";

						$sql .= "'" . $sans_remise4 . "');";
						db_query($database_name, $sql);
		
				}
				if ($client5<>""){
						$sql  = "SELECT * ";
						$sql .= "FROM clients WHERE client = '$client5' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$remise10 = $user_["remise10"];
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];
						$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); 
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
				$sql  = "INSERT INTO commandes ( commande,date_e,client, vendeur, remise_10,remise_2,remise_3,evaluation,destination,sans_remise ) VALUES ( ";
						$sql .= "'" . $cde . "', ";
						$sql .= "'" . $date5 . "', ";
						$sql .= "'" . $client5 . "', ";
						$sql .= "'" . $vendeur . "', ";
						$sql .= "'" . $remise10 . "', ";
						$sql .= "'" . $remise2 . "', ";
						$sql .= "'" . $remise3 . "', ";
						$sql .= "'" . $encours . "', ";				$sql .= "'" . $destination . "', ";

						$sql .= "'" . $sans_remise5 . "');";
						db_query($database_name, $sql);
		
				}
				if ($client6<>""){
						$sql  = "SELECT * ";
						$sql .= "FROM clients WHERE client = '$client6' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$remise10 = $user_["remise10"];
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];
						$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); 
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
				$sql  = "INSERT INTO commandes ( commande,date_e,client, vendeur, remise_10,remise_2,remise_3,evaluation,destination,sans_remise ) VALUES ( ";
						$sql .= "'" . $cde . "', ";
						$sql .= "'" . $date6 . "', ";
						$sql .= "'" . $client6 . "', ";
						$sql .= "'" . $vendeur . "', ";
						$sql .= "'" . $remise10 . "', ";
						$sql .= "'" . $remise2 . "', ";
						$sql .= "'" . $remise3 . "', ";
						$sql .= "'" . $encours . "', ";				$sql .= "'" . $destination . "', ";

						$sql .= "'" . $sans_remise6 . "');";
						db_query($database_name, $sql);
		
				}
				if ($client7<>""){
						$sql  = "SELECT * ";
						$sql .= "FROM clients WHERE client = '$client7' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$remise10 = $user_["remise10"];
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];
						$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); 
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
				$sql  = "INSERT INTO commandes ( commande,date_e,client, vendeur, remise_10,remise_2,remise_3,evaluation,destination,sans_remise ) VALUES ( ";
						$sql .= "'" . $cde . "', ";
						$sql .= "'" . $date7 . "', ";
						$sql .= "'" . $client7 . "', ";
						$sql .= "'" . $vendeur . "', ";
						$sql .= "'" . $remise10 . "', ";
						$sql .= "'" . $remise2 . "', ";
						$sql .= "'" . $remise3 . "', ";
						$sql .= "'" . $encours . "', ";				$sql .= "'" . $destination . "', ";

						$sql .= "'" . $sans_remise7 . "');";
						db_query($database_name, $sql);
		
				}
				if ($client8<>""){
						$sql  = "SELECT * ";
						$sql .= "FROM clients WHERE client = '$client8' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$remise10 = $user_["remise10"];
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];
						$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); 
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
				$sql  = "INSERT INTO commandes ( commande,date_e,client, vendeur, remise_10,remise_2,remise_3,evaluation,destination,sans_remise ) VALUES ( ";
						$sql .= "'" . $cde . "', ";
						$sql .= "'" . $date8 . "', ";
						$sql .= "'" . $client8 . "', ";
						$sql .= "'" . $vendeur . "', ";
						$sql .= "'" . $remise10 . "', ";
						$sql .= "'" . $remise2 . "', ";
						$sql .= "'" . $remise3 . "', ";
						$sql .= "'" . $encours . "', ";				$sql .= "'" . $destination . "', ";

						$sql .= "'" . $sans_remise8 . "');";
						db_query($database_name, $sql);
		
				}
				if ($client9<>""){
						$sql  = "SELECT * ";
						$sql .= "FROM clients WHERE client = '$client9' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$remise10 = $user_["remise10"];
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];
						$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); 
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
				$sql  = "INSERT INTO commandes ( commande,date_e,client, vendeur, remise_10,remise_2,remise_3,evaluation,destination,sans_remise ) VALUES ( ";
						$sql .= "'" . $cde . "', ";
						$sql .= "'" . $date9 . "', ";
						$sql .= "'" . $client9 . "', ";
						$sql .= "'" . $vendeur . "', ";
						$sql .= "'" . $remise10 . "', ";
						$sql .= "'" . $remise2 . "', ";
						$sql .= "'" . $remise3 . "', ";
						$sql .= "'" . $encours . "', ";				$sql .= "'" . $destination . "', ";

						$sql .= "'" . $sans_remise9 . "');";
						db_query($database_name, $sql);
		
				}
				if ($client10<>""){
						$sql  = "SELECT * ";
						$sql .= "FROM clients WHERE client = '$client10' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$remise10 = $user_["remise10"];
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];
						$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); 
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
				$sql  = "INSERT INTO commandes ( commande,date_e,client, vendeur, remise_10,remise_2,remise_3,evaluation,destination,sans_remise ) VALUES ( ";
						$sql .= "'" . $cde . "', ";
						$sql .= "'" . $date10 . "', ";
						$sql .= "'" . $client10 . "', ";
						$sql .= "'" . $vendeur . "', ";
						$sql .= "'" . $remise10 . "', ";
						$sql .= "'" . $remise2 . "', ";
						$sql .= "'" . $remise3 . "', ";
						$sql .= "'" . $encours . "', ";				$sql .= "'" . $destination . "', ";

						$sql .= "'" . $sans_remise10 . "');";
						db_query($database_name, $sql);
		
				}
		
		//retour à liste triée par date
		$date=$_POST['date'];$vendeur=$_POST['vendeur'];$action="recherche";$destination=$_POST['destination'];
					

			break;

			case "update_user":
			if(isset($_REQUEST["ev_pre"])) { $ev_pre = 1; } else { $ev_pre = 0; }
						if(isset($_REQUEST["piece"])) { $piece = 1; } else { $piece = 0; }

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
				
						if(isset($_REQUEST["active"])) { $active = 1;$encours=$mois1." ".$dev; } 
						else { $active = 0; $encours=$evaluation;}
			$sql = "UPDATE commandes SET ";
			$sql .= "client = '" . $client . "', ";
			$sql .= "date_e = '" . $date . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			$sql .= "evaluation = '" . $encours . "', ";
			$sql .= "eval = '" . $dir_eval . "', ";
			$sql .= "mois = '" . $mois1 . "', ";
			$sql .= "annee = '" . $annee . "', ";
			$sql .= "active = '" . $active . "', ";
			$sql .= "remise_10 = '" . $remise10 . "', ";
			$sql .= "remise_2 = '" . $remise2 . "', ";
			$sql .= "remise_3 = '" . $remise3 . "', ";
			$sql .= "net = '" . $net . "', ";
			$sql .= "ev_pre = '" . $ev_pre . "', ";
			$sql .= "piece = '" . $piece . "', ";
			$sql .= "bl = '" . $bl . "', ";
			$sql .= "bc = '" . $bc . "', ";
			$sql .= "sans_remise = '" . $sans_remise . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);

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
		$sql .= "FROM commandes where vendeur='$vendeur' and date_e='$date' ORDER BY date_e;";
		$users = db_query($database_name, $sql);
		}
		
		else
			
		{
		@$vendeur=$_GET['vendeur'];@$date=$_GET['date'];@$destination=$_GET['destination'];
		$sql  = "SELECT * ";
		$sql .= "FROM commandes where vendeur='$vendeur' and date_e='$date' ORDER BY date_e;";
		$users = db_query($database_name, $sql);}
		
	if(isset($_REQUEST["action_"]))
	{$date=dateFrToUs($_POST['date']);$date_f=dateFrToUs($_POST['date']);$vendeur=$_POST['vendeur'];
		
		$sql  = "SELECT * ";
		$sql .= "FROM commandes where vendeur='$vendeur' and date_e='$date' ORDER BY date_e;";
		$users = db_query($database_name, $sql);
		}
		
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Evaluations"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "evaluation_client.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "liste Evaluations"; ?></span>
<tr>
<td><?php echo dateUsToFr($date_f); ;?></td>
</tr><tr><? echo "<td><a href=\"evaluation_client.php?vendeur=$vendeur&destination=$destination&date=$date_f&user_id=0\">Ajout Evaluation</a></td>";?>
</tr>

<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo "Articles G.";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Net";?></th>
	
</tr>

<?php 

$total_g=0;
while($users_ = fetch_array($users)) { ?><tr>
<? $commande=$users_["commande"];$bln=$users_["bl"];$bcn=$users_["bc"];$evaluation=$users_["evaluation"];$client=$users_["client"];$date_e=dateUsToFr($users_["date_e"]);
$vendeur=$users_["vendeur"];$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];
$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$id=$users_["id"]; $date_en=dateFrToUs($users_["date"]);$ev_pre=$users_["ev_pre"];
echo "<td><a href=\"evaluation_client.php?date=$date_e&user_id=$id\">$evaluation</a></td>";$ref=$users_["vendeur"];?>
<? echo "<td><a href=\"enregistrer_panier.php?vendeur=$vendeur&client=$client&date=$date_e&numero=$commande\">$evaluation </a>";?>
<? echo "<a href=\"editer_evaluation_c.php?vendeur=$vendeur&client=$client&date=$date_e&numero=$commande\">---> Imprimer</a></td>";?>
<td><?php echo $date_e; ?></td>
<td><?php echo $users_["client"]; ?></td>
<? ///////////////

	$sql1  = "SELECT * ";$m=0;$total=0;
	$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=0 ORDER BY produit;";
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

		$p=$users1_["prix_unit"];$total=$total+$m;
	}?>

<?
if ($sans_remise==1){$t=$total;$net=$total;} else {$t=$total;$remise_1=0;$remise_2=0;$remise_3=0;
if ($remise10>0){$remise_1=$total*$remise10/100;}?>
<? if ($remise2>0){$remise_2=($total-$remise_1)*$remise2/100;}?>
<? if ($remise3>0){$remise_3=($total-$remise_1-$remise_2)*$remise3/100;} ?>
<? }?>

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
		if ($favoris==0){$non_favoris=$non_favoris+$m;}

$p=$users1_["prix_unit"];$total1=$total1+$m;}?>

<?php $net=$total+$total1-$remise_1-$remise_2-$remise_3; 

/////////////////?>

<td style="text-align:Right"><?php $total_g=$total_g+$net;echo number_format($net,2,',',' '); ?></td>
<td><?php if($ev_pre) { echo " inclus"; } else {echo " non inclus";}?></td>
<? if ($bln<>"")
{echo "<td><a href=\"editer_bl_ent.php?destination=$destination&numero=$commande&client=$client&bl=$bln&bc=$bcn\">Editer BL</a></td>";}?>


<?php } ?>
<tr><td></td><td></td><td></td><td></td>
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