<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Impaye";

		$client = "";
		$facture = "";$numero_effet="";
		$date_impaye = "";$m_cheque="";$montant_f="";$date_facture = "";$locked="";$numero_cheque="";$v_banque="";$client_tire="";
		
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM porte_feuilles_factures WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$client = $user_["client"];
		$facture = $user_["facture_n"];$date_impaye = dateUsToFr($user_["date_impaye"]);$date_facture = dateUsToFr($user_["date_f"]);
		$m_cheque = $user_["m_cheque"];$montant_f = $user_["montant_f"];$vendeur = $user_["vendeur"];$numero_cheque = $user_["numero_cheque"];
		$v_banque = $user_["v_banque"];$client_tire = $user_["client_tire"];$m_effet = $user_["m_effet"];$numero_effet = $user_["numero_effet"];
		if ($m_effet>0){$m_cheque=$m_effet;}
		}
	$profiles_list_client = "";
	$sql = "SELECT * FROM clients ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_client .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$profiles_list_client .= $temp_["client"];
		$profiles_list_client .= "</OPTION>";
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

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
		if(document.getElementById("client").value == "" ) {
			alert("<?php echo Translate("The values for the fields are required !"); ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "saisie_impayes.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">
<? require "body_cal.php";?>
<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="saisie_impayes.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
		<tr>
		<td><?php echo "Client"; ?></td><td><select id="client" name="client"><?php echo $profiles_list_client; ?></select></td>
		</tr>
		<tr>
		<td><?php echo "Facture"; ?></td><td><input type="text" id="facture" name="facture" style="width:260px" value="<?php echo $facture; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Date Facture"; ?></td><td><input onClick="ds_sh(this);" name="date_facture" value="<?php echo $date_facture; ?>" readonly="readonly" style="cursor: text" /></td>
		</tr>
		<tr>
		<td><?php echo "Numero Cheque :"; ?></td><td><input type="text" id="numero_cheque" name="numero_cheque" style="width:260px" value="<?php echo $numero_cheque; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Numero Effet :"; ?></td><td><input type="text" id="numero_effet" name="numero_effet" style="width:260px" value="<?php echo $numero_effet; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Banque :"; ?></td><td><input type="text" id="v_banque" name="v_banque" style="width:260px" value="<?php echo $v_banque; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Client tire :"; ?></td><td><input type="text" id="client_tire" name="client_tire" style="width:260px" value="<?php echo $client_tire; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Date Impaye : "; ?></td><td><input onClick="ds_sh(this);" name="date_impaye" value="<?php echo $date_impaye; ?>" readonly="readonly" style="cursor: text" /></td>
		</tr>
		<tr>
		<td><?php echo "Montant  :"; ?></td><td><input type="text" id="m_cheque" name="m_cheque" style="width:260px" value="<?php echo $m_cheque; ?>"></td>
		</tr>
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
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php 
} ?>
</tr></table>

</center>

</form>


</body>

</html>