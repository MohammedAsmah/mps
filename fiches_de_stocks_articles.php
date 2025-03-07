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
			$tige2=$_REQUEST["tige2"];$qte_tige2=$_REQUEST["qte_tige2"];
			$tige3=$_REQUEST["tige3"];$qte_tige3=$_REQUEST["qte_tige3"];
			$tige4=$_REQUEST["tige4"];$qte_tige4=$_REQUEST["qte_tige4"];
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
			
		
				$sql  = "INSERT INTO produits ( produit, condit, prix,dispo, tige,qte_tige,tige2,qte_tige2,tige3,qte_tige3,tige4,qte_tige4,matiere,qte_matiere,emballage,qte_emballage,emballage2,qte_emballage2,emballage3,qte_emballage3,emballage4,qte_emballage4,
				etiquette,qte_etiquette,favoris,non_favoris,accessoire_1,accessoire_2,accessoire_3,qte_ac_1,qte_ac_2,qte_ac_3,type,famille,non_disponible,stock_controle,poids_evaluation,poids ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $condit . "', ";
				$sql .= "'" . $prix . "', ";
				$sql .= "'" . $dispo . "', ";
				$sql .= "'" . $_REQUEST["tige"] . "', ";
				$sql .= "'" . $_REQUEST["qte_tige"] . "', ";
				$sql .= "'" . $_REQUEST["tige2"] . "', ";
				$sql .= "'" . $_REQUEST["qte_tige2"] . "', ";
				$sql .= "'" . $_REQUEST["tige3"] . "', ";
				$sql .= "'" . $_REQUEST["qte_tige3"] . "', ";
				$sql .= "'" . $_REQUEST["tige4"] . "', ";
				$sql .= "'" . $_REQUEST["qte_tige4"] . "', ";
				$sql .= "'" . $_REQUEST["matiere"] . "', ";
				$sql .= "'" . $_REQUEST["qte_matiere"] . "', ";
				$sql .= "'" . $_REQUEST["emballage"] . "', ";
				$sql .= "'" . $_REQUEST["qte_emballage"] . "', ";
				$sql .= "'" . $_REQUEST["emballage2"] . "', ";
				$sql .= "'" . $_REQUEST["qte_emballage2"] . "', ";
				$sql .= "'" . $_REQUEST["emballage3"] . "', ";
				$sql .= "'" . $_REQUEST["qte_emballage3"] . "', ";
				$sql .= "'" . $_REQUEST["emballage4"] . "', ";
				$sql .= "'" . $_REQUEST["qte_emballage4"] . "', ";
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
			$sql .= "tige2 = '" . $_REQUEST["tige2"] . "', ";
			$sql .= "qte_tige2 = '" . $_REQUEST["qte_tige2"] . "', ";
			$sql .= "tige3 = '" . $_REQUEST["tige3"] . "', ";
			$sql .= "qte_tige3 = '" . $_REQUEST["qte_tige3"] . "', ";
			$sql .= "tige4 = '" . $_REQUEST["tige4"] . "', ";
			$sql .= "qte_tige4 = '" . $_REQUEST["qte_tige4"] . "', ";
			
			$sql .= "matiere = '" . $_REQUEST["matiere"] . "', ";
			$sql .= "qte_matiere = '" . $_REQUEST["qte_matiere"] . "', ";
			$sql .= "emballage = '" . $_REQUEST["emballage"] . "', ";
			$sql .= "qte_emballage = '" . $_REQUEST["qte_emballage"] . "', ";
			$sql .= "emballage2 = '" . $_REQUEST["emballage2"] . "', ";
			$sql .= "qte_emballage2 = '" . $_REQUEST["qte_emballage2"] . "', ";
			$sql .= "emballage3 = '" . $_REQUEST["emballage3"] . "', ";
			$sql .= "qte_emballage3 = '" . $_REQUEST["qte_emballage3"] . "', ";
			$sql .= "emballage4 = '" . $_REQUEST["emballage4"] . "', ";
			$sql .= "qte_emballage4 = '" . $_REQUEST["qte_emballage4"] . "', ";
			$sql .= "sachet_paquet = '" . $_REQUEST["sachet_paquet"] . "', ";
			$sql .= "sachet_piece = '" . $_REQUEST["sachet_piece"] . "', ";
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
	$sql .= "FROM produits where famille <> '$acc'  ORDER BY produit;";
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

