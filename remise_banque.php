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
	$action="recherche";$date1="";$date2="";$n_banque="";
		$profiles_list_p = "Selectionnez Produit";
	$sql_produit = "SELECT * FROM rs_data_banques ORDER BY banque;";
	$temp_produit = db_query($database_name, $sql_produit);
	while($temp_produit_ = fetch_array($temp_produit)) {
		if($n_banque == $temp_produit_["banque"]) { $selected = " selected"; } else { $selected = ""; }
		$profiles_list_p .= "<OPTION VALUE=\"" . $temp_produit_["banque"] . "\"" . $selected . ">";
		$profiles_list_p .= $temp_produit_["banque"];
		$profiles_list_p .= "</OPTION>";
	}

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
	if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="remise_banque.php">
	<td><?php echo "Du : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au : "; ?><input onClick="ds_sh(this);" name="date2" value="<?php echo $date2; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Banque : "; ?><select id="n_banque" name="n_banque"><?php echo $profiles_list_p; ?></select></td>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<? }



	if(isset($_REQUEST["action"])){
	$date1=dateFrToUs($_POST['date1']);$total=0;$date2=dateFrToUs($_POST['date2']);$n_banque=$_POST['n_banque'];$eff="EFFET";
	
	/*$sql  = "SELECT * ";$chq="CHEQUE";
	$sql .= "FROM porte_feuilles where (date_cheque between '$date1' and '$date2') and remise=0 ORDER BY date_remise;";
	$users11 = db_query($database_name, $sql);*/
	$sql  = "SELECT date_cheque,client,client_tire,client_tire_e,vendeur,numero_cheque,v_banque,facture_n,
	sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix ";
	$sql .= "FROM porte_feuilles where (date_cheque between '$date1' and '$date2') and remise=0 and facture_n<>0 Group BY numero_cheque;";
	$users11 = db_query($database_name, $sql);

	
	
?>


<span style="font-size:24px"><?php echo "Remise du : ".dateUsToFr($date1).' au '.dateUsToFr($date2); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date Valeur";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Client Tire";?></th>
	<th><?php echo "Ref Cheque";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Observation";?></th>
</tr>

<?php $compteur1=0;$total_g=0;$total_ge=0;
while($users_1 = fetch_array($users11)) { 
			$ref=$users_1["numero_cheque"]."/".$users_1["v_banque"];$date_cheque=dateUsToFr($users_1["date_cheque"]);
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];$client_tire_e=$users_1["client_tire_e"];
			$client=$users_1["client"];$total_e=$users_1["total_e"];$total_avoir=$users_1["total_avoir"];
			$total_cheque=$users_1["total_cheque"];$total_espece=$users_1["total_espece"];$total_effet=$users_1["total_effet"];
			$total_diff_prix=$users_1["total_diff_prix"];$facture_n=$users_1["facture_n"];?>
			
			<td><? echo $date_cheque;?></td>
			<td><?php echo $client; ?></td>
			<td><?php echo $client_tire; ?></td>
			<td><?php echo $ref; ?></td>
			<td align="right"><?php $total_g=$total_g+$total_cheque;echo number_format($total_cheque,2,',',' '); ?></td>
			<td><?php echo $facture_n; ?></td>
            </tr>

<? } ?>
<tr><td></td><td></td><td></td><td></td><td align="right"><?php echo number_format($total_g,2,',',' '); ?></td>
</table>


<? echo "<tr><table><td><a href=\"remise_banque_valider.php?date1=$date1&date2=$date2&n_banque=$n_banque\">Valider Remise</a></td></table></tr>";?>

<? } ?>

</strong>
<p style="text-align:center">


</body>

</html>