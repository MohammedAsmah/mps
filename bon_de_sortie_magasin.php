<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";?>
	
		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link rel="stylesheet" type="text/css" href="styles.css">

</head>

<body>

	<?
		if(isset($_REQUEST["action_"])) { 
		if($_REQUEST["action_"] == "update_user") {
			$user=$_REQUEST["login"];
			$datej=date("d/m/Y H:m");
			$user=$user." le ".$datej;
			$sql = "UPDATE bon_de_sortie_magasin SET ";
			$sql .= "user = '" . $user . "', ";
			$sql .= "depot_a = '" . $_REQUEST["depot_a"] . "', ";
			$sql .= "depot_b = '" . $_REQUEST["depot_b"] . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);$id_registre= $_REQUEST["id_registre"];
	}}
	else
	{
	
		$id_registre=$_GET['id_registre'];$bon_sortie=$_GET['bon_sortie'];$c=$_GET['observation'];
		$montant=$_GET['montant'];
		$montant=number_format($montant,2,',',' ');
		$vendeur=$_GET['vendeur'];$date=dateUsToFr($_GET['date']);$service=$_GET['service'];
		}
		
		?>
			
<table class="table2">

<tr>
	<th><?php echo "Produit";?></th>
	<th><?php echo "MPS";?></th>
	<th><?php echo "JAOUDA";?></th>
	<th><?php echo "TOTAL";?></th>
</tr>




	<? $sql1  = "SELECT * ";
	$sql1 .= "FROM bon_de_sortie_magasin where id_registre='$id_registre' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
	$produit=$users1_["produit"]; $depot_a=$users1_["depot_a"];$condit=$users1_["condit"];$depot_b=$users1_["depot_b"];
	$depot_c=$users1_["depot_c"];$id=$users1_["id"];?>
	<tr>
	<td><?php echo "<a href=\"despatch_sortie.php?id_registre=$id_registre&user_id=$id\">".$produit."</a>"; ?></td>
	<td><?php echo $depot_a;?></td>
	<td><?php echo $depot_b;?></td>
	<td><?php echo $depot_a+$depot_b;?></td>
	</tr>
		<?  }?>
		
		</table>
		
	</body>

</html>
	 
