<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$date=$_GET['date'];$date1=$_GET['date1'];$produit=$_GET['produit'];$id=$_GET['id'];
	$du=dateUsToFr($_GET['date']);$au=dateUsToFr($_GET['date1']);
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE id = $id ";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$produit = $user_["produit"];

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
	
	/*$sql  = "SELECT produit,quantite,condit,date_f,facture,sum(quantite*condit) As total_quantite ,sum(quantite) As t_quantite ";
	$sql .= "FROM detail_factures where produit='$produit' and (date_f between '$date' and '$date1') GROUP BY facture order by facture ASC;";
	$users = db_query($database_name, $sql);*/
	$sql  = "SELECT * ";
	$sql .= "FROM detail_factures where produit='$produit' and (date_f between '$date' and '$date1') order by facture ASC;";
	$users = db_query($database_name, $sql);
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Despatching Article par Facture : $produit $du au $au "; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Facture";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Paquets";?></th>
	<th><?php echo "Condit";?></th>
	<th><?php echo "Quantite";?></th>
</tr>

<?php $debit=0;$credit=0;$t=0;$s=0;$t_q=0;
while($users_ = fetch_array($users)) { ?><tr>
<td><?php echo $users_["facture"];?></td>
<td><?php echo dateUsToFr($users_["date_f"]);?></td>
<td align="right"><?php echo $users_["quantite"];?></td>
<td align="right"><?php $q=$users_["quantite"]*$users_["condit"];echo $users_["condit"];$t_q=$t_q+$q;?></td>
<td align="right"><?php echo $q;?></td>
<?php } ?>
<tr>
<td></td><td></td><td></td>
<td align="right"><?php echo $t_q;?></td>
</tr>
</table>

<p style="text-align:center">

</body>

</html>