<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$caisse=$_GET['caisse'];

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
	
	
<?			
	$du1=date("d/m/Y");
	$date1=$_GET['date1'];$date=$_GET['date'];$au=dateUsToFr($_GET['date1']);$du=dateUsToFr($_GET['date']);
	
	$sql  = "SELECT type,caisse,date,debit,credit,sum(debit) As total_debit,sum(credit) As total_credit ";
	$sql .= "FROM journal_caisses where date between '$date' and '$date1' and caisse='$caisse' GROUP BY type;";
	$users = db_query($database_name, $sql);
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Balance Caisse $caisse du $du au $au"; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Type";?></th>
	<th><?php echo "Debit";?></th>
	<th><?php echo "Credit";?></th>
	<th><?php echo "Solde";?></th>
</tr>

<?php $debit=0;$credit=0;
while($users_ = fetch_array($users)) { ?><tr>
<?php $type=$users_["type"];?>
<? echo "<td><a href=\"balance_caisses_details.php?caisse=$caisse&type=$type&date=$date&date1=$date1\">$type</a></td>";?>
<td align="right"><?php echo number_format($users_["total_debit"],2,',',' ');?></td>
<td align="right"><?php echo number_format($users_["total_credit"],2,',',' ');?></td>
<td align="right"><?php echo number_format($users_["total_debit"]-$users_["total_credit"],2,',',' ');?></td></tr>
<?php } ?>
</table>

<p style="text-align:center">

</body>

</html>