<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";$action="Recherche";$date1="";$date2="";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url

	
	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="encaissements_mois.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date2" value="<?php echo $date2; ?>" readonly="readonly" style="cursor: text" /></td>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<? }


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

<? 	if(isset($_REQUEST["action"]))
	{ $date=dateFrToUs($_POST['date1']);$total=0;$date2=dateFrToUs($_POST['date2']);
	
	/*$sql  = "SELECT * ";$espece="ESPECE";
	$sql .= "FROM porte_feuilles where date_enc='$date' ORDER BY id_registre_regl;";
	$users11 = db_query($database_name, $sql);*/
	$sql  = "SELECT date_enc,client,client_tire,client_tire_e,vendeur,numero_cheque,v_banque,facture_n,impaye,
	sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix ";
	$sql .= "FROM porte_feuilles where facture_n<>0 and m_cheque<>0 and date_remise between '$date' and '$date2' Group BY id;";
	$users11 = db_query($database_name, $sql);
	
?>


<span style="font-size:24px"><?php echo "Encaissments Cheques : ".dateUsToFr($date)." Au ".dateUsToFr($date2); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Facture";?></th>
	<th><?php echo "Reference";?></th>
	<th><?php echo "ESPECE";?></th>
	<th><?php echo "CHEQUE";?></th>
	<th><?php echo "EFFET";?></th>
	
</tr>

<?php $compteur1=0;$total_g=0;$total_e=0;$total_c=0;$total_t=0;$total_ee=0;
while($users_1 = fetch_array($users11)) { $date_enc=$users_1["date_enc"];$vendeur=$users_1["vendeur"];$impaye=$users_1["impaye"];
			$ref=$users_1["numero_cheque"]."/".$users_1["v_banque"];$facture_n=$users_1["facture_n"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];$client_tire_e=$users_1["client_tire_e"];
			$client=$users_1["client"];$total_e=$users_1["total_e"];$total_avoir=$users_1["total_avoir"];
			$total_cheque=$users_1["total_cheque"];$total_espece=$users_1["total_espece"];$total_effet=$users_1["total_effet"];
			$total_diff_prix=$users_1["total_diff_prix"];
			if ($impaye==1){$total_espece=$users_1["total_cheque"];$total_cheque=$users_1["total_espece"];}?>
			
			
			<tr><td><?php echo $vendeur; ?></td>
			<td><?php echo $client; ?></td>
			<td><?php echo $facture_n; ?></td>
			<td><?php echo $ref; ?></td>

			<td align="right"><?php $total_e=$total_e+$total_espece;$total_ee=$total_ee+$total_espece;echo number_format($total_espece,2,',',' '); ?></td>
			<td align="right"><?php $total_c=$total_c+$total_cheque;echo number_format($total_cheque,2,',',' '); ?></td>
			<td align="right"><?php $total_t=$total_t+$total_effet;echo number_format($total_effet,2,',',' '); ?></td>

<? } ?>
<tr><td></td><td></td><td></td><td></td>
			<td align="right"><?php echo number_format($total_ee,2,',',' '); ?></td>
			<td align="right"><?php echo number_format($total_c,2,',',' '); ?></td>
			<td align="right"><?php echo number_format($total_t,2,',',' '); ?></td>

</table>
</strong>
<p style="text-align:center">


<? }?>
</body>

</html>