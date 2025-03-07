<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	// recherche ville
	?>
	
	<?
	
	 if(isset($_REQUEST["action"])){$date1 = dateFrToUs($_POST["date1"]);}else{ $action="Recherche";$date1=date("d/m/Y");?>
	<form id="form" name="form" method="post" action="stock_produits_alarme.php">
	<td><?php echo "Date : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<? }

	$sql  = "SELECT * ";$vide="";$article="Accessoire";
	$sql .= "FROM produits where dispo=1 and produit<>'$vide' and seuil_critique<>0 and type<>'$article' ORDER BY produit;";
	$users_s = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Produits"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>


<span style="font-size:24px"><?php $jour=date("d/m/y");$d=$_POST["date1"];echo "Etat de Stock Alarme Au : $d"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Article";?></th>
	<th><?php echo "Seuil Critique";?></th>
	<th><?php echo "MPS";?></th>
	<th><?php echo "JAOUDA";?></th>
	<th><?php echo "Stock global";?></th>
	<th><?php echo "Stock Alarme";?></th>
</tr>

<?php while($users_ss = fetch_array($users_s)) { ?>

<?php $id=$users_ss["id"];$produit=$users_ss["produit"];$stock_controle=$users_ss["stock_controle"];
$seuil_critique=$users_ss["seuil_critique"];?>
			
			<? 
			//entrees
			$sql1  = "SELECT produit,date,sum(depot_a) As total_depot_a,sum(depot_b) As total_depot_b,sum(depot_c) As total_depot_c ";
			$du="2009-01-01";$au=dateFrToUs(date("d/m/y"));
			$sql1 .= "FROM entrees_stock where produit='$produit' and (date between '$du' and '$date1' ) group BY produit;";
			$users11s = db_query($database_name, $sql1);$users1s = fetch_array($users11s);
			$e_depot_a = $users1s["total_depot_a"];$e_depot_b = $users1s["total_depot_b"];
			$e_depot_c = $users1s["total_depot_c"];
			
			//sorties
			$sql1  = "SELECT produit,date,sum(depot_a) As total_depot_a,sum(depot_b) As total_depot_b,sum(depot_c) As total_depot_c ";
			$du="2009-01-01";$au=dateFrToUs(date("d/m/y"));
			$sql1 .= "FROM bon_de_sortie_magasin where produit='$produit' and (date between '$du' and '$date1' ) group BY produit;";
			$users111s = db_query($database_name, $sql1);$users2s = fetch_array($users111s);
			$s_depot_a = $users2s["total_depot_a"];$s_depot_b = $users2s["total_depot_b"];
			$s_depot_c = $users2s["total_depot_c"];
			$mps=$e_depot_a-$s_depot_a;$jaouda=$e_depot_b-$s_depot_b;
			
			
			?>
			
			
<tr>
<td bgcolor="#66CCCC"><? $user_id=$users_ss["id"];echo "<a href=\"fiche_de_stock.php?date=$date1&user_id=$user_id\">".$produit."</a>"; ?></td>
<td bgcolor="#66CCCC"><?php echo $seuil_critique; ?></td>
<td bgcolor="#66CCCC"><?php echo $e_depot_a-$s_depot_a; ?></td>
<td bgcolor="#66CCCC"><?php echo $e_depot_b-$s_depot_b; ?></td>
<td bgcolor="#66CCCC"><?php echo ($e_depot_a-$s_depot_a)+($e_depot_b-$s_depot_b); ?></td>
<td bgcolor="#66CCCC"><?php $stock_final=($e_depot_a-$s_depot_a)+($e_depot_b-$s_depot_b);echo $stock_final-$seuil_critique; ?></td>

<?php }?>

</table>

<p style="text-align:center">

</body>

</html>
