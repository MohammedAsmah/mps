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
	<form id="form" name="form" method="post" action="stock_produits_alarmes.php">
	<td><?php echo "Date : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<? }

	$sql  = "SELECT * ";$vide="";$article="article";
	$sql .= "FROM produits where dispo=1 and produit<>'$vide' and seuil_critique<>0 and famille='$article' ORDER BY produit;";
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
	<th><?php echo "Moyenne S/jour";?></th>
	<th><?php echo "NbJours Rest.";?></th>
	
	<th><?php echo "";?></th>
</tr>

<?php while($users_ss = fetch_array($users_s)) { ?>

<?php $id=$users_ss["id"];$produit=$users_ss["produit"];$stock_controle=$users_ss["stock_controle"];$date_dispo=$users_ss["date_dispo"];$stock_mps=$users_ss["stock_mps"];
$stock_jp=$users_ss["stock_jp"];
$seuil_critique=$users_ss["seuil_critique"];$condit=$users_ss["condit"];$stock_simulation=$users_ss["stock_simulation"];$date_simulation=$users_ss["date_simulation"];?>
			
			<? 
			
			
			if ($seuil_critique >= $stock_simulation)
	{ $t_prix_p=0;$vide="encours";$encours="encours";
			$date_jour=date("Y-m-d");
			$nbjours = round((strtotime($date_jour) - strtotime($date_dispo))/(60*60*24)-1); 
			$sql  = "SELECT valeur,commande,produit,sans_remise,quantite,condit,date,sum(quantite*condit*prix_unit) As total_prix,sum(quantite*condit) As total_quantite ,sum(quantite) As t_quantite ";
			$sql .= "FROM detail_commandes where date between '$date_dispo' and '$date_jour' and evaluation<>'$vide' and produit='$produit' GROUP BY produit order by produit DESC;";
			$users = db_query($database_name, $sql);$users_sss = fetch_array($users);
			$p=$users_sss["produit"];$qte_sortie=$users_sss["t_quantite"];$qte_moyenne=$qte_sortie/$nbjours;$qt=number_format($qte_moyenne,0,',',' ');
			
		$ts = strtotime($date_jour);
		$unJour = 3600 * 24; // nombre de secondes dans une journée
		@$nbrjoursrestant=number_format($stock_simulation/$qte_moyenne,0,',',' ');
		$ts += $nbrjoursrestant*$unJour; // 8 jours de plus
 
		$date_echeance=(date('Y-m-d', $ts)); // remise au format
		//echo "<tr><td>$p</td><td>$qte_sortie</td><td>$qt</td><td>$stock_simulation</td><td>$seuil_critique</td><td>$nbrjoursrestant</td><td>$date_echeance</td></tr>";
	
	
	?>
			
			
<tr>
<td ><? $user_id=$users_ss["id"];echo "<a href=\"fiche_de_stock.php?date=$date1&user_id=$user_id\">".$produit."</a>"; ?></td>
<td ><?php echo $seuil_critique; ?></td>
<td ><?php echo $stock_mps; ?></td>
<td ><?php echo $stock_jp; ?></td>
<td ><?php echo $stock_simulation; ?></td>
<td ><?php echo $qt; ?></td>
<td ><?php echo $nbrjoursrestant; ?></td>

<?php
//en production
			$sql1  = "SELECT * ";
			
			$sql1 .= "FROM programme_machines where produit='$produit' order BY id;";
			$users1111s = db_query($database_name, $sql1);$i=0;
			while($users_ = fetch_array($users1111s)) {
			$i=$i+1;}
			
if ($i >= 1)
	{ ?>

<?php }?>
<?php }?>
<?php }?>

</table>


<p style="text-align:center">

</body>

</html>
