<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];$date_ajout=date("Y-m-d");$matiere="";$poids="";$time_ajout=date("Y-m-d H:i:s");
	
		//sub
		
		if(isset($_REQUEST["action_1"])){
			$produit=$_REQUEST["produit"];$produit1=$_REQUEST["produit1"];$numero=$_REQUEST["numero"];$favoris11=1;$du=$_REQUEST["du"];
			$quantite=$_REQUEST["quantite"];$prix_unit=$_REQUEST["prix_unit"];$condit=$_REQUEST["condit"];$sub=1;$mois=$_REQUEST["mois"];$annee=$_REQUEST["annee"];
			if ($du>="2018-01-01" and $du<="2018-12-31"){$factures="factures2018";$detail_factures="detail_factures2018";}
			if ($du>="2019-01-01" and $du<="2019-12-31"){$factures="factures2019";$detail_factures="detail_factures2019";}
			if ($du>="2020-01-01" and $du<="2020-12-31"){$factures="factures2020";$detail_factures="detail_factures2020";}
			if ($du>="2021-01-01" and $du<="2021-12-31"){$factures="factures2021";$detail_factures="detail_factures2021";}
			if ($du>="2022-01-01" and $du<="2022-12-31"){$factures="factures2022";$detail_factures="detail_factures2022";}
			if ($du>="2023-01-01" and $du<="2023-12-31"){$factures="factures2023";$detail_factures="detail_factures2023";}
			if ($du>="2024-01-01" and $du<="2024-12-31"){$factures="factures2024";$detail_factures="detail_factures2024";}
			if ($du>="2025-01-01" and $du<="2025-12-31"){$factures="factures2025";$detail_factures="detail_factures2025";}
			if ($du>="2026-01-01" and $du<="2026-12-31"){$factures="factures2026";$detail_factures="detail_factures2026";}
			$sql = "DELETE FROM ".$detail_factures." WHERE facture='$numero' and produit='$produit'" ;
			db_query($database_name, $sql);
			
			$sql15  = "SELECT * ";
			$sql15 .= "FROM produits where produit='$produit1' ORDER BY produit;";
			$users115 = db_query($database_name, $sql15);
			$users115_ = fetch_array($users115);$matiere="";$poids="";
			$matiere=$users115_["matiere"];$poids=$users115_["poids"];if ($prix_unit<>""){$prix_unit=$_REQUEST["prix_unit"];}else{$prix_unit=$users115_["prix"];}
			$condit=$users115_["condit"];
			
			
			$id = $numero-0;
		$sql  = "SELECT * ";
		$sql .= "FROM ".$factures." WHERE id = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_f"]);$date_f = $user_["date_f"];
		$client = $user_["client"];$montant_f = $user_["montant"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
		
				$sql  = "INSERT INTO ".$detail_factures." ( date_ajout,time_ajout,user,facture,date_f, produit, matiere,poids,favoris,quantite,prix_unit,sub,sub_article,condit ) VALUES ( ";
				$sql .= "'" . $date_ajout . "', ";
				$sql .= "'" . $time_ajout . "', ";
				$sql .= "'" . $login . "', ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $date_f . "', ";
				$sql .= "'" . $produit1 . "', ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $poids . "', ";
				$sql .= "'" . $favoris11 . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $prix_unit . "', ";
				$sql .= "'" . $sub . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $condit . "');";

				db_query($database_name, $sql);
		
				
				
		}
		
		
		
		
		
		
		if(isset($_REQUEST["action1_"])){
			$produit=$_REQUEST["produit"];$produit1=$_REQUEST["produit1"];$numero=$_REQUEST["numero"];$du=$_REQUEST["du"];$mois=$_REQUEST["mois"];
			$quantite=$_REQUEST["quantite"];$prix_unit=$_REQUEST["prix_unit"];$condit=$_REQUEST["condit"];$sub=1;
			if ($du>="2018-01-01" and $du<="2018-12-31"){$factures="factures2018";$detail_factures="detail_factures2018";}
			if ($du>="2019-01-01" and $du<="2019-12-31"){$factures="factures2019";$detail_factures="detail_factures2019";}
			if ($du>="2020-01-01" and $du<="2020-12-31"){$factures="factures2020";$detail_factures="detail_factures2020";}
			if ($du>="2021-01-01" and $du<="2021-12-31"){$factures="factures2021";$detail_factures="detail_factures2021";}
			if ($du>="2022-01-01" and $du<="2022-12-31"){$factures="factures2022";$detail_factures="detail_factures2022";}
			if ($du>="2023-01-01" and $du<="2023-12-31"){$factures="factures2023";$detail_factures="detail_factures2023";}
			if ($du>="2024-01-01" and $du<="2024-12-31"){$factures="factures2024";$detail_factures="detail_factures2024";}
			if ($du>="2025-01-01" and $du<="2025-12-31"){$factures="factures2025";$detail_factures="detail_factures2025";}
			if ($du>="2026-01-01" and $du<="2026-12-31"){$factures="factures2026";$detail_factures="detail_factures2026";}
			$sql = "DELETE FROM ".$detail_factures." WHERE facture='$numero' and produit='$produit'" ;
			db_query($database_name, $sql);
			$sql15  = "SELECT * ";
			$sql15 .= "FROM produits where produit='$produit1' ORDER BY produit;";
			$users115 = db_query($database_name, $sql15);
			$users115_ = fetch_array($users115);
			$matiere=$users115_["matiere"];$poids=$users115_["poids"];if ($prix_unit<>""){$prix_unit=$_REQUEST["prix_unit"];}else{$prix_unit=$users115_["prix"];}
			$condit=$users115_["condit"];
			
			$id = $numero-0;
		$sql  = "SELECT * ";
		$sql .= "FROM ".$factures." WHERE id = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_f"]);$date_f = $user_["date_f"];
		$client = $user_["client"];$montant_f = $user_["montant"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
			
				$sql  = "INSERT INTO ".$detail_factures." ( date_ajout,time_ajout,user,facture,date_f, produit,matiere,poids, quantite,prix_unit,sub,sub_article,condit ) VALUES ( ";
				$sql .= "'" . $date_ajout . "', ";
				$sql .= "'" . $time_ajout . "', ";
				$sql .= "'" . $login . "', ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $date_f . "', ";
				$sql .= "'" . $produit1 . "', ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $poids . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $prix_unit . "', ";
				$sql .= "'" . $sub . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $condit . "');";

				db_query($database_name, $sql);
		
				
		}
	
		if(isset($_REQUEST["action_"])) { 
		$du =$_REQUEST["du"];
		if($_REQUEST["action_"] != "delete_user") {$numero =$_REQUEST["numero"];$client =$_REQUEST["client"];$mois=$_REQUEST["mois"];
		$id = $_REQUEST["numero"];
		if ($du>="2018-01-01" and $du<="2018-12-31"){$factures="factures2018";$detail_factures="detail_factures2018";}
			if ($du>="2019-01-01" and $du<="2019-12-31"){$factures="factures2019";$detail_factures="detail_factures2019";}
			if ($du>="2020-01-01" and $du<="2020-12-31"){$factures="factures2020";$detail_factures="detail_factures2020";}
			if ($du>="2021-01-01" and $du<="2021-12-31"){$factures="factures2021";$detail_factures="detail_factures2021";}
			if ($du>="2022-01-01" and $du<="2022-12-31"){$factures="factures2022";$detail_factures="detail_factures2022";}
			if ($du>="2023-01-01" and $du<="2023-12-31"){$factures="factures2023";$detail_factures="detail_factures2023";}
			if ($du>="2024-01-01" and $du<="2024-12-31"){$factures="factures2024";$detail_factures="detail_factures2024";}
			if ($du>="2025-01-01" and $du<="2025-12-31"){$factures="factures2025";$detail_factures="detail_factures2025";}
			if ($du>="2026-01-01" and $du<="2026-12-31"){$factures="factures2026";$detail_factures="detail_factures2026";}
		$sql  = "SELECT * ";
		$sql .= "FROM ".$factures." WHERE numero = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_f"]);$montant_f=$user_["montant"];$date_f=$user_["date_f"];
		$client = $user_["client"];
		$vendeur = $user_["vendeur"];
		$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
			
			// prepares data to simplify database insert or update
			$produit =$_REQUEST["produit"];
			$quantite = $_REQUEST["quantite"];$condit = $_REQUEST["condit"];$prix_unit = $_REQUEST["prix_unit"];$quantite_avoir = $_REQUEST["quantite_avoir"];
		}	
		
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			$sql15  = "SELECT * ";
			$sql15 .= "FROM produits where produit='$produit' ORDER BY produit;";
			$users115 = db_query($database_name, $sql15);
			$users115_ = fetch_array($users115);
			$matiere=$users115_["matiere"];$poids=$users115_["poids"];if ($prix_unit<>""){$prix_unit=$_REQUEST["prix_unit"];}else{$prix_unit=$users115_["prix"];}
			$condit=$users115_["condit"];
			
			
			
				$sql  = "INSERT INTO ".$detail_factures." ( date_ajout,time_ajout,user,facture,date_f, produit,matiere,poids, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $date_ajout . "', ";
				$sql .= "'" . $time_ajout . "', ";
				$sql .= "'" . $login . "', ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $date_f . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $poids . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $prix_unit . "', ";
				$sql .= "'" . $condit . "');";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
			
			$sql15  = "SELECT * ";
			$sql15 .= "FROM produits where produit='$produit' ORDER BY produit;";
			$users115 = db_query($database_name, $sql15);
			$users115_ = fetch_array($users115);
			$matiere=$users115_["matiere"];$poids=$users115_["poids"];if ($prix_unit<>""){$prix_unit=$_REQUEST["prix_unit"];}else{$prix_unit=$users115_["prix"];}
			$condit=$users115_["condit"];
			
			$sql = "UPDATE ".$detail_factures." SET ";
			$sql .= "produit = '" . $produit . "', ";
			$sql .= "matiere = '" . $matiere . "', ";
			$sql .= "poids = '" . $poids . "', ";
			$sql .= "time_ajout = '" . $time_ajout . "', ";
			$sql .= "date_ajout = '" . $date_ajout . "', ";
			$sql .= "user = '" . $login . "', ";
			$sql .= "quantite = '" . $quantite . "', ";
			$sql .= "quantite_avoir = '" . $quantite_avoir . "', ";
			$sql .= "prix_unit = '" . $prix_unit . "', ";
			$sql .= "sans_remise = '" . $sans_remise . "', ";
			$sql .= "condit = '" . $condit . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
		
			break;
			
			case "delete_user":
		if ($du>="2018-01-01" and $du<="2018-12-31"){$factures="factures2018";$detail_factures="detail_factures2018";}
			if ($du>="2019-01-01" and $du<="2019-12-31"){$factures="factures2019";$detail_factures="detail_factures2019";}
			if ($du>="2020-01-01" and $du<="2020-12-31"){$factures="factures2020";$detail_factures="detail_factures2020";}
			if ($du>="2021-01-01" and $du<="2021-12-31"){$factures="factures2021";$detail_factures="detail_factures2021";}
			if ($du>="2022-01-01" and $du<="2022-12-31"){$factures="factures2022";$detail_factures="detail_factures2022";}
			if ($du>="2023-01-01" and $du<="2023-12-31"){$factures="factures2023";$detail_factures="detail_factures2023";}
			if ($du>="2024-01-01" and $du<="2024-12-31"){$factures="factures2024";$detail_factures="detail_factures2024";}
			if ($du>="2025-01-01" and $du<="2025-12-31"){$factures="factures2025";$detail_factures="detail_factures2025";}
			if ($du>="2026-01-01" and $du<="2026-12-31"){$factures="factures2026";$detail_factures="detail_factures2026";}
		$sql  = "SELECT * ";
		$sql .= "FROM ".$detail_factures." WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$numero = $user_["facture"];
		

			$sql = "DELETE FROM ".$detail_factures." WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
		$id = $numero-0;
		$sql  = "SELECT * ";
		$sql .= "FROM ".$factures." WHERE id = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_f"]);$date = $user_["date_f"];$date_f=$user_["date_f"];
		$client = $user_["client"];$montant_f = $user_["montant"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
			
			
			break;


		} //switch
		
	} //if
	else
	{
	
	$numero=$_GET['numero'];$client=$_GET['client'];$montant_f=$_GET['montant'];$du=$_GET['du'];$date_f=$_GET['date_f'];$mois=$_GET['mois'];
	$id = $numero;
	if ($date_f>="2018-01-01" and $date_f<="2018-12-31"){$factures="factures2018";$detail_factures="detail_factures2018";}
			if ($date_f>="2019-01-01" and $date_f<="2019-12-31"){$factures="factures2019";$detail_factures="detail_factures2019";}
			if ($date_f>="2020-01-01" and $date_f<="2020-12-31"){$factures="factures2020";$detail_factures="detail_factures2020";}
			if ($date_f>="2021-01-01" and $date_f<="2021-12-31"){$factures="factures2021";$detail_factures="detail_factures2021";}
			if ($date_f>="2022-01-01" and $date_f<="2022-12-31"){$factures="factures2022";$detail_factures="detail_factures2022";}
			if ($date_f>="2023-01-01" and $date_f<="2023-12-31"){$factures="factures2023";$detail_factures="detail_factures2023";}
			if ($date_f>="2024-01-01" and $date_f<="2024-12-31"){$factures="factures2024";$detail_factures="detail_factures2024";}
			if ($date_f>="2025-01-01" and $date_f<="2025-12-31"){$factures="factures2025";$detail_factures="detail_factures2025";}
			if ($date_f>="2026-01-01" and $date_f<="2026-12-31"){$factures="factures2026";$detail_factures="detail_factures2026";}
		$sql  = "SELECT * ";
		$sql .= "FROM ".$factures." WHERE numero = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_f"]);$date_f=$user_["date_f"];
		$client = $user_["client"];$montant_f = $user_["montant"];$cloture = $user_["cloture"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
	}
	
	
