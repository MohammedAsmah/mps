<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	$id_commande=$_GET['id_commande'];$id_registre=$_GET['id_registre'];$vendeur=$_GET['vendeur'];
	$client=$_GET['client'];$montant_e=$_GET['montant'];$action_r="reglement";$n_banque="BCP";
	$mode_list = "";$mo="mode_reg";$date_enc=$_GET['date_enc'];$facture="";$montant_f="";
	
	$montant_r="";
	$mode="";
	$ref="";
	$v_banque="";
	$date_valeur="";
	$client_tire="";
	$obs="";
	



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
			UpdateUser();
	}

--></script>

<style type="text/css">
<!--
.Style1 {color: #FF0000}
-->
</style>
</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<form id="form_user" name="form_user" method="post" action="reglements1_list.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
		<tr>
		<td><?php echo "Client"; ?></td><td><?php echo $client; ?></td>
		</tr>
		<tr>
		<td><?php echo "Date"; ?></td><td><?php echo dateUsToFr($date_enc); ?></td>
		</tr>
		<tr>
		<td><?php echo "Facture N° : "; ?></td><td><?php echo $id_commande+9040; ?>
		</td>
		</tr>
		<tr>
		<td><?php echo "Montant Facture : "; ?></td><td><?php echo $montant_e; ?></td>
		</tr>
	</table>
	<tr>
		
		<table width="317" border="1">
          <tr>
            <td bgcolor="#3399FF">Montant</td>
            <td><input name="montant_r" type="text" class="Style1" id="montant_r" style="width:150px" value="<?php echo $montant_r; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Mode</td>
            <td><input name="mode" type="text" class="Style1" id="mode" style="width:150px" value="<?php echo $mode; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Reference </td>
            <td><input name="ref" type="text" class="Style1" id="ref" style="width:150px" value="<?php echo $ref; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Banque</td>
            <td><input name="v_banque" type="text" class="Style1" id="v_banque" style="width:150px" value="<?php echo $v_banque; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Client tir&eacute;</td>
            <td><input name="client_tire" type="text" class="Style1" id="client_tire" style="width:150px" value="<?php echo $client_tire; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Date Valeur </td>
            <td><input name="date_valeur" type="text" class="Style1" id="date_valeur" style="width:150px" value="<?php echo $date_valeur; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Obs</td>
            <td><input name="obs" type="text" class="Style1" id="obs" style="width:150px" value="<?php echo $obs; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
	</table>

        <p>&nbsp;</p>
  <tr>
  <p style="text-align:center">
    
<center>
    
<input type="hidden" id="id_registre" name="id_registre" value="<?php echo $id_registre; ?>">
    <input type="hidden" id="id_commande" name="id_commande" value="<?php echo $id_commande; ?>">
    <input type="hidden" id="action_r" name="action_r" value="<?php echo $action_r; ?>">
    <input type="hidden" id="montant_e" name="montant_e" value="<?php echo $montant_e; ?>">
    <input type="hidden" id="vendeur" name="vendeur" value="<?php echo $vendeur; ?>">
    <input type="hidden" id="date_enc" name="date_enc" value="<?php echo $date_enc; ?>">
    
<table class="table3"><tr>
    
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
    </tr></table>
    
</center>
</form>


<p style="text-align:center">
<table>
<? /*echo "<td><a href=\"registres_reglements.php?date=$date&vendeur=$vendeur&id_registre=$id_registre\">Terminer</a></td>";*/?>
</table>
</body>

</html>