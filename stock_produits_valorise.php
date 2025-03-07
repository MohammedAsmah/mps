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
	<form id="form" name="form" method="post" action="stock_produits_valorise.php">
	<td><?php echo "Date : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<? }

	
	
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









<? $sql  = "SELECT * ";$vide="";$article="article";
	$sql .= "FROM produits where dispo=1 and produit<>'$vide' and famille='$article' ORDER BY produit;";
	$users = db_query($database_name, $sql);?>



<span style="font-size:24px"><?php $jour=date("d/m/y");$d=$_POST["date1"];echo "Etat de Stock Au : $d"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Article";?></th>
	<th><?php echo "MPS";?></th>
	<th><?php echo "JAOUDA";?></th>
	<th><?php echo "Stock TOTAL";?></th>
	<th><?php echo "Condit.";?></th>
	<th><?php echo "Prix Unitaire";?></th>
	<th><?php echo "Valeur";?></th>
</tr>

<?php $valeur_totale=0;while($users_ = fetch_array($users)) { ?>

<?php $id=$users_["id"];$produit=$users_["produit"];$stock_controle=$users_["stock_controle"];
$type=$users_["type"];$prix=$users_["prix"];$condit=$users_["condit"];?>
			
			<? 
			//entrees
			$sql1  = "SELECT produit,date,sum(depot_a) As total_depot_a,sum(depot_b) As total_depot_b,sum(depot_c) As total_depot_c ";
			$du="2017-03-03";$au=dateFrToUs(date("d/m/y"));
			$sql1 .= "FROM entrees_stock where produit='$produit' and (date between '$du' and '$date1' ) group BY produit;";
			$users11 = db_query($database_name, $sql1);$users1 = fetch_array($users11);
			$e_depot_a = $users1["total_depot_a"];$e_depot_b = $users1["total_depot_b"];$e_depot_c = $users1["total_depot_c"];
			
			//sorties
			$sql1  = "SELECT produit,date,sum(depot_a) As total_depot_a,sum(depot_b) As total_depot_b,sum(depot_c) As total_depot_c ";
			$du="2017-03-03";$au=dateFrToUs(date("d/m/y"));
			$sql1 .= "FROM bon_de_sortie_magasin where produit='$produit' and (date between '$du' and '$date1' ) group BY produit;";
			$users111 = db_query($database_name, $sql1);$users2 = fetch_array($users111);
			$s_depot_a = $users2["total_depot_a"];$s_depot_b = $users2["total_depot_b"];$s_depot_c = $users2["total_depot_c"];
			$mps=$e_depot_a-$s_depot_a;$jaouda=$e_depot_b-$s_depot_b;
			
			/*$sql = "UPDATE produits SET ";
			$sql .= "famille = '" . $type . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);*/
			
			
			if ($mps==0 and $jaouda==0){}else{
			?>
			
			
<tr>
<td ><? $user_id=$users_["id"];echo "<a href=\"fiche_de_stock.php?date=$date1&user_id=$user_id\">".$produit."</a>"; ?></td>

<td align="center"><?php echo $e_depot_a-$s_depot_a; ?></td>
<td align="center"><?php echo $e_depot_b-$s_depot_b; ?></td>
<td align="center"><?php echo ($e_depot_a-$s_depot_a)+($e_depot_b-$s_depot_b); $stock=($e_depot_a-$s_depot_a)+($e_depot_b-$s_depot_b);?></td>
<td align="center"><?php echo $condit; ?></td>
<td align="center"><?php echo number_format($prix,2,',',' '); ?></td>
<td align="right"><? $valeur=$stock*$prix*$condit;echo number_format($valeur,2,',',' ');$valeur_totale=$valeur_totale+$valeur; ?></td>
<?php }}?>
<tr><td></td><td></td><td></td><td></td><td></td><td></td>
<td align="right"><? echo number_format($valeur_totale,2,',',' ');?></td>
</table>

<p style="text-align:center">

</body>

</html>
