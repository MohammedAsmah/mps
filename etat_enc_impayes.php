<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";$date1="";$date2="";$action="Recherche";$total_g=0;
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url

	
	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="etat_enc_impayes.php">
	<td><?php echo "Du : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au : "; ?><input onClick="ds_sh(this);" name="date2" value="<?php echo $date2; ?>" readonly="readonly" style="cursor: text" /></td>
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

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre_remise.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	


	if(isset($_REQUEST["action"]))
	{ $date=dateFrToUs($_POST['date1']);$date2=dateFrToUs($_POST['date2']);
	$date_d1=dateFrToUs($_POST['date1']);$date_d2=dateFrToUs($_POST['date2']);
	$de1=dateFrToUs($_POST['date1']);$de2=dateFrToUs($_POST['date2']);}
	
	
	if (isset($_REQUEST["action"])){
	$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles_impayes where date_enc between '$date' and '$date2' and facture_n<>0 ORDER BY date_enc;";
	//$sql .= "FROM porte_feuilles_impayes where (date_enc between '$date' and '$date2' and m_espece<>0) or (date_remise_e between '$date' and '$date2' and m_effet<>0) or (date_remise between '$date' and '$date2' and m_cheque<>0) and facture_n<>0 ORDER BY date_enc;";
	
	$users11 = db_query($database_name, $sql);



?>


<span style="font-size:24px"><?php echo "Etat Encaissement des impayés : ".dateUsToFr($date)." Au ".dateUsToFr($date2); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Reference";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Mode";?></th>
	<th><?php echo "Date Encaissement";?></th>
	<th><?php echo "Facture";?></th>
	<th><?php echo "Date Facture";?></th>
	<th><?php echo "Ref Enc";?></th>
	<th><?php echo "Remise";?></th>
</tr>

<?php 
$compteur1=0;$total_g=0;$enc_effet=0;$enc_cheque=0;
while($users_1 = fetch_array($users11)) { 
			$date_remise=$users_1["date_remise"];$dr=dateUsToFr($users_1["date_remise"]);$id_i=$users_1["id"];$facture_n=$users_1["facture_n"];
			$client=$users_1["client"];$numero_cheque_imp=$users_1["numero_cheque_imp"];$numero_cheque=$users_1["numero_cheque"];$numero_effet=$users_1["numero_effet"];
			$m_cheque=$users_1["m_cheque"]+$users_1["m_espece"]+$users_1["m_virement"]+$users_1["m_avoir"]+$users_1["m_effet"];$total_g=$total_g+$m_cheque;

			if ($client==""){
			if ($numero_cheque_imp<>""){
			$sql  = "SELECT * ";
				$sql .= "FROM porte_feuilles where numero_cheque='$numero_cheque_imp' or numero_effet='$numero_cheque_imp' ORDER BY id;";
				$userscp = db_query($database_name, $sql);$rowcp = fetch_array($userscp);$client=$rowcp["client"];
			}
			
			$sql = "UPDATE porte_feuilles_impayes SET client = '$client' WHERE id = '$id_i'";
			db_query($database_name, $sql);
			
			}
			
			$sql  = "SELECT * ";
				$sql .= "FROM clients where client='$client' ORDER BY id;";
				$usersc = db_query($database_name, $sql);$rowc = fetch_array($usersc);$v=$rowc["vendeur_nom"];
			$sql = "UPDATE porte_feuilles_impayes SET vendeur = '$v' WHERE id = '$id_i'";
			db_query($database_name, $sql);

			
			$ref="";$date_enc=$users_1["date_enc"];$oui="non";
			if ($users_1["m_espece"]>0){$ref="espece";$oui="oui";}
			if ($users_1["m_virement"]>0){$ref="virement";if ($users_1["date_virement"]>='$date' and $users_1["date_virement"]<='$date2'){$oui="oui";}else{$oui="non";}}
			if ($users_1["m_cheque"]>0){$ref="cheque";if ($users_1["date_remise"]>='$date' and $users_1["date_remise"]<='$date2'){$oui="oui";}else{$oui="non";}}
			if ($users_1["m_avoir"]>0){$ref=$users_1["numero_avoir"];}
			if ($users_1["m_effet"]>0){$ref="effet";$date_enc=$users_1["date_echeance"];if ($users_1["date_remise_e"]>='$date' and $users_1["date_remise_e"]<='$date2'){$oui="oui";}else{$oui="non";}}
			$facture_n=$users_1["facture_n"];$date_f=$users_1["date_f"];
				if ($facture_n>9039){
				$sql  = "SELECT * ";
				$sql .= "FROM factures2016 where numero='$facture_n' ORDER BY id;";
				$users = db_query($database_name, $sql);$row = fetch_array($users);$d=$row["date_f"];
				}else
				{
				$sql  = "SELECT * ";
				$sql .= "FROM factures where numero='$facture_n' ORDER BY id;";
				$users = db_query($database_name, $sql);$row = fetch_array($users);$d=$row["date_f"];
				}

			//if ($oui=="oui"){?><tr>
			<td><?php $n_v= $numero_cheque_imp;
			
			$sql  = "SELECT * ";
			$sql .= "FROM porte_feuilles_factures where numero_effet='$n_v' or numero_cheque='$n_v' ORDER BY date_enc;";
	
			$users1221 = db_query($database_name, $sql);$users_221 = fetch_array($users1221);$meff=$users_221["m_effet"];$mch=$users_221["m_cheque"];
			if ($meff>0){$typed="EFFET";$enc_effet=$enc_effet+$m_cheque;}else{$typed="CHEQUE";$enc_cheque=$enc_cheque+$m_cheque;}
			
			
			
			print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$typed / $n_v </font>"); ?></td>
			<td><?php $c_t= $client;print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$c_t </font>"); ?></td>
			<td align="right"><?php $m_c= number_format($m_cheque,2,',',' '); print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$m_c </font>");?></td>
			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$ref </font>");?></td>
			<td><?php $d_i= dateUsToFr($date_enc); print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$d_i </font>");?></td>
			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$facture_n </font>");?></td>
			<td><?php $d= dateUsToFr($date_f); print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$d</font>");?></td>
			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$numero_cheque $numero_effet </font>");?></td>

			<? } ?>



</strong>
	
<? }?>

<tr><td></td><td><? echo "Total Enc/Effets impayes : ";?></td>
			<td align="right"><?php $m_c_g1= number_format($enc_effet,2,',',' '); print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$m_c_g1 </font>");?></td>
<td></td><td></td><td></td><td></td>
<tr><td></td><td><? echo "Total Enc/Cheques impayes : ";?></td>
			<td align="right"><?php $m_c_g2= number_format($enc_cheque,2,',',' '); print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$m_c_g2 </font>");?></td>
<td></td><td></td><td></td><td></td>
<tr><td></td><td><? echo "Total Enc : ";?></td>
			<td align="right"><?php $m_c_g= number_format($total_g,2,',',' '); print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$m_c_g </font>");?></td>
<td></td><td></td><td></td><td></td>
</table>
</body>

</html>
