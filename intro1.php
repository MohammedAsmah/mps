<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); 
	$profile_id = GetUserProfile(); $sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];// checks if current user is admin
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . Translate("Intro"); ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
--></script>

</head>

<body style="text-align:center">

<? if ($login=="admin" or $login=="nezha" or $login=="nabila"){?><center>

<table>
<tr><td style="height:50px"> <? echo "INSTANCES BONS DE COMMANDES ";?></td></tr>
<?
$sql  = "SELECT * ";$date_cloture="0000-00-00";
		$sql .= "FROM commandes_frs where date_cloture='$date_cloture' ORDER BY date_e;";
		$users = db_query($database_name, $sql);
?>

<table class="table2">

<tr><th><?php echo "DATE COMMANDE";?></th>
	<th><?php echo "FOURNISSEUR";?></th>
	<th><?php echo "ARTICLES";?></th>
	<th><?php echo "CLOTURE LE";?></th>
	
	
</tr>

<?php 

$total_g=0;
while($users_ = fetch_array($users)) { ?><tr><td><?php $date_e=dateUsToFr($users_["date_e"]);echo $date_e; ?></td>
<? $commande=$users_["commande"];$bln=$users_["bl"];$bcn=$users_["bc"];$evaluation=$users_["evaluation"];$client=$users_["client"];$date_ee=$users_["date_e"];
$vendeur=$users_["vendeur"];$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];$date_cloture=dateUsToFr($users_["date_cloture"]);
$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$id=$users_["id"]; $date_en=dateFrToUs($users_["date"]);$ev_pre=$users_["ev_pre"];
echo "<td><a href=\"bc_mps_details.php?date=$date_e&user_id=$id\">$client</a></td>";$ref=$users_["vendeur"];?>
<? echo "<td><a href=\"enregistrer_panier_bc_mps.php?vendeur=$vendeur&client=$client&date=$date_e&numero=$id\">Detail commande </a>";?>
<td><?php echo $date_cloture; $obs_cloture="ras";
/*$sql = "UPDATE commandes_frs SET ";
			
			$sql .= "date_cloture = '" . $date_ee . "', ";
			$sql .= "obs_cloture = '" . $obs_cloture . "' ";
			
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);*/



?></td>

<? 

 }?>

</table>

</table>
<? }?>
</center>

</body>

</html>