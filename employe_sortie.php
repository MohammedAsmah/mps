<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Client";

		$ref = "";$service="";
		$employe = "";$statut=0;$poste="";$s_h=0;$mode="";$paie="";
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM employes WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$ref = $user_["ref"];$service = $user_["service"];$s_h = $user_["s_h"];
		$employe = $user_["employe"];$statut=$user_["statut"];$poste=$user_["poste"];$mode=$user_["mode"];
		$paie=$user_["paie"];
		}
	$profiles_list_s = "";
	$sql43 = "SELECT * FROM rs_data_services ORDER BY service;";
	$temp = db_query($database_name, $sql43);
	while($temp_ = fetch_array($temp)) {
		if($service == $temp_["service"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_s .= "<OPTION VALUE=\"" . $temp_["service"] . "\"" . $selected . ">";
		$profiles_list_s .= $temp_["service"];
		$profiles_list_s .= "</OPTION>";
	}
$profiles_list_poste = "";
	$sql43 = "SELECT * FROM rs_data_postes ORDER BY poste;";
	$temp = db_query($database_name, $sql43);
	while($temp_ = fetch_array($temp)) {
		if($poste == $temp_["poste"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_poste .= "<OPTION VALUE=\"" . $temp_["poste"] . "\"" . $selected . ">";
		$profiles_list_poste .= $temp_["poste"];
		$profiles_list_poste .= "</OPTION>";
	}
$profiles_list_paie = "";
	$sql45 = "SELECT * FROM rs_data_paie ORDER BY paie;";
	$temp = db_query($database_name, $sql45);
	while($temp_ = fetch_array($temp)) {
		if($paie == $temp_["paie"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_paie .= "<OPTION VALUE=\"" . $temp_["paie"] . "\"" . $selected . ">";
		$profiles_list_paie .= $temp_["paie"];
		$profiles_list_paie .= "</OPTION>";
	}
$profiles_list_mode = "";
	$sql46 = "SELECT * FROM rs_data_mode ORDER BY mode;";
	$temp = db_query($database_name, $sql46);
	while($temp_ = fetch_array($temp)) {
		if($mode == $temp_["mode"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_mode .= "<OPTION VALUE=\"" . $temp_["mode"] . "\"" . $selected . ">";
		$profiles_list_mode .= $temp_["mode"];
		$profiles_list_mode .= "</OPTION>";
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
		if(document.getElementById("employe").value == "" ) {
			alert("<?php echo Translate("The values for the fields are required !"); ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "employes_sortie.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="employes_sortie.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
		<tr>
		<td><?php echo "ref"; ?></td><td><input type="text" id="ref" name="ref" style="width:260px" value="<?php echo $ref; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "employe"; ?></td><td><input type="text" id="employe" name="employe" style="width:260px" value="<?php echo $employe; ?>"></td>
		</tr>
		<tr><td><?php echo "Type"; ?></td><td><select id="service" name="service"><?php echo $profiles_list_s; ?></select></td>
		<tr><td><?php echo "Poste"; ?></td><td><select id="poste" name="poste"><?php echo $profiles_list_poste; ?></select></td>
		<tr>
		<td><?php echo "Salaire H."; ?></td><td><input type="text" id="s_h" name="s_h" style="width:90px" value="<?php echo $s_h; ?>"></td>
		</tr>
		<tr><td><?php echo "Paie"; ?></td><td><select id="paie" name="paie"><?php echo $profiles_list_paie; ?></select></td>
		<tr><td><?php echo "Mode"; ?></td><td><select id="mode" name="mode"><?php echo $profiles_list_mode; ?></select></td>
		
		<tr><td><input type="checkbox" id="statut" name="statut"<?php if($statut) { echo " checked"; } ?>></td><td>Arr�t</td>

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