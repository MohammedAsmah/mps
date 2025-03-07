<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$produit = $_REQUEST["produit"];$condit = $_REQUEST["condit"];$prix = $_REQUEST["prix"];$poids = $_REQUEST["poids"];
			$tige=$_REQUEST["tige"];$qte_tige=$_REQUEST["qte_tige"];
			$stock_initial = $_REQUEST["stock_initial"];$stock_final = $_REQUEST["stock_final"];$encours = $_REQUEST["encours"];
			$prix_revient = $_REQUEST["prix_revient"];$prix_revient_final = $_REQUEST["prix_revient_final"];$en_cours_final = $_REQUEST["en_cours_final"];
			
			if(isset($_REQUEST["favoris"])) { $favoris = 1; } else { $favoris = 0; }
			if(isset($_REQUEST["non_favoris"])) { $non_favoris = 1; } else { $non_favoris = 0; }
			if(isset($_REQUEST["dispo"])) { $dispo = 1; } else { $dispo = 0; }
		
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO produits ( produit, condit, prix,dispo, tige,qte_tige,matiere,qte_matiere,emballage,qte_emballage,
				etiquette,qte_etiquette,favoris,non_favoris,poids ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $condit . "', ";
				$sql .= "'" . $prix . "', ";
				$sql .= "'" . $dispo . "', ";
				$sql .= "'" . $_REQUEST["tige"] . "', ";
				$sql .= "'" . $_REQUEST["qte_tige"] . "', ";
				$sql .= "'" . $_REQUEST["matiere"] . "', ";
				$sql .= "'" . $_REQUEST["qte_matiere"] . "', ";
				$sql .= "'" . $_REQUEST["emballage"] . "', ";
				$sql .= "'" . $_REQUEST["qte_emballage"] . "', ";
				$sql .= "'" . $_REQUEST["etiquette"] . "', ";
				$sql .= "'" . $_REQUEST["qte_etiquette"] . "', ";
				$sql .= "'" . $favoris . "', ";
				$sql .= "'" . $non_favoris . "', ";
				$sql .= $poids . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE produits SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "', ";
			$sql .= "favoris = '" . $favoris . "', ";
			$sql .= "non_favoris = '" . $non_favoris . "', ";
			$sql .= "condit = '" . $condit . "', ";
			$sql .= "dispo = '" . $dispo . "', ";
			$sql .= "stock_initial = '" . $stock_initial . "', ";
			$sql .= "stock_final = '" . $stock_final . "', ";
			$sql .= "encours = '" . $encours . "', ";
			$sql .= "en_cours_final = '" . $en_cours_final . "', ";
			$sql .= "prix_revient = '" . $prix_revient . "', ";
			$sql .= "prix_revient_final = '" . $prix_revient_final . "', ";
			$sql .= "prix = '" . $prix . "', ";
			$sql .= "tige = '" . $_REQUEST["tige"] . "', ";
			$sql .= "qte_tige = '" . $_REQUEST["qte_tige"] . "', ";
			$sql .= "matiere = '" . $_REQUEST["matiere"] . "', ";
			$sql .= "qte_matiere = '" . $_REQUEST["qte_matiere"] . "', ";
			$sql .= "emballage = '" . $_REQUEST["emballage"] . "', ";
			$sql .= "qte_emballage = '" . $_REQUEST["qte_emballage"] . "', ";
			$sql .= "etiquette = '" . $_REQUEST["etiquette"] . "', ";
			$sql .= "qte_etiquette = '" . $_REQUEST["qte_etiquette"] . "', ";
			$sql .= "poids = '" . $poids . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM produits WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	
	// recherche ville
	?>
	
	<?
	$sql  = "SELECT * ";
	$sql .= "FROM produits where encours<>0 ORDER BY produit;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Produits"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "produit_encours.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Produits"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Code";?></th>
	<th><?php echo "Nom";?></th>
	<th><?php echo "Conditionnement";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Poids";?></th>
	<th><?php echo "Dispo";?></th>
	<th><?php echo "S.Final";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>

<? 			/*$produit=$users_["produit"];$id=$users_["id"];$stock_initial=$users_["stock_initial"];$encours=$users_["encours"];
			$sql1  = "SELECT * ";$qte_vendu=0;$du="2008-01-01";$au="2008-12-31";
			$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$du' and '$au' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);
			while($users11_ = fetch_array($users11)) { 
			$qte_vendu=$qte_vendu+($users11_["quantite"]*$users11_["condit"]);
	
			}
			$stock_final=$stock_initial+$encours-$qte_vendu;
			$sql = "UPDATE produits SET ";
			$sql .= "stock_final = '" . $stock_final . "'  ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);*/


/*$p=$users_["produit"];$c=$users_["condit"];
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_factures where produit='$p' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
			$id=$users1_["id"];
			$sql = "UPDATE detail_factures SET ";
			$sql .= "condit = '" . $c . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
	}*/
	
	
	
	?>









<? if ($users_["favoris"]){?>
<td bgcolor="#66CCCC"><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["id"];?></A></td>
<td style="text-align:left" bgcolor="#66CCCC"><?php echo $users_["produit"]; ?></td>
<td bgcolor="#66CCCC"><?php echo $users_["condit"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC"><?php echo $users_["prix"]; ?></td>
<td bgcolor="#66CCCC"><?php echo $users_["poids"]; ?></td>
<?php if ($users_["dispo"]==0){?><td bgcolor="#FF3333"><? echo "non";}else{?><td bgcolor="#0066FF"><? echo "oui";}; ?></td>
<td bgcolor="#66CCCC"><?php echo $users_["stock_final"]; ?></td>

<? } else {?>
<? if ($users_["non_favoris"]){?>
<td bgcolor="#FFFF00"><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["id"];?></A></td>
<td style="text-align:left"  bgcolor="#FFFF00"><?php echo $users_["produit"]; ?></td>
<td  bgcolor="#FFFF00"><?php echo $users_["condit"]; ?></td>
<td style="text-align:left"  bgcolor="#FFFF00"><?php echo $users_["prix"]; ?></td>
<td  bgcolor="#FFFF00"><?php echo $users_["poids"]; ?></td>
<?php if ($users_["dispo"]==0){?><td bgcolor="#FF3333"><? echo "non";}else{?><td bgcolor="#0066FF"><? echo "oui";}; ?></td>
<td bgcolor="#FFFF00"><?php echo $users_["stock_final"]; ?></td>

<? } else {?>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["id"];?></A></td>
<td style="text-align:left"><?php echo $users_["produit"]; ?></td>
<td><?php echo $users_["condit"]; ?></td>
<td style="text-align:left"><?php echo $users_["prix"]; ?></td>
<td><?php echo $users_["poids"]; ?></td>
<?php if ($users_["dispo"]==0){?><td bgcolor="#FF3333"><? echo "non";}else{?><td bgcolor="#0066FF"><? echo "oui";}; ?></td>
<td><?php echo $users_["stock_final"]; ?></td>
<? }?>
<? }?>
<?php } ?>

</table>

<p style="text-align:center">


</body>

</html>