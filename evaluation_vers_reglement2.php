<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";$action_r="m_reglement";
	$id=$_GET['id'];
	$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles where id='$id' ORDER BY id;";
	$users11 = db_query($database_name, $sql);$users_1 = fetch_array($users11);$id_registre_regl=$users_1["id_registre_regl"];
	$id_r=$users_1["id"];$date_enc=$users_1["date_enc"];$vendeur=$users_1["vendeur"];$n_banque=$users_1["n_banque"];
	$client=$users_1["client"];$evaluation=$users_1["evaluation"];$id_commande=$users_1["id_commande"];$date_cheque=dateUsToFr($users_1["date_valeur"]);
	$mode=$users_1["mode"];$valeur=$users_1["valeur"];$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];
	$client_tire=$users_1["client_tire"];$facture_n=$users_1["facture_n"];$montant_f=$users_1["montant_f"];
	
	$mode_list = "Selectionnez Produit";$mo="mode_reg";
	$sql = "SELECT profile_name,type FROM rs_produits_profiles where type='$mo' ORDER BY type;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($mode == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		$mode_list .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$mode_list .= $temp_["profile_name"];
		$mode_list .= "</OPTION>";
	}
	
	$profiles_list_p = "Selectionnez Produit";
	$sql_produit = "SELECT * FROM rs_data_banques ORDER BY banque;";
	$temp_produit = db_query($database_name, $sql_produit);
	while($temp_produit_ = fetch_array($temp_produit)) {
		if($n_banque == $temp_produit_["banque"]) { $selected = " selected"; } else { $selected = ""; }
		$profiles_list_p .= "<OPTION VALUE=\"" . $temp_produit_["banque"] . "\"" . $selected . ">";
		$profiles_list_p .= $temp_produit_["banque"];
		$profiles_list_p .= "</OPTION>";
	}
	$profiles_list_p1 = "Selectionnez Produit";
	$sql_produit = "SELECT * FROM rs_data_banques ORDER BY banque;";
	$temp_produit = db_query($database_name, $sql_produit);
	while($temp_produit_ = fetch_array($temp_produit)) {
		if($v_banque == $temp_produit_["banque"]) { $selected = " selected"; } else { $selected = ""; }
		$profiles_list_p1 .= "<OPTION VALUE=\"" . $temp_produit_["banque"] . "\"" . $selected . ">";
		$profiles_list_p1 .= $temp_produit_["banque"];
		$profiles_list_p1 .= "</OPTION>";
	}
	

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Detail Evaluation"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
		if(document.getElementById("mode").value == "" ) {
			alert("<?php echo Translate("The values for the fields are required !"); ?>");
		} else {
			UpdateUser();
		}
	}
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "reglements_maj.php?action_r=delete_user&id=<?php echo $id; ?>";
		}
	}
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<form id="form_user" name="form_user" method="post" action="reglements_maj.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
		<tr>
		<td><?php echo "Client"; ?></td><td><?php echo $client; ?></td>
		</tr>
		<tr>
		<td><?php echo "Evaluation"; ?></td><td><?php echo $evaluation; ?></td>
		</tr>
		<tr>
		<td><?php echo "Date Enc"; ?></td><td><?php echo dateUsToFr($date_enc); ?></td>
		</tr>
		<tr>
		<td><?php echo "Facture N° : "; ?></td><td><input type="text" id="facture_n" name="facture_n" style="width:260px" value="<?php echo $facture_n; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Montant Facture : "; ?></td><td><input type="text" id="montant_f" name="montant_f" style="width:260px" value="<?php echo $montant_f; ?>"></td>
		</tr>
	</table>
		<tr>
		
	<table class="table3">
		<td width="100"><?php echo "Montant"; ?></td><td width="150"><?php echo "Mode"; ?></td><td width="200"><?php echo "V/Banque"; ?></td>
		<td width="200"><?php echo "Numero Chèque"; ?></td><td width="200"><?php echo "Date Chèque"; ?></td><td width="200"><?php echo "Client Tiré"; ?></td>
		<td width="200"><?php echo "N/Banque"; ?></td>
		<tr>
		<td align="right" width="100"><input type="text" id="montant" name="montant" value="<?php echo $valeur; ?>"></td>
		<td width="100"><select id="mode" name="mode"><?php echo $mode_list; ?></select></td>
		<td><select id="n_banque" name="n_banque"><?php echo $profiles_list_p; ?></select></td>
		<td><input type="text" id="ref" name="ref" value="<?php echo $numero_cheque; ?>"></td>
		<td><input type="text" id="date_cheque" name="date_cheque" value="<?php echo $date_cheque; ?>"></td>
		<td><input type="text" id="client_tire" name="client_tire" value="<?php echo $client_tire; ?>"></td>
		<td><select id="v_banque" name="v_banque"><?php echo $profiles_list_p1; ?></select></td>
		</tr>

	</table>


<p style="text-align:center">

<center>

<input type="hidden" id="id_registre" name="id_registre" value="<?php echo $id_registre_regl; ?>">
<input type="hidden" id="id_commande" name="id_commande" value="<?php echo $id_commande; ?>">
<input type="hidden" id="action_r" name="action_r" value="<?php echo $action_r; ?>">
<input type="hidden" id="vendeur" name="vendeur" value="<?php echo $vendeur; ?>">
<input type="hidden" id="date_enc" name="date_enc" value="<?php echo $date_enc; ?>">
<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
<table class="table3"><tr>

<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<td><button type="button" onClick="DeleteUser()"><?php echo Translate("Delete"); ?></button></td>

</tr></table>

</center>

</form>


<p style="text-align:center">
<table>
<? /*echo "<td><a href=\"registres_reglements.php?date=$date&vendeur=$vendeur&id_registre=$id_registre\">Terminer</a></td>";*/?>
</table>
</body>

</html>