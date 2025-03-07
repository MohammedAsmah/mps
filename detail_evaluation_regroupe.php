<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	$numero=$_GET['numero'];$client=$_GET['client'];$id=$_GET['numero']-9040;
	
		$sql  = "SELECT * ";
		$sql .= "FROM factures WHERE id = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_f"]);
		$client = $user_["client"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];$remise3 = $user_["remise_3"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];
	
?>
</table>

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
<table class="table2">
<TR><td>MOULAGE PLASTIQUE DU SUD</td>
<TD></TD>
<TD align="center">FACTURE</TD>
</TR>
<TR>
<TD></TD><TD></TD>
<th align="center"><?php echo $numero;?></th>
</tr>
<tr></tr>
<tr>
<td><?php echo "Client : $client";?></td>
<td align="center"><?php echo "Date : $date";?></td>
</tr>
</table>



<table class="table2">

<tr>
	<th><?php $total=0;echo "Produit";?></th>
	<th><?php echo "Quantité";?></th>
	<th><?php echo "Paquets";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Total";?></th>
</tr>

<?	
	$sql  = "SELECT * ";
	$sql .= "FROM produits ORDER BY produit;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) { 
 		$produit = $users_["produit"];$condit1 = $users_["condit"];$qte=0;$prix = $users_["prix"];$montant=0;$condit=0;
	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_factures where facture='$numero' and produit='$produit' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
			$qte=$qte+$users1_["quantite"];$montant=$montant+($users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"]);
	
	}
	
	if ($qte>0)
	
	{?>
<td align="left"><?php echo $produit; ?></td>
<td align="center"><?php echo $qte; ?></td>
<td align="center"><?php echo $condit1; ?></td>
<td align="right"><?php $p=$montant/$qte/$condit1;echo number_format($p,2,',',' '); ?></td>
<td align="right"><?php $m=$montant;$total=$total+$montant;echo number_format($m,2,',',' '); ?></td>
</tr>
<?	} }?>

<?
if ($sans_remise==1){?>
<td></td><td></td><td></td>
<td>Net à payer</td>
<td align="right"><?php $t=$total;echo number_format($t,2,',',' '); ?></td>
<? } else {?>

<td></td><td></td><td></td>
<td>Total</td>
<td align="right"><?php $t=$total;echo number_format($t,2,',',' '); ?></td>
<? 		
		$remise_1=0;$remise_2=0;$remise_3=0;
?>
<tr>
<td></td>
<td></td>
<td></td>
<? if ($remise10>0){?>
<td>Remise 10%</td>
<td align="right"><?php $remise_1=$total*$remise10/100; echo number_format($remise_1,2,',',' ');?></td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
<? }?>
<? if ($remise2>0){?>
<td><? if ($remise2==2){echo "Remise 2%";}?></td>
<td align="right"><?php $remise_2=($total-$remise_1)*$remise2/100; echo number_format($remise_2,2,',',' ');?></td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
<? }?>
<? if ($remise3>0){?>
<td><? if ($remise3==2){echo "Remise 2%";}else{echo "Remise 3%";}?></td>
<td align="right"><?php $remise_3=($total-$remise_1-$remise_2)*$remise3/100; echo number_format($remise_3,2,',',' ');?></td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
<? }?>
<td>Net à payer</td>
<td align="right"><?php $net=$total-$remise_1-$remise_2-$remise_3; echo number_format($net,2,',',' ');?></td>
</tr>

<? }?>

</table>

<p style="text-align:center">


</body>

</html>