?>
</table>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Facture Client"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<table class="table2">
<td><?php echo $client;?></td><td><?php $montant1=number_format($montant_f,2,',',' ');echo "Facture : ".$numero."  Le  : ".dateUsToFr($date_f)."  >Montant : $montant1";?></td>
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
	$sql1 .= "FROM ".$detail_factures." where facture='$numero' and sans_remise=0 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
//
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];$dispo_g = $user_["dispo_g"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}

if ($dispo_g==0){

echo "<td><a href=\"detail_facture_backup.php?date_f=$date_f&numero=$numero&user_id=$id&client=$client&montant=$m&mois=$mois&du=$du\">$id</a></td>";

echo "<td>$produit</td>";
?>
<td align="center" bgcolor="#FF3300"><?php echo $users1_["quantite"]; ?></td>
<td align="center" bgcolor="#FF3300"><?php echo $users1_["condit"]; ?></td>
<td align="right" bgcolor="#FF3300"><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<td align="right" bgcolor="#FF3300"><?php $total=$total+$m;echo number_format($m,2,',',' '); ?></td>
</tr>
<? } else { 
echo "<td><a href=\"detail_facture_backup.php?date_f=$date_f&numero=$numero&user_id=$id&client=$client&montant=$m&mt=$montant_f&mois=$mois&du=$du\">$id</a></td>";
echo "<td>$produit</td>";
?>
<td align="center"><?php echo $users1_["quantite"]; ?></td>
<td align="center"><?php echo $users1_["condit"]; ?></td>
<td align="right"><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<td align="right"><?php $total=$total+$m;echo number_format($m,2,',',' '); ?></td>
</tr>
<?	}?>
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

