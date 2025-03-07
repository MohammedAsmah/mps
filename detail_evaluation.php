<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	$evaluation=$_GET['user_id'];$client=$_GET['client'];
		$sql1  = "SELECT * "; 
		$sql1 .= "FROM clients WHERE ref = '$client';";
		$user1 = db_query($database_name, $sql1); $user1_ = fetch_array($user1);
		$nom_client = $user1_["client"];$remise2 = $user1_["remise2"];$remise3 = $user1_["remise3"];

	
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes where commande='$evaluation' ORDER BY produit;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Detail Evaluation"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "produit.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Detail Evaluation : $nom_client / Rmise : $remise2-$remise3"; ?></span>

<table class="table2">

<tr>
	<th><?php $total=0;echo "Produit";?></th>
	<th><?php echo "Quantité";?></th>
	<th><?php echo "Paquets";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Total";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<? 		$sql1  = "SELECT * ";$ref=$users_["produit"]; 
		$sql1 .= "FROM produits WHERE ref = " . $ref . ";";
		$user1 = db_query($database_name, $sql1); $user1_ = fetch_array($user1);
		$produit = $user1_["produit"];$condit = $user1_["condit"];
?>
<td><?php echo $produit; ?></td>
<td><?php echo $users_["quantite"]; ?></td>
<td><?php echo $condit; ?></td>
<td align="right"><?php echo $users_["prix_unit"]; ?></td>
<td align="right"><?php echo $users_["prix_unit"]*$users_["quantite"]*$condit;
$total=$total+$users_["prix_unit"]*$users_["quantite"]*$condit; ?></td>

<?php } ?>
<tr>
<td></td>
<td></td>
<td></td>
<td>Total</td>
<td align="right"><?php echo $total; ?></td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
<td>Remise 10%</td>
<td align="right"><?php $remise_1=$total*10/100; echo $remise_1;?></td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
<td>Remise 2%</td>
<td align="right"><?php $remise_2=($total-$remise_1)*$remise2/100; echo $remise_2;?></td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
<td>Remise 3%</td>
<td align="right"><?php $remise_3=($total-$remise_1-$remise_2)*$remise3/100; echo $remise_3;?></td>
</tr>

<?
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_asr where commande='$evaluation' ORDER BY produit;";
	$users = db_query($database_name, $sql);$total1=0;

while($users_ = fetch_array($users)) { ?><tr>
<td><?php echo $users_["produit"]; ?></td>
<td><?php echo $users_["quantite"]; ?></td>
<td><?php echo $users_["condit"]; ?></td>
<td align="right"><?php echo $users_["prix_unit"]; ?></td>
<td align="right"><?php echo $users_["prix_unit"]*$users_["quantite"]*$users_["condit"];
$total1=$total1+$users_["prix_unit"]*$users_["quantite"]*$users_["condit"]; ?></td>

<?php } ?>

<tr>
<td></td>
<td></td>
<td></td>
<td>Net à payer</td>
<td align="right"><?php $net=$total+$total1-$remise_1-$remise_2-$remise_3; echo $net;?></td>
</tr>
</table>

<p style="text-align:center">


</body>

</html>