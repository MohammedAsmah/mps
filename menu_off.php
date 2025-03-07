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
	$menu7 = $user_["menu7"];$menu8 = $user_["menu8"];$menu9 = $user_["menu9"];$menu10 = $user_["menu10"];
	$menu11 = $user_["menu11"];$menu12 = $user_["menu12"];
	$menu13 = $user_["menu13"];$menu14 = $user_["menu14"];$menu15 = $user_["menu15"];$menu16 = $user_["menu16"];
	
	
	
	
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
	function DeLog() { top.location = "index1.php?action_=delog"; }

--></script>

</head>

<body style="text-align:center; margin:5px 0px 5px 5px">

<span style="font-size:24px"></span>
<span style="font-size:12px; color:#7f7f7f"><a href="" target="_blank"></a></span>
<hr>

<center>

<table style="text-align:center">
<tr><td><?php echo Translate("User"); ?> : <?php echo $login." - "; ?></td></tr>
<tr><td><?php $dj=date("d-m-Y");echo $dj; ?></td></tr>
<tr><td style="font-size:12px"><a href="JavaScript:DeLog()">[ <?php echo Translate("disconnect"); ?> ]</a></td></tr>
</table>
<?php if($login <> "adminrecap" and $login <> "MED") { ?>

<hr>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_COOKIE["bookings_user_id"]; ?>">
<input type="hidden" id="screen_width" name="screen_width">
<input type="hidden" id="screen_height" name="screen_height">

<hr>


	<hr>

	<tr>
	
		<table style="font-family:'Comic Sans MS' " style="font-size:12px ">
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="menu.php?type_c=<? $v="comr";echo $v;?>"><?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#33CC66\">[COMMERCIAL]</font>"); ?></a></td>
	</tr>	<tr></tr>
	<tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="menu.php?type_c=<? $v="avoir";echo $v;?>"><?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#33CC66\">[AVOIRS]</font>"); ?></a></td>
	</tr>	<tr></tr>	
	<tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="menu.php?type_c=<? $v="fact";echo $v;?>"><?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#33CC66\">[FACTURATION]</font>"); ?></a></td>
	</tr>	<tr></tr>
	<tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="menu.php?type_c=<? $v="cais";echo $v;?>"><?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#33CC66\">[CAISSE]</font>"); ?></a></td>
	</tr>	<tr></tr>
	<tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="menu.php?type_c=<? $v="ech";echo $v;?>"><?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#33CC66\">[BANQUE]</font>"); ?></a></td>
	</tr>	<tr></tr>

	<tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="menu.php?type_c=<? $v="encs";echo $v;?>"><?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#33CC66\">[ENCAISSEMENTS]</font>"); ?></a></td>
	</tr>	<tr></tr>	
    <tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="menu.php?type_c=<? $v="edit";echo $v;?>"><?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#33CC66\">[EDITIONS]</font>"); ?></a></td>
	</tr>	<tr></tr>	
	<tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="menu.php?type_c=<? $v="acha";echo $v;?>"><?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#33CC66\">[ACHATS]</font>"); ?></a></td>
	</tr>	<tr></tr>
	<tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="menu.php?type_c=<? $v="para";echo $v;?>"><?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#33CC66\">[PARAMETRAGE]</font>"); ?></a></td>
	</tr>	<tr></tr>
	<tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="menu.php?type_c=<? $v="stock";echo $v;?>"><?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#33CC66\">[STOCK]</font>"); ?></a></td>
	</tr>	<tr></tr>
	<tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="menu.php?type_c=<? $v="prod";echo $v;?>"><?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#33CC66\">[PRODUCTION]</font>"); ?></a></td>
	</tr>	<tr></tr>
	<tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="menu.php?type_c=<? $v="main";echo $v;?>"><?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#33CC66\">[MAINTENANCE]</font>"); ?></a></td>
	</tr>	<tr></tr>
	<tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="menu.php?type_c=<? $v="paie";echo $v;?>"><?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#33CC66\">[PAIE]</font>"); ?></a></td>
	</tr>	<tr></tr>	
	<tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="menu.php?type_c=<? $v="bc";echo $v;?>"><?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#33CC66\">[BON COMMANDES]</font>"); ?></a></td>
	</tr>	<tr></tr>		
	<tr></tr>
	<td style="width:10px"></td>
	<?php if($login == "admin" or $login == "rakia") { ?>
	<td><a href="users.php" target="middle_frame"><?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#33CC66\">[UTILISATEURS] </font>"); ?></a></td>
	</tr>	<tr></tr>	
	<? } ?>
	
	<?php if($login <> "semhari" and $login <> "zerhoudi") { ?>
	<tr>
	<td style="width:10px"></td>
	<td><a href="contacts.php" target="middle_frame"><?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#33CC66\">[MAJ REPERTOIRE] </font>"); ?></a></td>
	</tr>	<tr></tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="contacts_g.php" target="middle_frame"><?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#33CC66\">[REPERTOIRE] </font>"); ?></a></td>
	</tr>	<tr></tr>
	<tr><td></td><td><? echo "========================";?></td></tr>
	<? }?>
	
	</table>
	

<tr></tr>
<tr></tr>

		<table style="font-size:13x">

		
		
		
		
	<? if(isset($_REQUEST["type_c"])){
	
	if($_REQUEST["type_c"]=="avoir"){?>

		

	<?php if($tout == 1 or $menu16==1) { ?>
	<tr>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">GESTION AVOIRS </font>"); ?>]</td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="avoirs_client.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Saisie Avoirs </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="regrouper_avoirs_client.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Evaluation Avoirs </font>"); ?>]</a></td>
	</tr>	
	<tr>
	<td style="width:10px"></td>
	<td><a href="etat_avoirs_vendeurs.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Avoirs / vendeur </font>"); ?>]</a></td>
	</tr>	
	<tr>
	<td style="width:10px"></td>
	<td><a href="etat_avoirs_mat.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Avoirs / Chauffeur </font>"); ?>]</a></td>
	</tr>	
	
	<tr>
	<td style="width:10px"></td>
	<td><a href="etat_avoirs_clients.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Avoirs / client </font>"); ?>]</a></td>
	</tr>		
	<tr>
	<td style="width:10px"></td>
	<td><a href="etat_avoirs_articles_periode.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Analyse Avoirs / articles </font>"); ?>]</a></td>
	</tr>		
		
		
	<?php if($login == "admin" or $login == "driss" or $login="rakia"  ) { ?>	
	<tr>
	<td style="width:10px"></td>
	<td><a href="etat_avoirs_clients_periode.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Analyse Avoirs / client </font>"); ?>]</a></td>
	</tr>	
	<tr>
	<td style="width:10px"></td>
	<td><a href="etat_avoirs_vendeurs_periode.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Analyse Avoirs / vendeur </font>"); ?>]</a></td>
	</tr>	
	
	<? }?>
	<?php if($login == "admin" or $login == "driss" or $login="rakia"){?>
	<tr>
	<td style="width:10px"></td>
	<td><a href="choix_produits_palmares_avoirs.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Palmares / Avoirs </font>"); ?>]</a></td>
	</tr>
	<? }?>
	<?php if($login == "admin" or $login == "driss" or $login="rakia" ){?>
	<tr>
	<td style="width:10px"></td>
	<td><a href="choix_produits_palmares_avoirs1.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Palmares / Avoirs / SC </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="palmares_clients_avoirs.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Palmares C.A / Avoirs </font>"); ?>]</a></td>
	</tr>
	<? }?>
	
	
	<? }?>
	<? }?>
	
		<? if($_REQUEST["type_c"]=="para"){?>

		

	<?php if($tout == 1 or $menu1==1) { ?>
	<tr>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">Parametrage </font>"); ?>]</td>
	</tr>
	<tr></tr>
	<?php if($login == "admin" or $login == "rakia" or $login == "Radia" or $login == "najat" or $login == "driss") { ?>
	<td style="width:10px"></td>
	<td><a href="clients.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Clients </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? }?>
	<td style="width:10px"></td>
	<td><a href="liste_clients.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">C.A par Clients </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="villes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Villes </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="camions.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Camions </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="produits.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Articles </font>"); ?>]</a></td>
	</tr>
	
	<td style="width:10px"></td>
	<td><a href="produits_par_date.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Tarifs Articles</font>"); ?>]</a></td>
	</tr>
	
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="accessoires_articles.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Accessoires </font>"); ?>]</a></td>
	</tr>
