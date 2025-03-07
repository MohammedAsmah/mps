<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";$action="Recherche";$date1="";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url


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
	$tableau=$_GET['tableau'];$total=0;$vendeur=$_GET['vendeur'];$service=$_GET['service'];
	
	/*$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles where id_registre_regl='$tableau' and (m_cheque<>0 or m_effet<>0) ORDER BY id_registre_regl;";
	$users11 = db_query($database_name, $sql);*/
	$sql  = "SELECT numero_cheque,v_banque,date_enc,facture_n,montant_f,client,client_tire,client_tire_e,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix ";
	$sql .= "FROM porte_feuilles where id_registre_regl='$tableau' and m_cheque<>0 and facture_n<>0 and impaye<>1 Group BY id;";
	$users11 = db_query($database_name, $sql);
	
	
?>


<span style="font-size:24px"><?php echo "ETAT DES CHEQUES : "; ?></span>

<table class="table2">
	<th><?php echo "Tableau : ".$tableau."/2009";?></th>
	<th><?php echo "Vendeur : ".$vendeur;?></th>
	<th><?php echo "Destination : ".$service;?></th>

</table>



<table class="table2">

<tr>
	<th><?php echo "Date Entree";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "M.T Chq";?></th>
	<th><?php echo "M.T Effet";?></th>
	<th><?php echo "M.T Fact";?></th>
	<th><?php echo "N° Fact";?></th>
	<th><?php echo "M.T Traité";?></th>
	
</tr>

<?php $compteur1=0;$total_g=0;$total_e=0;$total_c=0;$total_t=0;$total_ce=0;
while($users_1 = fetch_array($users11)) { 
			$date_enc=$users_1["date_enc"];
			$client=$users_1["client"];$facture_n=$users_1["facture_n"];$client_tire=$users_1["client_tire"];
			$total_cheque=$users_1["total_cheque"];$numero_cheque=$users_1["numero_cheque"];$total_effet=$users_1["total_effet"];
			$montant_f=$users_1["montant_f"];$client_tire_e=$users_1["client_tire_e"];$v_banque=$users_1["v_banque"];?>
			<tr><td><?php echo dateUsToFr($users_1["date_enc"]); ?></td>
			<td><?php echo $client."/".$client_tire."/".$client_tire_e."/ ".$numero_cheque."/".$v_banque; ?></td>
			<td align="right"><?php $total_c=$total_c+$total_cheque;echo number_format($total_cheque,2,',',' '); ?></td>
			<td align="right"><?php $total_e=$total_e+$total_effet;echo number_format($total_effet,2,',',' '); ?></td>
			<td align="right"><?php $total_t=$total_t+$montant_f;echo number_format($montant_f,2,',',' '); ?></td>
			<td align="right"><?php echo $facture_n; ?></td>
			<td align="right"><?php $total_ce=$total_ce+$total_cheque+$total_effet;echo number_format($total_cheque+$total_effet,2,',',' '); ?></td>

<? } ?>
<tr>
<td></td><td></td><td align="right"><?php echo number_format($total_c,2,',',' '); ?></td>
<td align="right"><?php echo number_format($total_e,2,',',' '); ?></td>
<td align="right"></td>
<td></td>
<td align="right"><?php echo number_format($total_ce,2,',',' '); ?></td>

</table>
</strong>
<p style="text-align:center">


</body>

</html>