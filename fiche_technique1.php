<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$id_produit = $_REQUEST["id_produit"];$produit = $_REQUEST["produit"];$categorie = $_GET["categorie"];
	$sql  = "SELECT * ";
	$sql .= "FROM produits  where produit='$produit' ORDER BY produit ASC;";
	$users = db_query($database_name, $sql);$user_p = fetch_array($users);
	$condit = $user_p["condit"];$poids = $user_p["poids"];$prix = $user_p["prix"];
	
	
	
	

	if($user_id == "0") {

		$action = "insert_new_user";

		$title = "";

		$concurent = "";$prix_vente="";$matiere="";$poids = "";$remise1=0;$remise2=0;$remise3=0;$remise4=0;$marche="";$obs="";$date_maj="";
	
	} else {

		$action = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM fiches_techniques1 WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "";

		$concurent = $user_["concurent"];$prix_vente=$user_["prix_vente"];$matiere=$user_["matiere"];$remise1=$user_["remise1"];
		$poids=$user_["poids"];$remise2=$user_["remise2"];$remise3=$user_["remise3"];$remise4=$user_["remise4"];$obs=$user_["obs"];$date_maj=$user_["date_maj"];
	}

	
	
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
		if(document.getElementById("concurent").value == "" ) {
			alert("<?php echo "valeurs required !"; ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "fiches_techniques1.php?action=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">
<? require "body_cal.php";?>
<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="fiches_techniques1.php">

<table class="table2">

<tr><td style="text-align:center"><?php echo "Article : ".$produit; ?></td></tr>

	<center>

	<table class="table2">

		<tr>
		
		<tr><td><?php echo "Concurent : "; ?></td><td><input type="text" id="concurent" name="concurent" style="width:160px" value="<?php echo $concurent; ?>"></td>
		<tr><td><?php echo "Poids"; ?></td><td><input type="text" id="poids" name="poids" style="width:160px" value="<?php echo $poids; ?>"></td></tr>
		<tr><td><?php echo "Matiere : "; ?></td><td><input type="text" id="matiere" name="matiere" style="width:160px" value="<?php echo $matiere; ?>"></td>
		<tr><td><?php echo "Prix de Vente : "; ?></td><td><input type="text" id="prix_vente" name="prix_vente" style="width:160px" value="<?php echo $prix_vente; ?>"></td>
		<tr><td><?php echo "Remises"; ?></td>
		<td><table class="table2">
		<tr><td><input type="text" id="remise1" name="remise1" style="width:160px" value="<?php echo $remise1; ?>"><?php echo " 1ere Remise"; ?></td></tr>
		<tr><td><input type="text" id="remise2" name="remise2" style="width:160px" value="<?php echo $remise2; ?>"><?php echo " 2eme Remise"; ?></td></tr>
		<tr><td><input type="text" id="remise3" name="remise3" style="width:160px" value="<?php echo $remise3; ?>"><?php echo " 3eme Remise"; ?></td></tr>
		<tr><td><input type="text" id="remise4" name="remise4" style="width:160px" value="<?php echo $remise4; ?>"><?php echo " 4eme Remise"; ?></td></tr>
		</table></td>
		<tr><td><?php echo "Marche"; ?></td><td><input type="text" id="marche" name="marche" style="width:160px" value="<?php echo $marche; ?>"></td></tr>
		<tr><td><?php echo "Observations"; ?></td><td><input type="text" id="obs" name="obs" style="width:160px" value="<?php echo $obs; ?>"></td></tr>
		<tr><td><?php echo "Date"; ?></td><td><input onClick="ds_sh(this);" name="date_maj" value="<?php echo dateUsToFr($date_maj); ?>" readonly="readonly" style="cursor: text" /></td></tr>
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