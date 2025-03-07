<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
$valeur=3600;
set_time_limit($valeur);
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];
	
	
	
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
	
	<form id="form" name="form" method="post" action="releves_factures_edition.php">
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
		
	if ($date2>"2016-12-31"){
	if ($date2>="2018-01-01" and $date2<"2019-01-01"){$factures="factures2018";$exe="/18";}
	if ($date2>="2017-01-01" and $date2<"2018-01-01"){$factures="factures";$exe="/17";}
	if ($date2>="2019-01-01" and $date2<"2020-01-01"){$factures="factures2019";$exe="/19";}
	if ($date2>="2020-01-01" and $date2<"2021-01-01"){$factures="factures2020";$exe="/20";}
	if ($date2>="2021-01-01" and $date2<"2022-01-01"){$factures="factures2021";$exe="/21";}
	if ($date2>="2022-01-01" and $date2<"2023-01-01"){$factures="factures2022";$exe="/22";}
	if ($date2>="2023-01-01" and $date2<"2024-01-01"){$factures="factures2023";$exe="/23";}
	if ($date2>="2024-01-01" and $date2<"2025-01-01"){$factures="factures2024";$exe="/24";}
	if ($date2>="2025-01-01" and $date2<"2026-01-01"){$factures="factures2025";$exe="/25";}
	if ($date2>="2026-01-01" and $date2<"2027-01-01"){$factures="factures2026";$exe="/26";}
	
	
	$sql  = "SELECT * ";
	$sql .= "FROM ".$factures." where (date_f between '$date1' and '$date2') and montant>0 group by client ORDER BY id ;";
	}
	else
	{
	$sql  = "SELECT * ";
	$sql .= "FROM factures2016 where (date_f between '$date1' and '$date2') and montant>0 ORDER BY id;";
	}
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
<? $client=$users_["client"];$id=$users_["id"];$f=$users_["numero"];$d=$users_["date_f"];$client_se=Trim($client);$df=$users_["date_f"];
$evaluation=$users_["evaluation"]; $client=$users_["client"];$user_id=$users_["id"];
$sql  = "SELECT * ";
		$sql .= "FROM clients WHERE client = '" . $client . "';";
		$user_c = db_query($database_name, $sql); $user_cc = fetch_array($user_c);
		$adr = substr($user_cc["adrresse"],0,35);$ville = $user_cc["ville"];$patente = $user_cc["patente"];$v = $user_cc["vendeur"];
		
if ($date2>"2016-12-31"){
$facture=$users_["id"]+0;
if ($user_id<10){$zero="000";}
if ($user_id>=10 and $user_id<100){$zero="00";}
if ($user_id>=100 and $user_id<1000){$zero="0";}
if ($user_id>=1000 and $user_id<10000){$zero="";}
$facture=$users_["id"]+0;$exercice=$users_["exercice"];$facture=$zero.$facture."/".$exercice;
}else
{
$facture=$users_["id"]+9040;
}


?>
<td><?php $date=dateUsToFr($users_["date_f"]);$d=dateUsToFr($users_["date_f"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td><?php 	$f_lien="<a href=\"detail_regl_fact1.php?numero=$facture&client=$client&date1=$date1&date2=$date2\">$facture</a>";
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$f_lien </font>"); ?></td>
<td><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?> </td>
<td><?php $v=$users_["vendeur"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$v </font>"); ?> </td>
<td><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$adr </font>"); ?> </td>
<td><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ville </font>"); ?> </td>
<td><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$patente </font>"); ?> </td>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];?>
<td align="right" width="150"><?php $ca=$ca+$users_["montant"];$ht=number_format($users_["montant"]/1.2,2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ht </font>"); ?></td>
<td align="right" width="150"><?php $tva=number_format($users_["montant"]/1.2*0.20,2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tva </font>"); ?></td>
<td align="right" width="150"><?php $ttc=number_format($users_["montant"],2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ttc </font>"); ?></td>
<? 


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
<? echo "<td><a href=\"edition_factures_pdf_entete.php?date1=$date_d1&date2=$date_d2\">Imprimer Factures / entete</a></td>";	?>
<? echo "<td><a href=\"edition_factures_pdf_entete_count.php?date1=$date_d1&date2=$date_d2\">Imprimer Factures report / entete</a></td>";	?>
<? echo "<td><a href=\"edition_factures_pdf_entete_iks.php?date1=$date_d1&date2=$date_d2\">Imprimer Factures IKS/ entete</a></td>";	?>
<table><tr><? echo "<td><a href=\"\\mps\\tutorial\\releve_factures.php?date1=$date_d1&date2=$date_d2\">Imprimer Facturation du mois</a></td>";?>
<tr></tr>
<tr><? echo "<td><a href=\"\\mps\\tutorial\\releve_factures_n_enc.php?date1=$date_d1&date2=$date_d2\">Imprimer Factures Non Encaissees du mois</a></td>";?>
<tr><? echo "<td><a href=\"edition_factures_pdf.php?date1=$date_d1&date2=$date_d2\">Imprimer Factures</a></td>";
if ($login=="admin"){

echo "<td><a href=\"edition_factures_pdf2.php?date1=$date_d1&date2=$date_d2\">Imprimer Factures 2</a></td>";
echo "<td><a href=\"edition_factures_pdf_iks.php?date1=$date_d1&date2=$date_d2\">Imprimer Factures iks</a></td>";
echo "<td><a href=\"edition_factures_pdf_iks_13_14.php?date1=$date_d1&date2=$date_d2\">Imprimer Factures iks 13/14</a></td>";
}


?>
<tr><? echo "<td><a href=\"\\mps\\tutorial\\releve_factures_espece.php?date1=$date_d1&date2=$date_d2\">Imprimer Etat Timbres / Factures espece</a></td>";?>
</table>
</tr>
<? } ?>
<p style="text-align:center">

</body>

</html>