<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];
	$qte_tige1=0;
				


	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Produit";

		$produit = "";$favoris = 0;$non_favoris = 0;$colorant="";$qte_colorant=0;$dispo=0;
		$condit = "";$poids_evaluation="";$unite="";$seuil_critique=0;
		$non_disponible="";$seuil_critique=0;$type="";$stock_controle="";
		$accessoire_1="";$qte_ac_1="";$poids_ac_1="";$mat_ac_1="";
		$accessoire_2="";$qte_ac_2="";$poids_ac_2="";$mat_ac_2="";
		$accessoire_3="";$qte_ac_3="";$poids_ac_3="";$mat_ac_3="";$famille="";$type_c="";

		$prix = "";$en_cours_final=0;$prix_revient_final=0;$production=0;$stock_ini_exe=0;
		$poids = "";$stock_initial = 0;$encours = 0;$stock_final = 0;$prix_revient =0;
		$tige="";$qte_tige=1;$emballage="";$qte_emballage=1;$matiere="";$qte_matiere=1;$etiquette="";$qte_etiquette=1;
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$non_disponible=$user_["non_disponible"];$seuil_critique=$user_["seuil_critique"];
		$accessoire_1=$user_["accessoire_1"];$qte_ac_1=$user_["qte_ac_1"];
		$accessoire_2=$user_["accessoire_2"];$qte_ac_2=$user_["qte_ac_2"];
		$accessoire_3=$user_["accessoire_3"];$qte_ac_3=$user_["qte_ac_3"];$unite=$user_["unite"];



		$title = "details";$poids_evaluation=$user_["poids_evaluation"];$type_c=$user_["type_c"];
		$stock_ini_exe = $user_["stock_ini_exe"];$type = $user_["type"];$stock_controle = $user_["stock_controle"];
		$produit = $user_["produit"];$colorant = $user_["colorant"];$dispo = $user_["dispo"];$seuil_critique = $user_["seuil_critique"];
		$production=0;$production1 = $user_["production"];
		$condit = $user_["condit"];$qte_colorant=$user_["qte_colorant"];$prix_revient_final = $user_["prix_revient_final"];$en_cours_final = $user_["en_cours_final"];
		$prix = $user_["prix"];$favoris = $user_["favoris"];$non_favoris = $user_["non_favoris"];$encours = $user_["encours"];
		$poids = $user_["poids"];$stock_initial = $user_["stock_initial"];$stock_final = $user_["stock_final"];$prix_revient = $user_["prix_revient"];
		$tige=$user_["tige"];$qte_tige=$user_["qte_tige"];$emballage=$user_["emballage"];$qte_emballage=$user_["qte_emballage"];
		$matiere=$user_["matiere"];$qte_matiere=$user_["qte_matiere"];$etiquette=$user_["etiquette"];$qte_etiquette=$user_["qte_etiquette"];
			
			
	}
	
	$profiles_list_famille = "";
	$sql1 = "SELECT * FROM familles_produits ORDER BY produit;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($type == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_famille .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_famille .= $temp_["produit"];
		$profiles_list_famille .= "</OPTION>";
	}
	
	$profiles_list_dp = "";
	$sql1 = "SELECT * FROM familles_dp ORDER BY produit;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($type_c == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_dp .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_dp .= $temp_["produit"];
		$profiles_list_dp .= "</OPTION>";
	}
	
	
	$list_unites = "";
	$sql5 = "SELECT * FROM unites_mesures ORDER BY unite;";
	$temp = db_query($database_name, $sql5);
	while($temp_ = fetch_array($temp)) {
		if($unite == $temp_["unite"]) { $selected = " selected"; } else { $selected = ""; }
		
		$list_unites .= "<OPTION VALUE=\"" . $temp_["unite"] . "\"" . $selected . ">";
		$list_unites .= $temp_["unite"];
		$list_unites .= "</OPTION>";
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
			document.location = "articles_commandes_mp.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="articles_commandes_mp.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table width="671" class="table3">

		<tr>
		<td><?php echo "Article"; ?></td><td><input type="text" id="produit" name="produit" style="width:260px" value="<?php echo $produit; ?>"></td>
		</tr>
        </td>
		<tr>
		<td><?php echo "Departement : "; ?></td><td><select id="type_c" name="type_c"><?php echo $profiles_list_dp; ?></select></td>
		</tr>
		<tr>
		<td><?php echo "Famille : "; ?></td><td><select id="type" name="type"><?php echo $profiles_list_famille; ?></select></td>
		</tr>
        <tr>
		<td><?php echo "Unite"; ?></td><td><select id="unite" name="unite"><?php echo $list_unites;?></select></td>
		</tr>
		<tr>
		<td><?php echo "Prix Unitaire"; ?></td><td><input type="text" id="prix" name="prix" style="width:140px" value="<?php echo $prix; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Stock"; ?></td><td><input type="text" id="stock_initial" name="stock_initial" style="width:140px" value="<?php echo $stock_initial; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Stock Alarme"; ?></td><td><input type="text" id="seuil_critique" name="seuil_critique" style="width:140px" value="<?php echo $seuil_critique; ?>"></td>
		</tr>
		
	</table>

	</center>

</td></tr></table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<table class="table3"><tr>

<?php if($user_id != "0") { ?>
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