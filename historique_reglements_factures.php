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
	$action="recherche";$numero=$_GET["numero"];$date_f=$_GET["date_f"];
	
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

	$total=0;$total1=0;$total11=0;$total111=0;
	
	if ($date_f>="2018-01-01" and $date_f<"2019-01-01"){$factures="factures2018";}
	if ($date_f>="2017-01-01" and $date_f<"2018-01-01"){$factures="factures";}
	if ($date_f>="2019-01-01" and $date_f<"2020-01-01"){$factures="factures2019";}
	if ($date_f>="2020-01-01" and $date_f<"2021-01-01"){$factures="factures2020";}
	if ($date_f>="2021-01-01" and $date_f<"2022-01-01"){$factures="factures2021";}
	if ($date_f>="2022-01-01" and $date_f<"2023-01-01"){$factures="factures2022";}
	if ($date_f>="2023-01-01" and $date_f<"2024-01-01"){$factures="factures2023";}
	if ($date_f>="2024-01-01" and $date_f<"2025-01-01"){$factures="factures2024";}
	if ($date_f>="2025-01-01" and $date_f<"2026-01-01"){$factures="factures2025";}
	if ($date_f>="2026-01-01" and $date_f<"2027-01-01"){$factures="factures2026";}
	
	
	
	
	
				$sql  = "SELECT * ";
				$sql .= "FROM ".$factures." where numero='$numero' ORDER BY id;";
				$users = db_query($database_name, $sql);$row = fetch_array($users);$d=$row["date_f"];$m=$row["montant"];$mm=number_format($m,2,',',' ');
				$user_id=$row["id"];$exercice=$row["exercice"];
	if ($user_id<10){$zero="000";}
	if ($user_id>=10 and $user_id<100){$zero="00";}
	if ($user_id>=100 and $user_id<1000){$zero="0";}
	if ($user_id>=1000 and $user_id<10000){$zero="";}
	$facture1=$zero.$user_id."/".$exercice;
	
	
	
	
	/*$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles where date_valeur='$date' and mode='$mode' and remise=0 ORDER BY date_valeur;";
	$users11 = db_query($database_name, $sql);*/
	$sql  = "SELECT id,date_enc,date_cheque,r_impaye,date_impaye,client,client_tire,client_tire_e,v_banque,numero_cheque,sum(m_cheque) As total_cheque ,
	sum(m_espece) As total_espece,numero_effet,sum(m_effet) As total_effet,sum(m_virement) As total_virement ";
	$sql .= "FROM porte_feuilles_factures where facture_n='$numero' and date_f='$date_f' Group BY id;";
	$users11 = db_query($database_name, $sql);
	
		
?>


<span style="font-size:24px"><?php echo "Detail reglements Facture : ".$facture1."     Montant : ".$mm; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Client Tiré";?></th>
	
	<th><?php echo "Reference";?></th>
	<th><?php echo "Cheque";?></th>
	<th><?php echo "Espece";?></th>
	<th><?php echo "Effet";?></th>
	<th><?php echo "Virement";?></th>
</tr>


