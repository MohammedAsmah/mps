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
	$action="recherche";$date1="";$date2="";
	
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
	
	$date1=$_GET['date1'];$total=0;$date2=$_GET['date2'];
	
	$sql  = "SELECT id,date_enc,date_valeur,client,client_tire,mode,v_banque,numero_cheque,valeur ";$chq="CHEQUE";$eff="EFFET";
	$sql .= "FROM porte_feuilles where (date_remise between '$date1' and '$date2') and (mode='$chq' or mode='$eff') and remise=0 ORDER BY date_remise;";
	$users11 = db_query($database_name, $sql);
?>


<span style="font-size:24px"><?php echo "Remise du : ".dateUsToFr($date1).' au '.dateUsToFr($date2); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date Valeur";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Client Tire";?></th>
	<th><?php echo "Mode";?></th>
	<th><?php echo "Numero Cheque";?></th>
	<th><?php echo "Montant";?></th>
	
</tr>

<?php $compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { $id_r=$users_1["id"];$date_enc=$users_1["date_enc"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];
			$mode=$users_1["mode"];$valeur=$users_1["valeur"];$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];
			$ref=$v_banque." ".$numero_cheque;$date_valeur=dateUsToFr($users_1["date_valeur"]);$date_valeur1=$users_1["date_valeur"];?>
			<td><? echo $date_valeur;?></td>
			<td><?php echo $client; ?></td>
			<td><?php echo $client_tire; ?></td>
			<td><?php echo $mode; ?></td>
			<td><?php echo $ref; ?></td>
			<td align="right"><?php $total_g=$total_g+$valeur;echo number_format($valeur,2,',',' '); ?></td></tr>

			<?
			$sql = "UPDATE porte_feuilles SET ";$remise=1;$remise_le=dateFrToUs(date("d/m/Y"));$n_banque=$_GET['n_banque'];
			$sql .= "remise = '" . $remise . "', ";
			$sql .= "remise_le = '" . $remise_le . "', ";
			$sql .= "remise_bq = '" . $n_banque . "' ";
			$sql .= "WHERE id = " . $id_r . ";";
			db_query($database_name, $sql);
			?>

<? } ?>
<tr><td></td><td></td><td></td><td></td><td align="right"><?php echo number_format($total_g,2,',',' '); ?></td>
</table>



</strong>
<p style="text-align:center">


</body>

</html>