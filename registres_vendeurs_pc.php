<?php
set_time_limit(0);
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$user_login = $user_["login"];
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"])) { 
		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			
			$date_v = dateFrToUs($_REQUEST["date"]);
			
			
			list($annee1,$mois1,$jour1) = explode('-', $date_v); 
			$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
			$mois=date("m",$pdu);$annee=date("Y",$pdu);
			$service=$_REQUEST["service"];
			$vendeur=$_REQUEST["vendeur"];
			$result = mysql_query("SELECT bon_sortie FROM registre_vendeurs where mois=$mois and annee=$annee ORDER BY bon_sortie DESC LIMIT 0,1"); 
			$row = mysql_fetch_array($result); 
			
			$dir = $row["bon_sortie"]+1;
			$imprimer1=$_REQUEST["imprimer1"];
			if($user_login == "rakia" or $user_login=="admin") {$matricule=$_REQUEST["matricule"];$obs_c=$_REQUEST["obs_c"];}else{$matricule="";$obs_c="";}
			if($imprimer1 != 1) {
			if(isset($_REQUEST["imprimer"])) { $imprimer = 1; } else { $imprimer = 0; }
			$heure=date("d/m/y H:i");
			$montant=$_REQUEST["montantev"];}else{ $imprimer = 1; $heure=$_REQUEST["heure1"];
			$montant=$_REQUEST["montantev1"];}
			
			
			
			$statut=$dir."/".$mois.$annee;
			$date_open=$_REQUEST["date_open"];
			$user_open=$user_name;
			$observation=$_REQUEST["observation"];
			$motif_cancel=$_REQUEST["motif_cancel"];
			
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
	// recherche contrat			
		$code_produit="";
			
				$type_service="SEJOURS ET CIRCUITS";
				$sql  = "INSERT INTO registre_vendeurs (date,service,vendeur,date_open,user_open,observation,mois,annee,bon_sortie,statut)
				 VALUES ('$date_v','$service','$vendeur','$date_open','$user_open','$observation','$mois','$annee','$dir','$statut')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			if(isset($_REQUEST["bl_out"])) { $bl_out = 1; } else { $bl_out = 0; }
			if(isset($_REQUEST["bl_in"])) { $bl_in = 1; } else { $bl_in = 0; }
			$sql = "UPDATE registre_vendeurs SET ";
			$sql .= "service = '" . $_REQUEST["service"] . "', ";
			$sql .= "bl_out = '" . $bl_out . "', ";
			$sql .= "bl_in = '" . $bl_in . "', ";
			$sql .= "date = '" . $date_v . "', ";
			$sql .= "montant = '" . $montant . "', ";
			$sql .= "heure = '" . $heure . "', ";
			$sql .= "imprimer = '" . $imprimer . "', ";
			$sql .= "observation = '" . $observation . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			if($user_login == "rakia" or $user_login=="admin"){$sql .= "matricule = '" . $matricule . "', ";$sql .= "obs_c = '" . $obs_c . "', ";}
			$sql .= "motif_cancel = '" . $motif_cancel . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			$id_registre=$_REQUEST["user_id"];
			$sql  = "SELECT * ";
			$sql .= "FROM registre_vendeurs WHERE id = " . $_REQUEST["user_id"] . ";";
			$user = db_query($database_name, $sql); $user_ = fetch_array($user);
			$bondesortie = $user_["statut"];
			
			
			
			
			//validation bon sortie
			if ($valide==1){
			$sql = "TRUNCATE TABLE `bon_de_sortie1`  ;";
			db_query($database_name, $sql);
			$sql  = "SELECT * ";
		$sql .= "FROM commandes WHERE id_registre = " . $id_registre . ";";
		$user = db_query($database_name, $sql); 

		while($user_ = fetch_array($user)) { 
		$date = dateUsToFr($user_["date_e"]);
		$client = $user_["client"];$montant_f = $user_["net"];$numero = $user_["commande"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];

		//////////////////////////////blocage evaluation
		$sql = "UPDATE commandes SET ";$id=$user_["id"];$controle=1;
			$sql .= "controle = '" . $controle . "', ";
			$sql .= "bondesortie = '" . $bondesortie . "', ";
			$sql .= "date_e = '" . $date_v . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
		
		
		
		
	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; 
		$id=$users1_["id"];$quantite=$users1_["quantite"];$condit=$users1_["condit"];
				$sql  = "INSERT INTO bon_de_sortie1 ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
		//accesoires
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$userp = db_query($database_name, $sql);
		$user_a = fetch_array($userp);
		$accessoire_1 = $user_a["accessoire_1"];$accessoire_2 = $user_a["accessoire_2"];$accessoire_3 = $user_a["accessoire_3"];
		
		$qte_ac_1 = $user_a["qte_ac_1"]*$quantite;$qte_ac_2 = $user_a["qte_ac_2"]*$quantite;$qte_ac_3 = $user_a["qte_ac_3"]*$quantite;
		if ($accessoire_1<>"")
		{		
				$sql  = "INSERT INTO bon_de_sortie1 ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $accessoire_1 . "', ";
				$sql .= "'" . $qte_ac_1 . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
		}
		if ($accessoire_2<>"")
		{		$sql  = "INSERT INTO bon_de_sortie1 ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $accessoire_2 . "', ";
				$sql .= "'" . $qte_ac_2 . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
		}
		if ($accessoire_3<>"")
		{		$sql  = "INSERT INTO bon_de_sortie1 ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $accessoire_3 . "', ";
				$sql .= "'" . $qte_ac_3 . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
		}
		
		}
		
		
		
//promotion
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes_pro where commande='$numero' ORDER BY produit;";
	$users1p = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1p)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$quantite=$users1_["quantite"];$condit=$users1_["condit"];
				$sql  = "INSERT INTO bon_de_sortie1 ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
				
	//accessoires promo
			//accesoires
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$userp = db_query($database_name, $sql);
		$user_a = fetch_array($userp);
		$accessoire_1 = $user_a["accessoire_1"];$accessoire_2 = $user_a["accessoire_2"];$accessoire_3 = $user_a["accessoire_3"];
		
		$qte_ac_1 = $user_a["qte_ac_1"]*$quantite;$qte_ac_2 = $user_a["qte_ac_2"]*$quantite;$qte_ac_3 = $user_a["qte_ac_3"]*$quantite;
		if ($accessoire_1<>"")
		{		
				$sql  = "INSERT INTO bon_de_sortie1 ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $accessoire_1 . "', ";
				$sql .= "'" . $qte_ac_1 . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
		}
		if ($accessoire_2<>"")
		{		$sql  = "INSERT INTO bon_de_sortie1 ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $accessoire_2 . "', ";
				$sql .= "'" . $qte_ac_2 . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
		}
		if ($accessoire_3<>"")
		{		$sql  = "INSERT INTO bon_de_sortie1 ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $accessoire_3 . "', ";
				$sql .= "'" . $qte_ac_3 . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
		}
			
				
				
				
		}



	}
	$sql1  = "SELECT commande,produit,condit,sum(quantite) as total_quantite ";
	$sql1 .= "FROM bon_de_sortie1 where commande='$id_registre' group BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users11_ = fetch_array($users1)) { 
	$produit=$users11_["produit"]; $quantite=$users11_["total_quantite"];$condit=$users11_["condit"];
	
				$sql  = "INSERT INTO bon_de_sortie_magasin ( id_registre, date,produit, condit,depot_a ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $date_v . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $condit . "', ";
				$sql .= "'" . $quantite . "');";

				db_query($database_name, $sql);
	}	

	}

			if ($valide==0){
			$sql = "DELETE FROM bon_de_sortie_magasin WHERE id_registre = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
		//////////////////////////////deblocage evaluation
		$sql = "UPDATE commandes SET ";$user_id=$_REQUEST["user_id"];$controle=0;
			$sql .= "controle = '" . $controle . "', ";
			$sql .= "date_e = '" . $date_v . "' ";
			$sql .= "WHERE id_registre = " . $user_id . ";";
			db_query($database_name, $sql);
					
			
			}
			
			//mise \E0 jour commandes
			/*$sql = "UPDATE commandes SET ";
			$sql .= "date_e = '" . $date_v . "' ";
			$sql .= "WHERE id_registre = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);*/
			
			
			break;
			
			case "delete_user":
			
			
			// delete user's profile
			$sql = "DELETE FROM registre_vendeurs WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			$sql = "UPDATE commandes SET ";$vide=0;
			$sql .= "id_registre = '" . $vide . "' ";
			$sql .= "WHERE id_registre = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			$sql = "DELETE FROM bon_de_sortie_magasin WHERE id_registre = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			$profile_id = GetUserProfile();	$user_name=GetUserName();$date_time=date("y-m-d h:m:s");
			$table_name="registre_vendeurs";$record=$_REQUEST["user_id"];
				$sql  = "INSERT INTO deleted_files ( user,date_time,table_name,record ) VALUES ( ";
				$sql .= "'" . $user_name . "', ";
				$sql .= "'" . $date_time . "', ";
				$sql .= "'" . $table_name . "', ";
				$sql .= "'" . $record . "');";

				db_query($database_name, $sql);
			
			
			break;


		} //switch
	} //if
	
	else {$vendeur="";$date1="";$date2="";}
	if(isset($_REQUEST["action_"]) and $_REQUEST["action_"] != "delete_user") { $date1 = $_REQUEST["date"];}
	else {$vendeur="";$date1="";$date2="";}
	$action="recherche";
	
	
	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="registres_vendeurs_pc.php">
	<td><?php echo "Du : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au : "; ?><input onClick="ds_sh(this);" name="date2" value="<?php echo $date2; ?>" readonly="readonly" style="cursor: text" /></td>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	
	</form>
	
	<? }


