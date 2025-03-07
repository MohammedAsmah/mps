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
	$action="recherche";$date=$_GET["date"];$client=$_GET["client"];
	
	if(isset($_REQUEST["action_"]))
	{
		if($_REQUEST["action_"]=="update_user")
		{
			$date_c=dateFrToUs($_REQUEST["date_c"]);$numero_cheque=$_REQUEST["numero_cheque"];$client=$_REQUEST["client"];
			$sql = "UPDATE porte_feuilles SET ";
			$sql .= "date_cheque = '" . $date_c . "' ";
			$sql .= "WHERE numero_cheque='$numero_cheque' and client = '$client' ;";
			db_query($database_name, $sql);
			
			
			$sql = "UPDATE porte_feuilles_factures SET ";
			$sql .= "date_cheque = '" . $date_c . "' ";
			$sql .= "WHERE numero_cheque='$numero_cheque' and client = '$client' ;";
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
<style type="text/css">

</style>


</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	

	$total=0;
	
	
	/*$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles where date_valeur='$date' and mode='$mode' and remise=0 ORDER BY date_valeur;";
	$users11 = db_query($database_name, $sql);*/
	$sql  = "SELECT id,date_enc,date_cheque,client,client_tire,v_banque,numero_cheque,sum(m_effet) As total_cheque ";
	$sql .= "FROM porte_feuilles_factures where date_echeance<='$date' and client='$client' and m_effet<>0 GROUP BY numero_effet order by date_effet;";
	$users11 = db_query($database_name, $sql);
	
?>


<span style="font-size:24px"><?php echo "Porte Feuilles $client au : ".dateUsToFr($date); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo "Client Tiré";?></th>
	<th><?php echo "Date Encaisse";?></th>
	<th><?php echo "Reference";?></th>
	<th><?php echo "Montant Cheque";?></th>
	
</tr>

<?php $compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { 
			$date_enc=$users_1["date_cheque"];$id=$users_1["id"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];
			$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_effet"];$total_cheque=$users_1["total_cheque"];
			$ref1=$v_banque." ".$numero_cheque;$ref=$numero_cheque;?>
			<tr>
			<td><?php echo $client; ?></td>
			<td><?php echo $client_tire; ?></td>
			<td><?php echo dateUsToFr($date_enc); ?></td>
			<? echo "<td><a href=\"maj_date_cheque.php?client=$client&ref=$ref&id=$id&date=$date\">$ref1</a></td>";?>
			
			<td align="right"><?php $total=$total+$total_cheque;echo number_format($total_cheque,2,',',' '); ?></td></tr>


<? } ?>
<tr><td></td><td></td><td></td><td></td>
			<td align="right"><?php echo number_format($total,2,',',' '); ?></td>
</table>
</strong>
<p style="text-align:center">


</body>

</html>