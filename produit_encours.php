<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$qte_tige1=0;

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Produit";

		$produit = "";$favoris = 0;$non_favoris = 0;$colorant="";$qte_colorant=0;$dispo=0;
		$condit = "";
		$prix = "";$en_cours_final=0;$prix_revient_final=0;
		$poids = "";$stock_initial = 0;$encours = 0;$stock_final = 0;$prix_revient =0;
		$tige="";$qte_tige=1;$emballage="";$qte_emballage=1;$matiere="";$qte_matiere=1;$etiquette="";$qte_etiquette=1;
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$produit = $user_["produit"];$colorant = $user_["colorant"];$dispo = $user_["dispo"];
		$condit = $user_["condit"];$qte_colorant=$user_["qte_colorant"];$prix_revient_final = $user_["prix_revient_final"];$en_cours_final = $user_["en_cours_final"];
		$prix = $user_["prix"];$favoris = $user_["favoris"];$non_favoris = $user_["non_favoris"];$encours = $user_["encours"];
		$poids = $user_["poids"];$stock_initial = $user_["stock_initial"];$stock_final = $user_["stock_final"];$prix_revient = $user_["prix_revient"];
		$tige=$user_["tige"];$qte_tige=$user_["qte_tige"];$emballage=$user_["emballage"];$qte_emballage=$user_["qte_emballage"];
		$matiere=$user_["matiere"];$qte_matiere=$user_["qte_matiere"];$etiquette=$user_["etiquette"];$qte_etiquette=$user_["qte_etiquette"];
		
		
		
	}
				
			$sql1  = "SELECT * ";$qte_vendu=0;$du="2008-01-01";$au="2008-12-31";
			$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$du' and '$au' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);
			while($users11_ = fetch_array($users11)) { 
			$qte_vendu=$qte_vendu+($users11_["quantite"]*$users11_["condit"]);
	
			}
			$stock_final=$stock_initial+$encours-$qte_vendu;
	
	
	
	
	$profiles_list_tige = "";
	$sql1 = "SELECT * FROM types_tiges ORDER BY profile_name;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($tige == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_tige .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$profiles_list_tige .= $temp_["profile_name"];
		$profiles_list_tige .= "</OPTION>";
	}
	
	$profiles_list_etiquette = "";
	$sql2 = "SELECT * FROM types_etiquettes ORDER BY profile_name;";
	$temp = db_query($database_name, $sql2);
	while($temp_ = fetch_array($temp)) {
		if($etiquette == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_etiquette .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$profiles_list_etiquette .= $temp_["profile_name"];
		$profiles_list_etiquette .= "</OPTION>";
	}

	$profiles_list_matiere = "";
	$sql3 = "SELECT * FROM types_matieres ORDER BY profile_name;";
	$temp = db_query($database_name, $sql3);
	while($temp_ = fetch_array($temp)) {
		if($matiere == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_matiere .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$profiles_list_matiere .= $temp_["profile_name"];
		$profiles_list_matiere .= "</OPTION>";
	}

	$profiles_list_colorant = "";
	$sql3 = "SELECT * FROM types_colorants ORDER BY profile_name;";
	$temp = db_query($database_name, $sql3);
	while($temp_ = fetch_array($temp)) {
		if($colorant == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_colorant .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$profiles_list_colorant .= $temp_["profile_name"];
		$profiles_list_colorant .= "</OPTION>";
	}
	$profiles_list_emballage = "";
	$sql4 = "SELECT * FROM types_emballages ORDER BY profile_name;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($emballage == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_emballage .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$profiles_list_emballage .= $temp_["profile_name"];
		$profiles_list_emballage .= "</OPTION>";
	}

	
	// extracts profile list

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">
<link href="Templates/css.css" rel="stylesheet" type="text/css">
<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
		if(document.getElementById("produit").value == "" ) {
			alert("<?php echo "Nom Produit !"; ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression de ce produit ?"; ?>")) {
			document.location = "produits.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="produits.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table width="671" class="table3">

		<tr>
		<td><?php echo "Article"; ?></td><td><input type="text" id="produit" name="produit" style="width:160px" value="<?php echo $produit; ?>"></td>
		</tr><tr>
		<td><?php echo "Conditionnement"; ?></td><td><input type="text" id="condit" name="condit" style="width:240px" value="<?php echo $condit; ?>"></td>
		</tr><tr>
		<td><?php echo "Prix Unitaire"; ?></td><td><input type="text" id="prix" name="prix" style="width:140px" value="<?php echo $prix; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Poids"; ?></td><td><input type="text" id="poids" name="poids" style="width:140px" value="<?php echo $poids; ?>"></td>
		</tr>
		<tr><td><?php echo "Matiere : "; ?></td><td><select id="matiere" name="matiere"><?php echo $profiles_list_matiere; ?></select>
		<input type="text" id="qte_matiere" name="qte_matiere" style="width:40px" value="<?php echo $qte_matiere; ?>"></td>
		</tr>
		<tr><td><?php echo "Tige : "; ?></td><td><select id="tige" name="tige"><?php echo $profiles_list_tige; ?></select>
		<input type="text" id="qte_tige" name="qte_tige" style="width:40px" value="<?php echo $qte_tige; ?>"></td>
		</tr>
		
		
		<tr><td><?php echo "Emballage : "; ?></td><td><select id="emballage" name="emballage"><?php echo $profiles_list_emballage; ?></select>
		<input type="text" id="qte_emballage" name="qte_emballage" style="width:40px" value="<?php echo $qte_emballage; ?>"></td>
		</tr>

		<tr><td><?php echo "Etiquette : "; ?></td><td><select id="etiquette" name="etiquette"><?php echo $profiles_list_etiquette; ?></select>
		<input type="text" id="qte_etiquette" name="qte_etiquette" style="width:40px" value="<?php echo $qte_etiquette; ?>"></td>
		</tr>
		<tr><td><input type="checkbox" id="favoris" name="favoris"<?php if($favoris) { echo " checked"; } ?>></td><td>Article favoris</td>
			<tr><td><input type="checkbox" id="non_favoris" name="non_favoris"<?php if($non_favoris) { echo " checked"; } ?>></td><td>Article non favoris</td>


		<tr>
		<td bgcolor="#33CCCC"><?php echo "Stock Initial"; ?></td><td><input type="text" id="stock_initial" name="stock_initial" style="width:140px" value="<?php echo $stock_initial; ?>"></td>
		</tr>
		<tr>
		<td bgcolor="#33CCCC"><?php echo "Encours"; ?></td><td><input type="text" id="encours" name="encours" style="width:140px" value="<?php echo $encours; ?>"></td>
		</tr>
	
		<tr>
		<td bgcolor="#33CCCC"><?php echo "Vendu"; ?></td><td><?php echo $qte_vendu; ?></td>
		</tr>

		<tr>
		<td bgcolor="#33FF99"><?php echo "Stock Final"; ?></td><td><?php echo $stock_final; ?></td>
		</tr>
		<tr>
		<td bgcolor="#33FF99"><?php echo "Prix Revient"; ?></td><td><input type="text" id="prix_revient" name="prix_revient" style="width:140px" value="<?php echo $prix_revient; ?>"></td>
		</tr>
		<tr>
		<td bgcolor="#3366FF"><?php echo "Production Encours"; ?></td><td><input type="text" id="en_cours_final" name="en_cours_final" style="width:140px" value="<?php echo $en_cours_final; ?>"></td>
		</tr>
		<tr>
		<td bgcolor="#3366FF"><?php echo "Prix Revient Encours"; ?></td><td><input type="text" id="prix_revient_final" name="prix_revient_final" style="width:140px" value="<?php echo $prix_revient_final; ?>"></td>
		</tr>
		<tr><td><input type="checkbox" id="dispo" name="dispo"<?php if($dispo) { echo " checked"; } ?>></td><td>Article disponible</td>


	</table>

	</center>

</td></tr></table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="stock_final" name="stock_final" value="<?php echo $stock_final; ?>">


</center>

</form>

</body>

</html>