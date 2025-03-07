<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$date="";$date_f="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;
		$date="";$action="Recherche";	
	$profiles_list_vendeur = "";$vendeur="";
?>




<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Avoirs"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "avoir_client.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
	<? 
		$date1=$_GET['date1'];$date2=$_GET['date2'];$produit=$_GET['produit'];$client=$_GET['client'];
		$date_du=dateUsToFr($_GET['date1']);$date_au=dateUsToFr($_GET['date2']);
		$sql  = "SELECT * ";
		$sql .= "FROM detail_commandes where produit='$produit' and client='$client' ORDER BY date DESC;";
		$users = db_query($database_name, $sql);
		?>
	
	
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "liste Evaluations Du $date_du Au $date_au   -  $produit "; ?></span>

<table class="table2">

	<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Produit";?></th>
	<th><?php echo "Quantite";?></th>
	<th><?php echo "Client";?></th>
	</tr>
	
<?php 

$total_g=0;$bon="";$client_g="";$total_gg=0;
while($users_ = fetch_array($users)) { ?><tr>
<? 

?>
<td><?php echo dateUsToFr($users_["date"]); ?></td>
<td><?php echo $users_["produit"]; ?></td>
<td><?php echo $users_["quantite"]*$users_["condit"]; $total_g=$total_g+($users_["quantite"]*$users_["condit"]);?></td>
<td><?php echo $users_["client"]; ?></td>



<?php } ?>	
	

</tr>
<tr>
<td></td><td></td>
<td><?php echo $total_g; ?></td>
<td></td>
</tr>
</table>


<p style="text-align:center">


</body>

</html>