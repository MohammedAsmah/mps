<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_name=GetUserName();
	$user_id = $_REQUEST["user_id"];
	if($user_id == "0") {

		$action_ = "insert_new_user";
		$service = "";
		$divers = "";
		$user_open = $user_name;
		$date_open = dateFrToUs(date("d/m/Y"));
		$observation="";
		$date_lp="";
		$libelle="";
		$ref="";
		
	
	} else {

		$action_ = "update_user";
		$action1_ = "update_detail";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM folio_divers_depenses_rak WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$ref = $user_["ref"];
		$date_lp=dateUsToFr($user_["date_lp"]);
		$libelle=$user_["libelle"];
		$service = $user_["service"];
		$divers=$user_["divers"];
	}
	
	$profiles_depenses = "Selectionez ";
	$sql_depenses = "SELECT profile_name FROM types_depenses ORDER BY profile_name;";
	$temp_depenses = db_query($database_name, $sql_depenses);
	while($temp_depenses_ = fetch_array($temp_depenses)) {
		if($service == $temp_depenses_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_depenses .= "<OPTION VALUE=\"" . $temp_depenses_["profile_name"] . "\"" . $selected . ">";
		$profiles_depenses .= $temp_depenses_["profile_name"];
		$profiles_depenses .= "</OPTION>";
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
			UpdateUser();
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression  ?"; ?>")) {
			document.location = "registres_depenses.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<form id="form_user" name="form_user" method="post" action="registres_depenses.php">

<?

if($user_id == "0") { ?>

<table class="table2"><tr><td style="text-align:center">
		<tr><td><?php echo "Date Depense : "; ?></td><td><input onclick="ds_sh(this);" name="date_lp" readonly="readonly" style="cursor: text" / value="<?php echo $date_lp; ?>"></td>
		<tr><td><?php echo "Libelle:"; ?></td><td><input type="text" id="libelle" name="libelle" style="width:250px" value="<?php echo $libelle; ?>"></td></tr>
		<tr><td><?php echo "References:"; ?></td><td><input type="text" id="ref" name="ref" style="width:100px" value="<?php echo $ref; ?>"></td></tr>
		<tr><td><?php echo "Montant:"; ?></td><td><input type="text" id="divers" name="divers" style="width:80px" value="<?php echo $divers; ?>"></td>
		<td><?php echo "Type Depense	:";?></td><td>
		<select id="service" name="service"><?php echo $profiles_depenses; ?></select></td></tr>

</td></tr></table>
<? }
else
{ ?>
<table class="table2"><tr><td style="text-align:center">

		<tr><td><?php echo "Date Depense : "; ?></td><td><input onclick="ds_sh(this);" name="date_lp" readonly="readonly" style="cursor: text" / value="<?php echo $date_lp; ?>"></td>
		<tr><td><?php echo "Libelle:"; ?></td><td><input type="text" id="libelle" name="libelle" style="width:250px" value="<?php echo $libelle; ?>"></td></tr>
		<tr><td><?php echo "References:"; ?></td><td><input type="text" id="ref" name="ref" style="width:100px" value="<?php echo $ref; ?>"></td></tr>
		<tr><td><?php echo "Montant:"; ?></td><td><input type="text" id="divers" name="divers" style="width:80px" value="<?php echo $divers; ?>"></td>
		<td><?php echo "Type Depense	:";?></td><td><select id="service" name="service"><?php echo $profiles_depenses; ?></select></td></tr>

</td></tr></table>
<? } ?>



<center>
<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="user_open" name="user_open" value="<?php echo $user_open; ?>">
<input type="hidden" id="date_open" name="date_open" value="<?php echo $date_open; ?>">
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