<?php if($login == "admin" ) { ?>	
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="factures_update.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Factures update</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="porte_feuilles_factures_b.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Clients tire</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="clients_mvt.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Clients Mvt</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? }?>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="tarifa2.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Recherche Articles </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? if ($login=="admin"){?>
	<td style="width:10px"></td>
	<td><a href="controle_stocks.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Controle stock </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="stock_produits_nc.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Stock NC</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? }?>
	<td style="width:10px"></td>
	<td><a href="fiches_stock.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Fiches Stock </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="vendeurs.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Vendeurs</font>"); ?>]</a></td>
	</tr>
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="promotions.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Promotions</font>"); ?>]</a></td>
	</tr>
	<tr></tr>
    
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="banques.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Banques</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="matieres.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Matieres Premieres</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="matieres_c.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Matieres Consomables</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="colorants.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Colorants</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="tiges.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Tiges</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="emballages.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Emballages Carton</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="emballages1.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Emballages Sachets</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="emballages2.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Emballages Divers</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="etiquettes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Etiquettes</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="maj_factures_details_favoris.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Article non favoris</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="machines.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Machines</font>"); ?>]</a></td>
	</tr>	
	<? }?>
	<? }?>
	
		
	<?	if($_REQUEST["type_c"]=="bc"){?>

		

	<?php if($tout == 1 or $menu15==1) { ?>
	<tr>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">Bon Commandes </font>"); ?>]</td>
	</tr>
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="bc_mps.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Commandes </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="etat_bc_mps.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Commandes </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<?php if($login == "admin" or $login=="rakia" or $login=="nabila") { ?>	
	<td style="width:10px"></td>
	<td><a href="controle_bc_mps.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Controle Commandes </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? }?>
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="demandes_prix_mps.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Demande de prix </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="articles_commandes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Ajout Bon Besoin   </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="articles_commandes_reception1.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Confirmation Bon de Besoin   </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="historique_bons_besoins.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Historique Bons de Besoins   </font>"); ?>]</a></td>
	</tr>
	
	<tr>
	<td style="width:10px"></td>
	<td><a href="articles_commandes_reception.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Bon de Reception   </font>"); ?>]</a></td>
	<tr>
	<td style="width:10px"></td>
	<td><a href="fournisseurs_produits.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Fournisseurs    </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="familles_articles_commandes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Familles articles    </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="consulter_base_fournisseurs.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Recherche / famille  </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="consulter_base_fournisseurs_articles.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Recherche / article  </font>"); ?>]</a></td>
	</tr>
	
	<tr>
	<td style="width:10px"></td>
	<td><a href="tarifs_achats.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Tarifs Achats  </font>"); ?>]</a></td>
	</tr>	
	
	<? }?>
	<? }?>
	
	
		<? if($_REQUEST["type_c"]=="stock"){?>
	
	<?php if($tout == 1 or $menu10==1) { ?>
	<tr>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">STOCK </font>"); ?>]</td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="entrees_stock.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Saisie Production </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="entrees_stock_a_vers_b.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">MPS ===> JAOUDA </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="entrees_stock_b_vers_a.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">JAOUDA ===> MPS </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="etat_sorties.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat de Sorties </font>"); ?>]</a></td>
	</tr>
		<tr>
	<td style="width:10px"></td>
	<td><a href="etat_production.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat de Production </font>"); ?>]</a></td>
	</tr>
		<tr>
	<td style="width:10px"></td>
	<td><a href="stock_produits_couleurs.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Stock Produits Couleurs </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="stock_produits.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat de Stock Articles</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="registres_vendeurs_controle.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat controle Validation</font>"); ?>]</a></td>
	</tr>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="camions.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Camions </font>"); ?>]</a></td>
	
	<?php if($login == "admin" or $login == "rakia") { ?>
	<tr>
	<td style="width:10px"></td>
	<td><a href="stock_produits_valorise.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat de Stock Articles1</font>"); ?>]</a></td>
	</tr>
		<? }?>
		
	<?php if($login == "admin") { ?>
	<tr>
	<td style="width:10px"></td>
	<td><a href="stock_produits_magasins.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat de Stock controle</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="stock_produits1.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat de Stock ANCIEN</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="mvt_stock_produits.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Validation Stock</font>"); ?>]</a></td>
	</tr>
	
	
		<? }?>	
	<?php if($login == "admin" or $login=="leila") { ?>
	<tr>
	<td style="width:10px"></td>
	<td><a href="entrees_stock_mp_controle.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Entrees Matieres P.S.F</font>"); ?>]</a></td>
	</tr>
		<? }?>		
	<tr>
	<td style="width:10px"></td>
	<td><a href="stock_produits_alarmes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat de Stock Alarme</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="stock_accessoires.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat de Stock Accessoires</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="entrees_stock_report.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Saisie Stock Report MPS</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="entrees_stock_report_b.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Saisie Stock Report JAOUDA</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="entrees_stock_casse_mps.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Saisie Casse MPS</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="entrees_stock_casse_jaouda.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Saisie Casse JAOUDA</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="produits_en_production.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Articles  en production</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="registres_vendeurs_s.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Validation Bon Sortie</font>"); ?>]</a></td>
	</tr>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="registres_vendeurs_ss.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Validation Bon Sortie G</font>"); ?>]</a></td>
	</tr>
	<?php if($login == "admin"){?>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="registres_vendeurs_global.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Indexation Bon Sortie</font>"); ?>]</a></td>
	</tr>
	<? } ?>
	<tr>
	<td style="width:10px"></td>
	<td><a href="registres_bons_sortie.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Despatching Bon sortie </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="registres_bons_sortie_ss.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Despatching Bon sortie G</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="registre_programmes_equipes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Programme Equipes </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="registre_programmes_equipes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Programme Equipes </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="registre_programmes_equipes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Programme Equipes </font>"); ?>]</a></td>
	</tr>
	
	

