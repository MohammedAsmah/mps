<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";

	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	// check basic user rights
	$users_can_edit_objects = param_extract("users_can_edit_objects");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<?php

	// selects current year if not specified by posted vars
	if(isset($_REQUEST["annee"])) { $annee = $_REQUEST["annee"]; } else { $annee = date("Y"); }

	if(isset($_REQUEST["family_id"])) { $family_id = $_REQUEST["family_id"]; }
	if(isset($_REQUEST["object_id"])) { $object_id = $_REQUEST["object_id"]; }

	if($users_can_edit_objects == "yes") {
		$sql = "SELECT family_id, family_name, sort_order FROM rs_param_families ORDER BY sort_order;";
	} else {
		// avoids showing families without objects
		$sql = "SELECT DISTINCT rs_param_families.family_id, rs_param_families.family_name, rs_param_families.sort_order ";
		$sql .= "FROM rs_param_families INNER JOIN rs_data_objects ON rs_param_families.family_id = rs_data_objects.family_id;";
	}
	
	$families = db_query($database_name, $sql);

	$n = 0; $families_list = "";
	
	while($families_ = fetch_array($families)) { $n++;
		
		if(!isset($family_id) && $n == 1) { $family_id = $families_["family_id"]; }

		$families_list .= "<option value=\"" . $families_["family_id"] . "\"";
		if($families_["family_id"] == $family_id) { $families_list .= " selected"; }
		$families_list .= ">" . $families_["family_name"] . "</option>" . chr(10);
	}

	// extracts objects list
	$sql  = "SELECT object_id, object_name FROM rs_data_objects ";
	$sql .= "WHERE family_id = " . $family_id . " ORDER BY object_name;";
	$objets = db_query($database_name, $sql);

	$n = 0; $objects_list = "";
	
	while($objets_ = fetch_array($objets)) { $n++;

		if(!isset($object_id) && $n == 1) { $object_id = $objets_["object_id"]; }


		$objects_list .= "<option value=\"" . $objets_["object_id"] . "\"";
		if($objets_["object_id"] == $object_id) { $objects_list .= " selected"; }
		$objects_list .= ">" . $objets_["object_name"] . "</option>" . chr(10);
	}

	// constructs hours list
	$start_hour = param_extract("activity_start");
	$end_hour = param_extract("activity_end");
	$activity_step = param_extract("activity_step") * 60;
	
	$activity_start = strtotime("1970-01-01" . " " . $start_hour);
	$activity_end = strtotime("1970-01-01" . " " . $end_hour);
	
	$hours_list = "";
	
	for($h=$activity_start;$h<=$activity_end;$h+=$activity_step) {
		if($hours_list == "") { $default_end_hour = $h + $activity_step; }
		$hours_list .= "<option value=\"" . $h . "\">" . date("H:i", $h) . "</option>" . chr(10);
	}

	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];$tout = $user_["tout"];$menu1 = $user_["menu1"];$menu2 = $user_["menu2"];$menu3 = $user_["menu3"];
	$menu4 = $user_["menu4"];$menu5 = $user_["menu5"];$menu6 = $user_["menu6"];
	$menu7 = $user_["menu7"];$menu8 = $user_["menu8"];$menu9 = $user_["menu9"];

?>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . Translate("Menu"); ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	
	function ChangeFamily(FamilyId) {
		
		if(FamilyId !=0) {
			document.location = "menu.php?user_id=<?php echo $_COOKIE["bookings_user_id"]; ?>&family_id=" + FamilyId + "&annee=" + document.getElementById("annee").value;
		} else {
			document.getElementById("object_id").disabled = true;
			document.getElementById("show_object").disabled = true;
			document.getElementById("show_year").disabled = true;
			document.getElementById("show_week").disabled = true;
		}
	}
	
	function ChangeObject(ObjectId) {
		
		if(ObjectId == 0) {
			document.getElementById("family_id").disabled = true;
			document.getElementById("show_family").disabled = true;
			document.getElementById("show_year").disabled = true;
			document.getElementById("show_week").disabled = true;
		} else {
			document.getElementById("family_id").disabled = false;
			document.getElementById("show_family").disabled = false;
			document.getElementById("show_year").disabled = false;
			document.getElementById("show_week").disabled = false;
		}
	}
	
	function ShowFamily() { window.open("family.php?user_id=<?php echo $_COOKIE["bookings_user_id"]; ?>&family_id=" + document.getElementById("family_id").value, "family", "height=300, width=400, top=" + (screen.height-300)/2 + ", left=" + (screen.width-400)/2); }
	function ShowObject() { window.open("object.php?object_id=" + document.getElementById("object_id").value + "&user_id=<?php echo $_COOKIE["bookings_user_id"]; ?>&family_id=" + document.getElementById("family_id").value, "object", "height=300, width=400, top=" + (screen.height-300)/2 + ", left=" + (screen.width-400)/2); }
	function AvailabilitySearch() { document.getElementById("search_form").submit(); }
	function ShowCalendar(filename) { document.getElementById("form_resa").action = filename; document.getElementById("form_resa").submit(); }
	function DeLog() { top.location = "index.php?action_=delog"; }

