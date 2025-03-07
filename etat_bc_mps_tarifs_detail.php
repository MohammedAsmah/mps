<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();	$user_name=GetUserName();


	$error_message = "";$date="";$date_f="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;
		$date="";$action="Recherche";	
	$profiles_list_vendeur = "";$vendeur="";

	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	
	$produit = $_GET["produit"];$id = $_GET["id"];
	
		$sql  = "SELECT * ";
		$sql .= "FROM detail_commandes_frs where id = '$id' ORDER BY prix_unit;";
		$users1 = db_query($database_name, $sql);
		$user_ = fetch_array($users1);$produit = $user_["produit"];
	
	

	
		
		$sql  = "SELECT * ";
		$sql .= "FROM detail_commandes_frs where produit = '$produit' ORDER BY prix_unit;";
		$users = db_query($database_name, $sql);
		
		
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Commandes"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "Tarifs Achats : $produit "; ?></span>
<tr>


<table class="table2">

<tr>
	<th><?php echo "Date";?></th><th><?php echo "Ref";?></th>
	<th><?php echo "Fournisseur";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Quantite";?></th>
	<th><?php echo "Mode";?></th>

	
</tr>

<?php 

$total_g=0;
while($users_ = fetch_array($users)) { ?><tr>
<?php $commande=$users_["commande"]; $prix_unit=$users_["prix_unit"]; $qte=$users_["quantite"]; $prix_ref=$users_["prix_ref"];

if ($users_["prix_unit"]==0){$prix=$prix_ref;}else{$prix=number_format($users_["prix_unit"],2,',',' ');}
		$sql  = "SELECT * ";
		$sql .= "FROM commandes_frs WHERE id = " . $commande . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_e"]);$montant_f=$user_["net"];$date_sortie = $user_["date_e"];
		$client = $user_["client"];$piece = $user_["piece"];$ttc = $user_["ttc"];if ($ttc==1){$ttc="TTC";}else{$ttc="HT";}
		$vendeur = $user_["vendeur"];
		if ($user_["date_e"]<="2009-12-31" and $user_["date_e"]>="2009-01-01"){$annee="/09";}
		if ($user_["date_e"]<="2010-12-31" and $user_["date_e"]>="2010-01-01"){$annee="/10";}
		if ($user_["date_e"]<="2011-12-31" and $user_["date_e"]>="2011-01-01"){$annee="/11";}
		if ($user_["date_e"]<="2012-12-31" and $user_["date_e"]>="2012-01-01"){$annee="/12";}
		if ($user_["date_e"]<="2013-12-31" and $user_["date_e"]>="2013-01-01"){$annee="/13";}
		if ($user_["date_e"]<="2014-12-31" and $user_["date_e"]>="2014-01-01"){$annee="/14";}
		if ($user_["date_e"]<="2015-12-31" and $user_["date_e"]>="2015-01-01"){$annee="/15";}
		if ($user_["date_e"]<="2016-12-31" and $user_["date_e"]>="2016-01-01"){$annee="/16";}
		if ($user_["date_e"]<="2017-12-31" and $user_["date_e"]>="2017-01-01"){$annee="/17";}
		if ($user_["date_e"]<="2018-12-31" and $user_["date_e"]>="2018-01-01"){$annee="/18";}
		if ($user_["date_e"]<="2019-12-31" and $user_["date_e"]>="2019-01-01"){$annee="/19";}
		if ($user_["date_e"]<="2020-12-31" and $user_["date_e"]>="2020-01-01"){$annee="/19";}
		
		$c=219+$commande;
		$numero_c=$c.$annee;

?>
<? echo "<td>$date"; ?></td>
<? echo "<td>$numero_c"; ?></td>
<? echo "<td>$client"; ?></td>
<? echo "<td>$prix "; ?></td>
<? echo "<td>$qte "; ?></td>
<? echo "<td>$ttc "; ?></td>

<? }?>

</table>
<tr>
</tr>

<p style="text-align:center">
</body>

</html>