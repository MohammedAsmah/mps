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
	$action="recherche";$client=$_GET["client"];$date=$_GET["date"];$date2=$_GET["date2"];
	
	if(isset($_REQUEST["action_"]))
	{
		if($_REQUEST["action_"]=="update_user")
		{
			$date_c=dateFrToUs($_REQUEST["date_c"]);$numero_cheque=$_REQUEST["numero_cheque"];$client=$_REQUEST["client"];
			$sql = "UPDATE porte_feuilles SET ";
			$sql .= "date_echeance = '" . $date_c . "' ";
			$sql .= "WHERE numero_effet='$numero_cheque' and client = '$client' ;";
			db_query($database_name, $sql);
			
			
			$sql = "UPDATE porte_feuilles_factures SET ";
			$sql .= "date_echeance = '" . $date_c . "' ";
			$sql .= "WHERE numero_effet='$numero_cheque' and client = '$client' ;";
			db_query($database_name, $sql);
			
		
		}
		
	$date=$_REQUEST["date"];
	$client=$_REQUEST["client"];
	
	}
	
	
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

	$total=0;
	
	/*$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles where date_valeur='$date' and mode='$mode' and remise=0 ORDER BY date_valeur;";
	$users11 = db_query($database_name, $sql);*/
	$sql  = "SELECT id,date_enc,date_echeance,date_remise_e,client,client_tire,client_tire_e,v_banque,numero_effet,sum(m_effet) As total_cheque ";
	$sql .= "FROM porte_feuilles where date_remise_e between '$date' and '$date2' and client='$client' and m_effet<>0 and remise_e=1 and eff_f=1 GROUP BY numero_effet;";
	$users11 = db_query($database_name, $sql);
	
?>


<span style="font-size:24px"><?php echo "Remises effets  : ".$client." du ".dateUsToFr($date)." au ".dateUsToFr($date2); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo "Client Tiré";?></th>
	<th><?php echo "Date Remise";?></th>
	<th><?php echo "Date Echeance";?></th>
	<th><?php echo "Reference";?></th>
	<th><?php echo "Montant";?></th>
	
</tr>

<?php $compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { 
			$date_enc=$users_1["date_enc"];$date_echeance=$users_1["date_echeance"];$id=$users_1["id"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire_e"];$date_remise=$users_1["date_remise_e"];
			$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_effet"];$total_cheque=$users_1["total_cheque"];
			$ref1=$v_banque." ".$numero_cheque;$ref=$numero_cheque;?>
			<tr>
			<td><?php echo $client; ?></td>
			<td><?php echo $client_tire; ?></td>
			<td><?php echo dateUsToFr($date_remise); ?></td>
			<td><?php echo dateUsToFr($date_echeance); ?></td>
			<? echo "<td><a href=\"maj_date_effet_r.php?client=$client&ref=$ref&id=$id&date=$date&date2=$date2\">$ref1</a></td>";?>
			<td align="right"><?php $total=$total+$total_cheque;echo number_format($total_cheque,2,',',' '); ?></td></tr>


<? } ?>
<tr><td></td><td></td><td></td><td></td><td></td>
			<td align="right"><?php echo number_format($total,2,',',' '); ?></td>
</table>
</strong>
<p style="text-align:center">


</body>

</html>