<?php if($tout == 1 or $menu13==1) { ?>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="registres_vendeurs_sg.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Validation BSG</font>"); ?>]</a></td>
	</tr>
	<? }?>

	<? }?>
	<? }?>
		<? if($_REQUEST["type_c"]=="ech"){?>
	
	<?php if($tout == 1 or $menu13==1) { ?>
	<?php //if($login == "admin" ) { ?>
	<tr>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">Tresorerie </font>"); ?>]</td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="journal_banques.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Saisie Operations </font>"); ?>]</a></td>
	</tr>
	
	<tr>
	<td style="width:10px"></td>
	<td><a href="types_operations_b.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Type Operations </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="balance_banques.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Balance Operations </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="journal_banques_editions.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Edition Operations </font>"); ?>]</a></td>
	</tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="registres_remises.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Remises à la Banque</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
		</tr>	<tr></tr>	
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="porte_feuilles_factures.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Porte Feuilles Cheques</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	<tr></tr>	
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="porte_feuilles_cheques_clients.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Porte Feuilles Cheques/C</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="porte_feuilles_effets.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Porte Feuilles Effets</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="porte_feuilles_effets_clients.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Porte Feuilles Effets/C</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="porte_feuilles_effets_vendeurs.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Porte Feuilles Effets/V</font>"); ?>]</a></td>
	</tr>	<tr></tr>	
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="porte_feuilles1.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Porte Feuille</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="porte_feuilles_evaluations.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Porte Feuilles Evaluations</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="recherche.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Recherche</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="porte_feuilles_effets_clients_remis.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Porte Feuilles Effets/C/R</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	
	
	<?php if($login == "admin" ) { ?>
	<tr>
	<td style="width:10px"></td>
	<td><a href="journal_banques_simulation.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Banque Simulation </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="porte_feuilles_indexation.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Indexation Porte feuilles</font>"); ?>]</a></td>
	</tr>
	<tr>
	<? } ?>
	<td style="width:10px"></td>
	<td><a href="registres_remises_tresorerie.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Validation Remises </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="registres_raps.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat de Rapprochement </font>"); ?>]</a></td>
	</tr>		
		<? // } ?>
	<tr>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">ECHEANCIER </font>"); ?>]</td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="credits.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Credits </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="provisions.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Provisions</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="effets_oc.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Effets O.C</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="effets_aa.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Effets AVAL / ACC</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="echeancier_previsionnels.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Echeancier Previsionel</font>"); ?>]</a></td>
	</tr>	
	<tr>
	<td style="width:10px"></td>
	<td><a href="maj_echeances.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Maj Echeances</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="ec.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Echeancier/mois </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="echeancier.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Echeancier/Date</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="ligne_effets_oc.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Consulter Ligne O.C</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="ligne_effets_av.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Consulter Ligne Aval</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="ligne_effets_natpet.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Consulter Ligne Natpet</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="ligne_effets_escompte.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Consulter Ligne Escompte</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="echeancier_mps.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Echeancier</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="echeancier_mps_echus.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Echeancier Echus</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="pf.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Porte Feuille</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="tb.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Tableau Bord</font>"); ?>]</a></td>
	</tr>
	<? }?>
	<? }?>

		<? if($_REQUEST["type_c"]=="prod"){?>
	
	<?php if($tout == 1 or $menu11==1) { ?>
	<tr>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">PRODUCTION </font>"); ?>]</td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="productions.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Saisie Production </font>"); ?>]</a></td>
	</tr>
	<?php if($login == "admin" or $login == "nezha" or $login == "driss" or $login == "arahal") { ?>
	<tr>
	<td style="width:10px"></td>
	<td><a href="machines.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Machines </font>"); ?>]</a></td>
	</tr>
	<?php if($login == "admin" or $login == "nezha" or $login == "driss" or $login == "rakia" or $login == "arahal") { ?>
	<tr>
	<td style="width:10px"></td>
	<td><a href="articles_en_productions.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste articles </font>"); ?>]</a></td>
	</tr>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="choix_produits_simulation.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Simulation Sorties</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="choix_simulation_sorties.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Simulation Disponibilité </font>"); ?>]</a>
    </td>
	
	</tr>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="fiches_globales.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Fiches Techniques</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	</tr>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="melanges.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Melanges</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	<? }?>
	<?php if($login == "admin"){?>
	<tr>
	<td style="width:10px"></td>
	<td><a href="historique_productions.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Historique Production </font>"); ?>]</a>
    </td>
	
	</tr>
		<? }?>
	
	<? }?>
	<tr>
	<td style="width:10px"></td>
	<td><a href="programme_machines.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Programme Machines </font>"); ?>]</a>
    </td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="etat_avoirs_articles.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Retours / articles </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="choix_produits_palmares_quantite.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Palmares / articles </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">=============== </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="articles_commandes_mp.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Inventaire MP </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="entrees_stock_mp.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Entrees stock MP </font>"); ?>]</a></td>
	</tr>
	
	<tr>
	<td style="width:10px"></td>
	<td><a href="sorties_stock_mp.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Sorties stock MP </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="recherche_commande.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Suivi Commandes </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="etat_stock_mp.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat Stock MP </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="etat_stock_mp_alarme.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Stock Alarme Mat.Prem</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="stock_produits_alarmes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Stock Alarme Produits.Finis </font>"); ?>]</a></td>
	</tr>
	
	<tr>
	<td style="width:10px"></td>
	<td><a href="stock_accessoires.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat de Stock Accessoires</font>"); ?>]</a></td>
	</tr>
	<? }?>
	<? }?>
		<? if($_REQUEST["type_c"]=="main"){?>
	
	<?php if($tout == 1 or $menu12==1) { ?>
	<tr>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">MAINTENANCE </font>"); ?>]</td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="maintenances.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Saisie Maintenance </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="machines.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Machines </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="interventions.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Interventions </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="services.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Services </font>"); ?>]</a></td>
	</tr>
		<tr>
	<td style="width:10px"></td>
	<td><a href="Programmation.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Programme Equipes </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="programme_machines.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Programme Machines </font>"); ?>]</	
    a></td>
	</tr>
	
	<? }?>
	<? }?>





		<? if($_REQUEST["type_c"]=="comr"){?>
	
	<?php if($tout == 1 or $menu2==1) { ?>
	<tr>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">Commercial </font>"); ?>]</td>
	</tr>
	<td style="width:10px"></td>
	<td><a href="evaluations_client.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Commandes Clients</font>"); ?>]</a></td>
	</tr>
	<?php if($login == "admin" or $login=="leila"){ ?>
	</tr>
	<td style="width:10px"></td>
	<td><a href="evaluations_client_solde.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Mise à jour soldes</font>"); ?>]</a></td>
	</tr>
	</tr>
	<td style="width:10px"></td>
	<td><a href="sorties_stock_couleurs.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">MAJ Sortie Couleurs </font>"); ?>]</a></td>
	</tr>
	<? }?>
	</tr>
	<td style="width:10px"></td>
	<td><a href="evaluations_client_encours.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Commandes En cours</font>"); ?>]</a></td>
	</tr>
	
	<td style="width:10px"></td>
	<td><a href="gratuites.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">sorties personnel</font>"); ?>]</a></td>
	</tr>
	<td style="width:10px"></td>
	<td><a href="fiches_employes_globales.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Personnes bénéficière</font>"); ?>]</a></td>
	</tr>
	<?php if($login == "admin" or $login == "rakia")
	{ ?>
	<td style="width:10px"></td>
	<td><a href="palmares_gratuites.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Historique sortie personnel</font>"); ?>]</a></td>
	</tr>
	<? } ?>

	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="registres_vendeurs.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Edition Bon de Sortie</font>"); ?>]</a></td>
	</tr>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="registres_vendeurs_t.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Bon Frais Transport</font>"); ?>]</a></td>
	</tr>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="registres_vendeurs_bl.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat B.L N.R</font>"); ?>]</a></td>
	</tr>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="registres_vendeurs_pc.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat Pieces Trst</font>"); ?>]</a></td>
	</tr>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="registres_vendeurs_periode.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Edition Etat Ventes</font>"); ?>]</a></td>
	</tr>
	
	<?php if($login == "admin" or $login == "rakia") { ?>	
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="registres_vendeurs_mc.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Edition Etat</font>"); ?>]</a></td>
	</tr>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="registres_vendeurs_escomptes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Bon de Sortie Escompte</font>"); ?>]</a></td>
	</tr>
	
	<? } ?>
	
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="promotions.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Promotions</font>"); ?>]</a></td>
	</tr>

	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="e_d_m.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Engagement Importation</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="releves_factures_08_09_10.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Edition Factures</font>"); ?>]</a></td>
	</tr>	<tr></tr>	
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="releves_regl_factures_08_09_10.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Edition Regl. Factures</font>"); ?>]</a></td>
	</tr>	<tr></tr>	

	
	
