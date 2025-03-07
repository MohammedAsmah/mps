<?php

	/* OpenBookings - Copyright (C) 2005 Jérôme ROGER (jerome@openbookings.org)
	
	family.php - This file is part of OpenBookings.org (http://www.openbookings.org)

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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">

<title><?php echo "OpenBookings.org :: " . Translate("Family"); ?></title>

<?
	$family_id = $_REQUEST["family_id"];
		
	if($family_id == "0") {
		
		$action_ = "insert_new_family";

		$family_name = "";
		$sort_order = "";
		
	} else {

		$action_ = "update_family";
		
		$sql  = "SELECT family_id, family_name, sort_order ";
		$sql .= "FROM rs_param_families WHERE family_id = " . $family_id . ";";
		$temp = db_query($database_name, $sql); $temp_ = fetch_array($temp);
		
		$family_name = $temp_["family_name"];
		$sort_order = $temp_["sort_order"];
	}

	// actions
	if(isset($_REQUEST["action_"])) {
	
		// postype : "before" = -1, "after" = 0
		$order = intval($_REQUEST["sort_order"]) + intval($_REQUEST["postype"]) +1;

		switch($_REQUEST["action_"]) {
	
			case "insert_new_family":

			// punch hole in sort #
			$sql = "UPDATE rs_param_families SET sort_order = sort_order + 1 WHERE sort_order >= " . $order . ";";
			//db_query($database_name, $sql);

			$sql  = "INSERT INTO rs_param_families ( family_name, sort_order ) ";
			$sql .= "VALUES ( ";
			$sql .= "'" . $_REQUEST["family_name"] . "', ";
			$sql .= "'" . $order . "' );";
			//db_query($database_name, $sql);
		
			break;
			
			case "update_family":
			
			// removes sort #
			$sql = "UPDATE rs_param_families SET sort_order = 0 WHERE sort_order = " . $_REQUEST["previous_sort_order"] . ";";
			//db_query($database_name, $sql);

			$sql = "SELECT family_id, sort_order FROM rs_param_families WHERE sort_order <> 0 ORDER BY sort_order;";
			$temp = db_query($database_name, $sql);

			if($order > 0) { $s = 0; } else { $s = 1; }
			
			while($temp_ = fetch_array($temp)) { $s++;
				if($temp_["sort_order"] <= $order || $order == 0) {
					$sql = "UPDATE rs_param_families SET sort_order = " . $s . " WHERE family_id = " . $temp_["family_id"] . ";";

					//db_query($database_name, $sql);
				}
			}

			if($order == 0) { $order = 1; }
			
			$sql = "UPDATE rs_param_families SET ";
			$sql .= "family_name = '" . $_REQUEST["family_name"] . "', ";
			$sql .= "sort_order = '" . $order . "' ";
			$sql .= "WHERE family_id = " . $_REQUEST["family_id"] . ";";
			//db_query($database_name, $sql);

		} // switch
?>

	<style type="text/css">
	body { background:#dfe8ff; }
	</style>

	<script type="text/javascript"><!--
		window.close();
		opener.location.reload();
	--></script>

</head>

<body style="text-align:center; margin-top:10px">

</body>

</html>

<?php

	} else { // !isset($_REQUEST["action_"])
	
		// extracts families list
		$families_list = "<select id='sort_order' name='sort_order'>";
		$sql  = "SELECT sort_order, family_name FROM rs_param_families ";
		$sql .= "WHERE family_id <> " . $family_id . " ";
		$sql .= "ORDER BY sort_order;";
		$temp = db_query($database_name, $sql);

		while($temp_ = fetch_array($temp)) {
			if($temp_["sort_order"] == $sort_order) { $selected = " selected"; } else { $selected = ""; }
			$families_list .= "<option value='" . $temp_["sort_order"] . "'" . $selected . ">" . $temp_["family_name"] . "</option>";
		}

		$families_list .= "</select>";

?>

	<style type="text/css">
	body { background:#dfe8ff; }
	a:link {color:black; text-decoration: none; }
	a:visited {color:black; text-decoration: none; }
	a:hover {color:red; text-decoration: none; }
	form { margin:0px; padding: 0px; }
	table { border-collapse: collapse; }
	td { padding: 3px; }
	</style>

</head>

<body style="text-align:center; margin-top:10px">

<center>

<form name="form_family" method="post" action="family.php">

<table><tr><td>

	<span style="font-size:24px"><?php echo Translate("Family"); ?></span><br>

	<table style="border:2px groove; background:#efefef"><tr><td style="padding:10px">

		<table>
		<tr><td><?php echo Translate("Family name"); ?><br><input id="family_name" name="family_name" style="width:200px; text-align:center" value="<?php echo $family_name; ?>"></td></tr>
		<tr><td style="height:10px"></td></tr>
		<tr><td style="font-weight:bold"><?php echo Translate("Position in list"); ?><br>
		
		<table><tr>
			<td><input type="radio" id="postype" name="postype" value="-1" checked><?php echo Translate("Before"); ?></td>
			<td><input type="radio" id="postype" name="postype" value="0"><?php echo Translate("After"); ?></td>
		</tr></table>
		
		<tr><td><?php echo $families_list; ?></td></tr>

		</tr></table>
	
	</td></tr></table>

</td></tr><tr><td style="text-align:center">

<button style="width:100px" type="submit"><?php echo Translate("OK"); ?></button>

</td></tr></table>

<input type="hidden" id="previous_sort_order" name="previous_sort_order" value="<?php echo $sort_order; ?>">
<input type="hidden" id="family_id" name="family_id" value="<?php echo $family_id; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">

</form>

</center>

</body></html>

<?php } // action_ ?>