?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre_vendeur.php?user_id=" + user_id; }
	function EditUser1(user_id) { document.location = "registre_sejour_annuler_sans_lp.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	if(isset($_REQUEST["action"]))
	{ $date=dateFrToUs($_POST['date1']);$date2=dateFrToUs($_POST['date2']);
	
	$sql  = "SELECT * ";$d1="2013-01-01";$d2="2013-01-31";
	$sql .= "FROM registre_vendeurs where date between '$date' and '$date2' and frais_v=0 ORDER BY date,id;";
	//	$sql .= "FROM registre_vendeurs where date between '$d1' and '$d2' ORDER BY id;";
	$users11 = db_query($database_name, $sql);
?>


<span style="font-size:24px"><?php echo "SITUATION DES BL N.R DU ".dateUsToFr($date)." AU ".dateUsToFr($date2); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Destination";?></th>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "B.S Magasin";?></th>
	<th><?php echo "Transport";?></th>
	
	
</tr>

<?php $compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { $id_r=$users_1["id"];$date3=$users_1["date"];$vendeur=$users_1["vendeur"];
			$statut=$users_1["statut"];$observation=$users_1["observation"];$valide=$users_1["valide"];$valide_c=$users_1["valide_c"];
			$service=$users_1["service"];$code=$users_1["code_produit"];$lp=$users_1["id"]+100000;$bon=$users_1["statut"];?><tr>
			<? $dt=dateUsToFr($users_1["date"]);$user_id=$users_1["id"];$imprimer=$users_1["imprimer"];
			$hh=$users_1["heure"];$mm=$users_1["montant"];$bl_out=$users_1["bl_out"];$bl_in=$users_1["bl_in"];$matricule=$users_1["matricule"];
			
			$sql  = "SELECT * ";
		$sql .= "FROM rs_data_camions WHERE matricule = '$matricule' ;";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$matricule = $user_["matricule"];
		$chauffeur = $matricule." - ".$user_["chauffeur"];
			
	
			
			?>
			
			<td><?php echo dateUsToFr($users_1["date"]); ?></td>
	
			
			<td><?php $destination=$users_1["service"];echo $users_1["service"]; ?></td>

			<td><?	  
			echo $users_1["vendeur"];
			?>				
			 
 						 
			 <td align="center"><? echo $bon;?></td>
			<td align="center"><? echo $chauffeur;?></td>
			
			
			<? $total_g=$total_g+1;}
			
 } 
 
 if ($user_login=="admin"){
 ?>
<tr><td><? echo $total_g;?></td>
<? }?>
</table>
</strong>


</body>

</html>
