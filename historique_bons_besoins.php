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

<center>



</table>

<table>
<tr><td style="height:50px"> <? echo "HISTORIQUE BONS DE BESOINS";?></td></tr>
<?
$sql  = "SELECT * ";$date_cloture="0000-00-00";$partielle="reception partielle";
		$sql .= "FROM detail_bon_besoin where date_b<>'$date_cloture' ORDER BY date_b;";
		$usersbb = db_query($database_name, $sql);
?>

<table class="table2">

<tr><th><?php echo "ID";?></th>
	<th><?php echo "DATE";?></th>
	<th><?php echo "DESIGNATION";?></th>
	<th><?php echo "QUANTITE";?></th>
	<th><?php echo "UNITE";?></th>
	<th><?php echo "BESOIN";?></th>
	<th><?php echo "Demandeur";?></th>
	<th><?php echo "OBS";?></th>
	<th><?php echo "STATUT";?></th>
	
</tr>

<? 
while($users_b = fetch_array($usersbb)) { ?><tr>

<td><?php echo $users_b["id"];$id=$users_b["id"];?></td>
<td><?php echo dateUsToFr($users_b["date_b"]); ?></td>
<td><?php echo $users_b["produit"]; ?></td>
<td><?php echo $users_b["quantite"]; ?></td>
<td><?php echo $users_b["unite"]; ?></td>
<td><?php echo $users_b["besoin"]; ?></td>
<td><?php echo $users_b["demandeur_bb"]; ?></td>
<td><?php echo $users_b["obs"]; ?></td>
<td><?php echo $users_b["statut"]; ?></td>





<? }?>
</table>


</center>

</body>

</html>