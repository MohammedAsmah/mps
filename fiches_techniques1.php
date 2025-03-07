<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	$id_produit = $_GET["id_produit"];$produit = $_GET["produit"];$prix = number_format($_GET["prix"],2,',',' ');$categorie = $_GET["categorie"];
	$sql  = "SELECT * ";
	$sql .= "FROM produits  where produit='$produit' ORDER BY produit ASC;";
	$users = db_query($database_name, $sql);$user_p = fetch_array($users);
	$condit = $user_p["condit"];$poids_p = number_format($user_p["poids_evaluation"],0,',',' ');$prix_p = number_format($user_p["prix"],2,',',' ');
	
	
	$condit = $_GET["condit"];$poidst = number_format($_GET["poids"],0,',',' ');
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action"]) && $profile_id == 1) { 

		if($_REQUEST["action"] != "delete_user") {
			// prepares data to simplify database insert or update
			$concurent = $_REQUEST["concurent"];$prix_vente = $_REQUEST["prix_vente"];$matiere = $_REQUEST["matiere"];$id_produit = $_REQUEST["id_produit"];$produit = $_REQUEST["produit"];
			$remise1 = $_REQUEST["remise1"];$remise2 = $_REQUEST["remise2"];$remise3 = $_REQUEST["remise3"];$marche = $_REQUEST["marche"];$obs = $_REQUEST["obs"];$date_maj = dateFrToUs($_REQUEST["date_maj"]);
			$poids = $_REQUEST["poids"];$remise4 = $_REQUEST["remise4"];
			//if(isset($_REQUEST["emb_separe"])) { $emb_separe = 1; } else { $emb_separe = 0; }
		}
		
		switch($_REQUEST["action"]) {

			case "insert_new_user":
			
				$sql  = "INSERT INTO fiches_techniques1 ( concurent,id_produit,matiere,prix_vente,remise1,remise2,remise3,remise4,poids,marche,date_maj,obs ) VALUES ( ";
				$sql .= "'".$concurent . "',";
				$sql .= "'".$id_produit . "',";
				$sql .= "'".$matiere . "',";
				$sql .= "'".$prix_vente . "',";
				$sql .= "'".$remise1 . "',";
				$sql .= "'".$remise2 . "',";$sql .= "'".$remise3 . "',";$sql .= "'".$remise4 . "',";
				$sql .= "'".$poids . "',";$sql .= "'".$marche . "',";$sql .= "'".$date_maj . "',";
				$sql .= "'".$obs . "');";
				db_query($database_name, $sql);

			break;

			case "update_user":

			$sql = "UPDATE fiches_techniques1 SET ";
			$sql .= "concurent = '" . $concurent . "', ";
			$sql .= "prix_vente = '" . $prix_vente . "', ";
			$sql .= "matiere = '" . $matiere . "', ";
			$sql .= "remise1 = '" . $remise1 . "', ";
			$sql .= "remise2 = '" . $remise2 . "', ";
			$sql .= "remise3 = '" . $remise3 . "', ";
			$sql .= "remise4 = '" . $remise4 . "', ";
			$sql .= "marche = '" . $marche . "', ";
			$sql .= "poids = '" . $poids . "', ";
			$sql .= "date_maj = '" . $date_maj . "', ";
			$sql .= "obs = '" . $obs . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM fiches_techniques1 WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
		
	$sql  = "SELECT * ";
	$sql .= "FROM fiches_techniques1 where id_produit='$id_produit' ORDER BY id;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "fiche_technique1.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><table class="table2">
<?php 

echo "<tr><td>Article : ".$produit."</td></tr><tr><td>Conditionnement : ".$condit."</td></tr><tr><td>Tarif de Vente : ".$prix_p."</td></tr><tr><td>Poids Article : ".$poids_p."gr</td></tr></table>"; ?></span>

<p style="text-align:center">


<table class="table2">

<tr><th><?php echo "Id";?></th>
	<th><?php echo "Concurent";?></th>
	<th><?php echo "Poids Article";?></th>
	<th><?php echo "Prix Vente";?></th>
	<th><?php echo "Remise 1";?></th>
	<th><?php echo "Remise 2";?></th>
	<th><?php echo "Remise 3";?></th>
	<th><?php echo "Remise 4";?></th>
	<th><?php echo "Date";?></th>
	
		
</tr>

<?php $poids=0;while($users_ = fetch_array($users)) { ?><tr>
	
	<? $user_id=$users_["id"];
	echo "<td><a href=\"fiche_technique1.php?user_id=$user_id&id_produit=$id_produit&produit=$produit\">$user_id </a>";?>
	<td><?php $concurent=$users_["concurent"];echo "$concurent "; ?></td>
	<td style="text-align:center"><?php echo $users_["poids"]; ?></td>
	<td><?php echo number_format($users_["prix_vente"],2,',',' '); ?></td>
	<td><?php echo number_format($users_["remise1"],2,',',' ')."%"; ?></td>
	<td><?php echo number_format($users_["remise2"],2,',',' ')."%"; ?></td>
	<td><?php echo number_format($users_["remise3"],2,',',' ')."%"; ?></td>
	<td><?php echo number_format($users_["remise4"],2,',',' ')."%"; ?></td>
	<td style="text-align:center"><?php echo dateUsToFr($users_["date_maj"]); ?></td>
		
	
<?php } ?>

</table>

<p style="text-align:center">
<table class="table2">
<? echo "<td><a href=\"fiche_technique1.php?user_id=0&id_produit=$id_produit&produit=$produit&categorie=$categorie\">Ajout Article </a>";?>
	
</table>
</body>

</html>