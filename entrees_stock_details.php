<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	$date1=$_GET['date1'];$date2=$_GET['date2'];$produit=$_GET['produit'];$du=dateUsToFr($date1);$au=dateUsToFr($date2);?>
	
	<?
	$sql  = "SELECT * ";$type="production";
	$sql .= "FROM entrees_stock where type='$type' and produit='$produit' and date between '$date1' and '$date2' ORDER BY date;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "ENTREE PRODUCTION"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:20px"><?php echo " PRODUCTION  $produit   du  $du  au  $au "; ?></span>


<table class="table2">

<tr>
	<th><?php echo "DATE";?></th>
	<th><?php echo "MPS";?></th>
	<th><?php echo "JAOUDA";?></th>
</tr>

<?php $t=0;while($users_ = fetch_array($users)) { ?><tr>

<td><?php echo dateUsToFr($users_["date"]);?></td>
<td style="text-align:center"><?php echo $users_["depot_a"]; $t=$t+$users_["depot_a"];?></td>
<td style="text-align:center"><?php echo $users_["depot_b"]; $t=$t+$users_["depot_b"];?></td>
<?php } ?>
<tr><td></td><td><?php echo $t;?></td></tr>
</table>

<p style="text-align:center">


</body>

</html>