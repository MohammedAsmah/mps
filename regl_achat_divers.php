<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$id_facture = $_REQUEST["id_facture"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$produit = "";
		$date="";$ref_f="";$montant_t="";$ref="";$frs="";$montant_g="";$date_valeur="";
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM reglements_factures_achats WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$produit = $user_["produit"];$montant_g = $user_["montant_g"];$date = dateUsToFr($user_["date"]);
		$montant_t = $user_["montant_t"];$ref_f=$user_["ref_f"];
		$frs=$user_["frs"];$ref=$user_["ref"];$taux_tva=$user_["taux_tva"];$date_valeur = dateUsToFr($user_["date_valeur"]);
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
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "regl_achats_divers.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="regl_achats_divers.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table width="671" class="table3">

		<tr>
		<td><?php echo "Date Reglement : "; ?></td><td><input type="text" id="date" name="date" style="width:160px" value="<?php echo $date; ?>"></td>
		</tr><tr>
		<tr>
		<td><?php echo "Date Valeur : "; ?></td><td><input type="text" id="date_valeur" name="date_valeur" style="width:160px" value="<?php echo $date_valeur; ?>"></td>
		</tr>
		<tr><td><?php echo "Ref Regl : "; ?></td><td><input type="text" id="ref" name="ref" style="width:240px" value="<?php echo $ref; ?>"></td>
		</tr>

		<tr>
		<td bgcolor="#33CCCC"><?php echo "Montant Traite"; ?></td>
		<td><input type="text" id="montant_t" name="montant_t" style="width:140px" value="<?php echo $montant_t; ?>"></td>
		</tr>
		

	</table>

	</center>

</td></tr></table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="id_facture" name="id_facture" value="<?php echo $_REQUEST["id_facture"]; ?>">
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