<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";$action="Recherche";$date="";$date1="";$du="";$au="";
	
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

	<?
	
			if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="balance_evaluations_net.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{
	
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];
	$du=$_POST['date'];$au=$_POST['date1'];$encours="encours";$enc_t=0;
	
	$sql  = "SELECT id,trimestre,vendeur,client,net,date_e,solde,sum(net) As total_net,sum(solde) As total_solde ";
	$sql .= "FROM commandes where date_e between '$date' and '$date1' and evaluation<>'$encours' GROUP BY vendeur;";
	$users = db_query($database_name, $sql);
	$du1_08_t="2008-01-01";$au1_08_t="2008-03-31";$trimestre1_08="1er Trimestre 2008";
	$du2_08_t="2008-04-01";$au2_08_t="2008-06-30";$trimestre2_08="2eme Trimestre 2008";
	$du3_08_t="2008-07-01";$au3_08_t="2008-09-30";$trimestre3_08="3eme Trimestre 2008";
	$du4_08_t="2008-10-01";$au4_08_t="2008-12-31";$trimestre4_08="4eme Trimestre 2008";
	
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Balance Evaluations sortie $du au $au"; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "Evaluation";?></th>
	<th><?php echo "Encaissement";?></th>
	<th><?php echo "En compte";?></th>
	<th><?php echo "Net a commissioner";?></th>
</tr>

<?php $debit=0;$credit=0;$t=0;$s=0;$t_avoir_t=0;
while($users_ = fetch_array($users)) { 
$vendeur=$users_["vendeur"];$date_e=$users_["date_e"];$id=$users_["id"];$client=$users_["client"];

?><tr>
<?php $vendeur=$users_["vendeur"];?>
<? echo "<td>$vendeur</td>";?>
<?php $t=$t+$users_["total_net"];$ca=number_format($users_["total_net"],2,',',' ');?>
<td align="right"><? echo "<a href=\"details_ca.php?vendeur=$vendeur&date1=$date&date2=$date1\">$ca</a></td>";?>
<?
	$sql  = "SELECT * ";
	$vide="";$enc=0;
	$sql .= "FROM porte_feuilles where (date_enc between '$date' and '$date1') and (date_e between '$date' and '$date1') 
	and vendeur='$vendeur' Order BY date_enc;";
	$users11 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;$t_effet=0;$t_virement=0;
	while($row = fetch_array($users11))
	{	
	
		$numero_cheque = $row['numero_cheque'];$facture_n = $row['facture_n'];$commande=$row['id_commande'];
		
		$total_cheque = $row['m_cheque'];$total_espece = $row['m_espece']-$row['m_avoir']-$row['m_diff_prix'];
		$total_effet = $row['m_effet'];$total_avoir = $row['m_avoir'];$total_diff = $row['m_diff_prix'];
		$total_virement = $row['m_virement'];$t_avoir=$t_avoir+$row['m_avoir'];$t_avoir_t=$t_avoir_t+$row['m_avoir'];
		$t_cheque=$t_cheque+$total_cheque;$t_effet=$t_effet+$total_effet;$t_virement=$t_virement+$total_virement;
		$t_espece=$t_espece+$total_espece;
		$enc=$enc+$row['m_cheque']+$row['m_espece']+$row['m_effet']+$row['m_virement'];
		$enc_t=$enc_t+$row['m_cheque']+$row['m_espece']+$row['m_effet']+$row['m_virement'];
		
		
	}?>
<?php $t_avoirs=number_format($t_avoir,2,',',' ');?>
<td align="right"><? $enc_n=number_format($enc,2,',',' ');
echo "<a href=\"details_enc.php?vendeur=$vendeur&date1=$date&date2=$date1\">$enc_n</a></td>";?>
<td align="right"><?php echo number_format($users_["total_net"]-$enc,2,',',' ');?></td>
<td align="right"><?php echo number_format($enc,2,',',' ');?></td>
<?php } ?>
<tr><td></td>
<td align="right"><?php echo number_format($t,2,',',' ');?></td>
<td align="right"><?php echo number_format($enc_t,2,',',' ');?></td>
<td align="right"><?php echo number_format($t-$enc_t,2,',',' ');?></td>
<td align="right"><?php echo number_format($enc_t,2,',',' ');?></td>
</table>




<?

	$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles where (date_impaye between '$date' and '$date1') and facture_n<>0 and r_impaye=1 and m_cheque<>0 ORDER BY date_impaye;";
	$users11 = db_query($database_name, $sql);



?>


<span style="font-size:24px"><?php echo "Etat des impayés : ".dateUsToFr($date)." Au ".dateUsToFr($date1); ?></span>

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
while($users_1 = fetch_array($users11)) { 
			$date_remise=$users_1["date_remise"];
			$client=$users_1["client"];$id=$users_1["id"];
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
			
<?	$sql  = "SELECT * ";$total_gg=0;
	$sql .= "FROM porte_feuilles_impayes where id_porte_feuille='$id' ORDER BY id;";
	$users111 = db_query($database_name, $sql);
 while($users_111 = fetch_array($users111)) { 
			$date_remise=$users_111["date_remise"];
			$client=$users_111["client"];$numero_cheque_imp=$users_111["numero_cheque_imp"];
			$m_cheque=$users_111["m_cheque"]+$users_111["m_espece"]+$users_111["m_virement"]+$users_111["m_avoir"];
			$total_gg=$total_gg+$m_cheque;$total_ggg=$total_ggg+$m_cheque;
			$ref="";
			if ($users_111["m_espece"]>0){$ref="espece";}
			if ($users_111["m_virement"]>0){$ref="virement";}
			if ($users_111["m_cheque"]>0){$ref="cheque";}
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
	<th><?php echo "Encaissement";?></th>
	
</tr>

<?php 

	$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles where (date_impaye_e between '$date' and '$date1') and facture_n<>0 and r_impaye_e=1 and m_cheque=0 ORDER BY id;";
	$users1111 = db_query($database_name, $sql);

$compteur1=0;$total_g=0;
while($users_1 = fetch_array($users1111)) { 
			$date_remise=$users_1["date_echeance"];$id_f=$users_1["id"];
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
<?	$sql  = "SELECT * ";$total_gg=0;
	$sql .= "FROM porte_feuilles_impayes where id_porte_feuille='$id_f' ORDER BY id;";
	$users11111 = db_query($database_name, $sql);
 while($users_111 = fetch_array($users11111)) { 
			$date_remise=$users_111["date_remise"];
			$client=$users_111["client"];$numero_cheque_imp=$users_111["numero_cheque_imp"];
			$m_cheque=$users_111["m_cheque"]+$users_111["m_espece"]+$users_111["m_virement"]+$users_111["m_avoir"];
			$total_gg=$total_gg+$m_cheque;$total_ggg=$total_ggg+$m_cheque;
			$ref="";
			if ($users_111["m_espece"]>0){$ref="espece";}
			if ($users_111["m_virement"]>0){$ref="virement";}
			if ($users_111["m_cheque"]>0){$ref="cheque";}
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
<td></td><td></td>
			<td align="right"><?php $t_gg= number_format($total_ggg,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$t_gg </font>"); ?></td>
</table>		




<?php } ?>


<p style="text-align:center">

</body>

</html>