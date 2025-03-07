<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$produit = $_REQUEST["produit"];$numero = $_REQUEST["numero"];$client = $_REQUEST["client"];$montant = $_REQUEST["montant"];

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM detail_factures WHERE produit='$produit' and facture = " . $numero . ";";
		$user = db_query($database_name, $sql); 

		$title = "details";$total=0;
		while($users1_ = fetch_array($user)) { 
		 $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		 $p=$users1_["prix_unit"]; 
		 $total=$total+$m; 
			}

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

<span style="font-size:24px"><?php echo "Facture : ".$numero."---> Article : ".$produit." --->Valeur : ".number_format($total,2,',',' '); ?></span>

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
<? @$qte=$total/($users_["condit"]*$users_["prix"]);?>
<?php $v = intval($qte);$centime = round(($qte * 100) - ($v * 100),0);?>
<?php $valeur=$qte*$users_["condit"]*$users_["prix"]; ?>
<? if ($centime==0 and $valeur==$total and $produit<>$users_["produit"]){?><tr>
<? $produit1=$users_["produit"];$prix_unit=$users_["prix"];$condit=$users_["condit"];$action1_="sub"; $trouve=$trouve+1;

echo "<td><a href=\"maj_factures.php?numero=$numero&action1_=$action1_&produit=$produit&produit1=$produit1
&quantite=$qte&prix_unit=$prix_unit&condit=$condit&client=$client\">$produit1</a></td>";?>
<td><?php echo $users_["condit"]; ?></td>
<td style="text-align:left"><?php echo $users_["prix"]; ?></td>
<td bgcolor="#33CCFF"><?php echo number_format($valeur,2,',',' '); ?></td>
<td bgcolor="#33CCFF"><?php echo number_format($qte,2,',',' '); ?></td>
<? }?>
<?php } ?>

<tr>
	<th><?php echo "Montant  divisé sur /2";?></th>
</tr>

<?php
	$sql  = "SELECT * ";
	$sql .= "FROM produits where favoris=1 ORDER BY produit;";
	$users = db_query($database_name, $sql);
 $trouve=0;while($users_ = fetch_array($users)) { ?>
<? @$qte=($total/2)/($users_["condit"]*$users_["prix"]);?>
<?php $v = intval($qte);$centime = round(($qte * 100) - ($v * 100),0);?>
<?php $valeur=$qte*$users_["condit"]*$users_["prix"]; ?>
<? if ($centime==0 and $valeur==$total/2 and $produit<>$users_["produit"]){?><tr>
<? $produit1=$users_["produit"];$prix_unit=$users_["prix"];$condit=$users_["condit"];$action1_="sub"; $trouve=$trouve+1;

/*echo "<td><a href=\"maj_factures.php?numero=$numero&action1_=$action1_&produit=$produit&produit1=$produit1
&quantite=$qte&prix_unit=$prix_unit&condit=$condit&client=$client\">$produit1</a></td>";*/?>
<td><?php echo $produit1; ?></td>
<td><?php echo $users_["condit"]; ?></td>
<td style="text-align:left"><?php echo $users_["prix"]; ?></td>
<td bgcolor="#33CCFF"><?php echo number_format($valeur,2,',',' '); ?></td>
<td bgcolor="#33CCFF"><?php echo number_format($qte,2,',',' '); ?></td>
<? }?>
<?php } ?>

<tr>
	<th><?php echo "Montant  divisé sur /3";?></th>
</tr>

<?php
	$sql  = "SELECT * ";
	$sql .= "FROM produits where favoris=1 ORDER BY produit;";
	$users = db_query($database_name, $sql);
 $trouve=0;while($users_ = fetch_array($users)) { ?>
<? @$qte=($total/3)/($users_["condit"]*$users_["prix"]);?>
<?php $v = intval($qte);$centime = round(($qte * 100) - ($v * 100),0);?>
<?php $valeur=$qte*$users_["condit"]*$users_["prix"]; ?>
<? if ($centime==0 and $valeur==$total/3 and $produit<>$users_["produit"]){?><tr>
<? $produit1=$users_["produit"];$prix_unit=$users_["prix"];$condit=$users_["condit"];$action1_="sub"; $trouve=$trouve+1;

/*echo "<td><a href=\"maj_factures.php?numero=$numero&action1_=$action1_&produit=$produit&produit1=$produit1
&quantite=$qte&prix_unit=$prix_unit&condit=$condit&client=$client\">$produit1</a></td>";*/?>
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

<?php
	$sql  = "SELECT * ";
	$sql .= "FROM produits where favoris=1 ORDER BY produit;";
	$users = db_query($database_name, $sql);
 $trouve=0;while($users_ = fetch_array($users)) { ?>
<? @$qte=($total/4)/($users_["condit"]*$users_["prix"]);?>
<?php $v = intval($qte);$centime = round(($qte * 100) - ($v * 100),0);?>
<?php $valeur=$qte*$users_["condit"]*$users_["prix"]; ?>
<? if ($centime==0 and $valeur==$total/4 and $produit<>$users_["produit"]){?><tr>
<? $produit1=$users_["produit"];$prix_unit=$users_["prix"];$condit=$users_["condit"];$action1_="sub"; $trouve=$trouve+1;

/*echo "<td><a href=\"maj_factures.php?numero=$numero&action1_=$action1_&produit=$produit&produit1=$produit1
&quantite=$qte&prix_unit=$prix_unit&condit=$condit&client=$client\">$produit1</a></td>";*/?>
<td><?php echo $produit1; ?></td>
<td><?php echo $users_["condit"]; ?></td>
<td style="text-align:left"><?php echo $users_["prix"]; ?></td>
<td bgcolor="#33CCFF"><?php echo number_format($valeur,2,',',' '); ?></td>
<td bgcolor="#33CCFF"><?php echo number_format($qte,2,',',' '); ?></td>
<? }?>
<?php } ?>

<tr>
	<th><?php echo "Montant  divisé sur /5";?></th>
</tr>

<?php 
	$sql  = "SELECT * ";
	$sql .= "FROM produits where favoris=1 ORDER BY produit;";
	$users = db_query($database_name, $sql);
$trouve=0;while($users_ = fetch_array($users)) { ?>
<? @$qte=($total/5)/($users_["condit"]*$users_["prix"]);?>
<?php $v = intval($qte);$centime = round(($qte * 100) - ($v * 100),0);?>
<?php $valeur=$qte*$users_["condit"]*$users_["prix"]; ?>
<? if ($centime==0 and $valeur==$total/5 and $produit<>$users_["produit"]){?><tr>
<? $produit1=$users_["produit"];$prix_unit=$users_["prix"];$condit=$users_["condit"];$action1_="sub"; $trouve=$trouve+1;

/*echo "<td><a href=\"maj_factures.php?numero=$numero&action1_=$action1_&produit=$produit&produit1=$produit1
&quantite=$qte&prix_unit=$prix_unit&condit=$condit&client=$client\">$produit1</a></td>";*/?>
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