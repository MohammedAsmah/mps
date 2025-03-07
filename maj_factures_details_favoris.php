<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	$du="";$au="";$action="Recherche";
	
	?>
	
	<form id="form" name="form" method="post" action="maj_factures_details_favoris.php">
	<td><?php echo "Du : "; ?><input type="text" id="du" name="du" value="<?php echo $du; ?>" size="15"></td>
	<td><?php echo "Au : "; ?><input type="text" id="au" name="au" value="<?php echo $au; ?>" size="15"></td>
	<tr><td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<?
	if(isset($_REQUEST["action"]))
	{
	 $du=dateFrToUs($_POST['du']);$au=dateFrToUs($_POST['au']);
	$sql  = "SELECT * ";
	$sql .= "FROM factures where date_f between '$du' and '$au' ORDER BY id;";
	$users = db_query($database_name, $sql);
	
	
	
	
	
?>
</table>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "detail_facture.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<table class="table2">
<td><?php ?></td><td><?php ?></td>
</table>
<tr>
<table class="table2">

<tr>
	<th><?php $total=0;echo "Facture";?></th>
	<th><?php $total=0;echo "Produit";?></th>
	<th><?php echo "Quantité";?></th>
	<th><?php echo "Paquets";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Total";?></th>
	
</tr>
<?php $ca=0;
while($users_ = fetch_array($users)) { $facture=$users_["id"]+9040;$total=0;

	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_factures where facture=$facture and non_favoris=1 ORDER BY facture,produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;$favoris1=1;$compteur=0;
	while($users1_ = fetch_array($users1)) { $compteur=$compteur+1;}
	
?>
<? if ($compteur>0){?>
<tr>
<? $client=$users_["client"];$m=$users_["montant"];
	
	
	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_factures where facture=$facture and non_favoris=1 ORDER BY facture,produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;$favoris1=1;
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];$favoris=$users1_["favoris"];$numero=$users1_["facture"];
?><tr>
<td><?php echo $facture; ?></td>
<td><?php echo $users1_["produit"]; ?></td>
<td><?php echo $users1_["quantite"]; ?></td>
<td><?php echo $users1_["condit"]; ?></td>
<td><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<td><?php $total=$total+$m;echo number_format($m,2,',',' '); ?></td>
</tr>

<?	}?>
<td></td><td></td><td></td><td></td><td></td>
<td align="right" bgcolor="#FFFF00"><?php echo number_format($total,2,',',' '); ?></td>
<? }?>
<? }?>

</table>

<? }?>
<p style="text-align:center">


</body>

</html>