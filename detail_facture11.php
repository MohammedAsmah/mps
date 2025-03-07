<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$numero = $_REQUEST["numero"];$client = $_REQUEST["client"];$montant = $_REQUEST["montant"];

		$action_ = "update_user";
		
		// gets user infos

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
		if(document.getElementById("produit").value == "" ) {
			alert("<?php echo Translate("The values for the fields [First name] and [Last name] are required !"); ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "maj_factures.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo "Facture : ".$numero."---> Article :  --->Valeur : ".number_format($montant,2,',',' '); ?></span>

<form id="form_user" name="form_user" method="post" action="maj_factures.php">


<p style="text-align:center">

<center>

<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="numero" name="numero" value="<?php echo $numero; ?>">
<input type="hidden" id="client" name="client" value="<?php echo $client; ?>">
<table class="table3"><tr>

</tr></table>

<? 	
	$sql  = "SELECT * ";
	$sql .= "FROM produits where favoris=1 ORDER BY produit;";
	$users = db_query($database_name, $sql);

?>
<table class="table2">

<tr>
	<th><?php echo "Article";?></th>
	<th><?php echo "Paquets";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Valeur";?></th>
	<th><?php echo "Qte";?></th>
</tr>
<tr>
	<th><?php echo "Montant  divisé sur /1";?></th>
</tr>
<?php $trouve=0;while($users_ = fetch_array($users)) { ?>
<? @$qte=($montant)/($users_["condit"]*$users_["prix"]);?>
<?php $v = intval($qte);$centime = round(($qte * 100) - ($v * 100),0);?>
<?php $valeur=$qte*$users_["condit"]*$users_["prix"]; ?>
<? if ($centime==0 and $valeur==$montant ){?><tr>
<? $produit1=$users_["produit"];$prix_unit=$users_["prix"];$condit=$users_["condit"];$action1_="sub"; $trouve=$trouve+1;?>

<td><?php echo $produit1; ?></td>

<td><?php echo $users_["condit"]; ?></td>
<td style="text-align:left"><?php echo $users_["prix"]; ?></td>
<td bgcolor="#33CCFF"><?php echo number_format($valeur,2,',',' '); ?></td>
<td bgcolor="#33CCFF"><?php echo number_format($qte,2,',',' '); ?></td>
<? }?>
<?php } ?>

<? ///////////////?>
<tr>
	<th><?php echo "Montant  divisé sur /2";?></th>
</tr>
<?php 
	$sql  = "SELECT * ";
	$sql .= "FROM produits where favoris=1 ORDER BY produit;";
	$users = db_query($database_name, $sql);
$trouve=0;while($users_ = fetch_array($users)) { ?>
<? @$qte=($montant/2)/($users_["condit"]*$users_["prix"]);?>
<?php $v = intval($qte);$centime = round(($qte * 100) - ($v * 100),0);?>
<?php $valeur=$qte*$users_["condit"]*$users_["prix"]; ?>
<? if ($centime==0 and $valeur==$montant/2 ){?><tr>
<? $produit1=$users_["produit"];$prix_unit=$users_["prix"];$condit=$users_["condit"];$action1_="sub"; $trouve=$trouve+1;?>

<td><?php echo $produit1; ?></td>

<td><?php echo $users_["condit"]; ?></td>
<td style="text-align:left"><?php echo $users_["prix"]; ?></td>
<td bgcolor="#33CCFF"><?php echo number_format($valeur,2,',',' '); ?></td>
<td bgcolor="#33CCFF"><?php echo number_format($qte,2,',',' '); ?></td>
<? }?>
<?php } ?>

<? ///////////////?>
<tr>
	<th><?php echo "Montant  divisé sur /3";?></th>
</tr>
<?php 
	$sql  = "SELECT * ";
	$sql .= "FROM produits where favoris=1 ORDER BY produit;";
	$users = db_query($database_name, $sql);
$trouve=0;while($users_ = fetch_array($users)) { ?>
<? @$qte=($montant/3)/($users_["condit"]*$users_["prix"]);?>
<?php $v = intval($qte);$centime = round(($qte * 100) - ($v * 100),0);?>
<?php $valeur=$qte*$users_["condit"]*$users_["prix"]; ?>
<? if ($centime==0 and $valeur==$montant/3){?><tr>
<? $produit1=$users_["produit"];$prix_unit=$users_["prix"];$condit=$users_["condit"];$action1_="sub"; $trouve=$trouve+1;?>

<td><?php echo $produit1; ?></td>

<td><?php echo $users_["condit"]; ?></td>
<td style="text-align:left"><?php echo $users_["prix"]; ?></td>
<td bgcolor="#33CCFF"><?php echo number_format($valeur,2,',',' '); ?></td>
<td bgcolor="#33CCFF"><?php echo number_format($qte,2,',',' '); ?></td>
<? }?>
<?php } ?>
<tr>
	<th><?php echo "Montant  divisé sur /4";?></th>
</tr>

<? ///////////////?>
<?php 
	$sql  = "SELECT * ";
	$sql .= "FROM produits where favoris=1 ORDER BY produit;";
	$users = db_query($database_name, $sql);
$trouve=0;while($users_ = fetch_array($users)) { ?>
<? @$qte=($montant/4)/($users_["condit"]*$users_["prix"]);?>
<?php $v = intval($qte);$centime = round(($qte * 100) - ($v * 100),0);?>
<?php $valeur=$qte*$users_["condit"]*$users_["prix"]; ?>
<? if ($centime==0 and $valeur==$montant/4){?><tr>
<? $produit1=$users_["produit"];$prix_unit=$users_["prix"];$condit=$users_["condit"];$action1_="sub"; $trouve=$trouve+1;?>
<td><?php echo $produit1; ?></td>

<td><?php echo $users_["condit"]; ?></td>
<td style="text-align:left"><?php echo $users_["prix"]; ?></td>
<td bgcolor="#33CCFF"><?php echo number_format($valeur,2,',',' '); ?></td>
<td bgcolor="#33CCFF"><?php echo number_format($qte,2,',',' '); ?></td>
<? }?>
<?php } ?>


<? ///////////////?>
<tr>
	<th><?php echo "Montant  divisé sur /5";?></th>
</tr>

<? ///////////////?>
<?php 
	$sql  = "SELECT * ";
	$sql .= "FROM produits where favoris=1 ORDER BY produit;";
	$users = db_query($database_name, $sql);
$trouve=0;while($users_ = fetch_array($users)) { ?>
<? @$qte=($montant/5)/($users_["condit"]*$users_["prix"]);?>
<?php $v = intval($qte);$centime = round(($qte * 100) - ($v * 100),0);?>
<?php $valeur=$qte*$users_["condit"]*$users_["prix"]; ?>
<? if ($centime==0 and $valeur==$montant/5 ){?><tr>
<? $produit1=$users_["produit"];$prix_unit=$users_["prix"];$condit=$users_["condit"];$action1_="sub"; $trouve=$trouve+1;?>

<td><?php echo $produit1; ?></td>

<td><?php echo $users_["condit"]; ?></td>
<td style="text-align:left"><?php echo $users_["prix"]; ?></td>
<td bgcolor="#33CCFF"><?php echo number_format($valeur,2,',',' '); ?></td>
<td bgcolor="#33CCFF"><?php echo number_format($qte,2,',',' '); ?></td>
<? }?>
<?php } ?>



<? if ($trouve==0){?>
<td><?php echo "aucun article ne correspond à cette valeur !!"; ?></td>
<? }?>

</table>


</center>

</form>

</body>

</html>