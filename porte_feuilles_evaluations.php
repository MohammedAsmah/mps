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
	$action="recherche";
	
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

	$date=dateFrToUs(date("d/m/Y"));$total=0;
	
	$sql  = "SELECT id,date_enc,date_cheque,client,client_tire,v_banque,numero_cheque,sum(m_cheque) As total_cheque ";
	$sql .= "FROM porte_feuilles where date_cheque>='$date' and m_cheque<>0 and remise=0 and chq_f=0 and encaisse=0  GROUP BY id;";
	$users11 = db_query($database_name, $sql);
?>


<span style="font-size:24px"><?php echo "Porte Feuilles Evaluations au : ".dateUsToFr($date); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date Remise";?></th>
   	<th><?php echo "Montant Cheque";?></th>
	<th><?php echo "Numero Cheque";?></th>
	<th><?php echo "Client";?></th>

	
</tr>

<?php $compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { 
			$date_enc=$users_1["date_enc"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];
			$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];$total_cheque=$users_1["total_cheque"];
			$ref=$v_banque." ".$numero_cheque;$date_cheque=dateUsToFr($users_1["date_cheque"]);$date_cheque1=$users_1["date_cheque"];?>
			<? echo "<tr><td><a href=\"porte_feuilles_details2.php?date_cheque=$date_cheque1\">$date_cheque</a></td>";?>
			<td align="right"><?php $total_g=$total_g+$total_cheque;echo number_format($total_cheque,2,',',' ');?></td>
			<td align="left"><?php echo $numero_cheque;?></td>
			<td align="left"><?php echo $client." / ".$client_tire;?></td>
			</tr>


<? } ?>
<tr><td><?php echo "Total General "; ?></td><td align="right"><?php echo number_format($total_g,2,',',' '); ?></td>
<td></td>
<td></td>

</table>
</strong>
<p style="text-align:center">


</body>

</html>