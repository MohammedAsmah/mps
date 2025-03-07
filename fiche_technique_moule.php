<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$id_produit = $_REQUEST["id_produit"];$produit = $_REQUEST["produit"];$categorie = $_REQUEST["categorie"];
    $sql  = "SELECT * ";
    $sql .= "FROM produits  where id='$id_produit' ORDER BY produit ASC;";
    $users = db_query($database_name, $sql);$user_pp = fetch_array($users);
    $image = $user_pp["image"];

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



        /////////maintenance
        $numero_moule=$user_["numero_moule"];
        $couleur_moule=$user_["couleur_moule"];
        
        $v1=$user_["v1"];
        $v2=$user_["v2"];
        $v3=$user_["v3"];
        $v4=$user_["v4"];
        $v5=$user_["v5"];
        $v6=$user_["v6"];
        $cycle_moule=$user_["cycle_moule"];


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
		if(document.getElementById("numero_moule").value == "" ) {
			alert("<?php echo "valeurs required !"; ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "fiches_techniques_moules.php?action=delete_user&categorie=<?php echo $_REQUEST["categorie"]; ?>&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="fiches_techniques_moules.php">

<table class="table2">

<tr><td style="text-align:center"><?php echo "Article : ".$produit; ?></td></tr>
<td><div class="icon" >
<img src="<?php echo $image ?>" height="150px" width="150px">
</div></td>

	<center>

	<table class="table3">

		<tr><td>Designation Moule : <? echo $accessoire ?></td>
		<tr><td><?php echo " Numero Moule : "; ?><input type="text" id="numero_moule" name="numero_moule" style="width:160px" value="<?php echo $numero_moule; ?>"></td></tr>
		
		<tr><td><label for="head">Couleur Moule : </label><input type="color" id="couleur_moule" name="couleur_moule" value="<?php echo $couleur_moule; ?>">
        </td></tr>
				
		<td><table>
		<tr><td><?php echo " HAUTEUR : "; ?><input type="text" id="v1" name="v1" style="width:160px" value="<?php echo $v1; ?>"></td></tr>
		<tr><td><?php echo " LARGEUR : "; ?><input type="text" id="v2" name="v2" style="width:160px" value="<?php echo $v2; ?>"></td></tr>
		<tr><td><?php echo " EPAISSEUR : "; ?><input type="text" id="v3" name="v3" style="width:160px" value="<?php echo $v3; ?>"></td></tr>
		
		
		<tr><td><?php echo "Temps de cycle : "; ?><input type="text" id="cycle_moule" name="cycle_moule" style="width:160px" value="<?php echo $cycle_moule; ?>"></td></tr>
		</table></td>
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

<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php 
} ?>
</tr></table>

</center>

</form>

</body>

</html>