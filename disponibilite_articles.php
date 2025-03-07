<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	
	//mise à jour stock_simulation
	$sql  = "SELECT * ";$vide="";$article="article";
	$sql .= "FROM produits where dispo=1 and produit<>'$vide' and famille='$article' ORDER BY produit;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) {  $id=$users_["id"];$produit=$users_["produit"];$stock_controle=$users_["stock_controle"];
	$famille=$users_["famille"];

			//entrees
			$du="2017-03-03";$au=dateFrToUs(date("d/m/y"));
			/*$sql1  = "SELECT produit,date,sum(depot_a) As total_depot_a,sum(depot_b) As total_depot_b,sum(depot_c) As total_depot_c,sum(marron) As marron,sum(beige) As beige,sum(gris) As gris ";
			$sql1 .= "sum(marron_b) As marron_b,sum(beige_b) As beige_b,sum(gris_b) As gris_b FROM entrees_stock where produit='$produit' and (date between '$du' and '$date1' ) group BY produit;";
			$users11 = db_query($database_name, $sql1);$users1 = fetch_array($users11);
			$e_depot_a = $users1["total_depot_a"];$e_depot_b = $users1["total_depot_b"];$e_depot_c = $users1["total_depot_c"];*/
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
	
	
	
	
	
	
	
	
	
	
	
	
	//reset 
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
	 }
	
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

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Simulation Sorties "; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Article";?></th><th><?php echo "Date dispo";?></th>
	<th><?php echo "Sortie Totale/P";?></th>
	<th><?php echo "Sortie Moyenne/J";?></th>
	<th><?php echo "Stock à ce jour";?></th>
	<th><?php echo "Seuil Critique";?></th>
	<th><?php echo "Nbr jours/seuil";?></th>
	<th><?php echo "Seuil atteint au";?></th>
	<th><?php echo "Nbr jours/non dispo";?></th>
	<th><?php echo "Non dispo Au";?></th>		
</tr>
	<?
	$vide="encours";$encours="encours";
	$date_jour=date("Y-m-d");
	$unJour = 3600 * 24;	
	$sql  = "SELECT * ";$article="article";
		$sql .= "FROM produits WHERE dispo=1 and famille='$article' and palmares=1 order by produit ";
		$user = db_query($database_name, $sql); 
	while($usersp_ = fetch_array($user)) {$ts = strtotime($date_jour);$ts1 = strtotime($date_jour);
		$palmares = $usersp_["palmares"];$dispo = $usersp_["dispo"];$date_dispo = $usersp_["date_dispo"];$produit = $usersp_["produit"];
		$stock_simulation = $usersp_["stock_simulation"];$date_simulation = $usersp_["date_simulation"];$seuil_critique = $usersp_["seuil_critique"];
		$encours="encours";$nbjours = round((strtotime($date_jour) - strtotime($date_dispo))/(60*60*24)); $depuis = DateUsTofr($usersp_["date_dispo"]);
		$sql  = "SELECT valeur,commande,produit,sans_remise,quantite,condit,date,sum(quantite*condit*prix_unit) As total_prix,sum(quantite*condit) As total_quantite ,sum(quantite) As t_quantite ";
		$sql .= "FROM detail_commandes where produit = '$produit' and date between '$date_dispo' and '$date_jour' and evaluation<>'$vide' GROUP BY produit  order by produit DESC;";
		$users = db_query($database_name, $sql);$users_ = fetch_array($users);

		$qte_sortie=$users_["t_quantite"];$qte_moyenne=$qte_sortie/$nbjours;$qt=intval($qte_moyenne);
				
		
		 // nombre de secondes dans une journée
		@$nbrjoursrestant=intval(($stock_simulation-$seuil_critique)/$qte_moyenne);
		$ts += $nbrjoursrestant*$unJour; // 8 jours de plus
		@$nbrjoursrestant1=intval($stock_simulation/$qte_moyenne);
		$ts1 += $nbrjoursrestant1*$unJour; // 8 jours de plus
		$date_echeance1=dateUstoFr((date('Y-m-d', $ts1))); // remise au format
		$date_echeance=dateUstoFr((date('Y-m-d', $ts))); // remise au format
		echo "<tr><td>$produit</td><td>$depuis</td><td>$qte_sortie</td><td>$qt</td><td>$stock_simulation</td><td>$seuil_critique</td><td>$nbrjoursrestant</td><td>$date_echeance</td><td>$nbrjoursrestant1</td><td>$date_echeance1</td></tr>";
				

 
 }
 ?>

 </table>


<p style="text-align:center">

</body>

</html>