<?php if($login == "admin" ) { ?>	
	<tr>
	<td style="width:10px"></td>
	<td><a href="bc_mps.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Bon Commande MPS </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="demandes_prix_mps.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Demande de Prix MPS </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="articles_commandes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Pieces   </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="entrer_fichier_pointage.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Importer Pointage</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="pointages.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Edition Pointage</font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="familles_articles_commandes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Familles Articles  </font>"); ?>]</a></td>
	</tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="bc.php_jaouda" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Saisie B.C JAOUDA </font>"); ?>]</a></td>
	</tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="entrer_fichier_frs.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Importer FRS</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="entrer_fichier_art_frs.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Importer Articles</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="entrer_fichier_clients.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Importer commandes</font>"); ?>]</a></td>
	</tr>	<tr></tr>	
	
<? }?>	

	<?php if($login == "admin" or $login == "rakia") { ?>
	<tr>
	<td style="width:10px"></td>
	<td><a href="registres_vendeurs_c.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Validation Evaluations </font>"); ?>]</a></td>
	</tr>
	<? }?>
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
	<td><a href="entrer_fichier_factures_rs.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Importer Factures rs</font>"); ?>]</a></td>
	</tr>	<tr></tr>
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
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="miseajour_portefeuille_commandes.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Mise a jour porte feuille</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="porte_feuilles_controle_com.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Controle porte feuille</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<?php } ?>
	<?php } ?>
	
	<?php } ?>
	
		<? if($_REQUEST["type_c"]=="edit"){?>
	
	
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
	<td><a href="evaluations_client_globale2.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat Evaluations / Promotions</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="evaluations_vendeurs_dates.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Evaluations / Vendeurs</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="liste_clients_mvt.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Mvt/Vendeurs</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="balance_evaluations.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Balance Evaluations G</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="balance_evaluations_e.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Balance Evaluations E</font>"); ?>]</a></td>
	
		<?php if($login == "admin" or $login == "rakia") { ?>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="palmares_des_clients_2008.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Balance Croisée 2008</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="palmares_des_clients_2009.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Balance Croisée 2009</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="palmares_vendeurs_clients.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Generer Balance Croisée</font>"); ?>]</a></td>
	
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="evaluations_clients_escomptes.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat Evaluations escomptes</font>"); ?>]</a></td>
	
	<? }?>
	
	<?php if($login == "admin" or $login == "rakia") { ?>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="etat_bc_mps_tarifs.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Historique Tarif Achat</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="etat_entrees_stock_mp.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Entrees Mat.P. </font>"); ?>]</a></td>
	</tr>
	<? }?>
	
		<?php if($login == "admin" or $login == "rakia") { ?>

	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="balance_commissions.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Balance Commissions</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	<? }?>
	
	<?php if($login == "admin" ) { ?>

	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="balance_evaluations_comparatif_clients.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Com Clients</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="choix_produits_simulation.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Simulation Sorties</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? }?>
	
	
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="balance_evaluations_comparatif.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Comparatif Vendeurs</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="balance_evaluations_comparatif_articles.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Comparatif Articles</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="comparatif_clients.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Comparatif Clients</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="comparatif_clients_com.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Comparatif Clients/Esc</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="evaluations_client_non_sortie.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Evaluations non sortie</font>"); ?>]</a></td>
	</tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="palmares_articles_global.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Palmares Articles Global</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="choix_produits_palmares.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Palmares Articles Partiel</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="palmares_clients_com.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Palmares Clients ESC/C.A</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="palmares_clients_com_v.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Palmares Vendeurs ESC/C.A</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="palmares_clients_com2.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Palmares Clients ESC 2%</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="palmares_clients_com1.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Palmares Clients ESC/EVAL</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="grilles_escomptes.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Grille % Escompte / C.A</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="palmares_clients.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Palmares des Clients</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="palmares_clients_last.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">C.A / CLIENTS</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="palmares_vendeurs.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Palmares des Vendeurs</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="despatching_articles_factures_g.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Despatching Aricles/Factures</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="despatching_articles_factures.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Despatching Famille/Factures</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	<?php } ?>
	<?php } ?>
	
	
		<? if($_REQUEST["type_c"]=="cais"){?>
	
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
	</tr>	


	<? }?>
	<? }?>

		<? if($_REQUEST["type_c"]=="acha"){?>
	
	<?php if($tout == 1 or $menu9==1) { ?>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">Saisie Achats </font>"); ?>]</td>
	</tr>
	<td style="width:10px"></td>
	<td><a href="fournisseurs.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Fournisseurs</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	</tr>	<tr></tr>	
	<td style="width:10px"></td>
	<td><a href="comparatif_achats.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Comparatif Achats</font>"); ?>]</a></td>
	</tr>	<tr></tr>	
	<td style="width:10px"></td>
	<td><a href="familles_articles_commandes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Familles Commandes</font>"); ?>]</a></td>
	</tr>	<tr></tr>	
	<td style="width:10px"></td>
	<td><a href="achats_mat.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Matieres Premieres</font>"); ?>]</a></td>
	</tr>	<tr></tr>	
	<td style="width:10px"></td>
	<td><a href="achats_mat2.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Matieres Regeneré</font>"); ?>]</a></td>
	</tr>	<tr></tr>	
	<td style="width:10px"></td>
	<td><a href="achats_mat_cons.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Matieres Consomables</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="achats_tig.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Tiges</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="achats_pied_alu.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Pieds en Aluminium</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="achats_ins.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Inserts Decoration</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="achats_col.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Collorants</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="achats_emb.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Emballages Carton</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="achats_emb1.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Emballages Sachets</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="achats_emb2.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Emballages Divers</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="achats_eti.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etiquettes</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="achats_divers.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Divers</font>"); ?>]</a></td>
	</tr>	<tr></tr>	
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="achats_vides.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">MAJ DATES ACHATS</font>"); ?>]</a></td>
	</tr>	<tr></tr>	
	<td style="width:10px"></td>
	<td><a href="balance_achats.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Balance Achats</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="etat_bc_mps_tarifs.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Historique Tarif Achat</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<?php if($login == "admin" or $login=="driss") { ?>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="historique_achats_col.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Historique Achat Collorant</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? }?>
	<tr>
	<td style="width:10px"></td>
	<td><a href="etat_entrees_stock_mp.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Entrees Mat.P. </font>"); ?>]</a></td>
	</tr>
	<td style="width:10px"></td>
	<td><a href="balance_achats_types.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Balance Achats/Famille</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="balance_fournisseurs.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Balance Fournisseurs</font>"); ?>]</a></td>
	</tr>	<tr></tr>	
	<td style="width:10px"></td>
	<td><a href="registres_reglements_frs.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Regl. Fournisseurs</font>"); ?>]</a></td>
	</tr>	<tr></tr>	

	<? }?>
	<? }?>

		<? if($_REQUEST["type_c"]=="fact"){?>

	<?php if($tout == 1 or $menu5==1) { ?>
	<tr>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">FACTURATION </font>"); ?>]</td>
	</tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="factures2019.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Facturation </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="factures.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Facturation2018/2017 </font>"); ?>]</a></td>
	</tr>	<tr></tr>

	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="factures_backup.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Facturation 2016</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="edition_factures_backup.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Mise à jour Factures</font>"); ?>]</a></td>
	</tr>	
	
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="fiches_de_stocks_articles_par_mois.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Tableau_de_stocks_par_mois</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="fiches_de_productions_articles_par_mois.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Tableau_de_Productions_par_mois</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<?php if($login == "admin" ) { ?>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="maj_factures_global.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Details Factures</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="porte_feuilles_factures_up.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Indexer p</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="factures1.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Erreur Factures</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="factures2.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Backup Factures</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="fiches_de_stocks_articles_par_mois_instance.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Instance Fiche de Stock</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="mysql_to_csv1.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Exporter evaluations</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? }?>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="factures_instances.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Instances</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? if ($login=="admin"){?>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="factures_instances_2016.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Instances 2</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? }?>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="ca_par_quantite.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">CA en Quantités</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="ca_par_quantite_par_prix.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">CA en Quantités1</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="ca_par_matiere.php?type_c=<? echo $v;?>" target="_Blank" >[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Stock Final Matiere</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? if ($login=="admin"){?>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="ca_par_matiere_pdf.php?type_c=<? echo $v;?>" target="_Blank" >[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Stock Final Matiere pdf</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? }?>
	
		<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="produits_finis.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Stock Produits Finis</font>"); ?>]</a></td>
	</tr>	<tr></tr>
		<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="emballages_sachets_productions.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Consommation Sachets</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	<? if($login == "admin" or $login == "leila"){ ?>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="ca_par_matiere_methode2.php?type_c=<? echo $v;?>" target="_Blank" >[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Stock Final Matiere 2</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr>
	<td style="width:10px"></td>
	<td><a href="articles_en_productions.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Production articles </font>"); ?>]</a></td>
	</tr>
	<? }?>
	
	
