<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	

	
	//reset 
	
	/*
	$activer=0;
	$sql = "UPDATE produits SET palmares = '$activer' where palmares=1 ";
	db_query($database_name, $sql);?>
	<table>
	<?
	$t1=$_POST['utilities1'];
	reset($t1);
	while (list($key, $val) = each($t1))
	 {   $val=stripslashes($val); 
	 
	 //
	$activer=1;
	$sql = "UPDATE produits SET palmares = '$activer' WHERE produit='$val'";
	db_query($database_name, $sql);
	
	
	$sql  = "SELECT * ";
	$sql .= "FROM produits where produit='$val' ORDER BY produit;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) {
	$id=$users_["id"];$produit=$users_["produit"];$stock_controle=$users_["stock_controle"];
	$famille=$users_["famille"];

			//entrees
			$du="2017-03-03";$au=dateFrToUs(date("d/m/y"));
			$sql1  = "SELECT produit,date,sum(depot_a) As total_depot_a,sum(depot_b) As total_depot_b,sum(depot_c) As total_depot_c ";
			$sql1 .= "FROM entrees_stock where produit='$produit' and (date between '$du' and '$au' ) group BY produit;";
			$users11 = db_query($database_name, $sql1);$users1 = fetch_array($users11);
			$e_depot_a = $users1["total_depot_a"];$e_depot_b = $users1["total_depot_b"];$e_depot_c = $users1["total_depot_c"];
			//sorties
			$du="2017-03-03";$au=dateFrToUs(date("d/m/y"));
			$sql1  = "SELECT produit,date,sum(depot_a) As total_depot_a,sum(depot_b) As total_depot_b,sum(depot_c) As total_depot_c ";
			$sql1 .= "FROM bon_de_sortie_magasin where produit='$produit' and (date between '$du' and '$au' ) group BY produit;";
			$users111 = db_query($database_name, $sql1);$users2 = fetch_array($users111);
			$s_depot_a = $users2["total_depot_a"];$s_depot_b = $users2["total_depot_b"];$s_depot_c = $users2["total_depot_c"];
			$mps=$e_depot_a-$s_depot_a;$jaouda=$e_depot_b-$s_depot_b;
		

//mise à jour stock
$stock_simulation=($e_depot_a-$s_depot_a+$e_depot_a_se)+($e_depot_b-$s_depot_b+$e_depot_b_se);
$stock_mps=$e_depot_a-$s_depot_a+$e_depot_a_se;$stock_jp=$e_depot_b-$s_depot_b+$e_depot_b_se;
$sql1 = "UPDATE produits SET stock_simulation = $stock_simulation,date_simulation='$au',stock_mps=$stock_mps,stock_jp=$stock_jp WHERE produit='$produit'";
	db_query($database_name, $sql1);
	
	 }
	 
	 }
	 */
	?>
	</table>
	


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
		<? require "body_cal.php";?>

	<?
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];
	$du=$_POST['date'];$au=$_POST['date1'];$t_prix_p=0;$vide="encours";$encours="encours";
	$date_jour=date("Y-m-d");
	$nbjours = round((strtotime($date) - strtotime($date1))/(60*60*24)-1); 
	
	$encours="encours";
		$sql  = "SELECT valeur,commande,produit,sans_remise,quantite,condit,date,sum(quantite*condit*prix_unit) As total_prix,sum(quantite*condit) As total_quantite ,sum(quantite) As t_quantite ";
	$sql .= "FROM detail_commandes where date between '$date' and '$date1' and evaluation<>'$vide' and escompte_exercice=0 GROUP BY produit  order by produit ;";
	$users = db_query($database_name, $sql);

	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php $nbj=$nbjours*-1;echo "Simulation Sortie sur $nbj jours du $du au $au"; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Article";?></th>
	<th><?php echo "Sortie Totale/P";?></th>
	<th><?php echo "Sortie Moyenne/J";?></th>
	<th><?php echo "Stock";?></th>
	<th><?php echo "Seuil Critique";?></th>
	<th><?php echo "Nbr jours";?></th>
	<th><?php echo "Echeance Non disponible";?></th>
	<th><?php echo "Echeance Seuil Critique";?></th>
			
</tr>

<?php $debit=0;$credit=0;$t=0;$s=0;$t_poids=0;$t_prix=0;$t_poids_evaluation=0;?>

<? while($users_ = fetch_array($users)) { ?><?php $p=$users_["produit"];$qte_sortie=$users_["t_quantite"];$qte_moyenne=$qte_sortie/$nbjours*-1;$qt=number_format($qte_moyenne,2,',',' ');
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$p' ";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$palmares = $user_["palmares"];$dispo = $user_["dispo"];$date_dispo = $user_["date_dispo"];
		if ($palmares=="1"){
		$stock_simulation = $user_["stock_simulation"];$date_simulation = $user_["date_simulation"];$seuil_critique = $user_["seuil_critique"];
		$ts = strtotime($date_jour);$ts1 = strtotime($date_jour);
		$unJour = 3600 * 24; // nombre de secondes dans une journée
		$nbrjoursrestant=number_format(($stock_simulation-$seuil_critique)/$qte_moyenne,0,',','');
		$nbrjoursrestant1=number_format($stock_simulation/$qte_moyenne,0,',','');
		if ($nbrjoursrestant1>5000){$nbrjoursrestant1=5000;}
		if ($nbrjoursrestant>5000){$nbrjoursrestant=5000;}
		$ts += $nbrjoursrestant*$unJour; 
		$ts1 += $nbrjoursrestant1*$unJour; // 8 jours de plus
 
		$date_echeance=(date('Y-m-d', $ts));$date_echeance1=(date('Y-m-d', $ts1)); 
		// remise au format
		$date_echeance=dateUsTofr($date_echeance);$date_echeance1=dateUsTofr($date_echeance1);
		echo "<tr><td>$p</td><td>$qte_sortie</td><td>$qt</td><td>$stock_simulation</td><td>$seuil_critique</td><td>$nbrjoursrestant1 </td><td>$date_echeance1</td><td>$date_echeance</td></tr>";
		
		/*$sql = "UPDATE produits SET date_ech = '$date_echeance1' where produit='$p' ";
		db_query($database_name, $sql);*/
		
		}

 } ?>

 </table>


<p style="text-align:center">

</body>

</html>