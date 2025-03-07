<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";?>

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
				$type_service="SEJOURS ET CIRCUITS";$date=$_GET['date'];
				$sql  = "SELECT * ";
				$sql .= "FROM porte_feuilles_factures where remise=0 and m_cheque>0 and facture_n<>0 and date_cheque<='$date' ORDER BY id;";
				$users = db_query($database_name, $sql);$tr=0;
				?>
<table border="0" class="table2">
<tr>
	<th><?php $d=dateUsToFr($date);echo "Apercu Remise du $d ";?></th>
</tr>
<tr>
	<th><?php echo "Date Emission";?></th>
	<th><?php echo "Designation";?></th>
	<th><?php echo "N° Cheque";?></th>
	<th><?php echo "Banque";?></th>
	<th><?php echo "Date Regl";?></th>
	<th><?php echo "MT Cheque";?></th>
	
</tr>

				<?
				while($users_ = fetch_array($users)) { 
				$id=$users_["id"];$m_cheque=$users_["m_cheque"];$date_enc=dateUsToFr($users_["date_enc"]);$client=$users_["client"];
				$client_tire=$users_["client_tire"];$v_banque=$users_["v_banque"];$date_cheque=dateUsToFr($users_["date_cheque"]);
				$numero_cheque=$users_["numero_cheque"];$m_cheque1=number_format($users_["m_cheque"],2,',',' ');
					echo "<tr><td>$date_enc</td><td>$client/$client_tire</td>";
					echo "<td>$numero_cheque</td><td>$v_banque</td>";
					echo "<td>$date_cheque</td>";?>
					<td align="right"><? echo $m_cheque1;?></td></tr>
					<? $tr=$tr+$m_cheque;
					 }?>
					 <td></td><td></td><td></td><td></td><td></td>
					<td align="right"><? echo number_format($tr,2,',',' ');?></td></tr>
					 </table>

</body>

</html>