<?	
	
	$sql1  = "SELECT * ";$total1=0;
	$sql1 .= "FROM ".$detail_factures." where facture='$numero' and sans_remise=1 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
//
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}

if ($sub==1){

echo "<tr><td><a href=\"detail_facture_backup.php?date_f=$date_f&numero=$numero&user_id=$id&client=$client&montant=$m&du=$du\">$id</a></td>";

echo "<td>$produit</td>";
?>
<td align="center" bgcolor="#FF3300"><?php echo $users1_["quantite"]; ?></td>
<td align="center" bgcolor="#FF3300"><?php echo $users1_["condit"]; ?></td>
<td align="right" bgcolor="#FF3300"><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<? if ($favoris){?>
<td align="right" bgcolor="#FF3300"><?php $total1=$total1+$m;echo number_format($m,2,',',' '); ?></td>
<? } else {?>
<td bgcolor="#FFFF00" align="right"><?php $total1=$total1+$m;echo number_format($m,2,',',' '); ?></td>
<? }?>
</tr>
<? } else { 
echo "<tr><td><a href=\"detail_facture_backup.php?date_f=$date_f&numero=$numero&user_id=$id&client=$client&montant=$m&mt=$montant_f&du=$du\">$id</a></td>";
echo "<td>$produit</td>";
?>
<td align="center"><?php echo $users1_["quantite"]; ?></td>
<td align="center"><?php echo $users1_["condit"]; ?></td>
<td align="right"><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<? if ($favoris){?>
<td align="right"><?php $total1=$total1+$m;echo number_format($m,2,',',' '); ?></td>
<? } else {?>
<td bgcolor="#FFFF00" align="right"><?php $total1=$total1+$m;echo number_format($m,2,',',' '); ?></td>
<? }?>
</tr>
<?	}?>
<?	}?>

