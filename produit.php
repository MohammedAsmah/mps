<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];
	$user_id = $_REQUEST["user_id"];$qte_tige1=0;
				$sql = "TRUNCATE TABLE `fiche_stock`  ;";
			db_query($database_name, $sql);


	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Produit";

		$produit = "";$favoris = 0;$non_favoris = 0;$colorant="";$qte_colorant=0;$dispo=0;$palmares1=0;$designation="";$barecode="";$dispo_stock=0;
		$condit = "";$poids_evaluation="";
		$non_disponible="";$seuil_critique=0;$type="";$stock_controle="";$prix_rechange=0;
		$accessoire_1="";$qte_ac_1="";$poids_ac_1="";$mat_ac_1="";$equipes="";
		$accessoire_2="";$qte_ac_2="";$poids_ac_2="";$mat_ac_2="";
		$accessoire_3="";$qte_ac_3="";$poids_ac_3="";$mat_ac_3="";$famille="";$type="";$r1=0;$r2=0;$r3=0;$avec_remise=0;
		$marron=0;$beige=0;$gris=0;$couleurs=0;$prix2=0;
		$prix = "";$en_cours_final=0;$prix_revient_final=0;$production=0;$stock_ini_exe=0;$dispo_f=0;
		$poids = "";$stock_initial = 0;$encours = 0;$stock_final = 0;$prix_revient =0;$stockable=0;
		$tige="";$qte_tige=1;$emballage="";$qte_emballage=1;$matiere="";$qte_matiere=1;$etiquette="";$qte_etiquette=1;
		$accessoire_4="";$qte_ac_4="";$accessoire_5="";$qte_ac_5="";$accessoire_6="";$qte_ac_6="";$date_dispo="";$categorie="";
		$acc1=0;$acc2=0;$acc3=0;$acc4=0;$acc5=0;$acc6=0;$dispo_g=0;$tarif_base=0;$fictif=0;$palette=0;$asswak=0;$designation_client = "";$barecode_piece = "";
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$non_disponible=$user_["non_disponible"];$seuil_critique=$user_["seuil_critique"];$prix_rechange=$user_["prix_rechange"];$palmares1=$user_["palmares1"];$designation=$user_["designation"];
		$accessoire_1=$user_["accessoire_1"];$qte_ac_1=$user_["qte_ac_1"];$stockable=$user_["stockable"];$barecode=$user_["barecode"];$palette=$user_["palette"];
		$accessoire_2=$user_["accessoire_2"];$qte_ac_2=$user_["qte_ac_2"];
		$accessoire_3=$user_["accessoire_3"];$qte_ac_3=$user_["qte_ac_3"];$equipes=$user_["equipes"];$date_dispo=dateUsToFr($user_["date_dispo"]);$date_dispo_f=dateUsToFr($user_["date_dispo_f"]);
		$marron=$user_["p_marron"];$beige=$user_["p_beige"];$gris=$user_["p_gris"];$couleurs=$user_["couleurs"];$tarif_base=$user_["tarif_base"];
		$accessoire_4=$user_["accessoire_4"];$qte_ac_4=$user_["qte_ac_4"];$categorie=$user_["categorie"];
		$accessoire_5=$user_["accessoire_5"];$qte_ac_5=$user_["qte_ac_5"];
		$accessoire_6=$user_["accessoire_6"];$qte_ac_6=$user_["qte_ac_6"];
		$stock_comptable=$user_["stock_comptable"];$prix2 = $user_["prix2"];$dispo_stock = $user_["dispo_stock"];
		$acc1=$user_["acc1"];$acc2=$user_["acc2"];$acc3=$user_["acc3"];$acc4=$user_["acc4"];$acc5=$user_["acc5"];$acc6=$user_["acc6"];
		$title = "details";$poids_evaluation=$user_["poids_evaluation"];$famille=$user_["famille"];$dispo_f=$user_["dispo_f"];
		$stock_ini_exe = $user_["stock_ini_exe"];$type = $user_["type"];$stock_controle = $user_["stock_controle"];$stock_ini_exe_jp = $user_["stock_initial_jp"];
		$produit = $user_["produit"];$colorant = $user_["colorant"];$dispo = $user_["dispo"];$production=0;$production1 = $user_["production"];
		$condit = $user_["condit"];$qte_colorant=$user_["qte_colorant"];$prix_revient_final = $user_["prix_revient_final"];$en_cours_final = $user_["en_cours_final"];
		$prix = $user_["prix"];$favoris = $user_["favoris"];$non_favoris = $user_["non_favoris"];$encours = $user_["encours"];
		$poids = $user_["poids"];$stock_initial = $user_["stock_ini_exe"];$stock_final = $user_["stock_final"];$prix_revient = $user_["prix_revient"];$designation_client = $user_["designation_client"];
		$tige=$user_["tige"];$qte_tige=$user_["qte_tige"];$emballage=$user_["emballage"];$qte_emballage=$user_["qte_emballage"];$asswak=$user_["asswak"];$barecode_piece = $user_["barecode_piece"];
		$matiere=$user_["matiere"];$qte_matiere=$user_["qte_matiere"];$etiquette=$user_["etiquette"];$qte_etiquette=$user_["qte_etiquette"];
		$r1=$user_["r1"];$r2=$user_["r2"];$r3=$user_["r3"];$avec_remise=$user_["avec_remise"];$dispo_g=$user_["dispo_g"];$couvercle=$user_["couvercle"];$fictif=$user_["fictif"];	$enproduction=$user_["enproduction"];	
			
	}
	
	$profiles_list_type = "";
	$sql1 = "SELECT * FROM types_articles ORDER BY profile_name;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($type == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_type .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$profiles_list_type .= $temp_["profile_name"];
		$profiles_list_type .= "</OPTION>";
	}
	$profiles_list_famille = "";
	$sql1 = "SELECT * FROM familles_articles ORDER BY profile_name;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($famille == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
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

	$profiles_list_accessoire_1 = "";$acc="Accessoire";
	$sql3 = "SELECT * FROM produits where famille='$acc' ORDER BY produit;";
	$temp = db_query($database_name, $sql3);
	while($temp_ = fetch_array($temp)) {
		if($accessoire_1 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_accessoire_1 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_accessoire_1 .= $temp_["produit"];
		$profiles_list_accessoire_1 .= "</OPTION>";
	}
	$profiles_list_accessoire_2 = "";
	$sql3 = "SELECT * FROM produits where famille='$acc' ORDER BY produit;";
	$temp = db_query($database_name, $sql3);
	while($temp_ = fetch_array($temp)) {
		if($accessoire_2 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_accessoire_2 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_accessoire_2 .= $temp_["produit"];
		$profiles_list_accessoire_2 .= "</OPTION>";
	}
	$profiles_list_accessoire_3 = "";$acc="Accessoire";
	$sql3 = "SELECT * FROM produits where famille='$acc' ORDER BY produit;";
	$temp = db_query($database_name, $sql3);
	while($temp_ = fetch_array($temp)) {
		if($accessoire_3 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_accessoire_3 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_accessoire_3 .= $temp_["produit"];
		$profiles_list_accessoire_3 .= "</OPTION>";
	}

	$profiles_list_accessoire_4 = "";$acc="Accessoire";
	$sql4 = "SELECT * FROM produits where famille='$acc' ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($accessoire_4 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_accessoire_4 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_accessoire_4 .= $temp_["produit"];
		$profiles_list_accessoire_4 .= "</OPTION>";
	}
	
	$profiles_list_accessoire_5 = "";$acc="Accessoire";
	$sql5 = "SELECT * FROM produits where famille='$acc' ORDER BY produit;";
	$temp = db_query($database_name, $sql5);
	while($temp_ = fetch_array($temp)) {
		if($accessoire_5 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_accessoire_5 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_accessoire_5 .= $temp_["produit"];
		$profiles_list_accessoire_5 .= "</OPTION>";
	}
	
	$profiles_list_accessoire_6 = "";$acc="Accessoire";
	$sql6 = "SELECT * FROM produits where famille='$acc' ORDER BY produit;";
	$temp = db_query($database_name, $sql6);
	while($temp_ = fetch_array($temp)) {
		if($accessoire_6 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_accessoire_6 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_accessoire_6 .= $temp_["produit"];
		$profiles_list_accessoire_6 .= "</OPTION>";
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

	$profiles_list_categorie = "";
	$sql4 = "SELECT * FROM categories_articles ORDER BY categorie;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($categorie == $temp_["categorie"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_categorie .= "<OPTION VALUE=\"" . $temp_["categorie"] . "\"" . $selected . ">";
		$profiles_list_categorie .= $temp_["categorie"];
		$profiles_list_categorie .= "</OPTION>";
	}
	
	// extracts profile list

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
<? require "head_cal.php";?>
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
<? require "body_cal.php";?>
<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="produits.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table width="671" class="table3">

		<tr>
		<td><?php echo "Designation"; ?></td><td><input type="text" id="produit" name="produit" style="width:260px" value="<?php echo $produit; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Barecode"; ?></td><td><input type="text" id="barecode" name="barecode" style="width:260px" value="<?php echo $barecode; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Libelle"; ?></td><td><input type="text" id="designation" name="designation" style="width:260px" value="<?php echo $designation; ?>"></td>
		</tr>
        </td>
		<tr>
		<td><?php echo "Famille : "; ?></td><td><select id="famille" name="famille"><?php echo $profiles_list_famille; ?></select></td>
		</tr>
        <tr>
		<td><?php echo "Conditionnement"; ?></td><td><input type="text" id="condit" name="condit" style="width:240px" value="<?php echo $condit; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Palette"; ?></td><td><input type="text" id="palette" name="palette" style="width:240px" value="<?php echo $palette; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Tarif 1 : "; ?></td><td><input type="text" id="prix" name="prix" style="width:140px" value="<?php echo $prix; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Tarif 2 : "; ?></td><td><input type="text" id="prix2" name="prix2" style="width:140px" value="<?php echo $prix2; ?>"></td>
		</tr>
				
		<tr>
		<td bgcolor="#66CCCC"><?php echo "1ere Remise"; ?></td><td><input type="text" id="r1" name="r1" style="width:140px" value="<?php echo $r1; ?>"></td>
		</tr>
		
		<tr>
		<td bgcolor="#66CCCC"><?php echo "2eme Remise"; ?></td><td><input type="text" id="r2" name="r2" style="width:140px" value="<?php echo $r2; ?>"></td>
		</tr>
		
		<tr>
		<td bgcolor="#66CCCC"><?php echo "3eme Remise"; ?></td><td><input type="text" id="r3" name="r3" style="width:140px" value="<?php echo $r3; ?>"></td>
		</tr>
		
		<tr>
		<td bgcolor="#66CCCC"><?php echo "Prix net"; ?></td><td><?php $p1=$prix*$r1/100;$p2=($prix-$p1)*$r2/100;$p3=($prix-$p1-$p2)*$r3/100;$p=$prix-$p1-$p2-$p3;echo number_format($p,2,',',' '); ?></td>
		</tr>
		
		
		<tr>
		<td><?php echo "Stock Alarme"; ?></td><td><input type="text" id="seuil_critique" name="seuil_critique" style="width:80px" value="<?php echo $seuil_critique; ?>"></td>
		</tr>
		
		</tr><tr>
		<td><?php echo ""; ?></td><td><input type="text" id="stock_ini_exe" name="stock_ini_exe" style="width:140px" value="<?php echo $stock_ini_exe; ?>"></td>
		<tr>
		<td><?php echo "Nombre Equipes"; ?></td><td><input type="text" id="equipes" name="equipes" style="width:80px" value="<?php echo $equipes; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Stock Comptable"; ?></td><td><input type="text" id="stock_comptable" name="stock_comptable" style="width:80px" value="<?php echo $stock_comptable; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Stock Initial mps"; ?></td><td><input type="text" id="stock_ini_exe" name="stock_ini_exe" style="width:80px" value="<?php echo $stock_ini_exe; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Stock Initial jp"; ?></td><td><input type="text" id="stock_ini_exe_jp" name="stock_ini_exe_jp" style="width:80px" value="<?php echo $stock_ini_exe_jp; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Prix Unit Asswak"; ?></td><td><input type="text" id="asswak" name="asswak" style="width:80px" value="<?php echo $asswak; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Designation Asswak"; ?></td><td><input type="text" id="designation_client" name="designation_client" style="width:180px" value="<?php echo $designation_client; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "BarceCode Piece"; ?></td><td><input type="text" id="barecode_piece" name="barecode_piece" style="width:180px" value="<?php echo $barecode_piece; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Categorie : "; ?></td><td><select id="categorie" name="categorie"><?php echo $profiles_list_categorie; ?></select></td>
		</tr>
		
		</tr>	

		<tr>
		<td><?php echo "Prix Rechange"; ?></td><td><input type="text" id="prix_rechange" name="prix_rechange" style="width:140px" value="<?php echo $prix_rechange; ?>"></td>
		</tr>
		
		<tr>
		<td><?php echo "Prix Base"; ?></td><td><input type="text" id="tarif_base" name="tarif_base" style="width:140px" value="<?php echo $tarif_base; ?>"></td>
		</tr>
		
		<tr><td><input type="checkbox" id="couleurs" name="couleurs"<?php if($couleurs) { echo " checked"; } ?>></td><td>Stock en Couleurs</td>
		<tr>
		<td><?php echo " % Marron"; ?></td><td><input type="text" id="marron" name="marron" style="width:40px" value="<?php echo $marron; ?>"></td>
		</tr>
		<tr>
		<td><?php echo " % Beige"; ?></td><td><input type="text" id="beige" name="beige" style="width:40px" value="<?php echo $beige; ?>"></td>
		</tr>
		<tr>
		<td><?php echo " % Gris"; ?></td><td><input type="text" id="gris" name="gris" style="width:40px" value="<?php echo $gris; ?>"></td>
		</tr>
		
		<tr><td><input type="checkbox" id="couvercle" name="couvercle"<?php if($couvercle) { echo " checked"; } ?>></td><td>Couvercle</td>		
		<tr><td><input type="checkbox" id="dispo" name="dispo"<?php if($dispo) { echo " checked"; } ?>></td><td>Article disponible</td>
		<tr><td><input type="checkbox" id="dispo_stock" name="dispo_stock"<?php if($dispo_stock) { echo " checked"; } ?>></td><td>Article en Stock</td>
		<tr><td><?php echo "Date Dispo: "; ?><input onClick="ds_sh(this);" name="date_dispo" value="<?php echo $date_dispo; ?>" readonly="readonly" style="cursor: text" /></td>
		
		<tr><td><input type="checkbox" id="dispo_f" name="dispo_f"<?php if($dispo_f) { echo " checked"; } ?>></td><td>Article disponible / F  <input onClick="ds_sh(this);" name="date_dispo_f" value="<?php echo $date_dispo_f; ?>" readonly="readonly" style="cursor: text" /></td>
		
		<tr><td><input type="checkbox" id="dispo_g" name="dispo_g"<?php if($dispo_g) { echo " checked"; } ?>></td><td>Article disponible / G</td>
		<tr><td><input type="checkbox" id="palmares1" name="palmares1"<?php if($palmares1) { echo " checked"; } ?>></td><td>Article p</td>
		<tr><td><input type="checkbox" id="enproduction" name="enproduction"<?php if($enproduction) { echo " checked"; } ?>></td><td>en production</td>
		<tr><td><input type="checkbox" id="stockable" name="stockable"<?php if($stockable) { echo " checked"; } ?>></td><td>stockable</td>
		<tr><td><input type="checkbox" id="fictif" name="fictif"<?php if($fictif) { echo " checked"; } ?>></td><td>fictif</td>

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

<table width="671" class="table3">

<?		$sqlp  = "SELECT produit,prix_unit,condit ";
	$sqlp .= "FROM detail_commandes where produit='$produit' group by prix_unit ORDER BY prix_unit;";
	$usersp = db_query($database_name, $sqlp);
	while($users_p = fetch_array($usersp)) { 
				$produit=$users_p["produit"];$prix_unit=$users_p["prix_unit"];$condit=$users_p["condit"];
				
				?>
				<tr>
				<td><?php echo $prix_unit; ?></td>
				</tr>
				<?
						
				
				}
		
?>


</table>



</body>

</html>