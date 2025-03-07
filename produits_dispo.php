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
			$produit = $_REQUEST["produit"];$condit = $_REQUEST["condit"];$prix = $_REQUEST["prix"];$prix_rechange = $_REQUEST["prix_rechange"];$prix2 = $_REQUEST["prix2"];$palette = $_REQUEST["palette"];
			$type = $_REQUEST["type"];$famille = $_REQUEST["famille"];$equipes = $_REQUEST["equipes"];$tarif_base = $_REQUEST["tarif_base"];$categorie = $_REQUEST["categorie"];$asswak = $_REQUEST["asswak"];
			$seuil_critique = $_REQUEST["seuil_critique"];$stock_comptable = $_REQUEST["stock_comptable"];$stock_ini_exe = $_REQUEST["stock_ini_exe"];$barecode = $_REQUEST["barecode"];$designation = $_REQUEST["designation"];
			if(isset($_REQUEST["dispo"])) { $dispo = 1; } else { $dispo = 0; }
			if(isset($_REQUEST["stockable"])) { $stockable = 1; } else { $stockable = 0; }
			if(isset($_REQUEST["fictif"])) { $fictif = 1; } else { $fictif = 0; }
			if(isset($_REQUEST["palmares1"])) { $palmares1 = 1; } else { $palmares1 = 0; }
			$date_dispo = dateFrtoUs($_REQUEST["date_dispo"]);$date_dispo_f = dateFrtoUs($_REQUEST["date_dispo_f"]);
			if(isset($_REQUEST["dispo_f"])) { $dispo_f = 1; } else { $dispo_f = 0; }
			if(isset($_REQUEST["dispo_stock"])) { $dispo_stock = 1; } else { $dispo_stock = 0; }
			if(isset($_REQUEST["dispo_g"])) { $dispo_g = 1; } else { $dispo_g = 0; }
			if(isset($_REQUEST["couleurs"])) { $couleurs = 1; } else { $couleurs = 0; }
			if(isset($_REQUEST["couvercle"])) { $couvercle = 1; } else { $couvercle = 0; }
			if(isset($_REQUEST["enproduction"])) { $enproduction = 1; } else { $enproduction = 0; }
			
			$p_marron = $_REQUEST["marron"];
			$p_beige = $_REQUEST["beige"];
			$p_gris = $_REQUEST["gris"];
			$designation_client = $_REQUEST["designation_client"];
			$barecode_piece = $_REQUEST["barecode_piece"];
						
			
			$r1 = $_REQUEST["r1"];$r2 = $_REQUEST["r2"];$r3 = $_REQUEST["r3"];
			
			
		}
		
		if ($login=="admin" or $login=="rakia" or $login=="najat" or $login=="driss"){
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO produits ( produit, dispo_stock,designation,barecode,condit,palette,designation_client,barecode_piece, ";
				$sql .= "prix,asswak,prix2,prix_rechange,r1,r2,r3,seuil_critique,famille,equipes, dispo,stockable,enproduction,date_dispo,couleurs,categorie,p_marron,p_beige,p_gris,tarif_base,dispo_f ) VALUES ( ";
				$sql .= "'" . $produit . "', ";$sql .= "'" . $dispo_stock . "', ";$sql .= "'" . $designation . "', ";$sql .= "'" . $barecode . "', ";
				$sql .= "'" . $condit . "', ";$sql .= "'" . $palette . "', ";$sql .= "'" . $designation_client . "', ";$sql .= "'" . $barecode_piece . "', ";
				$sql .= "'" . $prix . "', ";$sql .= "'" . $asswak . "', ";$sql .= "'" . $prix2 . "', ";$sql .= "'" . $prix_rechange . "', ";
				$sql .= "'" . $r1 . "', ";$sql .= "'" . $r2 . "', ";$sql .= "'" . $r3 . "', ";
				$sql .= "'" . $seuil_critique . "', ";
				$sql .= "'" . $famille . "', ";$sql .= "'" . $equipes . "', ";$sql .= "'" . $dispo . "', ";$sql .= "'" . $stockable . "', ";$sql .= "'" . $enproduction . "', ";
				$sql .= "'" . $date_dispo . "', ";
				$sql .= "'" . $couleurs . "', ";$sql .= "'" . $categorie . "', ";$sql .= "'" . $p_marron . "', ";$sql .= "'" . $p_beige . "', ";$sql .= "'" . $p_gris . "', ";$sql .= "'" . $tarif_base . "', ";
				$sql .= $dispo_f . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			
			
			$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$ancien_produit=$user_["produit"];
			echo $ancien_produit." --> ".$_REQUEST["produit"];
			

			
			if ($login=="admin" or $login=="rakia" or $login=="najat"){
			$sql = "UPDATE produits SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "', ";$sql .= "designation = '" . $_REQUEST["designation"] . "', ";$sql .= "palette = '" . $_REQUEST["palette"] . "', ";
			if ($login=="admin"){
			$sql .= "stock_ini_exe = '" . $_REQUEST["stock_ini_exe"] . "', ";$sql .= "stock_initial_jp = '" . $_REQUEST["stock_ini_exe_jp"] . "', ";$sql .= "barecode = '" . $_REQUEST["barecode"] . "', ";
			$sql .= "date_dispo = '" . $date_dispo . "', ";$sql .= "palmares1 = '" . $palmares1 . "', ";$sql .= "stockable = '" . $stockable . "', ";$sql .= "barecode_piece = '" . $barecode_piece . "', ";
			$sql .= "dispo_g = '" . $dispo_g . "', ";$sql .= "dispo_f = '" . $dispo_f . "', ";$sql .= "date_dispo_f = '" . $date_dispo_f . "', ";$sql .= "designation_client = '" . $designation_client . "', ";
			$sql .= "tarif_base = '" . $tarif_base . "', ";$sql .= "couvercle = '" . $couvercle . "', ";$sql .= "enproduction = '" . $enproduction . "', ";$sql .= "asswak = '" . $asswak . "', ";
			$sql .= "dispo_stock = '" . $dispo_stock . "', ";
			}
			$sql .= "condit = '" . $condit . "', ";$sql .= "seuil_critique = '" . $seuil_critique . "', ";$sql .= "prix2 = '" . $prix2 . "', ";$sql .= "categorie = '" . $categorie . "', ";
			$sql .= "dispo = '" . $dispo . "', ";$sql .= "prix_rechange = '" . $prix_rechange . "', ";$sql .= "dispo_f = '" . $dispo_f . "', ";
			$sql .= "prix = '" . $prix . "', ";$sql .= "r1 = '" . $r1 . "', ";$sql .= "r2 = '" . $r2 . "', ";$sql .= "r3 = '" . $r3 . "', ";
			$sql .= "couleurs = '" . $couleurs . "', ";$sql .= "p_marron = '" . $p_marron . "', ";$sql .= "p_beige = '" . $p_beige . "', ";$sql .= "p_gris = '" . $p_gris . "', ";
			$sql .= "famille = '" . $famille . "', ";$sql .= "equipes = '" . $equipes . "', ";$sql .= "fictif = '" . $fictif . "', ";
			$sql .= "stock_comptable = '" . $stock_comptable . "' ";
			
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			if ($ancien_produit<>$_REQUEST["produit"]){
				
				echo "yes";
			//
			$sql = "UPDATE detail_commandes SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "' ";
			$sql .= "WHERE produit = '" . $ancien_produit . "';";
			db_query($database_name, $sql);
			
			//
			//
			$sql = "UPDATE bon_de_sortie_magasin SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "' ";
			$sql .= "WHERE produit = '" . $ancien_produit . "';";
			db_query($database_name, $sql);
			
			//
			
			//
			$sql = "UPDATE details_productions SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "' ";
			$sql .= "WHERE produit = '" . $ancien_produit . "';";
			db_query($database_name, $sql);
			
			//
			
			//
			$sql = "UPDATE detail_avoirs SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "' ";
			$sql .= "WHERE produit = '" . $ancien_produit . "';";
			db_query($database_name, $sql);
			
			//
			//
			$sql = "UPDATE entrees_stock SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "' ";
			$sql .= "WHERE produit = '" . $ancien_produit . "';";
			db_query($database_name, $sql);
			
			//
			$sql = "UPDATE entrees_stock_f SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "' ";
			$sql .= "WHERE produit = '" . $ancien_produit . "';";
			db_query($database_name, $sql);
			
			//
			$sql = "UPDATE detail_factures2023 SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "' ";
			$sql .= "WHERE produit = '" . $ancien_produit . "';";
			db_query($database_name, $sql);
			
			//
			$sql = "UPDATE detail_factures2024 SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "' ";
			$sql .= "WHERE produit = '" . $ancien_produit . "';";
			db_query($database_name, $sql);
			
			//
			$sql = "UPDATE bon_de_sortie_magasin1 SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "' ";
			$sql .= "WHERE produit = '" . $ancien_produit . "';";
			db_query($database_name, $sql);
			}
			
			
			}
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
	$sql  = "SELECT * ";$art="article";
	//$sql .= "FROM produits where famille='$art' ORDER BY dispo DESC,famille DESC,produit ASC;";
	$sql .= "FROM produits where dispo=1 and facturation = 0 and famille='$art' and fictif=0 ORDER BY produit ASC;";
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

<span style="font-size:24px"><?php echo "liste Produits"; ?></span>
<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>
<table class="table2">

<tr>
	<th><?php echo "code Bare";?></th>
	<th><?php echo "Article";?></th>
	
	<th><?php echo "Conditionnement";?></th>
		<th><?php echo "Dispo";?></th>
	
	

</tr>

<?php $compteur=1;while($users_ = fetch_array($users)) { $produit=$users_["produit"];$prix1=$users_["prix"];$user_id=$users_["id"];$dispo_f=$users_["dispo_f"];$dispo=$users_["dispo"];

		/*	$sql  = "SELECT * ";
		$sql .= "FROM liste_prix_revient WHERE produit = '$produit';";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$prix_revient = $user_["prix"];
			
			
			$sql = "UPDATE produits SET dispo_stock = $dispo WHERE id = '$user_id'";
			db_query($database_name, $sql);*/





?><tr>

<? 
?>

<? //}?><td bgcolor="#66CCCC"><?php echo $users_["barecode_piece"]; ?></td>
<? $id_produit=$users_["id"];echo "<td><a href=\"fiches_techniques.php?produit=$produit&id_produit=$id_produit&produit=$produit\">$produit</a></td>";?>

<td bgcolor="#66CCCC" align="left"><?php echo $users_["condit"]; ?></td>

<td bgcolor="#66CCCC"><?php if($users_["dispo_stock"]){echo "Oui";}else{echo "Non";} ?></td>

<?php $compteur=$compteur+1;} ?>

</table>

<p style="text-align:center">
<? 
?>

<? //}?>	
	<?  ?>

</body>

</html>