<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$action="Recherche";$date="";$date1="";$du="";$au="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
		
	
	// recherche ville
	
	$frs=$_GET['frs'];$produit=$_GET['produit'];
	
	
	
	
	
	$sql  = "SELECT * ";$col="col";
	$sql .= "FROM achats_mat where type='$col' and frs='$frs' and produit='$produit' group by date ORDER BY date;";
	$users = db_query($database_name, $sql);
		
	
	$sql1  = "SELECT * ";
		$sql1 .= "FROM detail_commandes_frs where produit='$produit' ORDER BY produit;";
		$users11 = db_query($database_name, $sql1);
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head><? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	
--></script>

</head>

<body style="background:#dfe8ff"><? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Achats Collorants : $frs ----> $produit "; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "Date";?></th>
	<th><?php echo "Ref";?></th>
	<th><?php echo "Quantite";?></th>
	<th><?php echo "Prix Unit";?></th>
	
</tr>
<? $t=0;$q=0;/*while($users_ = fetch_array($users)) {?><tr>
	
	<td><?php echo dateUsToFr($users_["date"]);?></td>
	<td><?php echo $users_["ref"];?></td>
	<td><?php echo $users_["qte"];?></td>
	<td><?php echo $users_["prix_achat"];?></td>
	

<? }*/?>

</table>


<table class="table2">

<tr>
	
	<th><?php echo "Date";?></th>
	<th><?php echo "Commande";?></th>
	<th><?php echo "Quantite";?></th>
	<th><?php echo "Prix Unit";?></th>
	
</tr>
<? $t=0;$q=0;while($user_11 = fetch_array($users11)) {?><tr>
	
	<td><?php echo dateUsToFr($user_11["date"]);$commande=$user_11["commande"];$c=219+$commande;
	if ($user_11["date_e"]<="2009-12-31" and $user_["date_e"]>="2009-01-01"){$annee="/09";}
		if ($user_11["date_e"]<="2010-12-31" and $user_11["date_e"]>="2010-01-01"){$annee="/10";}
		if ($user_11["date_e"]<="2011-12-31" and $user_11["date_e"]>="2011-01-01"){$annee="/11";}
		if ($user_11["date_e"]<="2012-12-31" and $user_11["date_e"]>="2012-01-01"){$annee="/12";}
		if ($user_11["date_e"]<="2013-12-31" and $user_11["date_e"]>="2013-01-01"){$annee="/13";}
		if ($user_11["date_e"]<="2014-12-31" and $user_11["date_e"]>="2014-01-01"){$annee="/14";}
		if ($user_11["date_e"]<="2015-12-31" and $user_11["date_e"]>="2015-01-01"){$annee="/15";}
		if ($user_11["date_e"]<="2016-12-31" and $user_11["date_e"]>="2016-01-01"){$annee="/16";}
		if ($user_11["date_e"]<="2017-12-31" and $user_11["date_e"]>="2017-01-01"){$annee="/17";}
		if ($user_11["date_e"]<="2018-12-31" and $user_11["date_e"]>="2018-01-01"){$annee="/18";}
		if ($user_11["date_e"]<="2019-12-31" and $user_11["date_e"]>="2019-01-01"){$annee="/19";}
		if ($user_11["date_e"]<="2020-12-31" and $user_11["date_e"]>="2020-01-01"){$annee="/19";}
		$numero_c=$c.$annee;?></td>
	<td><?php echo $numero_c;?></td>
	<td><?php echo $user_11["quantite"];?></td>
	<td><?php echo $user_11["prix_unit"];?></td>
	

<? }?>

</table>


</body>

</html>