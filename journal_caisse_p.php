<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$date = "";$libelle="";$caisse="";$type = "";$debit=0;$credit=0;$solde=0;$statut="";$credit_ancien=0;$debit_ancien=0;
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM journal_caisses WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "";

		$date = dateUsToFr($user_["date"]);$libelle=$user_["libelle"];$caisse=$user_["caisse"];$type=$user_["type"];$debit=$user_["debit"];
	$credit=$user_["credit"];$statut=$user_["statut"];$credit_ancien=$user_["credit"];$debit_ancien=$user_["debit"];
	}
		$profiles_list_caisse = "";
	$sql1 = "SELECT * FROM liste_caisses ORDER BY profile_name;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($caisse == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_caisse .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$profiles_list_caisse .= $temp_["profile_name"];
		$profiles_list_caisse .= "</OPTION>";
	}
	$profiles_list_type = "";
	$sql1 = "SELECT * FROM types_caisses ORDER BY profile_name;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($type == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_type .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$profiles_list_type .= $temp_["profile_name"];
		$profiles_list_type .= "</OPTION>";
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
		if(document.getElementById("date").value == "" ) {
			alert("<?php echo "valeurs required !"; ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "journal_caisses_p.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="journal_caisses_p.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
	
	<tr>
	<td><?php echo "Date"; ?></td><td><?php echo "Libelle"; ?></td><td><?php echo "Type"; ?></td>
	<td><?php echo "Debit"; ?></td><td><?php echo "Credit"; ?></td></tr>
	<tr>
	<td><input type="text" id="date" name="date" style="width:100px" value="<?php echo $date; ?>"></td>
	<td><input type="text" id="libelle" name="libelle" style="width:200px" value="<?php echo $libelle; ?>"></td>
	<td><select id="type" name="type"><?php echo $profiles_list_type; ?></select></td>
	<td align="right"><input type="text" id="debit" name="debit" style="width:100px" value="<?php echo $debit; ?>"></td>
	<td align="right"><input type="text" id="credit" name="credit" style="width:100px" value="<?php echo $credit; ?>"></td>

	</table>

	</center>

</td></tr></table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="debit_ancien" name="debit_ancien" value="<?php echo $debit_ancien; ?>">
<input type="hidden" id="credit_ancien" name="credit_ancien" value="<?php echo $credit_ancien; ?>">

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