<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$date="";$date_f="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;
		$date="";$action="Recherche";	
	$profiles_list_vendeur = "";$vendeur="";
	$du=$_GET["du"];$au=$_GET["au"];$matricule=$_GET["matricule"];$du1=dateUstofr($_GET["du"]);$au1=dateUsToFr($_GET["au"]);

	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url

		$sql  = "SELECT * ";
		$sql .= "FROM avoirs where matricule='$matricule' and date_e between '$du' and '$au' ORDER BY date_e;";
		$users = db_query($database_name, $sql);
	
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Avoirs"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "avoir_client.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "liste Avoirs Du $du1 Au $au1   -  $matricule "; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Numero BE.";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Ville";?></th>
	
</tr>

<?php 

$total_g=0;$bon="";$client_g="";$total_gg=0;
while($users_ = fetch_array($users)) { ?><tr>
<? $commande=$users_["commande"];$evaluation=$users_["be"];$client1=$users_["client"];$date_e=dateUsToFr($users_["date_e"]);
$vendeur=$users_["vendeur"];$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];$net1=$users_["net"];
$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$id=$users_["id"]; $date_en=dateFrToUs($users_["date"]);$ev_pre=$users_["ev_pre"];
$ref=$users_["vendeur"];$date=$users_["date_e"];

$bon=$bon."-".$evaluation;
$client_g=$client_g."-".$client;
$sql1  = "SELECT * ";
	$sql1 .= "FROM clients where client='$client1' ORDER BY client;";
	$users1 = db_query($database_name, $sql1);$user_ = fetch_array($users1);
	$ville = $user_["ville"];


?>
<td><?php echo dateUsToFr($users_["date_e"]); ?></td>
<td><?php echo $users_["be"]; ?></td>
<td><?php echo $users_["client"]; ?></td>
<td><?php echo $ville; ?></td>
<? ///////////////

	$sql1  = "SELECT * ";$m=0;$total=0;
	$sql1 .= "FROM detail_avoirs where commande='$numero' and sans_remise=0 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];
$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
//
			$sql = "UPDATE detail_avoirs SET ";
			$sql .= "client = '" . $client1 . "', ";
			$sql .= "date = '" . $date . "', ";
			$sql .= "vendeur = '" . $vendeur . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);


		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}

		$p=$users1_["prix_unit"];$total=$total+$m;
	}?>

<?
if ($sans_remise==1){$t=$total;$net=$total;} else {$t=$total;$remise_1=0;$remise_2=0;$remise_3=0;
if ($remise10>0){$remise_1=$total*$remise10/100;}?>
<? if ($remise2>0){$remise_2=($total-$remise_1)*$remise2/100;}?>
<? if ($remise3>0){$remise_3=($total-$remise_1-$remise_2)*$remise3/100;} ?>
<? }?>

<?	
	
	$sql1  = "SELECT * ";$total1=0;
	$sql1 .= "FROM detail_avoirs where commande='$numero' and sans_remise=1 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
//
			$sql = "UPDATE detail_avoirs SET ";
			$sql .= "client = '" . $client1 . "', ";
			$sql .= "date = '" . $date . "', ";
			$sql .= "vendeur = '" . $vendeur . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
			
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE ref = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}

$p=$users1_["prix_unit"];$total1=$total1+$m;}?>

<?php $net=$total+$total1-$remise_1-$remise_2-$remise_3; 

/////////////////?>



<?php } ?>

</tr>

</table>


<p style="text-align:center">


</body>

</html>