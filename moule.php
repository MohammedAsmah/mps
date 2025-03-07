<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Moule";

		$code = "";
		$designation = "";
		$code = "";
		$designation = "";
		$ordre = "";
		$couleur = "";
		$type_injection = "";
		$nbre_noyaux = "";
		$longeur_colonne = "";
		$epaisseur = "";
		$hauteur = "";
		$cales = "";
		$rondelle = "";
		$bague = "";
		$anneaux = "";
		$chint = "";
		$flexible = "";
		$faux_plateau = "";
		$soufflette = "";
		$regulateur_t = "";
		$t_pneumatique = "";
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM moules WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$code = $user_["code"];
		$designation = $user_["designation"];
		$ordre = $user_["ordre"];
		$couleur = $user_["couleur"];
		$type_injection = $user_["type_injection"];
		$nbre_noyaux = $user_["nbre_noyaux"];
		$longeur_colonne = $user_["longeur_colonne"];
		$epaisseur = $user_["epaisseur"];
		$hauteur = $user_["hauteur"];
		$cales = $user_["cales"];
		$rondelle = $user_["rondelle"];
		$bague = $user_["bague"];
		$anneaux = $user_["anneaux"];
		$chint = $user_["chint"];
		$flexible = $user_["flexible"];
		$faux_plateau = $user_["faux_plateau"];
		$soufflette = $user_["soufflette"];
		$regulateur_t = $user_["regulateur_t"];
		$t_pneumatique = $user_["t_pneumatique"];
		
		
		
		
		}

	// extracts profile list
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}
	

	function CheckUser() {
		if(document.getElementById("designation").value == "" ) {
			alert("<?php echo Translate("The values for the fields are required !"); ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "moules.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

	function PrintUser() {
		
			document.location = "print_moules.php?action_=print_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		
	}

--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="moules.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
		<tr>
		<td><?php echo "N° Moule : "; ?><input type="text" id="code" name="code" style="width:260px" value="<?php echo $code; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Code d'emplacement : "; ?><input type="text" id="ordre" name="ordre" style="width:260px" value="<?php echo $ordre; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Nom du Moule : "; ?><input type="text" id="designation" name="designation" style="width:260px" value="<?php echo $designation; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Couleur : "; ?><input type="text" id="couleur" name="couleur" style="width:260px" value="<?php echo $couleur; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Type d'éjection : "; ?><input type="text" id="type_injection" name="type_injection" style="width:260px" value="<?php echo $type_injection; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Nombre de noyaux hydrolique : "; ?><input type="text" id="nbre_noyaux" name="nbre_noyaux" style="width:260px" value="<?php echo $nbre_noyaux; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Longueur entre colonne : "; ?><input type="text" id="longeur_colonne" name="longeur_colonne" style="width:260px" value="<?php echo $longeur_colonne; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Epaisseur : "; ?><input type="text" id="epaisseur" name="epaisseur" style="width:260px" value="<?php echo $epaisseur; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Hauteur : "; ?><input type="text" id="hauteur" name="hauteur" style="width:260px" value="<?php echo $hauteur; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Cales : "; ?><input type="text" id="cales" name="cales" style="width:260px" value="<?php echo $cales; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Rondelle : "; ?><input type="text" id="rondelle" name="rondelle" style="width:260px" value="<?php echo $rondelle; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Bague de centrage : "; ?><input type="text" id="bague" name="bague" style="width:260px" value="<?php echo $bague; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Anneaux de levage : "; ?><input type="text" id="anneaux" name="anneaux" style="width:260px" value="<?php echo $anneaux; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Chint : "; ?><input type="text" id="chint" name="chint" style="width:260px" value="<?php echo $chint; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Flexible hydrolique : "; ?><input type="text" id="flexible" name="flexible" style="width:260px" value="<?php echo $flexible; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Faux plateau : "; ?><input type="text" id="faux_plateau" name="faux_plateau" style="width:260px" value="<?php echo $faux_plateau; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Soufflette pneumatique : "; ?><input type="text" id="soufflette" name="soufflette" style="width:260px" value="<?php echo $soufflette; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Régulateur thermique : "; ?><input type="text" id="regulateur_t" name="regulateur_t" style="width:260px" value="<?php echo $regulateur_t; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "T. Pneumatique : "; ?><input type="text" id="t_pneumatique" name="t_pneumatique" style="width:260px" value="<?php echo $t_pneumatique; ?>"></td>
		</tr>
		
		<tr>
		
		
		</table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<table class="table3"><tr>

<?php if($user_id != "0") { ?>
<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td style="width:20px"></td>
<td><button type="button" onClick="DeleteUser()"><?php echo Translate("Delete"); ?></button></td>
<td style="width:20px"></td>
<td><button type="button" onClick="PrintUser()"><?php echo "Imprimer"; ?></button></td>
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php 
} ?>
</tr></table>

</center>

</form>

</body>

</html>