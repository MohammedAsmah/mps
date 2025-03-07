<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$qte_tige1=0;

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";$bon="";$date="";$qte=0;

		$produit = "";
		$produit = "";$depot_a="";$produit1 = "";$depot_a1="";$produit2 = "";$depot_a2="";$produit3 = "";$depot_a3="";
		$produit4 = "";$depot_a4="";$produit5 = "";$depot_a5="";$produit6 = "";$depot_a6="";$produit7 = "";$depot_a7="";
		$date="";$qte=0;$depot_b=0;$depot_c=0;$produit8 = "";$depot_a8="";$produit9 = "";$depot_a9="";
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM entrees_stock WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$produit = $user_["produit"];$qte = $user_["qte"];$date = dateUsToFr($user_["date"]);$bon = $user_["ref"];
		$depot_a = $user_["depot_a"];$depot_b = $user_["depot_b"];$depot_c = $user_["depot_c"];
		$marron = $user_["marron"];$beige = $user_["beige"];$gris = $user_["gris"];
		$marron_b = $user_["marron_b"];$beige_b = $user_["beige_b"];$gris_b = $user_["gris_b"];
		
	}
	$profiles_list_article = "";
	$sql4 = "SELECT * FROM produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article .= $temp_["produit"];
		$profiles_list_article .= "</OPTION>";
	}
	if($user_id == "0") {
	$profiles_list_article1 = "";
	$sql41 = "SELECT * FROM produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit1 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article1 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article1 .= $temp_["produit"];
		$profiles_list_article1 .= "</OPTION>";
	}
	$profiles_list_article2 = "";
	$sql42 = "SELECT * FROM produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit2 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article2 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article2 .= $temp_["produit"];
		$profiles_list_article2 .= "</OPTION>";
	}
	$profiles_list_article3 = "";
	$sql43 = "SELECT * FROM produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit3 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article3 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article3 .= $temp_["produit"];
		$profiles_list_article3 .= "</OPTION>";
	}
	$profiles_list_article4 = "";
	$sql44 = "SELECT * FROM produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit4 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article4 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article4 .= $temp_["produit"];
		$profiles_list_article4 .= "</OPTION>";
	}
	$profiles_list_article5 = "";
	$sql45 = "SELECT * FROM produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit5 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article5 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article5 .= $temp_["produit"];
		$profiles_list_article5 .= "</OPTION>";
	}
	$profiles_list_article6 = "";
	$sql46 = "SELECT * FROM produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit6 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article6 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article6 .= $temp_["produit"];
		$profiles_list_article6 .= "</OPTION>";
	}
	$profiles_list_article7 = "";
	$sql47 = "SELECT * FROM produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit7 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article7 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article7 .= $temp_["produit"];
		$profiles_list_article7 .= "</OPTION>";
	}
	$profiles_list_article8 = "";
	$sql48 = "SELECT * FROM produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit8 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article8 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article8 .= $temp_["produit"];
		$profiles_list_article8 .= "</OPTION>";
	}
	$profiles_list_article9 = "";
	$sql49 = "SELECT * FROM produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit9 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article9 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article9 .= $temp_["produit"];
		$profiles_list_article9 .= "</OPTION>";
	}
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
			document.location = "entrees_stock_a_vers_b.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<span style="font-size:24px"><?php echo "MPS ======>JAOUDA"; ?></span>

<form id="form_user" name="form_user" method="post" action="entrees_stock_a_vers_b.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table width="671" class="table3">

		<tr>
		<td><?php echo "Date : "; ?><input onClick="ds_sh(this);" name="date" value="<?php echo $date; ?>" readonly="readonly" style="cursor: text" /></td>
		</tr>
		<tr>
		<td bgcolor="#33CCCC"><?php echo "Bon de Sortie Magasin"; ?></td><td><input type="text" id="bon" name="bon" style="width:140px" value="<?php echo $bon; ?>"></td>
		</tr>
		<tr>
		
		
		<tr><td><?php echo "Article : "; ?></td>
		</td><td><?php echo "Quantite"; ?></td>
		</td><td><?php echo "Marron"; ?></td>
		</td><td><?php echo "Beige"; ?></td>
		</td><td><?php echo "Gris"; ?></td>
		</tr>

		<tr><td><select id="produit" name="produit"><?php echo $profiles_list_article; ?></select></td>
		<td><input type="text" id="depot_a" name="depot_a" style="width:140px" value="<?php echo $depot_a; ?>"></td>
		<? if($user_id <> "0") {?>
		<td><input type="text" id="marron" name="marron" style="width:140px" value="<?php echo $marron; ?>"></td>
		<td><input type="text" id="beige" name="beige" style="width:140px" value="<?php echo $beige; ?>"></td>
		<td><input type="text" id="gris" name="gris" style="width:140px" value="<?php echo $gris; ?>"></td>
			<? }?>
		
		</tr>
		<? if($user_id == "0") {?>

		<tr><td><select id="produit1" name="produit1"><?php echo $profiles_list_article1; ?></select></td>
		<td><input type="text" id="depot_a1" name="depot_a1" style="width:140px" value="<?php echo $depot_a1; ?>"></td>
		</tr>
		<tr><td><select id="produit2" name="produit2"><?php echo $profiles_list_article2; ?></select></td>
		<td><input type="text" id="depot_a2" name="depot_a2" style="width:140px" value="<?php echo $depot_a2; ?>"></td>
		</tr>
		<tr><td><select id="produit3" name="produit3"><?php echo $profiles_list_article3; ?></select></td>
		<td><input type="text" id="depot_a3" name="depot_a3" style="width:140px" value="<?php echo $depot_a3; ?>"></td>
		</tr>
		<tr><td><select id="produit4" name="produit4"><?php echo $profiles_list_article4; ?></select></td>
		<td><input type="text" id="depot_a4" name="depot_a4" style="width:140px" value="<?php echo $depot_a4; ?>"></td>
		</tr>
		<tr><td><select id="produit5" name="produit5"><?php echo $profiles_list_article5; ?></select></td>
		<td><input type="text" id="depot_a5" name="depot_a5" style="width:140px" value="<?php echo $depot_a5; ?>"></td>
		</tr>
		<tr><td><select id="produit6" name="produit6"><?php echo $profiles_list_article6; ?></select></td>
		<td><input type="text" id="depot_a6" name="depot_a6" style="width:140px" value="<?php echo $depot_a6; ?>"></td>
		</tr>
		<tr><td><select id="produit7" name="produit7"><?php echo $profiles_list_article7; ?></select></td>
		<td><input type="text" id="depot_a7" name="depot_a7" style="width:140px" value="<?php echo $depot_a7; ?>"></td>
		</tr>
		<tr><td><select id="produit8" name="produit8"><?php echo $profiles_list_article8; ?></select></td>
		<td><input type="text" id="depot_a8" name="depot_a8" style="width:140px" value="<?php echo $depot_a8; ?>"></td>
		</tr>
		<tr><td><select id="produit9" name="produit9"><?php echo $profiles_list_article9; ?></select></td>
		<td><input type="text" id="depot_a9" name="depot_a9" style="width:140px" value="<?php echo $depot_a9; ?>"></td>
		</tr>
		<? }?>
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