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
		if(isset($_REQUEST["action_"])) { $id_registre= $_REQUEST["id_registre"];
		if($_REQUEST["action_"] == "mps") { //mps===>jaouda
			$sql1  = "SELECT * ";
	$sql1 .= "FROM bon_de_sortie_magasin where id_registre='$id_registre' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
	$produit=$users1_["produit"]; $depot_a=$users1_["depot_a"];$condit=$users1_["condit"];$depot_b=$users1_["depot_b"];
	$depot_c=$users1_["depot_c"];$id=$users1_["id"];$vide=0;
					$sql = "UPDATE bon_de_sortie_magasin SET ";
			$sql .= "depot_a = '" . $depot_b . "', ";
			$sql .= "depot_b = '" . $vide . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);

		
		  }

		
	}
	
	else
	{//jaouda===>mps
			$sql1  = "SELECT * ";
	$sql1 .= "FROM bon_de_sortie_magasin where id_registre='$id_registre' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
	$produit=$users1_["produit"]; $depot_a=$users1_["depot_a"];$condit=$users1_["condit"];$depot_b=$users1_["depot_b"];
	$depot_c=$users1_["depot_c"];$id=$users1_["id"];$vide=0;
					$user=$_REQUEST["login"];
			$datej=date("d/m/Y H:m");
			$user=$user." le ".$datej;
			$sql = "UPDATE bon_de_sortie_magasin SET ";
			$sql .= "user = '" . $user . "', ";
			$sql .= "depot_b = '" . $depot_a . "', ";
			$sql .= "depot_a = '" . $vide . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
	}
	}
	}
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
	<? 
	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM bon_de_sortie_magasin where id_registre='$id_registre' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
	$produit=$users1_["produit"]; $depot_a=$users1_["depot_a"];$condit=$users1_["condit"];$depot_b=$users1_["depot_b"];
	$depot_c=$users1_["depot_c"];$id=$users1_["id"];?>
	<tr>
	<td><?php echo $produit; ?></td>
	<td><?php echo $depot_a;?></td>
	<td><?php echo $depot_b;?></td>
	<td><?php echo $depot_a+$depot_b;?></td>
	</tr>
		<?  }?>
		
		</table>
<form id="form_user" name="form_user" method="post" action="bon_de_sortie_magasin_t.php">
		<tr><table class="table2">
		<? $action_="mps";?>
<?php $tout1="MPS VERS JAOUDA    ";$t1="mps";
			?>
<td align="center" bgcolor="#3300FF"><input type="submit" id="action_" name="action_" value="<?php echo $action_; ?>">		</td>
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="id_registre" name="id_registre" value="<?php echo $id_registre; ?>">
			
		</table></tr>
</form>

<form id="form_user" name="form_user" method="post" action="bon_de_sortie_magasin_t.php">
		<tr><table class="table2">
		<? $action_="jaouda";?>
<?php $tout1="JAOUDA VERS MPS   ";$t1="jaouda";
			 ?>
<td align="center" bgcolor="#FF0000"><input type="submit" id="action_" name="action_" value="<?php echo $action_; ?>">	</td>	
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="id_registre" name="id_registre" value="<?php echo $id_registre; ?>">
			
		</table></tr>
</form>
	</body>

</html>
	 