<tr>
<td></td>
<td></td>
<td></td><td></td>

<td>Net à payer</td>
<td align="right"><?php $net=$total+$total1-$remise_1-$remise_2-$remise_3; echo number_format($net,2,',',' ');?></td>

</tr>
<tr>
<td></td>
<td></td>
<td></td><td></td>
<td>Difference</td>
<td align="right"><?php $diff=$net-$montant_f;; echo number_format($diff,2,',',' ');?></td>
<tr>
<td></td>
<td></td>
<td></td><td></td>
<td>Diff. Brut</td>
<td align="right"><?php $diff=$net-$montant_f;

$diff = $diff/0.90;
if ($remise2>0){
$diff = $diff/(1-($remise2/100));
}
if ($remise3>0){
$diff = $diff/(1-($remise3/100));
}
 echo number_format($diff,2,',',' ');?></td>
<? }?>

</table>
<table>
<tr>
<? echo "<td><a href=\"detail_facture_backup.php?date_f=$date_f&numero=$numero&user_id=0&client=$client&du=$du\">Ajout Article dans facture</a></td>";?>
</tr>
<tr>
<? $action_22="update_user";echo "<td><a href=\"edition_factures_backup.php?date_f=$date_f&numero=$numero&action_22=$action_22&mois=$mois&du=$du\">Facture Controlée</a></td>";?>
</tr>
<? ?>
<tr>
<? $non_favoris_f= number_format($non_favoris,2,',',' ');$diff=$net-$montant_f;?>
</tr>

