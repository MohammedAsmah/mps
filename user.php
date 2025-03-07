<?php

	/* OpenBookings - Copyright (C) 2005 Jérôme ROGER (jerome@openbookings.org)
	
	week.php - This file is part of OpenBookings.org (http://www.openbookings.org)

    OpenBookings.org is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    OpenBookings.org is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with OpenBookings.org; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA */
	
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = Translate("New user");

		$login = "";
		$last_name = "";
		$first_name = "";
		$email = "";
		$locked = "";
		$profile_id = 0;
		$remarks = "";$to="";$menu1=0;$menu2=0;$menu3=0;$menu4=0;$menu5=0;$menu6=0;$menu7=0;$menu8=0;$menu9=0;$menu10=0;$tout=0;$menu11=0;
	$menu12=0;$menu13=0;$menu14=0;$menu15=0;$menu16=0;
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM rs_data_users WHERE user_id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = Translate("User details");

		$login = $user_["login"];
		$last_name = $user_["last_name"];
		$first_name = $user_["first_name"];
		$email = $user_["email"];
		$locked = $user_["locked"];
		$profile_id = $user_["profile_id"];
		$remarks = $user_["remarks"];$to = $user_["to"];
		$menu1 = $user_["menu1"];$menu2 = $user_["menu2"];$menu3 = $user_["menu3"];$menu4 = $user_["menu4"];
		$menu6 = $user_["menu6"];$menu7 = $user_["menu7"];$menu8 = $user_["menu8"];$menu5 = $user_["menu5"];
		$menu9 = $user_["menu9"];$tout = $user_["tout"];$menu10 = $user_["menu10"];$menu11 = $user_["menu11"];$menu12 = $user_["menu12"];$menu13 = $user_["menu13"];
		$menu14 = $user_["menu14"];$menu15 = $user_["menu15"];$menu16 = $user_["menu16"];
	}

	// extracts profile list
	$profiles_list = "";
	$sql = "SELECT profile_id, profile_name FROM rs_param_profiles ORDER BY display_order;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($profile_id == $temp_["profile_id"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list .= "<OPTION VALUE=\"" . $temp_["profile_id"] . "\"" . $selected . ">";
		$profiles_list .= $temp_["profile_name"];
		$profiles_list .= "</OPTION>";
	}
	$client_list = "";
	$sql = "SELECT * FROM  rs_data_clients ORDER BY last_name;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($to == $temp_["last_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list .= "<OPTION VALUE=\"" . $temp_["last_name"] . "\"" . $selected . ">";
		$client_list .= $temp_["last_name"];
		$client_list .= "</OPTION>";
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
		if( document.getElementById("password_confirm").value != "" && ( document.getElementById("password").value != document.getElementById("password_confirm").value )) {
			alert("<?php echo Translate("Password does not meet confirmation"); ?>");
		} else {
			document.getElementById("form_user").submit();
		}
	}

	function CheckUser() {
		if(document.getElementById("first_name").value == "" || document.getElementById("last_name").value == "") {
			alert("<?php echo Translate("The values for the fields [First name] and [Last name] are required !"); ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php echo Translate("WARNING !"); ?>\n<?php echo Translate("Do you really want to delete this user ?"); ?>")) {
			document.location = "users.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="users.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">

		<tr>
		<td><?php echo Translate("Login"); ?><br><input type="text" id="login" name="login" style="width:160px" value="<?php echo $login; ?>"></td>
		<td style="width:10px"></td>
		<td><?php echo Translate("Password"); ?><br><input type="password" id="password" name="password" style="width:160px" value=""></td>
		<td style="width:10px"></td>
		<td><?php echo Translate("Password confirm"); ?><br><input type="password" id="password_confirm" name="password_confirm" style="width:160px" value=""></td>
		</tr><tr>
		<td><?php echo Translate("Last name"); ?><br><input type="text" id="last_name" name="last_name" style="width:160px" value="<?php echo $last_name; ?>"></td>
		<td style="width:10px"></td>
		<td><?php echo Translate("First name"); ?><br><input type="text" id="first_name" name="first_name" style="width:160px" value="<?php echo $first_name; ?>"></td>
		<td style="width:10px"></td>
		<td><?php echo Translate("Email"); ?><br><input type="text" id="email" name="email" style="width:160px" value="<?php echo $email; ?>"></td>
		</tr>

		<tr><td colspan="5" style="height:10px"></td></tr>

		<tr><td colspan="5"><input type="text" id="remarks" name="remarks" style="width:520px; height:50px" value="<?php echo $remarks; ?>"></td></tr>

		<tr>




		<td colspan="5" style="text-align:center">

		<center>

		<table><tr>

			<td><?php echo Translate("Profile"); ?></td><td><select id="profile_id" name="profile_id"><?php echo $profiles_list; ?></select></td>
			<td style="width:20px"><input type="checkbox" id="locked" name="locked"<?php if($locked) { echo " checked"; } ?>></td>
			<td><?php echo Translate("Locked"); ?></td>
		</tr>
	</table>
<tr>
<table>
				<tr>
		<td><input type="checkbox" id="tout" name="tout"<?php if($tout) { echo " checked"; } ?>></td>
		<td><?php echo "Tout"; ?></td></tr>

		<tr>
		<td><input type="checkbox" id="menu1" name="menu1"<?php if($menu1) { echo " checked"; } ?>></td>
		<td><?php echo "Parametrage"; ?></td></tr>
		<tr>
		<td><input type="checkbox" id="menu2" name="menu2"<?php if($menu2) { echo " checked"; } ?>></td>
		<td><?php echo "Commercial"; ?></td></tr>
		<tr>
		<td><input type="checkbox" id="menu3" name="menu3"<?php if($menu3) { echo " checked"; } ?>></td>
		<td><?php echo "Editions"; ?></td></tr>
		<tr>
		<td><input type="checkbox" id="menu4" name="menu4"<?php if($menu4) { echo " checked"; } ?>></td>
		<td><?php echo "Caisse Comptoir"; ?></td></tr>
		<tr>
		<td><input type="checkbox" id="menu5" name="menu5"<?php if($menu5) { echo " checked"; } ?>></td>
		<td><?php echo "Facturation"; ?></td></tr>
		<tr>
		<td><input type="checkbox" id="menu6" name="menu6"<?php if($menu6) { echo " checked"; } ?>></td>
		<td><?php echo "Caisse Principale"; ?></td></tr>
		<tr>
		<td><input type="checkbox" id="menu7" name="menu7"<?php if($menu7) { echo " checked"; } ?>></td>
		<td><?php echo "Encaissements"; ?></td></tr>
		<tr>
		<td><input type="checkbox" id="menu8" name="menu8"<?php if($menu8) { echo " checked"; } ?>></td>
		<td><?php echo "Caisse Paie"; ?></td></tr>
		<tr>
		<td><input type="checkbox" id="menu9" name="menu9"<?php if($menu9) { echo " checked"; } ?>></td>
		<td><?php echo "Achats"; ?></td></tr>
		<tr>
		<td><input type="checkbox" id="menu10" name="menu10"<?php if($menu10) { echo " checked"; } ?>></td>
		<td><?php echo "Gestion stock"; ?></td></tr>
		<tr>
		<td><input type="checkbox" id="menu11" name="menu11"<?php if($menu11) { echo " checked"; } ?>></td>
		<td><?php echo "Gestion Production"; ?></td></tr>
		<tr>
		<td><input type="checkbox" id="menu12" name="menu12"<?php if($menu12) { echo " checked"; } ?>></td>
		<td><?php echo "Gestion Maintenance"; ?></td></tr>
		<tr>
		<td><input type="checkbox" id="menu13" name="menu13"<?php if($menu13) { echo " checked"; } ?>></td>
		<td><?php echo "Echeancier"; ?></td></tr>
		<td><input type="checkbox" id="menu14" name="menu14"<?php if($menu14) { echo " checked"; } ?>></td>
		<td><?php echo "Paie"; ?></td></tr>		
		<td><input type="checkbox" id="menu15" name="menu15"<?php if($menu15) { echo " checked"; } ?>></td>
		<td><?php echo "Bon de Commande"; ?></td></tr>	
		<td><input type="checkbox" id="menu16" name="menu16"<?php if($menu16) { echo " checked"; } ?>></td>
		<td><?php echo "Avoirs clients"; ?></td></tr>			
	</table>

		</center>

	</td></tr></table>

	</center>

</td></tr></table>


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
<?php } ?>
</tr></table>

</center>

</form>

</body>

</html>
