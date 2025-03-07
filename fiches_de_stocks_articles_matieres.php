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
			$stock_initial = $_REQUEST["stock_initial"];
			$stock_final = $_REQUEST["stock_initial"]+$_REQUEST["production"]-$_REQUEST["qte_vendu"];
			$encours = $_REQUEST["encours"];
			
			$type = $_REQUEST["type"];$famille = $_REQUEST["famille"];
			$accessoire_1 = $_REQUEST["accessoire_1"];$accessoire_2 = $_REQUEST["accessoire_2"];$accessoire_3 = $_REQUEST["accessoire_3"];
			$qte_ac_1 = $_REQUEST["qte_ac_1"];$qte_ac_2 = $_REQUEST["qte_ac_2"];$qte_ac_3 = $_REQUEST["qte_ac_3"];
			if(isset($_REQUEST["non_disponible"])) { $non_disponible = 1; } else { $non_disponible = 0; }
			
			$production = $_REQUEST["production"];$poids_evaluation = $_REQUEST["poids_evaluation"];
			$prix_revient = $_REQUEST["prix_revient"];$prix_revient_final = $_REQUEST["prix_revient_final"];
			$stock_ini_exe = $_REQUEST["stock_ini_exe"];
			if(isset($_REQUEST["liquider"])) { $liquider = 1; } else { $liquider = 0; }
			if(isset($_REQUEST["favoris"])) { $favoris = 1; } else { $favoris = 0; }
			if(isset($_REQUEST["non_favoris"])) { $non_favoris = 1; } else { $non_favoris = 0; }
			if(isset($_REQUEST["dispo"])) { $dispo = 1; } else { $dispo = 0; }
			if(isset($_REQUEST["stock_controle"])) { $stock_controle = 1; } else { $stock_controle = 0; }
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO produits ( produit, condit, prix,dispo, tige,qte_tige,matiere,qte_matiere,emballage,qte_emballage,emballage2,qte_emballage2,emballage3,qte_emballage3,
				etiquette,qte_etiquette,favoris,non_favoris,accessoire_1,accessoire_2,accessoire_3,qte_ac_1,qte_ac_2,qte_ac_3,type,famille,non_disponible,stock_controle,poids_evaluation,poids ) VALUES ( ";
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
				$sql .= "'" . $_REQUEST["emballage2"] . "', ";
				$sql .= "'" . $_REQUEST["qte_emballage2"] . "', ";
				$sql .= "'" . $_REQUEST["emballage3"] . "', ";
				$sql .= "'" . $_REQUEST["qte_emballage3"] . "', ";
				
				$sql .= "'" . $_REQUEST["etiquette"] . "', ";
				$sql .= "'" . $_REQUEST["qte_etiquette"] . "', ";
				$sql .= "'" . $favoris . "', ";
				$sql .= "'" . $non_favoris . "', ";
				$sql .= "'" . $accessoire_1 . "', ";
				$sql .= "'" . $accessoire_2 . "', ";
				$sql .= "'" . $accessoire_3 . "', ";
				$sql .= "'" . $qte_ac_1 . "', ";
				$sql .= "'" . $qte_ac_2 . "', ";
				$sql .= "'" . $qte_ac_3 . "', ";
				$sql .= "'" . $type . "', ";$sql .= "'" . $famille . "', ";
				$sql .= "'" . $non_disponible . "', ";
				$sql .= "'" . $stock_controle . "', ";
				$sql .= "'" . $poids_evaluation . "', ";
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
			$sql .= "encours = '" . $encours . "', ";
			$sql .= "stock_ini_exe = '" . $stock_ini_exe . "', ";
			$sql .= "prix_revient = '" . $prix_revient . "', ";
			$sql .= "prix_revient_final = '" . $prix_revient_final . "', ";
			$sql .= "prix = '" . $prix . "', ";
			$sql .= "poids_evaluation = '" . $poids_evaluation . "', ";
			$sql .= "accessoire_1 = '" . $accessoire_1 . "', ";
			$sql .= "accessoire_2 = '" . $accessoire_2 . "', ";
			$sql .= "accessoire_3 = '" . $accessoire_3 . "', ";
			$sql .= "qte_ac_1 = '" . $qte_ac_1 . "', ";
			$sql .= "qte_ac_2 = '" . $qte_ac_2 . "', ";
			$sql .= "qte_ac_3 = '" . $qte_ac_3 . "', ";
			$sql .= "type = '" . $type . "', ";
			$sql .= "non_disponible = '" . $non_disponible . "', ";
			$sql .= "stock_controle = '" . $stock_controle . "', ";
			$sql .= "tige = '" . $_REQUEST["tige"] . "', ";
			$sql .= "qte_tige = '" . $_REQUEST["qte_tige"] . "', ";
			$sql .= "matiere = '" . $_REQUEST["matiere"] . "', ";
			$sql .= "qte_matiere = '" . $_REQUEST["qte_matiere"] . "', ";
			$sql .= "emballage = '" . $_REQUEST["emballage"] . "', ";
			$sql .= "qte_emballage = '" . $_REQUEST["qte_emballage"] . "', ";
			$sql .= "emballage2 = '" . $_REQUEST["emballage2"] . "', ";
			$sql .= "qte_emballage2 = '" . $_REQUEST["qte_emballage2"] . "', ";
			$sql .= "emballage3 = '" . $_REQUEST["emballage3"] . "', ";
			$sql .= "qte_emballage3 = '" . $_REQUEST["qte_emballage3"] . "', ";
			$sql .= "famille = '" . $famille . "', ";
			$sql .= "etiquette = '" . $_REQUEST["etiquette"] . "', ";
			$sql .= "qte_etiquette = '" . $_REQUEST["qte_etiquette"] . "', ";
			$sql .= "liquider = '" . $liquider . "', ";
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
	$sql  = "SELECT * ";$vide="";$acc="Accessoire";$poids_total=0;
	$sql .= "FROM produits where dispo=1 and famille <> '$acc' ORDER BY produit;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Produits"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "fiche_de_stock_article_pdf.php?user_id=" + user_id; }
	function EditUser1(user_id) { document.location = "fiche_de_stock_article.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "FICHES DE STOCK DU 01/01/2014 AU 31/12/2014 "; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Designation";?></th>
	<th><?php echo "poids";?></th>
	<th><?php echo "matiere.";?></th>
	<th><?php echo "tige et insert";?></th>
	<th><?php echo "Carton";?></th>
	<th><?php echo "sachets";?></th>
	<th><?php echo "poids sachets";?></th>
	<th><?php echo "etiquette";?></th>
	
</tr>

<?php while($users_ = fetch_array($users)) { ?>


<tr>

<td style="text-align:left" bgcolor="#66CCCC"><?php echo $users_["produit"]." : ".$users_["condit"]; ?></td>
<td bgcolor="#66CCCC"><?php echo $users_["poids"]; ?></td>
<td bgcolor="#66CCCC"><?php echo $users_["matiere"]; ?></td>
<td bgcolor="#66CCCC"><?php echo $users_["tige"]; ?></td>
<td bgcolor="#66CCCC"><?php echo $users_["emballage"]." / ".$users_["emballage2"]; ?></td>
<td bgcolor="#66CCCC"><?php echo $users_["emballage3"]; ?></td>
<td bgcolor="#66CCCC"><?php if ($users_["qte_emballage3"]<>0){echo $users_["qte_emballage3"];} ?></td>
<td bgcolor="#66CCCC"><?php echo $users_["etiquette"]; ?></td>

<? } ?>



</table>

<p style="text-align:center">

	
	<? ?>

</body>

</html>