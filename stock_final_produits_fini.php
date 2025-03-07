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
	$sql  = "SELECT * ";
	$sql .= "FROM produits where stock_final>0 ORDER BY produit;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Stock Final Produits Fini"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "produit.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Stock Final Produits Finis"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Article";?></th>
	<th><?php echo "Quantite";?></th>
	<th><?php echo "Poids Unitaire";?></th>
	<th><?php echo "Poids Total";?></th>
	<th><?php echo "Matiere";?></th>
	<th><?php echo "Prix Revient";?></th>
	<th><?php echo "Valeur Total";?></th>
</tr>

<?php $valeur=0;$poids_total=0;while($users_ = fetch_array($users)) { ?><tr>
<td ><?php echo $users_["produit"]; ?></td>
<td align="center"><?php echo $users_["stock_final"]; ?></td>
<td align="center"><?php echo $users_["poids"]; ?></td>
<td align="right"><?php echo number_format(($users_["poids"]*$users_["stock_final"])/1000,3,',',' '); $poids_total=$poids_total+(($users_["poids"]*$users_["stock_final"])/1000);?></td>
<td ><?php if ($users_["matiere"]=="POLYPROPYLENE"){$mat="PP";}
if ($users_["matiere"]=="POLYPROPYLENE"){$mat="PP";}
if ($users_["matiere"]=="POLYSTERNE CRISTAL"){$mat="PS";}
if ($users_["matiere"]=="MATIERE CHOC"){$mat="PSC";}
if ($users_["matiere"]=="POLYTHYLENE"){$mat="PE";}
if ($users_["matiere"]=="REBROIYEE"){$mat="MR";}
if ($users_["matiere"]=="SOUFFLAGE"){$mat="PES";}
echo $mat; ?></td>
<td align="right"><?php echo $users_["prix_revient"]; ?></td>
<td align="right"><?php $valeur=$valeur+($users_["stock_final"]*$users_["prix_revient"]); echo number_format(($users_["stock_final"]*$users_["prix_revient"]),2,',',' ')?></td>
<?php } ?>
<tr><td></td><td></td><td></td><td align="right">
<?php echo number_format($poids_total,3,',',' '); ?>
</td><td></td><td></td>
<td align="right"><?php echo number_format($valeur,2,',',' '); ?></td>
</table>
<tr>
<span style="font-size:24px"><?php echo "Stock En cours au 31/12"; ?></span>
	<?
	$sql  = "SELECT * ";
	$sql .= "FROM produits where en_cours_final>0 ORDER BY produit;";
	$users = db_query($database_name, $sql);
	
?>

<table class="table2">

<tr>
	<th><?php echo "Article";?></th>
	<th><?php echo "Quantite";?></th>
	<th><?php echo "Poids Unitaire";?></th>
	<th><?php echo "Poids Total";?></th>
	<th><?php echo "Matiere";?></th>
	<th><?php echo "Prix Revient";?></th>
	<th><?php echo "Valeur Total";?></th>
</tr>

<?php $valeur=0;$poids_total=0;while($users_ = fetch_array($users)) { ?><tr>
<td ><?php echo $users_["produit"]; ?></td>
<td align="center"><?php echo $users_["en_cours_final"]; ?></td>
<td align="center"><?php echo $users_["poids"]; ?></td>
<td align="right"><?php echo number_format(($users_["poids"]*$users_["en_cours_final"])/1000,3,',',' '); 
$poids_total=$poids_total+(($users_["poids"]*$users_["en_cours_final"])/1000);?></td>
<td ><?php if ($users_["matiere"]=="POLYPROPYLENE"){$mat="PP";}
if ($users_["matiere"]=="POLYPROPYLENE"){$mat="PP";}
if ($users_["matiere"]=="POLYSTERNE CRISTAL"){$mat="PS";}
if ($users_["matiere"]=="MATIERE CHOC"){$mat="PSC";}
if ($users_["matiere"]=="POLYTHYLENE"){$mat="PE";}
if ($users_["matiere"]=="REBROIYEE"){$mat="MR";}
if ($users_["matiere"]=="SOUFFLAGE"){$mat="PES";}
echo $mat; ?></td>
<td align="right"><?php echo $users_["prix_revient_final"]; ?></td>
<td align="right"><?php $valeur=$valeur+($users_["en_cours_final"]*$users_["prix_revient_final"]); 
echo number_format(($users_["en_cours_final"]*$users_["prix_revient_final"]),2,',',' ')?></td>
<?php } ?>
<tr><td></td><td></td><td></td><td align="right">
<?php echo number_format($poids_total,3,',',' '); ?>
</td><td></td><td></td>
<td align="right"><?php echo number_format($valeur,2,',',' '); ?></td>
</table>

</tr>


<p style="text-align:center">


</body>

</html>