<tr><td><? echo "non favoris : $non_favoris_f";?></td></tr>
<tr><td><? $non_favoris=$non_favoris+$diff;$non_favoris_f= number_format($non_favoris,2,',',' ');
$m2=$montant_f-$net+$non_favoris;?></td></tr>
<? ?>
</table>



<table class="table2">
<?

$sql  = "SELECT * ";$article="article";
		$sql .= "FROM produits WHERE dispo_f = 1 and famille='$article' and dispo_g=1 and date_dispo_f<'$date_f' order by produit ;";
		$userss = db_query($database_name, $sql);
while($users_s = fetch_array($userss)) {$produit=$users_s["produit"];$id_v=$users_s["id"];$palmares=$users_s["palmares"];	?>

<tr>

	<td><? echo $produit;?>
	<td><? $px=number_format($users_s["prix"]*$users_s["condit"],2,',',' ');
	$float = substr($px, strpos($px, ',')+1);if ($float>0){$texte1="<a href=\"detail_facture_backup.php?mois=$mois&date_f=$date_f&numero=$numero&user_id=0&client=$client&produit=$produit&qte=1&du=$du\">$px</a>";
	print("<font size=\"3.5\" face=\"Comic sans MS\" color=\"#e70000\" bgcolor=\"#FF0000\">$texte1 </font>");
	}else 
	{$texte1="<a href=\"detail_facture_backup.php?mois=$mois&date_f=$date_f&numero=$numero&user_id=0&client=$client&produit=$produit&qte=1&du=$du\">$px</a>";
	print("<font size=\"2.5\" face=\"Comic sans MS\" color=\"#000033\" >$texte1 </font>");}?></td>
	
	<td><? $px=number_format($users_s["prix"]*$users_s["condit"]*2,2,',',' ');$float = substr($px, strpos($px, ',')+1);
	if ($float>0){$texte1="<a href=\"detail_facture_backup.php?mois=$mois&date_f=$date_f&numero=$numero&user_id=0&client=$client&produit=$produit&qte=2&du=$du\">$px</a>";
	print("<font size=\"3.5\" face=\"Comic sans MS\" color=\"#330000\">$texte1 </font>");
	}else 
	{$texte1="<a href=\"detail_facture_backup.php?mois=$mois&date_f=$date_f&numero=$numero&user_id=0&client=$client&produit=$produit&qte=2&du=$du\">$px</a>";
	print("<font size=\"2.5\" face=\"Comic sans MS\" color=\"#000033\">$texte1 </font>");}?></td>
	
	<td><? $px=number_format($users_s["prix"]*$users_s["condit"]*3,2,',',' ');$float = substr($px, strpos($px, ',')+1);
	if ($float>0){$texte1="<a href=\"detail_facture_backup.php?mois=$mois&date_f=$date_f&numero=$numero&user_id=0&client=$client&produit=$produit&qte=3&du=$du\">$px</a>";
	print("<font size=\"3.5\" face=\"Comic sans MS\" color=\"#330000\">$texte1 </font>");
	}else 
	{$texte1="<a href=\"detail_facture_backup.php?mois=$mois&date_f=$date_f&numero=$numero&user_id=0&client=$client&produit=$produit&qte=3&du=$du\">$px</a>";
	print("<font size=\"2.5\" face=\"Comic sans MS\" color=\"#000033\">$texte1 </font>");}?></td>
	
	<td><? $px=number_format($users_s["prix"]*$users_s["condit"]*4,2,',',' ');$float = substr($px, strpos($px, ',')+1);
	if ($float>0){$texte1="<a href=\"detail_facture_backup.php?mois=$mois&date_f=$date_f&numero=$numero&user_id=0&client=$client&produit=$produit&qte=4&du=$du\">$px</a>";
	print("<font size=\"3.5\" face=\"Comic sans MS\" color=\"#330000\">$texte1 </font>");
	}else 
	{$texte1="<a href=\"detail_facture_backup.php?mois=$mois&date_f=$date_f&numero=$numero&user_id=0&client=$client&produit=$produit&qte=4&du=$du\">$px</a>";
	print("<font size=\"2.5\" face=\"Comic sans MS\" color=\"#000033\">$texte1 </font>");}?></td>
	
	<td><? $px=number_format($users_s["prix"]*$users_s["condit"]*5,2,',',' ');$float = substr($px, strpos($px, ',')+1);
	if ($float>0){$texte1="<a href=\"detail_facture_backup.php?mois=$mois&date_f=$date_f&numero=$numero&user_id=0&client=$client&produit=$produit&qte=5&du=$du\">$px</a>";
	print("<font size=\"3.5\" face=\"Comic sans MS\" color=\"#330000\">$texte1 </font>");
	}else 
	{$texte1="<a href=\"detail_facture_backup.php?mois=$mois&date_f=$date_f&numero=$numero&user_id=0&client=$client&produit=$produit&qte=5&du=$du\">$px</a>";
	print("<font size=\"2.5\" face=\"Comic sans MS\" color=\"#000033\">$texte1 </font>");}?></td>
	
	<td><? $px=number_format($users_s["prix"]*$users_s["condit"]*6,2,',',' ');$float = substr($px, strpos($px, ',')+1);
	if ($float>0){$texte1="<a href=\"detail_facture_backup.php?mois=$mois&date_f=$date_f&numero=$numero&user_id=0&client=$client&produit=$produit&qte=6&du=$du\">$px</a>";
	print("<font size=\"3.5\" face=\"Comic sans MS\" color=\"#330000\">$texte1 </font>");
	}else 
	{$texte1="<a href=\"detail_facture_backup.php?mois=$mois&date_f=$date_f&numero=$numero&user_id=0&client=$client&produit=$produit&qte=6&du=$du\">$px</a>";
	print("<font size=\"2.5\" face=\"Comic sans MS\" color=\"#000033\">$texte1 </font>");}?></td>
	
	<td><? $px=number_format($users_s["prix"]*$users_s["condit"]*7,2,',',' ');$float = substr($px, strpos($px, ',')+1);
	if ($float>0){$texte1="<a href=\"detail_facture_backup.php?mois=$mois&date_f=$date_f&numero=$numero&user_id=0&client=$client&produit=$produit&qte=7&du=$du\">$px</a>";
	print("<font size=\"3.5\" face=\"Comic sans MS\" color=\"#330000\">$texte1 </font>");
	}else 
	{$texte1="<a href=\"detail_facture_backup.php?mois=$mois&date_f=$date_f&numero=$numero&user_id=0&client=$client&produit=$produit&qte=7&du=$du\">$px</a>";
	print("<font size=\"2.5\" face=\"Comic sans MS\" color=\"#000033\">$texte1 </font>");}?></td>
	
	<td><? $px=number_format($users_s["prix"]*$users_s["condit"]*8,2,',',' ');$float = substr($px, strpos($px, ',')+1);
	if ($float>0){$texte1="<a href=\"detail_facture_backup.php?mois=$mois&date_f=$date_f&numero=$numero&user_id=0&client=$client&produit=$produit&qte=8&du=$du\">$px</a>";
	print("<font size=\"3.5\" face=\"Comic sans MS\" color=\"#330000\">$texte1 </font>");
	}else 
	{$texte1="<a href=\"detail_facture_backup.php?mois=$mois&date_f=$date_f&numero=$numero&user_id=0&client=$client&produit=$produit&qte=8&du=$du\">$px</a>";
	print("<font size=\"2.5\" face=\"Comic sans MS\" color=\"#000033\">$texte1 </font>");}?></td>
	
	<td><? $px=number_format($users_s["prix"]*$users_s["condit"]*9,2,',',' ');$float = substr($px, strpos($px, ',')+1);
	if ($float>0){$texte1="<a href=\"detail_facture_backup.php?mois=$mois&date_f=$date_f&numero=$numero&user_id=0&client=$client&produit=$produit&qte=9&du=$du\">$px</a>";
	print("<font size=\"3.5\" face=\"Comic sans MS\" color=\"#330000\">$texte1 </font>");
	}else 
	{$texte1="<a href=\"detail_facture_backup.php?mois=$mois&date_f=$date_f&numero=$numero&user_id=0&client=$client&produit=$produit&qte=9&du=$du\">$px</a>";
	print("<font size=\"2.5\" face=\"Comic sans MS\" color=\"#000033\">$texte1 </font>");}?></td>
	
	<td><? $px=number_format($users_s["prix"]*$users_s["condit"]*10,2,',',' ');$float = substr($px, strpos($px, ',')+1);
	if ($float>0){$texte1="<a href=\"detail_facture_backup.php?mois=$mois&date_f=$date_f&numero=$numero&user_id=0&client=$client&produit=$produit&qte=10&du=$du\">$px</a>";
	print("<font size=\"3.5\" face=\"Comic sans MS\" color=\"#330000\">$texte1 </font>");
	}else 
	{$texte1="<a href=\"detail_facture_backup.php?mois=$mois&date_f=$date_f&numero=$numero&user_id=0&client=$client&produit=$produit&qte=10&du=$du\">$px</a>";
	print("<font size=\"2.5\" face=\"Comic sans MS\" color=\"#000033\">$texte1 </font>");}?></td>
</tr>	
<?	
}
?>
</table>

<? if ($login=="admin"){?>
<p style="text-align:center">
<table class="table2">
<?

		$sql  = "SELECT * ";
		$sql .= "FROM ".$factures." WHERE montant='$montant_f' and numero<>'$numero' order by id ;";
		$userssf = db_query($database_name, $sql);
		while($users_sf = fetch_array($userssf)) {$date_ff=$users_sf["date_f"];
		$clientf = $users_sf["client"];	$idf = $users_sf["id"];$montantff = $users_sf["montant"];?>

<tr>
<? echo "<td>$date_ff</td>";?>
<? echo "<td>$clientf</td>";?>
<? echo "<td>$montantff</td>";?>
<? $action="dupliquer";echo "<td><a href=\"#?action=$action&date_f=$date_f&numero=$numero&user_id=0&client=$client&du=$du\">dupliquer facture</a></td>";?>
</tr>	
<?	
}
?>
</table>

<? }?>

<p style="text-align:center">


</body>

</html>