--></script>

</head>

<body style="text-align:center; margin:5px 0px 5px 5px">

<span style="font-size:24px"></span>
<span style="font-size:12px; color:#7f7f7f"><a href="" target="_blank"></a></span>
<hr>

<center>

<table style="text-align:center">
<tr><td><?php echo Translate("User"); ?> : <?php echo $login; ?></td></tr>
<tr><td style="font-size:12px"><a href="JavaScript:DeLog()">[ <?php echo Translate("disconnect"); ?> ]</a></td></tr>
</table>

<hr>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_COOKIE["bookings_user_id"]; ?>">
<input type="hidden" id="screen_width" name="screen_width">
<input type="hidden" id="screen_height" name="screen_height">

<hr>


	<hr>


	<table style="font-size:14px">
		
	<tr>
	<td style="width:10px"></td>
	<?php if($login == "admin" or $login == "rakia") { ?>
	<td><a href="users.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Utilisateurs </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? } ?>
	<tr>
	<td style="width:10px"></td>
	<td><a href="contacts.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Repertoire </font>"); ?>]</a></td>
	</tr>	<tr></tr>

	<?php if($tout == 1 or $menu1==1) { ?>
	<tr>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">Parametrage </font>"); ?>]</td>
	</tr>
	<tr></tr>

	<td style="width:10px"></td>
	<td><a href="clients.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Clients </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="liste_clients.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">C.A par Clients </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="villes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Villes </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="produits.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Articles </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="fiches_stock.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Fiches Stock </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="vendeurs.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Vendeurs</font>"); ?>]</a></td>
	</tr>
	<tr></tr>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="banques.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Banques</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="Matieres.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Matieres</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="colorants.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Colorants</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="Tiges.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Tiges</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="Emballages.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Emballages</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="Etiquettes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Etiquettes</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="maj_factures_details_favoris.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Article non favoris</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="machines.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Machines</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="productions.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Saisie Production</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? }?>
	<?php if($tout == 1 or $menu2==1) { ?>
	<tr>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">Commercial </font>"); ?>]</td>
	</tr>
	<td style="width:10px"></td>
	<td><a href="evaluations_client.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Saisie Evaluations C</font>"); ?>]</a></td>
	</tr>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="registres_vendeurs.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Saisie Evaluations V</font>"); ?>]</a></td>
	</tr>
	
	<?php if($login == "admin") { ?>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="registres_vendeurs_update.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Fusion 1</font>"); ?>]</a></td>
	</tr>
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="registres_vendeurs_update1.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Fusion 2</font>"); ?>]</a></td>
	</tr>
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="registres_vendeurs_update3.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Fusion 3</font>"); ?>]</a></td>
	</tr>
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="registres_vendeurs_update4.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Fusion 4</font>"); ?>]</a></td>
	</tr>
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="registres_reglements_update.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Fusion R1</font>"); ?>]</a></td>
	</tr>
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="registres_reglements_update1.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Fusion R2</font>"); ?>]</a></td>
	</tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="entrer_fichier.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Evaluations</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="entrer_fichier1.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Details Evaluations</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="entrer_fichier_produits.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Importer Produits</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="entrer_fichier_clients.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Importer Clients</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="entrer_fichier_vendeurs.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Importer Vendeurs</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="entrer_fichier_factures.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Importer Factures</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="entrer_fichier_article_sr.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Importer Article sr</font>"); ?>]</a></td>
	</tr>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="journal_caisses_fusion.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">fusion Caisse</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<?php } ?>
	<?php } ?>
	<?php if($tout == 1 or $menu3==1) { ?>
	<tr>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">EDITIONS </font>"); ?>]</td>
	</tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="evaluations_client_globale1.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat Evaluations Globale</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="evaluations_client_globale11.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat Evaluations Par Clients</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="evaluations_client_globale.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat Evaluations Clients/Vendeur</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="balance_evaluations.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Balance Evaluations</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="evaluations_client_non_sortie.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Evaluations non sortie</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="palmares_articles.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Palmares des Articles</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="palmares_clients.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Palmares des Clients</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="palmares_vendeurs.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Palmares des Vendeurs</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="despatching_articles_factures.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Despatching Aricles/Factures</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<?php } ?>
	<?php if($tout == 1 or $menu4==1) { ?>
	<tr>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">CAISSE COMPTOIR </font>"); ?>]</td>
	</tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="journal_caisses_c.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Caisse Comptoir</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="journal_caisses_c_edition.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Edition Caisse Comptoir</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	<? }?>
	<?php if($tout == 1 or $menu8==1) { ?>
	<tr>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">CAISSE PAIE </font>"); ?>]</td>
	</tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="journal_caisses_p.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Caisse Paie</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="journal_caisses_p_edition.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Edition Caisse Paie</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? }?>
	<?php if($tout == 1 or $menu9==1) { ?>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">Saisie Achats </font>"); ?>]</td>
	</tr>
	<td style="width:10px"></td>
	<td><a href="fournisseurs.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Fournisseurs</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="achats_mat.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Matieres</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="achats_tig.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Tiges</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="achats_col.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Collorants</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="achats_emb.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Emballages</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="achats_eti.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etiquettes</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="balance_achats.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Balance Achats</font>"); ?>]</a></td>
	</tr>	<tr></tr>

	<? }?>
	

	<?php if($tout == 1 or $menu5==1) { ?>
	<tr>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">FACTURATION </font>"); ?>]</td>
	</tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="factures.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Facturation</font>"); ?>]</a></td>
	</tr>	<tr></tr>

	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="edition_factures.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Mise à jour Factures</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="factures_instances.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Instances</font>"); ?>]</a></td>
	</tr>	<tr></tr>

	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="ca_par_quantite.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">CA en Quantités</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="ca_par_matiere.php?type_c=<? echo $v;?>" target="_Blank" >[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Stock Final Matiere</font>"); ?>]</a></td>
	</tr>	<tr></tr>

	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="produits_finis.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Stock Produits Finis</font>"); ?>]</a></td>
	</tr>	<tr></tr>

	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="ca_par_valeur.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">CA en Valeurs</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? } ?>
	<?php if($tout == 1 or $menu6==1) { ?>
	<tr>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">CAISSE PRINCIPALE </font>"); ?>]</td>
	</tr>
	
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="types_caisses.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Lise Caisses</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="types_operations.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Type Opérations</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="types_depenses.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Type Depenses</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="journal_caisses.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Journal Caisses</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="balance_caisses.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Balance Caisses</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="journal_caisses_c_v.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Validation Caisses</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="journal_caisses_edition.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Edition Journal Caisses</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<?php } ?>
	
	<?php if($login == "admin" or $login == "rakia") { ?>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="ecritures.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Journal Ecritures </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? } ?>


	<?php if($tout == 1 or $menu7==1) { ?>
	<tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="menu.php?type_c=<? $v="enc";echo $v;?>">[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">ENCAISSEMENTS</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="registres_reglements.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Saisie Reglements</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="maj_porte_feuilles.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Modification Reglements</font>"); ?>]</a></td>
	</tr>	<tr></tr>

	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="saisie_reglements.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Saisie Reglements 2</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="registres_remises.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Remises à la Banque</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="saisie_impayes.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Ajout Impaye</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="registres_remises_impayes.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat des Impayes</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="registres_remises_impayes_enc.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Saisie Encaiss Impayes</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="etat_enc_impayes.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat Encaiss Impayes</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="journal_encaissements_f.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Journal Encaissements</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="journal_encaissements_chq.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat Entree Cheques/Fact</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="journal_encaissements_chq_eva.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat Entree Cheques/Eval</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="porte_feuilles_factures.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Porte Feuilles Facturé</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="porte_feuilles1.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Porte Feuille</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="porte_feuilles_evaluations.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Porte Feuilles Evaluations</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="releves_factures.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Releve Factures</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="releves_encaiss_cheques.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Releve Encaissements</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="recherche.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Recherche</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="encaissements_mois_chq.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Encaissements Chq</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="encaissements_mois_esp.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Encaissements Esp</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<?php } ?>
	</table>


</center>

<script type="text/javascript"><!--
document.getElementById("search_end_hour").value = <?php echo $default_end_hour; ?>;
document.getElementById("screen_width").value = screen.width;
document.getElementById("screen_height").value = screen.height;
--></script>

</body>

</html>