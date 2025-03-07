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

	$sql1  = "SELECT * ";$bcp="bcp";
	$sql1 .= "FROM rs_data_banques where banque='$bcp' ORDER BY banque;";
	$users1 = db_query($database_name, $sql1);$users_1 = fetch_array($users1);
	$oc=$users_1["oc"];$av=$users_1["av"];$escompte=$users_1["escompte"];
	
	
	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="ligne_effets_escompte.php">
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

<? 	 $date=date("Y-m-d");$total=0;$date_jour=date("Y-m-d");
	if(isset($_REQUEST["action"]))
	{ $date=dateFrToUs($_POST['date1']);$total=0;$date2=dateFrToUs($_POST['date2']);
	
	$sql  = "SELECT date_remise,date_enc,date_remise_e,client,client_tire,client_tire_e,vendeur,numero_effet,v_banque_e,facture_n,impaye,date_echeance,
	sum(m_effet) as total_effet ";
	$sql .= "FROM porte_feuilles_factures where facture_n<>0 and m_effet<>0 and remise_e=1
	and date_echeance>'$date2' group by numero_effet ORDER BY date_echeance;";
	$users11 = db_query($database_name, $sql);
	
?>


<span style="font-size:24px"><?php echo "Effets Remis à L'escompte : "." au ".$_POST['date2']; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo "Facture";?></th>
	<th><?php echo "Date Fact";?></th>
	<th><?php echo "Reference";?></th>
	<th><?php echo "Echeance";?></th>
	<th><?php echo "Mantant effet";?></th>
	<th><?php echo "Date Remise ";?></th>
	<th><?php echo "Nbr jours ";?></th>
	<th><?php echo "Cumul";?></th>
	
</tr>

<?php $compteur1=0;$total_g=0;$total_e=0;$total_c=0;$total_t=0;$total_ee=0;$d="";$d_t=0;
while($users_1 = fetch_array($users11)) { $date_enc=$users_1["date_enc"];$vendeur=$users_1["vendeur"];$impaye=$users_1["impaye"];
			$ref=$users_1["numero_effet"]."/".$users_1["v_banque_e"];$facture_n=$users_1["facture_n"];$date_remise=$users_1["date_remise"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire_e"];$client_tire_e=$users_1["client_tire_e"];
			$client=$users_1["client"];$total_e=$users_1["total_e"];$total_avoir=$users_1["total_avoir"];
			$total_cheque=$users_1["total_cheque"];$total_espece=$users_1["total_espece"];$total_effet=$users_1["total_effet"];
			$total_diff_prix=$users_1["total_diff_prix"];$date_echeance=$users_1["date_echeance"];$date_remise_e=$users_1["date_remise_e"];
	$sql  = "SELECT * ";
	$sql .= "FROM clients where client='$client' ORDER BY id;";
	$users111 = db_query($database_name, $sql);$user_ = fetch_array($users111);
		$inputation=$user_["inputation"];$patente=$user_["patente"];
				
				$sql  = "SELECT * ";
				$sql .= "FROM factures where numero='$facture_n' ORDER BY id;";
				$users = db_query($database_name, $sql);$row = fetch_array($users);$d=$row["date_f"];?>
			<? if ($d>=$date and $d<=$date2){?>

				

			<tr>
			<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$client </font>"); ?></td>
			<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$facture_n </font>"); ?></td>
			<td><?php $df=dateUsToFr($d);print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$df </font>"); ?></td>
			<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$ref </font>"); ?></td>
			<td><?php $d1= dateUsToFr($date_echeance);print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$d1 </font>"); ?></td>
			<td align="right"><?php $total_c=$total_c+$total_effet;$tchq=number_format($total_effet,2,',',' ');
			print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tchq </font>");
			 ?></td>
			 <td><?php $d1= dateUsToFr($date_remise_e);print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$d1 </font>"); ?></td>
			 <td align="center"><?php $duree = round((strtotime($date_echeance) - strtotime($date_remise_e))/(60*60*24)-1); $dt=$dt+$duree;print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$duree </font>"); ?></td>
			 <td align="right"><?php $tc=number_format($total_c,2,',',' ');
			print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tc </font>");
			 ?></td>
			 
			 	<? }?>
				
<? } ?>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
			<td align="right"><?php $tcc=number_format($total_c,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"#CC0000\">$tcc </font>");?></td>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><? echo "Ligne Escompte : ";?></td>
			<td align="right"><?php $lcc=number_format($escompte,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"#CC0000\">$lcc </font>");?></td>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><? echo "Solde Ligne Escompte : ";?></td>
			<td align="right"><?php $scc=number_format($escompte-$total_c,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"#CC0000\">$scc </font>");?></td>
</table>
</strong>
<p style="text-align:center">
<? }?>


</body>

</html>