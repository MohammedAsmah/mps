<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$date="";$date_f="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;
		$date="";$action="Recherche";	
	$profiles_list_vendeur = "";$vendeur="";

	
	
		$client=$_GET['client'];$date_au=$_GET['date2'];$date_du=$_GET['date'];$produit=$_GET['produit'];$qt=$_GET['qt'];
		$date_au_fr=dateUsToFr($date_au);$date_du_fr=dateUsToFr($date_du);
		$sql  = "SELECT date,produit,client,condit,sum(quantite) as quantite ";
		$sql .= "FROM detail_avoirs where date between '$date_du' and '$date_au' and produit='$produit' group by client ORDER BY quantite DESC;";
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
<span style="font-size:24px"><?php echo "Detail Avoirs Du $date_du_fr Au $date_au_fr   -  $produit "; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "Client";?></th>
	<th><?php echo "Quantite Avoir";?></th>
	<th><?php echo "Quantite Vendu";?></th>
	<th><?php echo " % ";?></th>
	
	</tr>

<?php 


	$m=0;$total_quantite=0;$total_quantite_v=0;
	
	while($users1_ = fetch_array($users)) { ?><tr>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$client=$users1_["client"];?>
		
		<tr>
		<tr><td><?php echo $users1_["client"]; ?></td>
		<td align="center"><?php echo $users1_["quantite"]*$users1_["condit"];$total_quantite=$total_quantite+$users1_["quantite"]*$users1_["condit"]; ?></td>
		<?php $p=$users1_["quantite"]*$users1_["condit"];
		$sql  = "SELECT date,produit,condit,sum(quantite) as quantite ";
		$sql .= "FROM detail_commandes where client='$client' and date between '$date_du' and '$date_au' and produit='$produit' group by client ORDER BY date DESC;";
		$users2 = db_query($database_name, $sql);$users2_ = fetch_array($users2);
		$v=$users2_["quantite"]*$users2_["condit"];$total_quantite_v=$total_quantite_v+$users2_["quantite"]*$users2_["condit"];
		?>
		<td align="center"><?php echo $users2_["quantite"]." X ".$users2_["condit"]; ?></td>
		<td align="center"><?php @$pc=number_format($p/$v*100,2,',',' ')." % ";echo $pc ?></td>
		</tr>
		
		
	<?}?>

	
</tr><td></td>
<td align="center"><?php echo $total_quantite; ?></td>
<td align="center"><?php  ?></td>
<td align="center"><?php  ?></td>
</table>


<p style="text-align:center">


</body>

</html>