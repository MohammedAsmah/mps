<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$qte_tige1=0;
				$sql = "TRUNCATE TABLE `fiche_stock`  ;";
			db_query($database_name, $sql);


	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Produit";

		$produit = "";$favoris = 0;$non_favoris = 0;$colorant="";$qte_colorant=0;$dispo=0;
		$condit = "";$poids_evaluation="";
		$non_disponible="";$seuil_critique=0;$type="";$stock_controle="";
		$accessoire_1="";$qte_ac_1="";$poids_ac_1="";$mat_ac_1="";
		$accessoire_2="";$qte_ac_2="";$poids_ac_2="";$mat_ac_2="";
		$accessoire_3="";$qte_ac_3="";$poids_ac_3="";$mat_ac_3="";$famille="";

		$prix = "";$en_cours_final=0;$prix_revient_final=0;$production=0;$stock_ini_exe=0;
		$poids = "";$stock_initial = 0;$encours = 0;$stock_final = 0;$prix_revient =0;
		$tige="";$qte_tige=1;$emballage="";$qte_emballage=1;$matiere="";$qte_matiere=1;$etiquette="";$qte_etiquette=1;
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$non_disponible=$user_["non_disponible"];$seuil_critique=$user_["seuil_critique"];
		$accessoire_1=$user_["accessoire_1"];$qte_ac_1=$user_["qte_ac_1"];
		$accessoire_2=$user_["accessoire_2"];$qte_ac_2=$user_["qte_ac_2"];
		$accessoire_3=$user_["accessoire_3"];$qte_ac_3=$user_["qte_ac_3"];



		$title = "details";$poids_evaluation=$user_["poids_evaluation"];
		$stock_ini_exe = $user_["stock_ini_exe"];$type = $user_["type"];$stock_controle = $user_["stock_controle"];
		$produit = $user_["produit"];$colorant = $user_["colorant"];$dispo = $user_["dispo"];$production=0;$production1 = $user_["production"];
		$condit = $user_["condit"];$qte_colorant=$user_["qte_colorant"];$prix_revient_final = $user_["prix_revient_final"];$en_cours_final = $user_["en_cours_final"];
		$prix = $user_["prix"];$favoris = $user_["favoris"];$non_favoris = $user_["non_favoris"];$encours = $user_["encours"];
		$poids = $user_["poids"];$stock_initial = $user_["stock_ini_exe"];$stock_final = $user_["stock_final"];$prix_revient = $user_["prix_revient"];
		$tige=$user_["tige"];$qte_tige=$user_["qte_tige"];$emballage=$user_["emballage"];$qte_emballage=$user_["qte_emballage"];
		$matiere=$user_["matiere"];$qte_matiere=$user_["qte_matiere"];$etiquette=$user_["etiquette"];$qte_etiquette=$user_["qte_etiquette"];
			
			
	}
	
	$profiles_list_famille = "";
	$sql1 = "SELECT * FROM familles_articles ORDER BY profile_name;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($type == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_famille .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$profiles_list_famille .= $temp_["profile_name"];
		$profiles_list_famille .= "</OPTION>";
	}
	
	
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

	$profiles_list_accessoire_1 = "";$acc="accessoire";
	$sql3 = "SELECT * FROM produits where type='$acc' ORDER BY produit;";
	$temp = db_query($database_name, $sql3);
	while($temp_ = fetch_array($temp)) {
		if($accessoire_1 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_accessoire_1 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_accessoire_1 .= $temp_["produit"];
		$profiles_list_accessoire_1 .= "</OPTION>";
	}
	$profiles_list_accessoire_2 = "";
	$sql3 = "SELECT * FROM produits where type='$acc' ORDER BY produit;";
	$temp = db_query($database_name, $sql3);
	while($temp_ = fetch_array($temp)) {
		if($accessoire_2 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_accessoire_2 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_accessoire_2 .= $temp_["produit"];
		$profiles_list_accessoire_2 .= "</OPTION>";
	}
	$profiles_list_accessoire_3 = "";$acc="accessoire";
	$sql3 = "SELECT * FROM produits where type='$acc' ORDER BY produit;";
	$temp = db_query($database_name, $sql3);
	while($temp_ = fetch_array($temp)) {
		if($accessoire_3 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_accessoire_3 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_accessoire_3 .= $temp_["produit"];
		$profiles_list_accessoire_3 .= "</OPTION>";
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
			document.location = "controle_stocks.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="controle_stocks.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table width="671" class="table3">

		<tr>
		<td><?php echo "Article"; ?></td><td><input type="text" id="produit" name="produit" style="width:260px" value="<?php echo $produit; ?>"></td>
		</tr>
        </td>
		<tr>
		<td><?php echo "Famille : "; ?></td><td><select id="type" name="type"><?php echo $profiles_list_famille; ?></select></td>
		</tr>
        <tr>
		<td><?php echo "Conditionnement"; ?></td><td><input type="text" id="condit" name="condit" style="width:240px" value="<?php echo $condit; ?>"></td>
		</tr><tr>
		<td><?php echo "Prix Unitaire"; ?></td><td><input type="text" id="prix" name="prix" style="width:140px" value="<?php echo $prix; ?>"></td>
		</tr>
		
		<tr><td><input type="checkbox" id="stock_controle" name="stock_controle"<?php if($stock_controle) { echo " checked"; } ?>></td><td>Article controle</td>

	</table>

	</center>

</td></tr></table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="stock_final" name="stock_final" value="<?php echo $stock_final; ?>">
<input type="hidden" id="production" name="production" value="<?php echo $production; ?>">
<input type="hidden" id="stock_initial" name="stock_initial" value="<?php echo $stock_ini_exe; ?>">
<input type="hidden" id="qte_vendu" name="qte_vendu" value="<?php echo $qte_vendu; ?>">
<table class="table3"><tr>

<?php if($user_id != "0") { 
?>
<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td style="width:20px"></td>
<td><button type="button" onClick="DeleteUser()"><?php echo Translate("Delete"); ?></button></td>
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php } ?>
</tr></table>

</center>

</form>


</body>

</html>