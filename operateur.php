<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Client";

		$code = "";$service="";
		$designation = "";
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM operateurs WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$code = $user_["code"];$service = $user_["service"];
		$designation = $user_["designation"];
		}
	$profiles_list_s = "";
	$sql43 = "SELECT * FROM services ORDER BY id;";
	$temp = db_query($database_name, $sql43);
	while($temp_ = fetch_array($temp)) {
		if($service == $temp_["designation"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_s .= "<OPTION VALUE=\"" . $temp_["designation"] . "\"" . $selected . ">";
		$profiles_list_s .= $temp_["designation"];
		$profiles_list_s .= "</OPTION>";
	}


	// extracts profile list
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
		if(document.getElementById("designation").value == "" ) {
			alert("<?php echo Translate("The values for the fields are required !"); ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "operateurs.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="operateurs.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
		<tr>
		<td><?php echo "Code"; ?></td><td><input type="text" id="code" name="code" style="width:260px" value="<?php echo $code; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "operateur"; ?></td><td><input type="text" id="designation" name="designation" style="width:260px" value="<?php echo $designation; ?>"></td>
		</tr>
		<tr><td><?php echo "Service"; ?></td><td><select id="service" name="service"><?php echo $profiles_list_s; ?></select></td>
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