<? if($login == "admin"){ ?>
<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="ca_par_matiere_premiere.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Fiche Stock Matiere</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="indexer_factures_matieres.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Indexation Matieres</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
<? }?>

	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="indexer_factures.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Indexation Factures</font>"); ?>]</a></td>
	</tr>	<tr></tr>

	
<? if($login == "admin"){ ?>

	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="journal_encaissements.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Indexation Porte feuilles</font>"); ?>]</a></td>
	</tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="indexation_effets_remis.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Indexation effets</font>"); ?>]</a></td>
	</tr>
	
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="indexation_dates.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Indexation dates</font>"); ?>]</a></td>
	</tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="encaissements_global_vendeur.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Enc / Vendeur</font>"); ?>]</a></td>
	</tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="encaissements_mois_factures.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Enc / Factures</font>"); ?>]</a></td>
	</tr>
	</tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="fiche_de_stock_article_pdf_global.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Fiches De Stock</font>"); ?>]</a></td>
	</tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="fiches_de_stocks_articles_matieres.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Fiches Techniques</font>"); ?>]</a></td>
	</tr>	
	<? }?>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="declaration_tva.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Edition Declaration TVA</font>"); ?>]</a></td>
	</tr>	<tr></tr>

	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="registres_tva.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Mise à jour TVA</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<?php if($login == "admin" or $login == "rakia" or $login == "najat" or $login == "radia") { ?>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="registres_tva_tableau.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Formule TVA</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	<? }?>

	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="ca_par_valeur.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">CA en Valeurs</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="entrees_stock_f.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Saisie Production</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="fiches_de_stocks_articles.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Fiches de Stock</font>"); ?>]</a></td>
	</tr>	
	</tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="fiche_de_stock_article_pdf_global.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Fiches De Stock Globales</font>"); ?>]</a></td>
	</tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="releves_factures.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Releves Factures</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	<?php if($login == "admin" ) { ?>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="releves_factures_majp.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Indexer PF</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="releves_factures_iks.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Releves Factures IKs</font>"); ?>]</a></td>
	</tr>	<tr></tr>
		<? } ?>
	
	<? } ?>
	<? } ?>
	
	<? if($_REQUEST["type_c"]=="paie"){?>
	<?php if($tout == 1 or $menu14==1) { ?>
	<tr>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">Paie Semaine</font>"); ?>]</td>
	</tr>
	<tr></tr>
	<?php if($login == "admin" or $login=="nabila") { ?>
	<td style="width:10px"></td>
	<td><a href="entrer_fichier_pointage.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Importer pointage </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="employes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Employes </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="employes_sortie.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Activer Employes </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="entrer_fichier_employes.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Importation Liste </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	
	
	
	<? if ($login=="admin"){?>
	<td style="width:10px"></td>
	<td><a href="cloture_paie_semaine.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Clôture Paie </font>"); ?>]</a></td>
	</tr>	<tr></tr>	
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="initialisation_pointage_employes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Initialisation Pointage </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? }?>
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="maj_pointage22.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat erreurs </font>"); ?>]</a></td>
	</tr>	<tr></tr>		
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="paie_ouvriers.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Journal Paie </font>"); ?>]</a></td>
	</tr>	<tr></tr>	
	
