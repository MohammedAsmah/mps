<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
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

<span style="font-size:24px"><?php echo "Detail Evaluation : "; ?></span>

<table class="table2">

<tr>
	<th><?php $total=0;echo "Facture";?></th>
	<th><?php $total=0;echo "Produit";?></th>
	<th><?php echo "Quantité";?></th>
	<th><?php echo "Paquets";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Total";?></th>
</tr>


<?
	$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_asr ORDER BY commande;";
	$users = db_query($database_name, $sql);$total1=0;

while($users_ = fetch_array($users)) { ?><tr>
<? 		
	$c=$users_["commande"];
	$sql1  = "SELECT * ";
	$sql1 .= "FROM commandes where commande='$c' ORDER BY commande;";
		$user1 = db_query($database_name, $sql1); $user1_ = fetch_array($user1);
		$date = $user1_["date"];$facture = $user1_["facture"];
?>
<td><?php echo $facture; ?></td>
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
<td align="right"><?php $net=$total1; echo $net;?></td>
</tr>
</table>

<p style="text-align:center">


</body>

</html>