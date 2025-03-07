<?php
	
	/* OpenBookings - Copyright (C) 2005 Jérôme ROGER (jerome@openbookings.org)
	
	settings.php - This file is part of OpenBookings.org (http://www.openbookings.org)

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

	if(isset($_REQUEST["action_"])) {
		$sql = "UPDATE rs_param SET param_value = '" . $_REQUEST["activity_start"] . "' WHERE param_name = 'activity_start';"; db_query($database_name, $sql);
		$sql = "UPDATE rs_param SET param_value = '" . $_REQUEST["activity_end"] . "' WHERE param_name = 'activity_end';"; db_query($database_name, $sql);
		$sql = "UPDATE rs_param SET param_value = '" . $_REQUEST["activity_step"] . "' WHERE param_name = 'activity_step';"; db_query($database_name, $sql);
		$sql = "UPDATE rs_param SET param_value = '" . $_REQUEST["validated_color"] . "' WHERE param_name = 'validated_color';"; db_query($database_name, $sql);
		$sql = "UPDATE rs_param SET param_value = '" . $_REQUEST["unvalidated_color"] . "' WHERE param_name = 'unvalidated_color';"; db_query($database_name, $sql);
		$sql = "UPDATE rs_param SET param_value = '" . $_REQUEST["users_can_edit_objects"] . "' WHERE param_name = 'users_can_edit_objects';"; db_query($database_name, $sql);
		$sql = "UPDATE rs_param SET param_value = '" . $_REQUEST["confirm_by_email"] . "' WHERE param_name = 'confirm_by_email';"; db_query($database_name, $sql);
		$sql = "UPDATE rs_param SET param_value = '" . $_REQUEST["language"] . "' WHERE param_name = 'language';"; db_query($database_name, $sql);
		$sql = "UPDATE rs_param SET param_value = '" . $_REQUEST["session_timeout"] . "' WHERE param_name = 'session_timeout';"; db_query($database_name, $sql);
	}

	// constructs the languages list. if you want to localize the program to another language,
	// just add a column to the table rs_param_lang and fill it with translated word or sentences
	$languages_list = "";
	$sql = "SHOW COLUMNS FROM rs_param_lang";
	$columns = db_query($database_name, $sql);

	$language = param_extract("language");

	while($columns_ = fetch_array($columns)) {
		
		if($columns_["Field"] != "lang_id") {
			
			if($columns_["Field"] == $language) {
				$languages_list .= "<option selected>";
			} else {
				$languages_list .= "<option>";
			}
			
			$languages_list .= $columns_["Field"] . "</option>";
		}
	}

	// constructs hours list
	$activity_start = strtotime("1970-01-01 " . param_extract("activity_start"));
	$activity_end = strtotime("1970-01-01 " . param_extract("activity_end"));

	$start_hours_list = ""; $end_hours_list = "";
	
	for($h=0;$h<=864000;$h+=1800) {
		$start_hours_list .= "<option value=\"" . date("H:i", $h) . "\"";
		if($activity_start == $h) { $start_hours_list .= " selected"; }
		$start_hours_list .= ">" . date("H:i", $h) . "</option>" . chr(10);
		
		$end_hours_list .= "<option value=\"" . date("H:i", $h) . "\"";
		if($activity_end == $h) { $end_hours_list .= " selected"; }
		$end_hours_list .= ">" . date("H:i", $h) . "</option>" . chr(10);
	}

	$activity_step = param_extract("activity_step");
	
	$step_list = "";
	$step_list .= "<option value=\"5\""; if($activity_step == "5") { $step_list .= " selected"; }; $step_list .= ">5</option>" . chr(10);
	$step_list .= "<option value=\"10\""; if($activity_step == "10") { $step_list .= " selected"; }; $step_list .= ">10</option>" . chr(10);
	$step_list .= "<option value=\"15\""; if($activity_step == "15") { $step_list .= " selected"; }; $step_list .= ">15</option>" . chr(10);
	$step_list .= "<option value=\"20\""; if($activity_step == "20") { $step_list .= " selected"; }; $step_list .= ">20</option>" . chr(10);
	$step_list .= "<option value=\"30\""; if($activity_step == "30") { $step_list .= " selected"; }; $step_list .= ">30</option>" . chr(10);
	$step_list .= "<option value=\"60\""; if($activity_step == "60") { $step_list .= " selected"; }; $step_list .= ">60</option>" . chr(10);
	
	$users_can_edit_objects = param_extract("users_can_edit_objects");
	$confirm_by_email = param_extract("confirm_by_email");
	$validated_color = param_extract("validated_color");
	$unvalidated_color = param_extract("unvalidated_color");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "OpenBookings.org :: " . Translate("Application settings"); ?></title>

<style type="text/css">
a:link {color:black; text-decoration: none; }
a:visited {color:black; text-decoration: none; }
a:hover {color:red; text-decoration: none; }
form { margin:0px; padding: 0px; }
table { border-collapse: collapse; }
td { padding: 3px; }
</style>

<script type="text/javascript"><!--
	<?php if(isset($_REQUEST["action_"])) { ?>parent.frames[0].location = "menu.php";<?php } ?>

--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo Translate("Application settings"); ?></span>

<form method="post" action="settings.php">

<table><tr><td>

<table style="background:#f7f7f7; border: 2px groove"><tr><td style="padding:10px">

<table>
<tr><td style="text-align:right"><?php echo Translate("Language"); ?> :</td><td><select id="language" name="language"><?php echo $languages_list; ?></select></td></tr>
<tr><td colspan="3" style="height:10px"></td></tr>
<tr><td style="text-align:right"><?php echo Translate("Activity start"); ?> :</td><td colspan="2"><select id="activity_start" name="activity_start" style="width:70px"><?php echo $start_hours_list; ?></select></td></tr>
<tr><td style="text-align:right"><?php echo Translate("Activity end"); ?> :</td><td colspan="2"><select id="activity_end" name="activity_end" style="width:70px"><?php echo $end_hours_list; ?></select></td></tr>
<tr><td style="text-align:right"><?php echo Translate("Activity step"); ?> :</td><td><select id="activity_step" name="activity_step" style="width:70px"><?php echo $step_list; ?></select></td><td><?php echo Translate("minutes"); ?></td></tr>
<tr><td colspan="3" style="height:10px"></td></tr>
<tr><td style="text-align:right"><?php echo Translate("Validated bookings color"); ?> :</td><td><input id="validated_color" name="validated_color" style="width:60px" value="<?php echo $validated_color; ?>"></td><td><table><tr><td style="border:1px solid;height:20px;padding:0px;width:30px; background:<?php echo $validated_color; ?>"></td></tr></table></td></tr>
<tr><td style="text-align:right"><?php echo Translate("Unvalidated bookings color"); ?> :</td><td><input id="unvalidated_color" name="unvalidated_color" style="width:60px" value="<?php echo $unvalidated_color; ?>"></td><td><table><tr><td style="border:1px solid; height:20px;padding:0px;width:30px; background:<?php echo $unvalidated_color; ?>"></td></tr></table></td></tr>
<tr><td colspan="3" style="height:10px"></td></tr>
<tr><td style="text-align:right"><?php echo Translate("Users can add/edit objects"); ?> :</td><td colspan="2"><select id="users_can_edit_objects" name="users_can_edit_objects"><option value="no"<?php if($users_can_edit_objects == "no") { echo " selected"; } ?>><?php echo Translate("Disabled"); ?></option><option value="yes"<?php if($users_can_edit_objects == "yes") { echo " selected"; } ?>><?php echo Translate("Enabled"); ?></option></select></td></tr>
<tr><td colspan="3" style="height:10px"></td></tr>
<tr><td style="text-align:right"><?php echo Translate("Email confirmations"); ?> :</td><td colspan="2"><select id="confirm_by_email" name="confirm_by_email"><option value="no"<?php if($confirm_by_email == "no") { echo " selected"; } ?>><?php echo Translate("Disabled"); ?></option><option value="yes"<?php if($confirm_by_email == "yes") { echo " selected"; } ?>><?php echo Translate("Enabled"); ?></option></select></td></tr>
<tr><td colspan="3" style="height:10px"></td></tr>
<tr><td style="text-align:right"><?php echo Translate("Session timeout"); ?> :</td><td><input id="session_timeout" name="session_timeout" style="width:70px" value="<?php echo param_extract("session_timeout"); ?>"></td><td><?php echo Translate("seconds"); ?> ( 0 = <?php echo Translate("Never"); ?> )</td></tr>
</table>

</td></tr></table>

</td></tr>

<tr><td style="height:10px"></td></tr>

<tr><td style="text-align:center"><button type="submit"><?php echo Translate("Save changes"); ?></button></td></tr>

</table>

<input type="hidden" id="action_" name="action_" value="save_settings">

</form>

</body>

</html>