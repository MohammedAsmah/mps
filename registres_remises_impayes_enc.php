<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";$date1="";$date2="";$action="Recherche";
	echo $_REQUEST["facture_imp"];
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_r"])){
		$m_cheque0=$_REQUEST["m_cheque0"];$numero_cheque=$_REQUEST["numero_cheque"];$date_cheque=dateFrToUs($_REQUEST["date_cheque"]);
		$v_banque=$_REQUEST["v_banque"];$client_tire=$_REQUEST["client_tire"];$m_cheque_g0=$_REQUEST["m_cheque_g0"];
	$m_effet=$_REQUEST["m_effet"];$date_echeance=dateFrToUs($_REQUEST["date_echeance"]);$numero_effet=$_REQUEST["numero_effet"];
	$v_banque1=$_REQUEST["v_banque1"];$client_tire1=$_REQUEST["client_tire1"];
	$espece=$_REQUEST["espece"];$date_enc=dateFrToUs($_REQUEST["date_enc"]);$numero_cheque_imp=$_REQUEST["numero_cheque_imp"];
	$m_virement=$_REQUEST["m_virement"];$date_virement=dateFrToUs($_REQUEST["date_virement"]);$client_imp=$_REQUEST["client_imp"];
	$du=$_REQUEST["date1"];$au=$_REQUEST["date2"];$id=$_REQUEST["id"];$tableau=$_REQUEST["tableau"];$facture_imp=$_REQUEST["facture_imp"];$date_f=$_REQUEST["date_f"];
	// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM factures WHERE numero = " . $_REQUEST["facture_imp"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$vendeur=$user_["vendeur"];
		
	$m_avoir=$_REQUEST["m_avoir"];$date_avoir=dateFrToUs($_REQUEST["date_avoir"]);$numero_avoir=$_REQUEST["numero_avoir"];$id_f=$_REQUEST["idp"];
			if(isset($_REQUEST["avoir_sur_compte"])) { $avoir_sur_compte = 1; } else { $avoir_sur_compte = 0; }
	
	if ($espece<>0)
	{
	$sql1  = "INSERT INTO porte_feuilles_impayes
	(client ,id_porte_feuille,tableau,date_enc,numero_cheque_imp,m_espece,facture_n,date_f )
	VALUES
	('$client_imp','$id_f','$tableau','$date_enc','$numero_cheque_imp','$espece','$facture_imp','$date_f')";
	db_query($database_name, $sql1);
	}
	if ($m_virement<>0)
	{
	$sql1  = "INSERT INTO porte_feuilles_impayes
	(client ,id_porte_feuille,tableau,date_enc,numero_cheque_imp,m_virement,facture_n,date_f )
	VALUES
	('$client_imp','$id_f','$tableau','$date_virement','$numero_cheque_imp','$m_virement','$facture_imp','$date_f')";
	db_query($database_name, $sql1);
	}
	if ($m_cheque0<>0)
	{$date_enc=dateFrToUs($_REQUEST["date_cheque"]);
	$sql1  = "INSERT INTO porte_feuilles_impayes
	(client ,id_porte_feuille,tableau,date_enc,numero_cheque_imp,m_cheque,m_cheque_g,numero_cheque,date_cheque,v_banque,client_tire,facture_n,date_f )
	VALUES
	('$client_imp','$id_f','$tableau','$date_enc','$numero_cheque_imp','$m_cheque0','$m_cheque_g0','$numero_cheque','$date_cheque','$v_banque','$client_tire','$facture_imp','$date_f')";
	db_query($database_name, $sql1);
	$chq_f=1;
	$sql11  = "INSERT INTO porte_feuilles
	(client ,vendeur,date_enc,numero_cheque,m_cheque,m_cheque_g,date_cheque,v_banque,client_tire,facture_n,numero_cheque_imp,chq_f )
	VALUES
	('$client_imp','$vendeur','$date_enc','$numero_cheque','$m_cheque0','$m_cheque_g0','$date_cheque','$v_banque','$client_tire','$facture_imp','$numero_cheque_imp','$chq_f')";
	db_query($database_name, $sql11);
	
	
	$sql11  = "INSERT INTO porte_feuilles_factures
	(client ,vendeur,date_enc,numero_cheque,m_cheque,m_cheque_g,date_cheque,v_banque,client_tire,facture_n,numero_cheque_imp )
	VALUES
	('$client_imp','$vendeur','$date_enc','$numero_cheque','$m_cheque0','$m_cheque_g0','$date_cheque','$v_banque','$client_tire','$facture_imp','$numero_cheque_imp')";
	db_query($database_name, $sql11);
	
	}
	if ($m_effet<>0)
	{$date_enc=dateFrToUs($_REQUEST["date_echeance"]);
	$sql1  = "INSERT INTO porte_feuilles_impayes
	(client ,id_porte_feuille,tableau,date_enc,numero_cheque_imp,m_effet,numero_effet,date_echeance,v_banque_e,client_tire_e,facture_n,date_f )
	VALUES
	('$client_imp','$id_f','$tableau','$date_enc','$numero_cheque_imp','$m_effet','$numero_effet','$date_echeance','$v_banque1','$client_tire1','$facture_imp','$date_f')";
	db_query($database_name, $sql1);
	$eff_f=1;
	$sql11  = "INSERT INTO porte_feuilles
	(client ,vendeur,date_enc,numero_effet,m_effet,date_echeance,v_banque_e,client_tire_e,facture_n,numero_cheque_imp,eff_f )
	VALUES
	('$client_imp','$vendeur','$date_enc','$numero_effet','$m_effet','$date_echeance','$v_banque1','$client_tire1','$facture_imp','$numero_cheque_imp','$eff_f')";
	db_query($database_name, $sql11);
	
	
	$sql11  = "INSERT INTO porte_feuilles_factures
	(client ,vendeur,date_enc,numero_effet,m_effet,date_echeance,v_banque_e,client_tire_e,facture_n,numero_cheque_imp )
	VALUES
	('$client_imp','$vendeur','$date_enc','$numero_effet','$m_effet','$date_echeance','$v_banque1','$client_tire1','$facture_imp','$numero_cheque_imp')";
	db_query($database_name, $sql11);
	
	}
	
	
	if ($m_avoir<>0)
	{
	$sql1  = "INSERT INTO porte_feuilles_impayes
	(client ,id_porte_feuille,tableau,date_enc,numero_cheque_imp,m_avoir,numero_avoir,avoir_sur_compte,facture_n,date_f )
	VALUES
	('$client_imp','$id_f','$tableau','$date_avoir','$numero_cheque_imp','$m_avoir','$numero_avoir','$avoir_sur_compte','$facture_imp','$date_f')";
	db_query($database_name, $sql1);
	}
	}
	

	
	?>
	<? if(isset($_REQUEST["action"]) or isset($_REQUEST["action_r"])){}else{ ?>
	<form id="form" name="form" method="post" action="registres_remises_impayes_enc.php">
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


	if(isset($_REQUEST["action"]) or isset($_REQUEST["action_r"]))
	{ $date=dateFrToUs($_POST['date1']);$date2=dateFrToUs($_POST['date2']);
	$date_d1=dateFrToUs($_POST['date1']);$date_d2=dateFrToUs($_POST['date2']);
	$de1=dateFrToUs($_POST['date1']);$de2=dateFrToUs($_POST['date2']);}
	
	
	if (isset($_REQUEST["action"]) or isset($_REQUEST["action_r"])){
	$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles_factures where (date_impaye between '$date' and '$date2') and facture_n<>0 and r_impaye=1 and m_cheque<>0 ORDER BY date_impaye;";
	$users11 = db_query($database_name, $sql);



?>


<span style="font-size:24px"><?php echo "Etat des impayés : ".dateUsToFr($date)." Au ".dateUsToFr($date2); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Cheque N°";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Date Remise";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Date impaye";?></th>
	<th><?php echo "Facture";?></th>
	<th><?php echo "Encaissé";?></th>
	
</tr>

<?php 
$compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { 
			$date_remise=$users_1["date_remise"];
			$client=$users_1["client"];$id=$users_1["id_porte_feuille"];$id_secours=$users_1["id"];
			$client_tire=$users_1["client_tire"];
			$numero_cheque=$users_1["numero_cheque"];$v_banque=$users_1["v_banque"];
			
			$idpp=$users_1["id"];
				/*if ($id==0){
				$sql  = "SELECT * ";
				$sql .= "FROM porte_feuilles where numero_cheque='$numero_cheque' and client='$client' ORDER BY id;";
				$usersp = db_query($database_name, $sql);
				while($users_1p = fetch_array($usersp)) { $id_po=$users_1p["id"];$id=$id_po;
						$sql = "UPDATE porte_feuilles_factures SET id_porte_feuille = '$id_po' WHERE id = '$idpp'";
						db_query($database_name, $sql);
				}
				}*/
				
			
			
			
			
			$m_cheque=$users_1["m_cheque"];$total_g=$total_g+$m_cheque;
			$date_impaye=$users_1["date_impaye"];$facture_n=$users_1["facture_n"];$date_f=$users_1["date_f"];
			if ($date_f>="2010-01-01" and $date_f<="2016-12-31"){$factures="factures2016";$detail_factures="detail_factures2016";$exe="/16";}	
			if ($date_f>="2017-01-01" and $date_f<="2017-12-31"){$factures="factures";$detail_factures="detail_factures";$exe="/17";}	
			if ($date_f>="2018-01-01" and $date_f<="2018-12-31"){$factures="factures2018";$detail_factures="detail_factures2018";$exe="/18";}
			if ($date_f>="2019-01-01" and $date_f<="2019-12-31"){$factures="factures2019";$detail_factures="detail_factures2019";$exe="/19";}
			if ($date_f>="2020-01-01" and $date_f<="2020-12-31"){$factures="factures2020";$detail_factures="detail_factures2020";$exe="/20";}
			if ($date_f>="2021-01-01" and $date_f<="2021-12-31"){$factures="factures2021";$detail_factures="detail_factures2021";$exe="/21";}
			if ($date_f>="2022-01-01" and $date_f<="2022-12-31"){$factures="factures2022";$detail_factures="detail_factures2022";$exe="/22";}
			if ($date_f>="2023-01-01" and $date_f<="2023-12-31"){$factures="factures2023";$detail_factures="detail_factures2023";$exe="/23";}
			if ($date_f>="2024-01-01" and $date_f<="2024-12-31"){$factures="factures2024";$detail_factures="detail_factures2024";$exe="/24";}
			if ($date_f>="2025-01-01" and $date_f<="2025-12-31"){$factures="factures2025";$detail_factures="detail_factures2025";$exe="/25";}
			if ($date_f>="2026-01-01" and $date_f<="2026-12-31"){$factures="factures2026";$detail_factures="detail_factures2026";$exe="/26";}			
				
				$sql  = "SELECT * ";
				$sql .= "FROM ".$factures." where numero='$facture_n' ORDER BY id;";
				$users = db_query($database_name, $sql);$row = fetch_array($users);$d=$row["date_f"];


			?><tr>
			<td><?php $action_s="";$n_v= $numero_cheque."/".$v_banque;
			$n_v1="<a href=\"encaissement_impayes.php?ref_impaye=$numero_cheque&client=$client&facture_n=$facture_n&date_f=$date_f&action_s=$action_s&du=$date&au=$date2&id=$id&id_secours=$id_secours\">$n_v</a>";
			print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$n_v1 </font>"); ?></td>
			<td><?php $c_t= $client."/".$client_tire;print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$c_t </font>"); ?></td>
			<td><?php $d_r= dateUsToFr($date_remise);print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$d_r </font>"); ?></td>
			<td align="right"><?php $m_c= number_format($m_cheque,2,',',' '); print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$m_c </font>");?></td>
			<td><?php $d_i= dateUsToFr($date_impaye); print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$d_i </font>");?></td>
			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$facture_n $exe </font>");?></td>

<?

	$sql  = "SELECT * ";$total_gg=0;
	$sql .= "FROM porte_feuilles_impayes where id_porte_feuille='$id' and numero_cheque_imp='$numero_cheque' and facture_n='$facture_n' ORDER BY id;";
	$users111 = db_query($database_name, $sql);
 while($users_111 = fetch_array($users111)) { 
			$date_remise=$users_111["date_remise"];
			$client=$users_111["client"];$numero_cheque_imp=$users_111["numero_cheque_imp"];
			$m_cheque=$users_111["m_cheque"]+$users_111["m_espece"]+$users_111["m_virement"]+$users_111["m_avoir"]+$users_111["m_effet"];
			$total_gg=$total_gg+$m_cheque;
			$ref="";
			if ($users_111["m_espece"]>0){$ref="espece";}
			if ($users_111["m_virement"]>0){$ref="virement";}
			if ($users_111["m_cheque"]>0){$ref="cheque";}
			if ($users_111["m_effet"]>0){$ref="effet";}
			if ($users_111["m_avoir"]>0){$ref=$users_111["numero_avoir"];}
			 } ?>
			<td align="right"><?php $m_c_s= number_format($total_gg,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$m_c_s </font>");?></td>
			
<? } ?>



</strong>
<p style="text-align:center">
<tr><td></td><td></td><td></td>
			<td align="right"><?php 
			$t_gc= $total_g;
			$t_g= number_format($total_g,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$t_g </font>"); ?></td>
<td></td><td></td><td></td>	
<tr></tr>
<p></p>


<tr>
	<th><?php echo "Effet N°";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Date Echeance";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Date impaye";?></th>
	<th><?php echo "Facture";?></th>
	<th><?php echo "Encaissé";?></th>
	
</tr>

<?php 

	$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles_factures where (date_impaye_e between '$date' and '$date2') and facture_n<>0 and r_impaye_e=1 and m_cheque=0 ORDER BY id;";
	$users1111 = db_query($database_name, $sql);

$compteur1=0;$total_g=0;
while($users_1 = fetch_array($users1111)) { 
			$date_remise=$users_1["date_echeance"];
			$client=$users_1["client"];$id_f=$users_1["id_porte_feuille"];$id_pf=$users_1["id"];
			$client_tire=$users_1["client_tire"];
			
			$idpp=$users_1["id"];
				/*if ($id==0){
				$sql  = "SELECT * ";
				$sql .= "FROM porte_feuilles where numero_effet='$numero_cheque' and client='$client' ORDER BY id;";
				$usersp = db_query($database_name, $sql);
				while($users_1p = fetch_array($usersp)) { $id_po=$users_1p["id"];$id_f=$id_po;
						$sql = "UPDATE porte_feuilles_factures SET id_porte_feuille = '$id_po' WHERE id = '$idpp'";
						db_query($database_name, $sql);
				}
				}*/
			
			
			
			$numero_cheque=$users_1["numero_effet"];$v_banque=$users_1["v_banque_e"];
			$m_cheque=$users_1["m_effet"];$total_g=$total_g+$m_cheque;
			$date_impaye=$users_1["date_impaye_e"];$facture_n=$users_1["facture_n"];$date_f=$users_1["date_f"];
				if ($date_f>="2010-01-01" and $date_f<="2016-12-31"){$factures="factures2016";$detail_factures="detail_factures2016";$exe="/16";}	
			if ($date_f>="2017-01-01" and $date_f<="2017-12-31"){$factures="factures";$detail_factures="detail_factures";$exe="/17";}	
			if ($date_f>="2018-01-01" and $date_f<="2018-12-31"){$factures="factures2018";$detail_factures="detail_factures2018";$exe="/18";}
			if ($date_f>="2019-01-01" and $date_f<="2019-12-31"){$factures="factures2019";$detail_factures="detail_factures2019";$exe="/19";}
			if ($date_f>="2020-01-01" and $date_f<="2020-12-31"){$factures="factures2020";$detail_factures="detail_factures2020";$exe="/20";}
			if ($date_f>="2021-01-01" and $date_f<="2021-12-31"){$factures="factures2021";$detail_factures="detail_factures2021";$exe="/21";}
			if ($date_f>="2022-01-01" and $date_f<="2022-12-31"){$factures="factures2022";$detail_factures="detail_factures2022";$exe="/22";}
			if ($date_f>="2023-01-01" and $date_f<="2023-12-31"){$factures="factures2023";$detail_factures="detail_factures2023";$exe="/23";}
			if ($date_f>="2024-01-01" and $date_f<="2024-12-31"){$factures="factures2024";$detail_factures="detail_factures2024";$exe="/24";}
			if ($date_f>="2025-01-01" and $date_f<="2025-12-31"){$factures="factures2025";$detail_factures="detail_factures2025";$exe="/25";}
			if ($date_f>="2026-01-01" and $date_f<="2026-12-31"){$factures="factures2026";$detail_factures="detail_factures2026";$exe="/26";}		
				$sql  = "SELECT * ";
				$sql .= "FROM ".$factures." where numero='$facture_n' ORDER BY id;";
				$users = db_query($database_name, $sql);$row = fetch_array($users);$d=$row["date_f"];


			?><tr>
			<td><?php $action_s="";$n_v= $numero_cheque."/".$v_banque;
			$n_v1="<a href=\"encaissement_impayes_effets.php?ref_impaye=$numero_cheque&client=$client&facture_n=$facture_n&date_f=$date_f&action_s=$action_s&du=$date&au=$date2&id=$id_f\">$n_v</a>";
			print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$n_v1 </font>"); ?></td>
			<td><?php $c_t= $client."/".$client_tire;print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$c_t </font>"); ?></td>
			<td><?php $d_r= dateUsToFr($date_remise);print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$d_r </font>"); ?></td>
			<td align="right"><?php $m_c= number_format($m_cheque,2,',',' '); print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$m_c </font>");?></td>
			<td><?php $d_i= dateUsToFr($date_impaye); print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$d_i </font>");?></td>
			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$facture_n $exe</font>");?></td>
<?
	$sql  = "SELECT * ";$total_gg=0;
	$sql .= "FROM porte_feuilles_impayes where id_porte_feuille='$id_f' and facture_n='$facture_n' and numero_cheque_imp='$numero_cheque' ORDER BY id;";
	$users111 = db_query($database_name, $sql);
 while($users_111 = fetch_array($users111)) { 
			$date_remise=$users_111["date_remise"];
			$client=$users_111["client"];$numero_cheque_imp=$users_111["numero_cheque_imp"];
			$m_cheque=$users_111["m_cheque"]+$users_111["m_espece"]+$users_111["m_virement"]+$users_111["m_avoir"]+$users_111["m_effet"];
			$total_gg=$total_gg+$m_cheque;
			$ref="";
			if ($users_111["m_espece"]>0){$ref="espece";}
			if ($users_111["m_virement"]>0){$ref="virement";}
			if ($users_111["m_cheque"]>0){$ref="cheque";}
			if ($users_111["m_effet"]>0){$ref="m_effet";}
			if ($users_111["m_avoir"]>0){$ref=$users_111["numero_avoir"];}
			 } ?>
			<td align="right"><?php $m_c_s= number_format($total_gg,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$m_c_s </font>");?></td>
<? } ?>



</strong>
<p style="text-align:center">
<tr><td></td><td></td><td></td>
			<td align="right"><?php $t_g= number_format($total_g,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$t_g </font>"); ?></td>
<td></td><td></td><td></td>	

<tr><td></td><td></td><td></td>
			<td align="right"><?php $t_g= number_format($total_g+$t_gc,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$t_g </font>"); ?></td>
<td></td><td></td><td></td>	
</table>		
	
<? }?>
</body>

</html>