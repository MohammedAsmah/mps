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
	
	$user_login = $user_["login"];
	
		//sub
	
	if(isset($_REQUEST["action_"]) && $profile_id == 1 && $_REQUEST["action_"]!="tableau" ) { 
		
		if($_REQUEST["action_"] != "delete_user") {$numero =$_REQUEST["numero"];$client =$_REQUEST["client"];
		$id = $_REQUEST["numero"];$id_c = $_REQUEST["numero"];
		$sql  = "SELECT * ";
		$sql .= "FROM commandes_frs WHERE id = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_e"]);$montant_f=$user_["net"];$date_sortie = $user_["date_e"];
		$client = $user_["client"];$piece = $user_["piece"];
		$vendeur = $user_["vendeur"];
		$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
			
			// prepares data to simplify database insert or update
			$produit =$_REQUEST["produit"];$quantite = $_REQUEST["quantite"];$reference = $_REQUEST["reference"];
			if ($_REQUEST["action_"]=="insert_new_user"){
			$id_bb1=$_REQUEST["id_bb1"];	
			$produit1 =$_REQUEST["produit1"];$quantite1 = $_REQUEST["quantite1"];$reference1 = $_REQUEST["reference1"];
			$produit2 =$_REQUEST["produit2"];$quantite2 = $_REQUEST["quantite2"];$reference2 = $_REQUEST["reference2"];
			$produit3 =$_REQUEST["produit3"];$quantite3 = $_REQUEST["quantite3"];$reference3 = $_REQUEST["reference3"];
			$produit4 =$_REQUEST["produit4"];$quantite4 = $_REQUEST["quantite4"];$reference4 = $_REQUEST["reference4"];
			$produit5 =$_REQUEST["produit5"];$quantite5 = $_REQUEST["quantite5"];$reference5 = $_REQUEST["reference5"];
			$produit6 =$_REQUEST["produit6"];$quantite6 = $_REQUEST["quantite6"];$reference6 = $_REQUEST["reference6"];
			$produit7 =$_REQUEST["produit7"];$quantite7 = $_REQUEST["quantite7"];$reference7 = $_REQUEST["reference7"];
			$produit8 =$_REQUEST["produit8"];$quantite8 = $_REQUEST["quantite8"];$reference8 = $_REQUEST["reference8"];
			$produit9 =$_REQUEST["produit9"];$quantite9 = $_REQUEST["quantite9"];$reference9 = $_REQUEST["reference9"];
			$produit10 =$_REQUEST["produit10"];$quantite10 = $_REQUEST["quantite10"];$reference10 = $_REQUEST["reference10"];




//////////////////////////////
			}

			if(isset($_REQUEST["sans_remise"]) and $produit<>"") { $sans_remise = 1; } else { $sans_remise = 0; }
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit = $user_["condit"];$prix_unit = $user_["prix"];

			if ($_REQUEST["action_"]=="insert_new_user"){
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit1' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit1 = $user_["condit"];$prix_unit1 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit2' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit2 = $user_["condit"];$prix_unit2 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit3' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit3 = $user_["condit"];$prix_unit3 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit4' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit4 = $user_["condit"];$prix_unit4 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit5' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit5 = $user_["condit"];$prix_unit5 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit6' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit6 = $user_["condit"];$prix_unit6 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit7' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit7 = $user_["condit"];$prix_unit7 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit8' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit8 = $user_["condit"];$prix_unit8 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit9' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit9 = $user_["condit"];$prix_unit9 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit10' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit10 = $user_["condit"];$prix_unit10 = $user_["prix"];
		}
		}	
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
				
				if ($produit<>""){
				
				$sql  = "INSERT INTO detail_commandes_frs ( commande, produit,reference, quantite,prix_unit,condit )
				VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit . "', ";$sql .= "'" . $reference . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $prix_unit . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
				
				
				$sql = "UPDATE detail_bon_besoin SET ";$bon_commande=1;$statut="commande en cours";
				$sql .= "date_commande = '" . $date_sortie . "', ";
				$sql .= "bon_commande = '" . $bon_commande . "', ";
				$sql .= "statut = '" . $statut . "' ";
				$sql .= "WHERE id = '" . $id_bb1 . "';";
				db_query($database_name, $sql);
				
				
				
				
				//promotions
				}
				
		
				if ($produit1<>""){
				$sql  = "INSERT INTO detail_commandes_frs ( commande, produit, reference,quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit1 . "', ";$sql .= "'" . $reference1 . "', ";
				$sql .= "'" . $quantite1 . "', ";
				$sql .= "'" . $prix_unit1 . "', ";
				$sql .= "'" . $condit1 . "');";
				db_query($database_name, $sql);
								//promotions

				
				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes_frs WHERE commande=$numero and produit = '$produit2' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit2="";}

				if ($produit2<>""){
				$sql  = "INSERT INTO detail_commandes_frs ( commande, produit, reference,quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit2 . "', ";$sql .= "'" . $reference2 . "', ";
				$sql .= "'" . $quantite2 . "', ";
				$sql .= "'" . $prix_unit2 . "', ";
				$sql .= "'" . $condit2 . "');";
				db_query($database_name, $sql);
								//promotions
				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes_frs WHERE commande=$numero and produit = '$produit3' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit3="";}

				if ($produit3<>""){
				$sql  = "INSERT INTO detail_commandes_frs ( commande, produit, reference,quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit3 . "', ";$sql .= "'" . $reference3 . "', ";
				$sql .= "'" . $quantite3 . "', ";
				$sql .= "'" . $prix_unit3 . "', ";
				$sql .= "'" . $condit3 . "');";
				db_query($database_name, $sql);
								//promotions
				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes_frs WHERE commande=$numero and produit = '$produit4' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit4="";}

				if ($produit4<>""){
				$sql  = "INSERT INTO detail_commandes_frs ( commande, produit,reference, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit4 . "', ";$sql .= "'" . $reference4 . "', ";
				$sql .= "'" . $quantite4 . "', ";
				$sql .= "'" . $prix_unit4 . "', ";
				$sql .= "'" . $condit4 . "');";
				db_query($database_name, $sql);
								//promotions

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes_frs WHERE commande=$numero and produit = '$produit5' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit5="";}

				if ($produit5<>""){
				$sql  = "INSERT INTO detail_commandes_frs ( commande, produit,reference, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit5 . "', ";$sql .= "'" . $reference5 . "', ";
				$sql .= "'" . $quantite5 . "', ";
				$sql .= "'" . $prix_unit5 . "', ";
				$sql .= "'" . $condit5 . "');";
				db_query($database_name, $sql);
								//promotions
				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes_frs WHERE commande=$numero and produit = '$produit6' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit6="";}

				if ($produit6<>""){
				$sql  = "INSERT INTO detail_commandes_frs ( commande, produit,reference, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit6 . "', ";$sql .= "'" . $reference6 . "', ";
				$sql .= "'" . $quantite6 . "', ";
				$sql .= "'" . $prix_unit6 . "', ";
				$sql .= "'" . $condit6 . "');";
				db_query($database_name, $sql);
								//promotions

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes_frs WHERE commande=$numero and produit = '$produit7' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit7="";}

				if ($produit7<>""){
				$sql  = "INSERT INTO detail_commandes_frs ( commande, produit,reference, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit7 . "', ";$sql .= "'" . $reference7 . "', ";
				$sql .= "'" . $quantite7 . "', ";
				$sql .= "'" . $prix_unit7 . "', ";
				$sql .= "'" . $condit7 . "');";
				db_query($database_name, $sql);
								//promotions

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes_frs WHERE commande=$numero and produit = '$produit8' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit8="";}

				if ($produit8<>""){
				$sql  = "INSERT INTO detail_commandes_frs ( commande, produit,reference, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit8 . "', ";$sql .= "'" . $reference8 . "', ";
				$sql .= "'" . $quantite8 . "', ";
				$sql .= "'" . $prix_unit8 . "', ";
				$sql .= "'" . $condit8 . "');";
				db_query($database_name, $sql);

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes_frs WHERE commande=$numero and produit = '$produit9' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit9="";}

				if ($produit9<>""){
				$sql  = "INSERT INTO detail_commandes_frs ( commande, produit,reference, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit9 . "', ";$sql .= "'" . $reference9 . "', ";
				$sql .= "'" . $quantite9 . "', ";
				$sql .= "'" . $prix_unit9 . "', ";
				$sql .= "'" . $condit9 . "');";
				db_query($database_name, $sql);
								//promotions

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_commandes_frs WHERE commande=$numero and produit = '$produit10' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit10="";}

				if ($produit10<>""){
				$sql  = "INSERT INTO detail_commandes_frs ( commande, produit,reference, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit10 . "', ";
				$sql .= "'" . $reference10 . "', ";
				$sql .= "'" . $quantite10 . "', ";
				$sql .= "'" . $prix_unit10 . "', ";
				$sql .= "'" . $condit10 . "');";
				db_query($database_name, $sql);
								//promotions

				}

			
			break;

			case "update_user":
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
			$condit=$_REQUEST["condit"];$prix_unit = $_REQUEST["prix_unit"];$prix_ref = $_REQUEST["prix_ref"];
			
			$prix_unit_r = $_REQUEST["prix_unit_r"];
			$quantite_r = $_REQUEST["quantite_r"];
			$date_r = dateFrToUs($_REQUEST["date_r"]);
			$reference_v = $_REQUEST["reference_v"];
			$obs_r = $_REQUEST["obs_r"];
			$reference_l1 = $_REQUEST["reference_l1"];
			$reference_l2 = $_REQUEST["reference_l2"];
			
			 if ($user_login=="admin" or $user_login=="rakia" or $user_login=="nassima"){
			$sql = "UPDATE detail_commandes_frs SET ";
			$sql .= "produit = '" . $produit . "', ";
			$sql .= "reference = '" . $reference . "', ";$sql .= "reference_l1 = '" . $reference_l1 . "', ";$sql .= "reference_l2 = '" . $reference_l2 . "', ";
			$sql .= "quantite = '" . $quantite . "', ";
			$sql .= "prix_unit = '" . $prix_unit . "', ";$sql .= "prix_ref = '" . $prix_ref . "', ";
			$sql .= "sans_remise = '" . $sans_remise . "', ";
			$sql .= "reference_v = '" . $reference_v . "', ";
			$sql .= "quantite_r = '" . $quantite_r . "', ";
			$sql .= "prix_unit_r = '" . $prix_unit_r . "', ";
			$sql .= "obs_r = '" . $obs_r . "', ";
			$sql .= "date_r = '" . $date_r . "', ";
			$sql .= "condit = '" . $condit . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			}else
			{$sql = "UPDATE detail_commandes_frs SET ";
			$sql .= "produit = '" . $produit . "', ";
			$sql .= "reference = '" . $reference . "', ";
			$sql .= "quantite = '" . $quantite . "', ";
			$sql .= "prix_unit = '" . $prix_unit . "', ";
			$sql .= "sans_remise = '" . $sans_remise . "', ";
			$sql .= "condit = '" . $condit . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);}
			

			break;
			
			case "delete_user":
			
		$sql  = "SELECT * ";
		$sql .= "FROM detail_commandes_frs WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$numero = $user_["commande"];$produit = $user_["produit"];
		

			$sql = "DELETE FROM detail_commandes_frs WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);

		$id = $numero;$id_c = $numero;
		$sql  = "SELECT * ";
		$sql .= "FROM commandes_frs WHERE id = " . $id . ";";
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
	if(isset($_REQUEST["action_"]) && $profile_id == 1 && $_REQUEST["action_"]=="tableau" )
		{echo "tableau";$numero =$_REQUEST["numero"];$client =$_REQUEST["client"];
		$id = $_REQUEST["numero"];$id_c = $_REQUEST["numero"];
		$sql  = "SELECT * ";
		$sql .= "FROM commandes_frs WHERE id = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_e"]);$montant_f=$user_["net"];$date_sortie = $user_["date_e"];
		$client = $user_["client"];$piece = $user_["piece"];$piece = $user_["piece"];
		$vendeur = $user_["vendeur"];
		$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
		
		
		$t1=$_POST['utilities1'];$activer=1;
	echo "<table>";	
	reset($t1);
	while (list($key, $val) = each($t1))
	 {   $val1=stripslashes($key); $val2=stripslashes($val); 
	 
	$sql  = "SELECT * ";
		$sql .= "FROM detail_bon_besoin WHERE id = " . $val2 . ";";
		$user = db_query($database_name, $sql); $user_p = fetch_array($user);
		$numero_bb = $user_p["id"];
		$produit = $user_p["produit"];
		$quantite = $user_p["quantite"];
		$unite = $user_p["unite"];
		$prix_unit = $user_p["prix_unit"];
		$condit = $user_p["condit"];
	
	
	
	$sql  = "INSERT INTO detail_commandes_frs ( commande, numero_bb,produit,quantite,unite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $id . "', ";
				$sql .= "'" . $numero_bb . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $unite . "', ";
				$sql .= "'" . $prix_unit . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
	
	echo "<tr><td>".$val1."--".$val2."</td></tr>";
	
	$sql = "UPDATE detail_bon_besoin SET bon_commande = '$activer' ,date_commande= '$date_sortie' WHERE id='$val2'";
	db_query($database_name, $sql);
	
	 }
	 
	echo "</table>"; 
	 
	 
		
		
		
		
		
		
		}
	else
	$numero=$_GET['numero'];$client=$_GET['client'];$montant_f=0;$vendeur=$_GET['vendeur'];$id_c=$_GET['numero'];
	$id = $numero;
		$sql  = "SELECT * ";
		$sql .= "FROM commandes_frs WHERE id = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_e"]);$client = $user_["client"];
		$client = $user_["client"];$montant_f = $user_["net"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
	}
	
	
