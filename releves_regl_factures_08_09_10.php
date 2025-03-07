<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
$valeur=3600;
set_time_limit($valeur);
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 
	} //if
	
	$date1="";$date2="";$action="Recherche";$t_cheque_t = 0;
	$t_espece_t = 0;
	$t_effet_t = 0;$t_virement_t = 0;
	$profiles_list_mois = "";$mois="";
	$sql1 = "SELECT * FROM mois_rak_08 ORDER BY id;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($mois == $temp_["mois"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_mois .= "<OPTION VALUE=\"" . $temp_["mois"] . "\"" . $selected . ">";
		$profiles_list_mois .= $temp_["mois"];
		$profiles_list_mois .= "</OPTION>";
	}
	
	
	?>
	
	<form id="form" name="form" method="post" action="releves_regl_factures_08_09_10.php">
	<td><?php echo "Du : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au : "; ?><input onClick="ds_sh(this);" name="date2" value="<?php echo $date2; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<?
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Factures"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "facture.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Factures"; ?></span>
<?
	if(isset($_REQUEST["action"]))
	{
	$date1=dateFrToUs($_POST['date1']);$date2=dateFrToUs($_POST['date2']);
	$date_d1=dateFrToUs($_POST['date1']);$date_d2=dateFrToUs($_POST['date2']);
	$de1=$_POST['date1'];$de2=$_POST['date2'];
		
	$sql  = "SELECT * ";
	$sql .= "FROM factures where (date_f between '$date1' and '$date2') and montant>0 ORDER BY id;";
	$users = db_query($database_name, $sql);
?>
<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Numero";?></th>
	<th width="200"><?php echo "Client";?></th>
	<th width="100"><?php echo "HTVA";?></th>
	<th width="100"><?php echo "TVA";?></th>
	<th width="100"><?php echo "TTC";?></th>
	<th width="200"><?php echo "Espece";?></th>
	<th width="100"><?php echo "Cheque";?></th>
	<th width="100"><?php echo "Effet";?></th>
	<th width="100"><?php echo "Virement";?></th>
	
</tr>

<?php $ca=0;while($users_ = fetch_array($users)) { 
$total_cheque = 0;
	$total_espece = 0;
	$total_effet = 0;
	$total_virement = 0;
?><tr>
<? $client=$users_["client"];$id=$users_["id"];$f=$users_["numero"];$d=$users_["date_f"];$client_se=Trim($client);
$evaluation=$users_["evaluation"]; $client=$users_["client"];$user_id=$users_["id"];$facture=$users_["id"]+9040;?>
<td><?php $date=dateUsToFr($users_["date_f"]);$d=dateUsToFr($users_["date_f"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td><?php 	$f_lien="<a href=\"detail_regl_fact1.php?numero=$facture&client=$client&date1=$date1&date2=$date2\">$facture</a>";
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$f_lien </font>"); ?></td>
<td><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?> </td>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];?>
<td align="right" width="150"><?php $ca=$ca+$users_["montant"];$ht=number_format($users_["montant"]/1.2,2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ht </font>"); ?></td>
<td align="right" width="150"><?php $tva=number_format($users_["montant"]/1.2*0.20,2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tva </font>"); ?></td>
<td align="right" width="150"><?php $ttc=number_format($users_["montant"],2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ttc </font>"); ?></td>
<? ///cheques		
		
		$sql  = "SELECT numero_cheque,facture_n,client,client_tire,v_banque,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece
		, sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
		$sql .= "FROM porte_feuilles where m_cheque<>0 and remise=1 and facture_n='$facture' and (date_remise between '$date1' and '$date2') Group BY facture_n;";
		$users11 = db_query($database_name, $sql);
		$t_cheque=0;
while($row = fetch_array($users11))
{
	$client = $row['client'];$client_tire=$row['client_tire'];
	$banque=$row['v_banque'];$facture_n=$row['facture_n'];
	$numero_cheque=$row['numero_cheque'];
	$total_e = 0;
	$total_avoir = $row['total_avoir'];
	$total_diff_prix = 0;
	$total_cheque = $row['total_cheque'];
	$t_cheque=$t_cheque+$total_cheque;
	$t_cheque_t=$t_cheque_t+$total_cheque;
}
/////fincheques

//effet
		$sql  = "SELECT remise,numero_cheque,facture_n,client,client_tire,v_banque,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece
		, sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
		$sql .= "FROM porte_feuilles where m_effet<>0 and facture_n='$facture' and (date_enc between '$date1' and '$date2') Group BY facture_n;";
		$users11 = db_query($database_name, $sql);
		$t_effet=0;
while($row = fetch_array($users11))
{
	$client = $row['client'];$client_tire=$row['client_tire'];
	$banque=$row['v_banque'];$facture_n=$row['facture_n'];
	$numero_cheque=$row['numero_cheque'];
	$total_e = 0;
	$total_avoir = $row['total_avoir'];
	$total_diff_prix = 0;
	$total_effet = $row['total_effet'];
	$t_effet=$t_effet+$total_effet;
	$t_effet_t=$t_effet_t+$total_effet;
}
///fin effet

//virment
		$sql  = "SELECT remise,numero_cheque,facture_n,client,client_tire,v_banque,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece
		, sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
		$sql .= "FROM porte_feuilles where m_virement<>0 and facture_n='$facture' and (date_enc between '$date1' and '$date2') Group BY facture_n;";
		$users11 = db_query($database_name, $sql);
		$t_virement=0;
while($row = fetch_array($users11))
{
	$client = $row['client'];$client_tire=$row['client_tire'];
	$banque=$row['v_banque'];$facture_n=$row['facture_n'];
	$numero_cheque=$row['numero_cheque'];
	$total_e = 0;
	$total_avoir = $row['total_avoir'];
	$total_diff_prix = 0;
	/*$total_cheque = $row['total_cheque'];*/
	/*$total_effet = $row['total_effet'];*/
	$total_virement = $row['total_virement'];
	/*$t_cheque=$t_cheque+$total_cheque;*/
	/*$total_effet=$total_effet+$total_effet;*/
	/*$t_cheque_t=$t_cheque_t+$total_cheque;*/
	/*$total_effet_t=$total_effet_t+$total_effet;*/
	$t_virement=$t_virement+$total_virement;
	$t_virement_t=$t_virement_t+$total_virement;
}
///fin virment

		$sql  = "SELECT numero_cheque,facture_n,client,client_tire,v_banque,m_espece,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece
		, sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
		$sql .= "FROM porte_feuilles where facture_n='$facture' and m_espece>0 and date_enc between '$date1' and '$date2' Group BY facture_n;";
		$users11 = db_query($database_name, $sql);
		$t_espece=0;
while($row = fetch_array($users11))
{
	$client = $row['client'];$client_tire=$row['client_tire'];
	$banque=$row['v_banque'];$facture_n=$row['facture_n'];
	$numero_cheque=$row['numero_cheque'];
	$total_e = 0;
	$total_avoir = $row['total_avoir'];
	$total_diff_prix = 0;
	$total_espece = $row['total_espece'];
	/*$total_espece=$total_espece+$total_espece;*/
	$t_espece=$t_espece+$total_espece;
	$t_espece_t=$t_espece_t+$total_espece;
}

?>
<td align="right" width="150"><?php $total_espece=number_format($total_espece,2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$total_espece </font>"); ?></td>
<td align="right" width="150"><?php $total_cheque=number_format($total_cheque,2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$total_cheque </font>"); ?></td>
<td align="right" width="150"><?php $total_effet=number_format($total_effet,2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$total_effet </font>"); ?></td>
<td align="right" width="150"><?php $total_virement=number_format($total_virement,2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$total_virement </font>"); ?></td>


<?php } ?>
</table>
<table><tr><? echo "<td><a href=\"\\mps\\tutorial\\releve_factures.php?date1=$date_d1&date2=$date_d2\">Imprimer Facturation du mois</a></td>";?>
<tr></tr>
<tr><? echo "<td><a href=\"edition_regl_factures_pdf.php?date1=$date_d1&date2=$date_d2\">Imprimer Reglements Factures</a></td>";?>

<tr><? echo "<td><a href=\"\\mps\\tutorial\\releve_factures_n_enc.php?date1=$date_d1&date2=$date_d2\">Imprimer Factures Non Encaissees du mois</a></td>";?>
</table>
</tr>
<? } ?>
<p style="text-align:center">

</body>

</html>