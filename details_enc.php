<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";$action="Recherche";
	$date1="";$date2="";
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
	$date=$_GET['date1'];$total=0;$date2=$_GET['date2'];$vendeur=$_GET['vendeur'];
	
	
	$sql  = "SELECT date_remise,id,date_f,date_enc,client,client_tire,client_tire_e,vendeur,numero_cheque,v_banque,facture_n,impaye,
	sum(montant_e) as total_e,id_commande,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles where vendeur='$vendeur' and (date_enc between '$date' and '$date2') and 
	(date_e between '$date' and '$date2') Group BY id;";
	$users11 = db_query($database_name, $sql);
	$total_cheque_t=0;$total_espece_t=0;$total_effet_t=0;$total_virement_t=0;
?>


<span style="font-size:24px"><?php echo "Encaissments  : ".dateUsToFr($date)." Au ".dateUsToFr($date2); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo "Date Enc";?></th>
	<th><?php echo "Espece";?></th>
	<th><?php echo "Cheque";?></th>
	<th><?php echo "Effet";?></th>
	<th><?php echo "Virement";?></th>
</tr>

<?php $compteur1=0;$total_g=0;$total_e=0;$total_c=0;$total_t=0;$total_ee=0;
while($users_1 = fetch_array($users11)) { 

			$date_enc=dateUsToFr($users_1["date_enc"]);$vendeur=$users_1["vendeur"];$impaye=$users_1["impaye"];
			$id_commande=$users_1["id_commande"];$tableau=$users_1["id_registre_regl"];$id=$users_1["id"];$facture_n=$users_1["facture_n"]-9040;
			$ref="espece";$facture_n=$users_1["facture_n"];$dff=$users_1["date_f"];$id=$users_1["id"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];$client_tire_e=$users_1["client_tire_e"];
			$client=$users_1["client"];$total_e=$users_1["total_e"];$total_avoir=$users_1["total_avoir"];
			$total_cheque=$users_1["total_cheque"];$total_espece=$users_1["total_espece"];$total_effet=$users_1["total_effet"];
			$total_diff_prix=$users_1["total_diff_prix"];$total_virement=$users_1["total_virement"];
			
			$total_cheque_t=$total_cheque_t+$total_cheque;
			$total_espece_t=$total_espece_t+$total_espece;
			$total_effet_t=$total_effet_t+$total_effet;
			$total_virement_t=$total_virement_t+$total_virement;

			
			///////////////
			?>
			
			<tr>
			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$client </font>"); ?></td>
			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$date_enc </font>"); ?></td>
			<td align="right"><?php $total_espece=number_format($total_espece,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_espece </font>"); ?></td>
			<td align="right"><?php $total_cheque=number_format($total_cheque,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_cheque </font>"); ?></td>
			<td align="right"><?php $total_effet=number_format($total_effet,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_effet </font>"); ?></td>
			<td align="right"><?php $total_virement=number_format($total_virement,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_virement </font>"); ?></td></tr>
<? } ?>
<td></td><td></td>
			<td align="right"><?php $total_espece_tt=number_format($total_espece_t,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_espece_tt </font>"); ?></td>
			<td align="right"><?php $total_cheque_tt=number_format($total_cheque_t,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_cheque_tt </font>"); ?></td>
			<td align="right"><?php $total_effet_tt=number_format($total_effet_t,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_effet_tt </font>"); ?></td>
			<td align="right"><?php $total_virement_tt=number_format($total_virement_t,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_virement_tt </font>"); ?></td></tr>
</table>
<tr>
<table class="table2">
<td></td><td>TOTAL ENCAISSEMENT</td>
			<td align="right"><?php $ttt=number_format($total_virement_t+$total_espece_t+$total_cheque_t+$total_effet_t,2,',',' ');
			print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$ttt </font>"); ?></td></tr>
</tr>

</table>
</strong>
<p style="text-align:center">


</body>

</html>