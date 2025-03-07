<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	$date=$_GET['date'];$date2=$_GET['date2'];$produit=$_GET['produit'];$du=dateUsToFr($date);$au=dateUsToFr($date2);
		

	$sql  = "SELECT * ";$type="reception";
	$sql .= "FROM entrees_stock_mp where date between '$date' and '$date2' and type='$type' and produit='$produit' ORDER BY date;";
	$users = db_query($database_name, $sql);

	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "ENTREE "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">


<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo " ETAT DES ENTREES M.P ".$produit." Du ".$du." Au ".$au; ?></span>


<table class="table2">

<tr>
	<th><?php echo "DATE";?></th>
	<th><?php echo "FOURNISSEUR";?></th>
	<th><?php echo "REFERENCE ENTREE";?></th>	<th><?php echo "REFERENCE CDE";?></th>
	<th><?php echo "QUANTITE";?></th>
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>

<td style="text-align:center"><?php echo dateUsToFr($users_["date"]); ?></td>
<td style="text-align:left"><?php echo $users_["frs"]; ?></td>
<td style="text-align:center"><?php echo $users_["reception"]; ?></td>
<td style="text-align:center"><?php echo $users_["commande"]; ?></td>
<td style="text-align:center"><?php echo $users_["depot_a"]; ?></td>

<?php } ?>

</table>

<p style="text-align:center">

</body>

</html>