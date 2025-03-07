<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();	$user_name=GetUserName();

	$error_message = "";
	
		//sub
	
	
		$montant=$_GET['montant'];$destination=$_GET['destination'];
		$montant=number_format($montant,2,',',' ');$m=0;
		$vendeur=$_GET['vendeur'];$date=$_GET['date'];$date_aff=dateUsToFr($_GET['date']);
			
			/*$sql = "TRUNCATE TABLE `bon_de_sortie`  ;";
			db_query($database_name, $sql);*/
		
		
		//creation evaluation vendeur
		
		
			$date_v = $_GET['date'];
			
			
			list($annee1,$mois1,$jour1) = explode('-', $date_v); 
			$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
			$mois=date("m",$pdu);$annee=date("Y",$pdu);
			$service="";
			$result = mysql_query("SELECT bon_sortie FROM registre_vendeurs where mois=$mois and annee=$annee ORDER BY bon_sortie DESC LIMIT 0,1"); 
			$row = mysql_fetch_array($result); 
			
			$dir = $row["bon_sortie"]+1;
			
			$statut=$dir."/".$mois.$annee;
			$date_open=date("Y-m-d");
			$user_open=$user_name;
			$observation="";
			$motif_cancel="";
		
		$sql22  = "SELECT * FROM commandes WHERE date_e='$date' and vendeur='$vendeur' and ev_pre=1 ";
		$user22 = db_query($database_name, $sql22); $i=0;$user22_ = fetch_array($user22);$destination = $user2_["destination"];
				
				////////////////////////////////////////:
				
				$sql  = "INSERT INTO registre_vendeurs (date,service,vendeur,date_open,user_open,observation,mois,annee,bon_sortie,statut)
				 VALUES ('$date_v','$destination','$vendeur','$date_open','$user_open','$destination','$mois','$annee','$dir','$statut')";

				db_query($database_name, $sql);$numero_ev=mysql_insert_id();

		
		
		
		
		
		
		$sql2  = "SELECT * FROM commandes WHERE date_e='$date' and vendeur='$vendeur' and ev_pre=1 ";
		$user2 = db_query($database_name, $sql2); $i=0;

		while($user2_ = fetch_array($user2)) { 
		$date = dateUsToFr($user2_["date_e"]);$i=$i+1;
		$client = $user2_["client"];$montant_f = $user2_["net"];$numero = $user2_["commande"];$m=$m+$user2_["net"];
		$vendeur = $user2_["vendeur"];$remise10 = $user2_["remise_10"];$remise2 = $user2_["remise_2"];
		$evaluation = $user2_["evaluation"];$sans_remise = $user2_["sans_remise"];$remise3 = $user2_["remise_3"];
		$id = $user2_["id"];
		
		//update registre vendeur
			$sql = "UPDATE commandes SET ";$ev_pre=0;
			$sql .= "date_e = '" . $date_v . "', ";
			$sql .= "id_registre = '" . $numero_ev . "', ";
			$sql .= "ev_pre = '" . $ev_pre . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
			
			///////////////////////////////////////////////
			
			
			
			/*$sql = "UPDATE registre_vendeurs SET ";$ev_pre=0;
			$sql .= "service = '" . $ser . "' ";
			$sql .= "WHERE id = " . $numero_ev . ";";
			db_query($database_name, $sql);*/
	}