?>
</table>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Commandes"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "detail_facture_pro.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<table class="table2">
<td><?php echo $client;?></td><td><?php $montant1=number_format($montant_f,2,',',' ');
echo "Commande : ".$evaluation."---->Date : $date --->";?></td>
</table>
<tr>
<table class="table2">

<tr>
	<th><?php $total=0;echo "Ref";?></th>
	<th><?php $total=0;echo "Article";?></th>
	<th><?php echo "Quantité";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Total";?></th>
</tr>

<?	
	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes_frs where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
echo "<td><a href=\"remplir_panier_bc_mps.php?numero=$numero&user_id=$id&client=$client&montant=$m\">$id</a></td>";?>
<td><?php echo $produit; ?></td>
<td align="center"><?php echo $users1_["quantite"]; ?></td>
<td align="right"><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<td align="right"><?php $total=$total+$m;echo number_format($m,2,',',' '); ?></td>
</tr>
<?	}?>

</table>
<table>
<tr>
<? echo "<td><a href=\"remplir_panier_bc_mps.php?numero=$numero&user_id=0&client=$client\">Ajout Article </a></td>";?>
<? echo "<td><a href=\"choix_articles_bc.php?numero=$numero&user_id=0&client=$client\">Ajout Articles </a></td>";?>
</tr><tr>
<? $date1=dateFrToUs($date);echo "<td><a href=\"bc_mps.php?vendeur=$vendeur&date=$date1\">Retour dans Liste Commandes</a></td>";?>
</tr>
<tr>
<? $date1=dateFrToUs($date);echo "<td><a href=\"editer_bc_mps5.php?numero=$numero\">Edition Bon de Commande</a></td>";?>
</tr>



</table>

<p style="text-align:center">


</body>

</html>