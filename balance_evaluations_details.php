<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$vendeur=$_GET['vendeur'];$date=$_GET['date'];$date1=$_GET['date1'];$bon=$_GET['bon'];
	$du=dateUsToFr($_GET['date']);$au=dateUsToFr($_GET['date1']);$id_registre=$_GET['id_registre'];
	$date11=$_GET['date'];$date22=$_GET['date1'];
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
	
	$sql  = "SELECT * ";
	$sql .= "FROM commandes where vendeur='$vendeur' and id_registre='$id_registre' and date_e between '$date11' and '$date22' ORDER BY date_e;";
	$users = db_query($database_name, $sql);
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Balance Evaluations $vendeur Bon sortie : $bon "; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Evaluation";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Net";?></th>
</tr>

<?php $debit=0;$credit=0;
while($users_ = fetch_array($users)) { ?><tr>
<td><?php echo dateUsToFr($users_["date_e"]);?></td>
<td><?php echo $users_["evaluation"];?></td>
<td><?php echo $users_["client"];?></td>
<td align="right"><?php $debit=$debit+$users_["net"];echo number_format($users_["net"],2,',',' ');?></td>
<?php } ?>
<tr><td></td><td></td><td></td>
<td align="right"><?php echo number_format($debit,2,',',' ');?></td>

</tr>
</table>

<p style="text-align:center">

</body>

</html>