<span style="font-size:24px"><?php echo "FICHES DE STOCK DU 01/01/2017 AU 31/12/2017 "; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Code";?></th>
	<th><?php echo "Code";?></th>
	<th><?php echo "Designation";?></th>
	<th><?php echo "Condit.";?></th>
	<th><?php echo "Qte Stock Ini.";?></th>
	<th><?php echo "Qte Facturée";?></th>
	<th><?php echo "Qte Production";?></th>
	<th><?php echo "Qte Stock Final";?></th>
	<th span col="4"><?php echo "Matiere et Emballages";?></th>
	
	<th><?php echo "Poids";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?>


			<? 
			
			$produit=$users_["produit"];$d1="2017-01-01";$d2="2017-12-31";$qte=0;$stock_final_a_reporter=$users_["stock_final_a_reporter"];$condit=$users_["condit"];
			$id=$users_["id"];$stock_ini_exe=$users_["stock_ini_exe"];
			
			$emballage2=$users_["emballage2"];$qte_emballage2=$users_["qte_emballage2"];$poids=$users_["poids"];
		$emballage3=$users_["emballage3"];$qte_emballage3=$users_["qte_emballage3"];		
		$tige=$users_["tige"];$qte_tige=$users_["qte_tige"];$emballage=$users_["emballage"];$qte_emballage=$users_["qte_emballage"];
		$qte_emballage4=$users_["qte_emballage4"];$emballage4=$users_["emballage4"];
			
			
			//report a nouveau stock
			/*$sql = "UPDATE produits SET ";
			$sql .= "stock_ini_exe = '" . $stock_final_a_reporter . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
			*/
			
			
			
		/*	$sql1  = "SELECT * ";
			$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$d1' and '$d2' ) ORDER BY produit;";
		$users11 = db_query($database_name, $sql1);
		while($users11_ = fetch_array($users11)) { 
			$qte=$qte+($users11_["quantite"]*$users11_["condit"]);
									
		}
		
		$poids_total=$poids_total+($qte*$users_["poids"]);$fa=$qte;
		
		$sql1  = "SELECT * ";$du="2016-01-01";$au=dateFrToUs("31/12/2016");$production=0;
			$sql1 .= "FROM entrees_stock_f where produit='$produit' and (date between '$du' and '$au' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);
			while($users11_ = fetch_array($users11)) { 
			
			$production=$production+($users11_["depot_a"]*$condit);

			}
			$pr=$production;
			*/
			$fa=0;$pr=0;
		?>






<? //if ($qte>0 or $stock_ini_exe>0 or $pr>0){?><tr>

<td bgcolor="#66CCCC"><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["id"];?></A></td>
<td bgcolor="#66CCCC"><a href="JavaScript:EditUser1(<?php echo $users_["id"]; ?>)"><?php echo $users_["id"];?></A></td>
<td style="text-align:left" bgcolor="#66CCCC"><?php echo $users_["produit"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC"><?php $px = number_format($users_["prix_revient"],2,',',' ');echo $px; ?></td>
<td bgcolor="#66CCCC"><?php echo $users_["condit"]; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $stock_ini_exe; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $fa; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $pr; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $stock_ini_exe+$pr-$fa; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $users_["sachet_paquet"]; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $users_["sachet_piece"]; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $users_["qte_emballage3"]; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $users_["matiere"]; ?></td>



<? //} ?>
<? } ?>
<tr><td></td><td></td><td></td>

<td></td><td></td>
</table>

<p style="text-align:center">

	
	<? ?>

</body>

</html>