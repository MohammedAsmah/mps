<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$qte_tige1=0;

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$produit = "";$pttt=0;
		$date="";$qte=0;$prix=0;$ref="";$frs="";$taux_tva=20;$ht=0;$importation=0;
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM achats_mat WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$produit = $user_["produit"];$qte = $user_["qte"];$date = dateUsToFr($user_["date"]);$prix = $user_["prix_achat"];$importation = $user_["importation"];
		$frs=$user_["frs"];$ref=$user_["ref"];$taux_tva=$user_["ttc"];$pttt=$user_["pttt"];$ht=$user_["ht"];
	}
	$profiles_list_article = "";
	$sql4 = "SELECT * FROM types_matieres ORDER BY profile_name;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$profiles_list_article .= $temp_["profile_name"];
		$profiles_list_article .= "</OPTION>";
	}
	
	$profiles_list_frs = "";
	$sql4 = "SELECT * FROM rs_data_fournisseurs where profile_id=1 ORDER BY last_name;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($frs == $temp_["last_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_frs .= "<OPTION VALUE=\"" . $temp_["last_name"] . "\"" . $selected . ">";
		$profiles_list_frs .= $temp_["last_name"];
		$profiles_list_frs .= "</OPTION>";
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
			document.location = "achats_mat.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="achats_mat.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table width="671" class="table3">

		<tr>
		<td><?php echo "Date"; ?></td><td><input type="text" id="date" name="date" style="width:160px" value="<?php echo $date; ?>"></td>
		</tr><tr>
		
		
		<tr><td><?php echo "Matiere : "; ?></td><td><select id="produit" name="produit"><?php echo $profiles_list_article; ?></select>
		</td>
		</tr>

		<tr>
		<td bgcolor="#33CCCC"><?php echo "Quantitte"; ?></td><td><input type="text" id="qte" name="qte" style="width:140px" value="<?php echo $qte; ?>"></td>
		</tr>
		<tr>
		<td bgcolor="#33CCCC"><?php echo "Prix Unit H.T"; ?></td><td><input type="text" id="prix" name="prix" style="width:140px" value="<?php echo $prix; ?>"></td>
		</tr>
		<tr>
		<td bgcolor="#33CCCC"><?php echo "Total H.T :"; ?></td><td><input type="text" id="ht" name="ht" style="width:140px" value="<?php echo $ht; ?>"></td>
		</tr>
		<tr>
		<td bgcolor="#33CCCC"><?php echo "Total TTC :"; ?></td><td><input type="text" id="taux_tva" name="taux_tva" style="width:140px" value="<?php echo $taux_tva; ?>"></td>
		</tr>
		<tr><td><?php echo "Importation"; ?></td><td><input type="checkbox" id="importation" name="importation"<?php if($importation) { echo " checked"; } ?>>		
        </td>
		
		<tr><td><?php echo "Prix TTC"; ?></td><td><input type="checkbox" id="pttt" name="pttt"<?php if($pttt) { echo " checked"; } ?>>		
        </td>
		<tr><td><?php echo "Fournisseur : "; ?></td><td><select id="frs" name="frs"><?php echo $profiles_list_frs; ?></select>
		</td>
		</tr>
		<tr>
		<td bgcolor="#33CCCC"><?php echo "BL/FACT/BON.Entree"; ?></td><td><input type="text" id="ref" name="ref" style="width:140px" value="<?php echo $ref; ?>"></td>
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