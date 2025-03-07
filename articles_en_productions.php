<?php
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];
	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"])) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$produit = $_REQUEST["produit"];$condit = $_REQUEST["condit"];$prix = $_REQUEST["prix"];
			$type = $_REQUEST["type"];$famille = $_REQUEST["famille"];$equipes = $_REQUEST["equipes"];
			$seuil_critique = $_REQUEST["seuil_critique"];$stock_comptable = $_REQUEST["stock_comptable"];
			if(isset($_REQUEST["dispo"])) { $dispo = 1; } else { $dispo = 0; }
		}
		
		if ($login=="admin" or $login=="rakia"){
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO produits ( produit, condit, prix,seuil_critique,type,famille,equipes, dispo ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $condit . "', ";
				$sql .= "'" . $prix . "', ";$sql .= "'" . $seuil_critique . "', ";
				$sql .= "'" . $type . "', ";$sql .= "'" . $famille . "', ";$sql .= "'" . $equipes . "', ";
				$sql .= $dispo . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE produits SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "', ";
			if ($login=="admin"){
			$sql .= "stock_ini_exe = '" . $_REQUEST["stock_ini_exe"] . "', ";}
			$sql .= "condit = '" . $condit . "', ";$sql .= "seuil_critique = '" . $seuil_critique . "', ";
			$sql .= "dispo = '" . $dispo . "', ";
			$sql .= "prix = '" . $prix . "', ";
			$sql .= "famille = '" . $famille . "', ";$sql .= "equipes = '" . $equipes . "', ";
			$sql .= "type = '" . $type . "', ";$sql .= "stock_comptable = '" . $stock_comptable . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM produits WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	}
	} //if
	
	
	// recherche ville
	?>
	
	<?
	$sql  = "SELECT * ";
	$sql .= "FROM produits ORDER BY produit;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Produits"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "produit.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php $jour=date("d/m/Y");echo "Historique Production du 05/09/2011 au $jour "; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "Article";?></th>
	<th><?php echo "Total Production";?></th>
	<th><?php echo "Historique";?></th>
	<th><?php echo "Poids";?></th>
</tr>

<?php 

	$sql  = "SELECT machine,produit,date,sum(prod_6_14) as t_prod_6_14,sum(prod_14_22) as t_prod_14_22,sum(prod_22_6) as t_prod_22_6,
	sum(temps_arret_h_1) as t_temps_arret_h1,sum(temps_arret_m_1) as t_temps_arret_m1,
	sum(temps_arret_h_2) as t_temps_arret_h2,sum(temps_arret_m_2) as t_temps_arret_m2,
	sum(temps_arret_h_3) as t_temps_arret_h3,sum(temps_arret_m_3) as t_temps_arret_m3,
	sum(rebut_1) as t_rebut1,sum(rebut_2) as t_rebut2,sum(rebut_3) as t_rebut3,sum(poids_1) as t_poids,
	sum(tc1) as t_tc1,sum(tc2) as t_tc2,sum(tc3) as t_tc3,sum(jour) as t_jour ";$today=date("y-m-d");$laveuse='LAVEUSE';$extrudeuse='EXTRUDEUSE';
	$sql .= "FROM details_productions where produit<>'$vide' and machine<>'$laveuse' and machine<>'$extrudeuse' group by produit ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	
	$ht=0;while($users_1 = fetch_array($users1)) { 
	
	$total= $users_1["t_prod_22_6"]+$users_1["t_prod_6_14"]+$users_1["t_prod_14_22"];
	
	if($total>0){
	
	?><tr>


	<td style="text-align:left" ><?php $produit=$users_1["produit"];echo $users_1["produit"]; ?></td>
	<? echo "<td><a href=\"productions_details_articles.php?produit=$produit\">Afficher</a></td>";?>
	<? echo "<td><a href=\"productions_details_articles_poids.php?produit=$produit\">Poids</a></td>";?>
	
	<?
	}
	}
	
	


 ?>

</table>
	
</body>

</html>