<? }?>

<?php if($login == "admin" ) { ?>	
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="retraits_avances_salaires.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Retraits / Occasionnels </font>"); ?>]</a></td>
	</tr>		
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="retraits_avances_salaires1.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Retraits / Permanents </font>"); ?>]</a></td>
	</tr>		
	<tr></tr>
<? }?>

<?php if($login == "admin" or $login=="rakia" or $login=="najat" or $login=="nabila" or $login=="driss" or $login=="rabie") { ?>	
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="fiches_employes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Fichier Employes </font>"); ?>]</a></td>
	</tr>
<? if ($login=="admin" or $login=="driss" or $login=="rakia" or $login=="rabie"){?>
	<td style="width:10px"></td>
	<td><a href="fiches_employes_globales.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Dossiers Salariés </font>"); ?>]</a></td>
	</tr>	<tr></tr>	
	<td style="width:10px"></td>
	<td><a href="fiches_employes_globales_cin.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">CIN EXPIREE </font>"); ?>]</a></td>
	</tr>	<tr></tr>	
	<? }?>	
	<?php if($login == "admin" or $login=="rakia" or $login=="leila" or $login=="rabie") { ?>
	<td style="width:10px"></td>
	<td><a href="fiche_employe_photo.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Photos </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? }?>
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="etat_heures_supp.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat Heures Supp </font>"); ?>]</a></td>
	</tr>	<tr></tr>		
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="etat_heures_occasionnels.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat H.N Occasionnels </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="etat_heures_occasionnels_sup.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat H.Sup Occasionnels </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="etat_heures_permanents.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat Permanents </font>"); ?>]</a></td>
	</tr>	<tr></tr>	
	<? }?>
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="employes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste Employes </font>"); ?>]</a></td>
	</tr>	<tr></tr>	
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="maj_pointage2.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Controle pointage </font>"); ?>]</a></td>
	</tr>	<tr></tr>

	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="carte_pointage.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Cartes De Pointage</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="etat_pointage_globale.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat De Pointage </font>"); ?>]</a></td>
	</tr>	<tr></tr>	
	<? if($login == "admin" or $login=="rakia" or $login=="najat" or $login=="leila"){?>	
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="avances_salaires.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Avances / Salaires </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="avances_salaires_soldes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Avances / Salaires / Soldées </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="etat_avances_employes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat Avances / Salaires </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="etat_retraits_employes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat Retraits / Salaires </font>"); ?>]</a></td>
	</tr>	<tr></tr>
		
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="paie_ouvriers.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Journal Paie </font>"); ?>]</a></td>
	</tr>	<tr></tr>	
	
	<? }?>
		<? if($login == "admin"){?>
	<tr>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">Paie Mensuels </font>"); ?>]</td>
	</tr>
	<td style="width:10px"></td>
	<td><a href="entrer_fichier_pointage_mensuel.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Importer pointage  </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="indexation_pointage_mensuel.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Indexation Pointage  </font>"); ?>]</a></td>
	</tr>	<tr></tr>	
	<tr></tr>
	<td style="width:10px"></td>
	<td><a href="initialisation_pointage_employes.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Initialisation Pointage </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="etat_pointage_mensuel.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat De Pointage </font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="employes_m.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Liste employes </font>"); ?>]</a></td>
	</tr>	
		
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="etat_pointage_globale_cloture.php" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Recherche Pointage </font>"); ?>]</a></td>
	</tr>	<tr></tr>		
