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
	$action="recherche";$numero=$_GET["numero"];$client=$_GET["client"];$date1=$_GET["date1"];$date2=$_GET["date2"];
	
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
	
	/*$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles where date_valeur='$date' and mode='$mode' and remise=0 ORDER BY date_valeur;";
	$users11 = db_query($database_name, $sql);*/
	$sql  = "SELECT id,date_enc,date_cheque,client,client_tire,v_banque,numero_cheque,sum(m_cheque) As total_cheque ,
	sum(m_espece) As total_espece,sum(m_effet) As total_effet,sum(m_virement) As total_virement ";
	$sql .= "FROM porte_feuilles_factures where facture_n=$numero and remise=1 and (date_remise between '$date1' and '$date2')Group BY id;";
	$users11 = db_query($database_name, $sql);
	
?>


<span style="font-size:24px"><?php echo "Detail regelement Facture : ".$numero." / ".$client; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Client Tiré";?></th>
	<th><?php echo "Date Entree";?></th>
	<th><?php echo "Date Encaiss";?></th>
	<th><?php echo "Reference";?></th>
	<th><?php echo "Cheque";?></th>
	<th><?php echo "Espece";?></th>
	<th><?php echo "Effet";?></th>
	<th><?php echo "Virement";?></th>
</tr>

<?php $compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { 
			$date_enc=$users_1["date_enc"];$date_cheque=$users_1["date_cheque"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];$total_espece=$users_1["total_espece"];
			$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];$total_cheque=$users_1["total_cheque"];
			$ref=$v_banque." ".$numero_cheque;$total_effet=$users_1["total_effet"];$total_virement=$users_1["total_virement"];?>
			<tr>
			<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$client_tire </font>");  ?></td>
			<td><?php $dc=dateUsToFr($date_enc);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$dc </font>");  ?></td>
			<td><?php $dch= dateUsToFr($date_cheque);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$dch </font>");  ?></td>
			<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ref </font>");  ?></td>
			<td align="right"><?php $total=$total+$total_cheque;$tc= number_format($total_cheque,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tc </font>");  ?></td>
			<td align="right"><?php $total1=$total1+$total_espece;$te= number_format($total_espece,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$te </font>"); ?></td>
			<td align="right"><?php $total11=$total11+$total_effet;$tf= number_format($total_effet,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tf </font>"); ?></td>
			<td align="right"><?php $total111=$total111+$total_virement;$tv= number_format($total_virement,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tv </font>"); ?></td>
<? } ?>
<tr><td></td><td></td><td></td><td></td>
			<td align="right"><?php $t1= number_format($total,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t1 </font>"); ?></td>
			<td align="right"><?php $t2= number_format($total1,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t2 </font>"); ?></td>
			<td align="right"><?php $t3= number_format($total11,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t3 </font>"); ?></td>
			<td align="right"><?php $t4= number_format($total111,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t4 </font>"); ?></td>

</table>
</strong>
<p style="text-align:center">


</body>

</html>