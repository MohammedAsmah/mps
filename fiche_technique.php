<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$id_produit = $_REQUEST["id_produit"];$produit = $_REQUEST["produit"];$categorie = $_REQUEST["categorie"];

	if($user_id == "0") {

		$action = "insert_new_user";

		$title = "";

		$accessoire = "";$qte="";$matiere="";$last_name = "";$emb_separe=0;$poids=0;$homo="";$copo="";$mlv="";$mrb="";$charge="";$homos="";
	
	} else {

		$action = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM fiches_techniques WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "";

		$accessoire = $user_["accessoire"];$qte=$user_["qte"];$matiere=$user_["matiere"];$emb_separe=$user_["emb_separe"];
		$poids=$user_["poids"];$homo=$user_["homo"];$copo=$user_["copo"];$mlv=$user_["mlv"];$mrb=$user_["mrb"];$charge=$user_["charge"];$homos=$user_["homos"];
	}

	$profiles_list_accessoire = "";$acc="accessoire";
	$sql4 = "SELECT * FROM produits ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($accessoire == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_accessoire .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_accessoire .= $temp_["produit"];
		$profiles_list_accessoire .= "</OPTION>";
	}
	$profiles_list_matiere = "";
	$sql5 = "SELECT * FROM types_matieres ORDER BY profile_name;";
	$temp = db_query($database_name, $sql5);
	while($temp_ = fetch_array($temp)) {
		if($matiere == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_matiere .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$profiles_list_matiere .= $temp_["profile_name"];
		$profiles_list_matiere .= "</OPTION>";
	}
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
		if(document.getElementById("accessoire").value == "" ) {
			alert("<?php echo "valeurs required !"; ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "fiches_techniques.php?action=delete_user&categorie=<?php echo $_REQUEST["categorie"]; ?>&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="fiches_techniques.php">

<table class="table2">

<tr><td style="text-align:center"><?php echo "Article : ".$produit; ?></td></tr>

	<center>

	<table class="table3">

		<tr>
		
		<tr><td><?php echo "Accessoire : "; ?></td><td><select id="accessoire" name="accessoire"><?php echo $profiles_list_accessoire; ?></select></td>
		<tr><td><?php echo "Qte"; ?></td><td><input type="text" id="qte" name="qte" style="width:160px" value="<?php echo $qte; ?>"></td></tr>
		<tr><td><?php echo "Matiere : "; ?></td><td><select id="matiere" name="matiere"><?php echo $profiles_list_matiere; ?></select></td>
		<tr><td><?php echo "Melange"; ?></td>
		<td><table>
		<tr><td><input type="text" id="homo" name="homo" style="width:160px" value="<?php echo $homo; ?>"><?php echo " HOMO"; ?></td></tr>
		<tr><td><input type="text" id="copo" name="copo" style="width:160px" value="<?php echo $copo; ?>"><?php echo " COPO"; ?></td></tr>
		<tr><td><input type="text" id="mlv" name="mlv" style="width:160px" value="<?php echo $mlv; ?>"><?php echo " MLV"; ?></td></tr>
		<tr><td><input type="text" id="mrb" name="mrb" style="width:160px" value="<?php echo $mrb; ?>"><?php echo " REBROYEE"; ?></td></tr>
		<tr><td><input type="text" id="charge" name="charge" style="width:160px" value="<?php echo $charge; ?>"><?php echo "%  CHARGE"; ?></td></tr>
		<tr><td><input type="text" id="homos" name="homos" style="width:160px" value="<?php echo $homos; ?>"><?php echo " HOMO SABIC"; ?></td></tr>
		</table></td>
		<tr><td><?php echo "Poids"; ?></td><td><input type="text" id="poids" name="poids" style="width:160px" value="<?php echo $poids; ?>"></td></tr>
		
	</table>

	</center>

</td></tr></table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action" name="action" value="<?php echo $action; ?>">
<input type="hidden" id="id_produit" name="id_produit" value="<?php echo $_REQUEST["id_produit"]; ?>">
<input type="hidden" id="produit" name="produit" value="<?php echo $_REQUEST["produit"]; ?>">
<input type="hidden" id="categorie" name="categorie" value="<?php echo $_REQUEST["categorie"]; ?>">
<table class="table3"><tr>

<?php if($user_id != "0") { ?>
<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td style="width:20px"></td>
<td><button type="button" onClick="DeleteUser()"><?php echo Translate("Delete"); ?></button></td>
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php 
} ?>
</tr></table>

</center>

</form>

</body>

</html>