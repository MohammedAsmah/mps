<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$action="recherche";
	
	?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	

	$date=dateFrToUs(date("d/m/Y"));$total=0;
	
	$sql  = "SELECT * ";$espece="ESPECE";
	$sql .= "FROM porte_feuilles where date_valeur>='$date' and mode<>'$espece' ORDER BY date_valeur;";
	$users11 = db_query($database_name, $sql);
?>


<span style="font-size:24px"><?php echo "Porte Feuilles au : ".dateUsToFr($date); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date V";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Client Tiré";?></th>
	<th><?php echo "Mode";?></th>
	<th><?php echo "Reference";?></th>
	<th><?php echo "Montant";?></th>
	
</tr>

<?php $compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { $id_r=$users_1["id"];$date_enc=$users_1["date_enc"];$vendeur=$users_1["vendeur"];
			$client=$users_1["client"];$evaluation=$users_1["evaluation"];$client_tire=$users_1["client_tire"];
			$mode=$users_1["mode"];$valeur=$users_1["valeur"];$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];
			$ref=$v_banque." ".$numero_cheque;?>
			<tr><td><?php echo dateUsToFr($users_1["date_valeur"]); ?></td>
			<td><?php echo $client; ?></td>
			<td><?php echo $client_tire; ?></td>
			<td><?php echo $mode; ?></td>
			<td><?php echo $ref; ?></td>
			<td align="right"><?php $total=$total+$valeur;echo number_format($valeur,2,',',' '); ?></td></tr>


<? } ?>
<tr><td></td><td></td><td></td><td></td><td></td>
			<td align="right"><?php echo number_format($total,2,',',' '); ?></td>
</table>
</strong>
<p style="text-align:center">
<table class="table2">

<tr>
	<th><?php echo "Date V";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Client Tiré";?></th>
	<th><?php echo "Mode";?></th>
	<th><?php echo "Reference";?></th>
	<th><?php echo "Montant";?></th>
	
</tr>
<?
$sql  = "SELECT date_virement,date_remise,date_echeance,date_enc,numero_cheque,facture_n,client,client_tire,v_banque,
		sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece
		, sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
		$sql .= "FROM porte_feuilles where facture_n=10042 Group BY id order by facture_n;";
		
		$users111 = db_query($database_name, $sql);/**/
while($users_11 = fetch_array($users111)) { $id_r=$users_11["id"];$date_enc=$users_11["date_enc"];$vendeur=$users_11["vendeur"];
			$client=$users_11["client"];$evaluation=$users_11["evaluation"];$client_tire=$users_11["client_tire"];
			$mode=$users_11["mode"];$valeur=$users_11["valeur"];$v_banque=$users_11["v_banque"];$numero_cheque=$users_11["numero_cheque"];
			$facture_n=$users_11["facture_n"];$total_cheque=$users_11["total_cheque"];$total_espece=$users_11["total_espece"];?>
			<tr><td><?php echo dateUsToFr($users_11["date_remise"]); ?></td>
			<td><?php echo $client; ?></td>
			<td><?php echo $client_tire; ?></td>
			<td><?php echo $total_cheque; ?></td>
			<td><?php echo $total_espece; ?></td>
			<?
			$sql  = "SELECT * ";
	$sql .= "FROM factures where numero='$facture_n' ORDER BY id;";
	$users1 = db_query($database_name, $sql);$row1 = fetch_array($users1);$dt=dateUsToFr($row1["date_f"]);
	$d=$row1["date_f"];$ff=$row1["numero"];?>
	<td><?php echo $d; ?></td>		


<? } ?>	


</body>

</html>