<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$date="";$date_f="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;
		$date="";$action="Recherche";	
	$profiles_list_vendeur = "";$vendeur="";

	
	
		$client=$_GET['client'];$date_au=$_GET['date2'];$date_du=$_GET['date'];$produit=$_GET['produit'];
		$date_au_fr=dateUsToFr($date_au);$date_du_fr=dateUsToFr($date_du);
		$sql  = "SELECT * ";
		$sql .= "FROM detail_commandes where client='$client' and date between '$date_du' and '$date_au' and produit='$produit' ORDER BY date DESC;";
		$users = db_query($database_name, $sql);
	
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Avoirs"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "Detail Sorties Du $date_du_fr Au $date_au_fr   -  $client / $produit "; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Quantite";?></th>
	<th><?php echo "Condit";?></th>
	<th><?php echo "Total";?></th>
	</tr>

<?php 


	$m=0;$total_quantite=0;
	
	while($users1_ = fetch_array($users)) { ?><tr>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];?>
		
		<tr><td><?php echo dateUsToFr($users1_["date"]); ?></td>
		<td align="center"><?php echo $users1_["quantite"];$total_quantite=$total_quantite+$users1_["quantite"]*$users1_["condit"]; ?></td>
		<td align="center"><?php echo $users1_["condit"];?>
		<td align="center"><?php echo $users1_["quantite"]*$users1_["condit"];?>
		</tr>
		
		
	<?}?>

	
</tr><td></td><td></td><td></td>
<td align="center"><?php echo $total_quantite; ?></td>
</table>


<p style="text-align:center">


</body>

</html>