<?php $compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { 
			$date_enc=dateUsToFr($users_1["date_enc"]);$date_cheque=$users_1["date_cheque"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];$total_espece=$users_1["total_espece"];$r_impaye=$users_1["r_impaye"];
			$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];$total_cheque=$users_1["total_cheque"];$date_impaye=dateUsToFr($users_1["date_impaye"]);
			$numero_effet=$users_1["numero_effet"];$client_tire_e=$users_1["client_tire_e"];
			if ($r_impaye){$imp="impayé le ".$date_impaye;$total_cheque=$total_cheque*-1;}else{$imp="";}
			$ref=$v_banque." ".$numero_cheque." ".$numero_effet." ".$imp;$total_effet=$users_1["total_effet"];$total_virement=$users_1["total_virement"];
			if ($total_espece<>0){$ref="Espece le ".$date_enc;}
			
			?>
			<tr>
			<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$client_tire $client_tire_e </font>");  ?></td>
			
			<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ref </font>");  ?></td>
			<td align="right"><?php $total=$total+$total_cheque;$tc= number_format($total_cheque,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tc </font>");  ?></td>
			<td align="right"><?php $total1=$total1+$total_espece;$te= number_format($total_espece,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$te </font>"); ?></td>
			<td align="right"><?php $total11=$total11+$total_effet;$tf= number_format($total_effet,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tf </font>"); ?></td>
			<td align="right"><?php $total111=$total111+$total_virement;$tv= number_format($total_virement,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tv </font>"); ?></td>
<? }?>

</tr>
</table>
<table class="table2">
<tr><td><? echo "Impayés sur Facture";?></td></tr>

<? $sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles_factures where facture_n=$numero and date_f='$date_f' and r_impaye=1 and m_cheque<>0 ORDER BY date_impaye;";
	$users111 = db_query($database_name, $sql);



?>



<table class="table2">

<tr>
	<th><?php echo "Cheque N°";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Date Remise";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Date impaye";?></th>
	<th><?php echo "Facture";?></th>
	<th><?php echo "Encaissement";?></th>
</tr>

<?php 
$compteur1=0;$total_g=0;
while($users_1 = fetch_array($users111)) { 
			$date_remise=$users_1["date_remise"];
			$client=$users_1["client"];$id=$users_1["id_porte_feuille"];
			$client_tire=$users_1["client_tire"];
			$numero_cheque=$users_1["numero_cheque"];$v_banque=$users_1["v_banque"];
			$m_cheque=$users_1["m_cheque"];$total_g=$total_g+$m_cheque;
			$date_impaye=$users_1["date_impaye"];$facture_n=$users_1["facture_n"];
				$sql  = "SELECT * ";
				$sql .= "FROM factures where numero='$facture_n' ORDER BY id;";
				$users = db_query($database_name, $sql);$row = fetch_array($users);$d=$row["date_f"];


			?><tr>
			<td><?php $n_v= $numero_cheque."/".$v_banque;print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$n_v </font>"); ?></td>
			<td><?php $c_t= $client."/".$client_tire;print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$c_t </font>"); ?></td>
			<td><?php $d_r= dateUsToFr($date_remise);print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$d_r </font>"); ?></td>
			<td align="right"><?php $m_c= number_format($m_cheque,2,',',' '); print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$m_c </font>");?></td>
			<td><?php $d_i= dateUsToFr($date_impaye); print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$d_i </font>");?></td>
			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$facture_n </font>");?></td>
	
<td><table class="table2">
	
<?	$sql  = "SELECT * ";$total_gg=0;
	$sql .= "FROM porte_feuilles_impayes where id_porte_feuille='$id' and facture_n='$facture_n' ORDER BY id;";
	$users111 = db_query($database_name, $sql);
 while($users_111 = fetch_array($users111)) { 
			$date_remise=$users_111["date_remise"];
			$client=$users_111["client"];$numero_cheque_imp=$users_111["numero_cheque_imp"];
			$m_cheque=$users_111["m_cheque"]+$users_111["m_espece"]+$users_111["m_virement"]+$users_111["m_avoir"]+$users_111["m_effet"];
			$total_gg=$total_gg+$m_cheque;$total_ggg=$total_ggg+$m_cheque;
			$ref="";
			if ($users_111["m_espece"]>0){$ref="espece";$tg=$users_111["m_espece"];}
			if ($users_111["m_virement"]>0){$ref="virement";$tg=$users_111["m_virement"];}
			if ($users_111["m_cheque"]>0){$ref="cheque";$tg=$users_111["m_cheque"];}
			if ($users_111["m_effet"]>0){$ref="effet";$tg=$users_111["m_effet"];}
			if ($users_111["m_avoir"]>0){$ref=$users_111["numero_avoir"];$tg=$users_111["m_avoir"];}?>
			<tr><td align="right"><?php $r= number_format($total_gg,2,',',' ')." ".$ref;print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$r </font>");?></td>

			 <?} ?>
			<tr><td align="right"><?php $m_c_s= "Total : ".number_format($total_gg,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$m_c_s </font>");?></td>
			</table>
<? } ?>



</strong>
<p style="text-align:center">

<tr></tr>
<p></p>


<tr>
	<th><?php echo "Effet N°";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Date Echeance";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Date impaye";?></th>
	<th><?php echo "Facture";?></th>
	<th><?php echo "Encaissement";?></th>
	
</tr>

<?php 

	$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles_factures where facture_n=$numero and date_f='$date_f' and r_impaye_e=1 and m_effet<>0 ORDER BY id;";
	$users1111 = db_query($database_name, $sql);

$compteur1=0;$total_g=0;
while($users_1 = fetch_array($users1111)) { 
			$date_remise=$users_1["date_echeance"];$id_f=$users_1["id_porte_feuille"];
			$client=$users_1["client"];
			$client_tire=$users_1["client_tire"];
			$numero_cheque=$users_1["numero_effet"];$v_banque=$users_1["v_banque_e"];
			$m_cheque=$users_1["m_effet"];$total_g=$total_g+$m_cheque;
			$date_impaye=$users_1["date_impaye_e"];$facture_n=$users_1["facture_n"];
				$sql  = "SELECT * ";
				$sql .= "FROM factures where numero='$facture_n' ORDER BY id;";
				$users = db_query($database_name, $sql);$row = fetch_array($users);$d=$row["date_f"];


			?><tr>
			<td><?php $n_v= $numero_cheque."/".$v_banque;print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$n_v </font>"); ?></td>
			<td><?php $c_t= $client."/".$client_tire;print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$c_t </font>"); ?></td>
			<td><?php $d_r= dateUsToFr($date_remise);print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$d_r </font>"); ?></td>
			<td align="right"><?php $m_c= number_format($m_cheque,2,',',' '); print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$m_c </font>");?></td>
			<td><?php $d_i= dateUsToFr($date_impaye); print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$d_i </font>");?></td>
			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$facture_n </font>");?></td>
			
			<td><table class="table2">
			
<?	$sql  = "SELECT * ";$total_gg=0;
	$sql .= "FROM porte_feuilles_impayes where id_porte_feuille='$id_f' and facture_n='$facture_n' ORDER BY id;";
	$users11111 = db_query($database_name, $sql);
 while($users_111 = fetch_array($users11111)) { 
			$date_remise=$users_111["date_remise"];
			$client=$users_111["client"];$numero_cheque_imp=$users_111["numero_cheque_imp"];
			$m_cheque=$users_111["m_cheque"]+$users_111["m_espece"]+$users_111["m_virement"]+$users_111["m_avoir"]+$users_111["m_effet"];
			$total_gg=$total_gg+$m_cheque;$total_ggg=$total_ggg+$m_cheque;
			$ref="";
			if ($users_111["m_espece"]>0){$ref="espece";$tg=$users_111["m_espece"];}
			if ($users_111["m_virement"]>0){$ref="virement";$tg=$users_111["m_virement"];}
			if ($users_111["m_cheque"]>0){$ref="cheque";$tg=$users_111["m_cheque"];}
			if ($users_111["m_effet"]>0){$ref="effet";$tg=$users_111["m_effet"];}
			if ($users_111["m_avoir"]>0){$ref=$users_111["numero_avoir"];$tg=$users_111["m_avoir"];}?>
			<tr><td align="right"><?php $r= number_format($tg,2,',',' ')." ".$ref;print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$r </font>");?></td>

			 <?} ?>
			<tr><td align="right"><?php $m_c_s= "Total : ".number_format($total_gg,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$m_c_s </font>");?></td>
			</table>
<? } ?>



</strong>
<p style="text-align:center">

</table>		
	
</table>
</strong>
<p style="text-align:center">


</body>

</html>