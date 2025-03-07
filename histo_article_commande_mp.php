<?php
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	
	
	// recherche ville
	?>
	
	<?
	
		$p=$_REQUEST["produit"];$au=$_REQUEST["au"];$aufr=dateUsToFr($_REQUEST["au"]);
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$p' ORDER BY produit;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$stock_initial=$user_2["stock_initial"];$sf=$stock_initial;
	
	$sql  = "SELECT * ";
	$sql .= "FROM entrees_stock_mp where produit='$p' and date<='$au' ORDER BY date;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "INVENTAIRE $p au $aufr"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "References";?></th>
	<th><?php echo "Entree";?></th>
	<th><?php echo " Sortie ";?></th>
	<th><?php echo "Stock";?></th>
</tr>
<td><?php $dt="02/05/2012";echo $dt; ?></td>
<td><?php echo "STOCK INITIAL"; ?></td>
<td><?php echo $sf; ?></td>
<td><?php  ?></td>
<td><?php echo $sf; ?></td>

<?php while($users_ = fetch_array($users)) { ?><tr>


<td><?php echo dateUsToFr($users_["date"]);?></td>

<td><?php if($users_["type"] == "reception") 
{ echo $users_["reception"]." - ".$users_["livraison"]." - ".$users_["commande"];}  
else { echo $users_["commande"];} ?></td>

<td><?php if($users_["type"] == "reception") { $op=$users_["depot_a"];echo number_format($users_["depot_a"],3,',',' ')."</td><td></td>";}  
else { $op=-$users_["depot_a"];echo "</td><td>".$users_["depot_a"]."</td>";} ?>
<td><?php $sf=$sf+$op; echo $sf;?></td>


<?php } ?>

</table>

<p style="text-align:center">

	
</body>

</html>