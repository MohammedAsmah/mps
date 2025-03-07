<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$id = $_REQUEST["id"];$ref = $_REQUEST["ref"];$date = $_REQUEST["date"];$date2 = $_REQUEST["date2"];

	

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM porte_feuilles_factures WHERE id = " . $_REQUEST["id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$client = $user_["client"];$date_remise_e = $user_["date_remise_e"];
		$facture = $user_["facture_n"];$date_enc = dateUsToFr($user_["date_enc"]);$date_c = dateUsToFr($user_["date_echeance"]);
		$m_espece = $user_["m_espece"];$montant_f = $user_["montant_f"];$vendeur = $user_["vendeur"];
		
		
	

	// extracts profile list
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
		
			UpdateUser();
		
	}
	
	


--></script>

</head>

<body style="background:#dfe8ff">
<? require "body_cal.php";?>
<span style="font-size:24px"><?php echo $client." au ".dateUsToFr($date); ?></span>

<form id="form_user" name="form_user" method="post" action="porte_feuilles_effet_details1cr.php">

	<table class="table2">
		<tr>
		<td><?php echo "Client"; ?></td><td><?php echo $client; ?></td>
		</tr>
		<tr>
		<td><?php echo "Numero Effet"; ?></td><td><?php echo $ref; ?></td>
		</tr>
		<tr>
		<td><?php echo "Date Echeance"; ?></td><td><input onClick="ds_sh(this);" name="date_c" value="<?php echo $date_c; ?>" readonly="readonly" style="cursor: text" /></td>
		</tr>
		<tr>
		<td><?php echo "Date Remise"; ?></td><td><?php echo dateUsToFr($date_remise_e); ?></td>
		</tr>
		</table>


<p style="text-align:center">

<center>

<input type="hidden" id="id" name="id" value="<?php echo $_REQUEST["id"]; ?>">
<input type="hidden" id="numero_cheque" name="numero_cheque" value="<?php echo $ref; ?>">
<input type="hidden" id="date" name="date" value="<?php echo $date; ?>">
<input type="hidden" id="date2" name="date2" value="<?php echo $date2; ?>">
<input type="hidden" id="client" name="client" value="<?php echo $client; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<table class="table3"><tr>

<?php if($id != "0") { ?>
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