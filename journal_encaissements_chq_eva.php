<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";$action="Recherche";$date1="";$date2="";$total_cc=0;$total_tt=0;$date="";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url

	
	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="journal_encaissements_chq_eva.php">
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

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	if(isset($_REQUEST["action"]))
	{ 
?>
<span style="font-size:24px"><?php $date1=dateFrToUs($_POST['date1']);$date2=dateFrToUs($_POST['date2']);$total=0;?>
<table border="0" class="table2" bordercolorlight="#FFFBF0" bordercolor="#FFFBF0">
<td align="center" bordercolor="#FFFBF0"></td><td align="center" bordercolor="#FFFBF0">
<? $e="ETAT DES ENTREES CHEQUES DU : ".dateUsToFr($date1);print("<font size=\"6\" face=\"Comic sans MS\" color=\"000033\">$e </font>"); ?></td></span>
</table>
<table border="0" class="table2" bordercolorlight="#FFFBF0" bordercolor="#FFFBF0">

<?
	$sql  = "SELECT * ";$total_cc=0;$total_tt=0;
	$sql .= "FROM registre_reglements where date between '$date1' and '$date2' ORDER BY id;";
	$users111 = db_query($database_name, $sql);
	
	while($users_111 = fetch_array($users111)) {
	$id_r=$users_111["id"];$vendeur=$users_111["vendeur"];$tableau=$users_111["bon_sortie"]."/".$users_111["mois"].$users_111["annee"];$service=$users_111["service"];
		
	/*$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles where id_registre_regl='$id_r' and (m_cheque<>0 or m_effet<>0) ORDER BY id_registre_regl;";
	$users11 = db_query($database_name, $sql);*/
	$sql  = "SELECT facture_n,v_banque,numero_cheque,client,client_tire,client_tire_e,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix ";
	$sql .= "FROM porte_feuilles where id_registre_regl='$id_r' and m_cheque<>0 and facture_n=0 and impaye<>1 and chq_f=0 Group BY numero_cheque;";
	$users11 = db_query($database_name, $sql);$total_c1=0;
	while($users_1 = fetch_array($users11)) { 
			
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];$client_tire_e=$users_1["client_tire_e"];
			$client=$users_1["client"];$total_e=$users_1["total_e"];$total_avoir=$users_1["total_avoir"];$facture_n=$users_1["facture_n"];
			$total_cheque=$users_1["total_cheque"];$total_espece=$users_1["total_espece"];$total_effet=$users_1["total_effet"];
			$total_diff_prix=$users_1["total_diff_prix"];$numero_cheque=$users_1["numero_cheque"];$v_banque=$users_1["v_banque"];
			$total_c1=$total_c1+$total_cheque;
			
	} 
	if ($total_c1>0){
	?>

<tr>
<td align="center" bordercolor="#FFFBF0"><? $link="<a href=\"\\mps\\tutorial\\journal_encaissement_tableau_eva.php?tableau=$id_r&vendeur=$vendeur&service=$service\">".$tableau."</a>";?>
<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"000033\">$link </font>");print("<font size=\"5\" face=\"Comic sans MS\" color=\"000033\">$service </font>"); ?></td><td bordercolor="#FFFBF0"></td>
</tr>

<?php $compteur1=0;$total_g=0;$total_e=0;$total_c=0;$total_t=0;
	$sql  = "SELECT facture_n,v_banque,numero_cheque,client,client_tire,client_tire_e,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix ";
	$sql .= "FROM porte_feuilles where id_registre_regl='$id_r' and m_cheque<>0 and facture_n=0 and impaye<>1 and chq_f=0 Group BY numero_cheque;";
	$users11 = db_query($database_name, $sql);
while($users_12 = fetch_array($users11)) { 
			
			$client=$users_12["client"];$client_tire=$users_12["client_tire"];$client_tire_e=$users_12["client_tire_e"];
			$client=$users_12["client"];$total_e=$users_12["total_e"];$total_avoir=$users_12["total_avoir"];$facture_n=$users_12["facture_n"];
			$total_cheque=$users_12["total_cheque"];$total_espece=$users_12["total_espece"];$total_effet=$users_12["total_effet"];
			$total_diff_prix=$users_12["total_diff_prix"];$numero_cheque=$users_12["numero_cheque"];$v_banque=$users_12["v_banque"];?>
			<tr>
			<td bordercolor="#FFFBF0"><?php $clt=$client." / ".$client_tire." / ".$client_tire_e; print("<font size=\"2\" face=\"Comic sans MS\" color=\"000033\">$clt </font>");
			?></td>
			<td align="right" bordercolor="#FFFBF0" width="100"><?php $total_cc=$total_cc+$total_cheque;$total_c=$total_c+$total_cheque;$tt=number_format($total_cheque,2,',',' ');
			print("<font size=\"2\" face=\"Comic sans MS\" color=\"000033\">$tt </font>"); ?></td>
			
<? } ?>
<tr><td align="right" bordercolor="#FFFBF0"><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"000033\">Total</font>");?></td>
			<td align="right"><?php $tc=number_format($total_c,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"000033\">$tc </font>");
			 ?></td>
			

</strong>
<p style="text-align:center">

<? }

}
?>

<? }?>
</table>
<tr><table border="0" class="table2" >
<tr><td align="right"><?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"000033\">Total General </font>");?></td>
			<td align="left"><?php $tcc=number_format($total_cc,2,',',' ');print("<font size=\"5\" face=\"Comic sans MS\" color=\"000033\">$tcc </font>"); ?></td>
</table>

</body>

</html>