<? }?>		
	<?
	}
	}
	
	?>
	
		<? if($_REQUEST["type_c"]=="encs"){?>

	<?php if($tout == 1 or $menu7==1) { ?>
	<tr>
	<td style="width:10px"></td>
	<td>[<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"#FF3300\">ENCAISSEMENT </font>"); ?>]</td>
	</tr>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="registres_reglements.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Saisie Reglements</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	<? if($login == "admin" or $login == "najat" or $login == "rakia") {?>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="comptes_vendeurs.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Situation Vendeurs</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? }?>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="saisie_reglements.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Saisie Reglements 2</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="encaissements_global_v.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat des Encaissements</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? if($login == "admin" ){?>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="encaissements_global.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Indexer Encaissements</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? }?>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="encaissements_mois_factures_global.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat Enc à Facturer</font>"); ?>]</a></td>
	</tr>
		</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="encaissements_mois_factures.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Validation Enc/Factures</font>"); ?>]</a></td>
	</tr>
	
	<? if($login == "admin" or $login == "rakia") {?>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="registres_reglements_debours.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat Depenses/Enc</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<? }?>
	
	
	
	
	
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
	<td><a href="journal_encaissements_effets.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat Entree Effets</font>"); ?>]</a></td>
	</tr>	<tr></tr>	
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="porte_feuilles_factures.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Porte Feuilles Cheques</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="porte_feuilles_effets.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Porte Feuilles Effets</font>"); ?>]</a></td>
	</tr>	<tr></tr>	
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="indexation_effets_remis.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Indexation effets</font>"); ?>]</a></td>
	</tr>
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
	<td><a href="encaissements_mois_effet.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat effets Echus</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="etat_effets_encaisses_mois.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Effets Non Echus du Mois</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="etat_effets_escompte_mois.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Effets Remis à L'escompte</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="etat_effets_encaisses.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Effets Non Echus Globale</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="effets_echeances_hors_exercices.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Effets Echeance Hors Exe</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="encaissements_mois_virement.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat des virements</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="etat_effets.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat des Effets</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="etat_effets_globale.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat des Effets globale</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="encaissements_mois_esp.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Encaissements Esp</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="encaissements_global_v.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Encaissements Global</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="balance_com_net3.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Commission/Encais/Eval</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="balance_com_net3_f.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Commission/Encais/Fact</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="balance_com_net3_fe.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Commission/Encais/Global</font>"); ?>]</a></td>
	</tr>	<tr></tr>

<? if($login == "admin") {?>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="evaluations_client_encompte.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Encompte clients</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="etat_client_encompte.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Etat Encompte clients</font>"); ?>]</a></td>
	</tr>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="releves_encaiss_cheques_com.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Commission/Encompte</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="releves_factures_com.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Commission/Facturation</font>"); ?>]</a></td>
	</tr>
<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="etat_effets_globale_escompte.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Effets remis à l'escompte</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	
	<? }?>
	
	
	<? if($login == "admin" or $login == "rakia") {?>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="encaissements_especes_mois_encours.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Enc espece/mois encours</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="encaissements_especes_encompte.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Enc espece/encompte</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="encaissements_cheques_mois_encours.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Enc cheques/mois encours</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="encaissements_cheques_encompte.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Enc cheques/encompte</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<td style="width:10px"></td><? $v="ventes";?>
	<td><a href="balance_com_net3_fe.php?type_c=<? echo $v;?>" target="middle_frame">[<?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"#0000FF\">Commission/Encais/Global</font>"); ?>]</a></td>
	</tr>	<tr></tr>
	<?php } ?>
	<?php } ?>
	<?php } ?>
	<?php } ?>
	</table>
	
<? } else {?>
    <table class="table2">
    <form id="form1" name="form1" method="post" action="echeancier_mps.php" target="middle_frame">
	<tr><td align="center"><input type="submit" id="echancier" name="echancier" value="ECHEANCIER "  style="font-size:18px"></td></tr>
    </form>
    <form id="form2" name="form2" method="post" action="porte_feuilles_factures.php" target="middle_frame">
	<tr><td align="center"><input type="submit" id="Porte_feuille_f" name="Porte_feuille_f" value="PORTE FEUILLE"  style="font-size:18px"></td></tr>
    </form>    

    <form id="form3" name="form3" method="post" action="evaluations_client_globale1.php" target="middle_frame">
	<tr><td align="center"><input type="submit" id="ventes" name="ventes" value="VENTES PAR JOUR " style="font-size:18px"></td></tr>
    </form>   
	
    <form id="form4" name="form4" method="post" action="palmares_vendeurs.php" target="middle_frame">
	<tr><td align="center"><input type="submit" id="ventes" name="ventes" value="CUMUL VENTES " style="font-size:18px"></td></tr>
    </form>   

    <form id="form5" name="form5" method="post" action="balance_evaluations_comparatif.php" target="middle_frame">
	<tr><td align="center"><input type="submit" id="ventes" name="ventes" value="COMPARATIF / VENDEURS"  style="font-size:18px"></td></tr>
    </form>

    <form id="form6" name="form6" method="post" action="registres_remises_impayes.php" target="middle_frame">
	<tr><td align="center"><input type="submit" id="ventes" name="ventes" value="CHEQUES IMPAYES" style="font-size:18px"></td></tr>
    </form> 

    <form id="form7" name="form7" method="post" action="etat_enc_impayes.php" target="middle_frame">
	<tr><td align="center"><input type="submit" id="ventes" name="ventes" value="ENC CHEQUES IMPAYES"  style="font-size:18px"></td></tr>
    </form>
    <form id="form7" name="form7" method="post" action="journal_encaissements_chq.php" target="middle_frame">
	<tr><td align="center"><input type="submit" id="ventes" name="ventes" value="ENTREE CHEQUES"  style="font-size:18px"></td></tr>
    </form>
    <form id="form8" name="form8" method="post" action="registres_vendeurs.php" target="middle_frame">
	<tr><td align="center"><input type="submit" id="ventes" name="ventes" value="EVALUATION VENDEURS"  style="font-size:18px"></td></tr>
    </form>
    <form id="form9" name="form9" method="post" action="edition_factures.php" target="middle_frame">
	<tr><td align="center"><input type="submit" id="ventes" name="ventes" value="FACTURATION"  style="font-size:18px"></td></tr>
    </form>
    <form id="form10" name="form10" method="post" action="registres_remises1.php" target="middle_frame">
	<tr><td align="center"><input type="submit" id="ventes" name="ventes" value="REMISES BANQUE"  style="font-size:18px"></td></tr>
    </form>
	<form id="form11" name="form11" method="post" action="balance_caisses.php" target="middle_frame">
	<tr><td align="center"><input type="submit" id="ventes" name="ventes" value="BALANCE CAISSES"  style="font-size:18px"></td></tr>
    </form>
	<form id="form12" name="form12" method="post" action="journal_caisses.php" target="middle_frame">
	<tr><td align="center"><input type="submit" id="ventes" name="ventes" value="JOURNAL CAISSES"  style="font-size:18px"></td></tr>
    </form>
	<form id="form13" name="form13" method="post" action="balance_fournisseurs.php" target="middle_frame">
	<tr><td align="center"><input type="submit" id="ventes" name="ventes" value="SITUATION FOURNISSEURS"  style="font-size:18px"></td></tr>
    </form>
	<form id="form14" name="form14" method="post" action="productions1.php" target="middle_frame">
	<tr><td align="center"><input type="submit" id="ventes" name="ventes" value="PRODUCTION MPS"  style="font-size:18px"></td></tr>
    </form>
	</table>

<? }?>	


	


</center>

<script type="text/javascript"><!--
document.getElementById("search_end_hour").value = <?php echo $default_end_hour; ?>;
document.getElementById("screen_width").value = screen.width;
document.getElementById("screen_height").value = screen.height;
--></script>

</body>

</html>