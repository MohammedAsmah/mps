<?php

	/* OpenBookings.org - Copyright (C) 2005 Jérôme ROGER (jerome@openbookings.org)
	
	availables.php - This file is part of OpenBookings.org (http://www.openbookings.org)

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

	$start = DateAndHour($_REQUEST["search_start_date"], $_REQUEST["search_start_hour"] + $time_offset);
	$end = DateAndHour($_REQUEST["search_end_date"], $_REQUEST["search_end_hour"] + $time_offset);
	
	$start_ = date("d/m/Y H:i", strtotime($start));
	$end_ = date("d/m/Y H:i", strtotime($end));

	// extracts family name using family_id as parameter
	$sql = "SELECT family_name FROM rs_param_families WHERE family_id = " . $_REQUEST["family_id"] . ";";
	$temp = db_query($database_name, $sql); $temp_ = fetch_array($temp); $family_name = $temp_["family_name"];
	
	// lists objects which are booked within the specified time range
	$sql  = "SELECT DISTINCT rs_data_objects.object_id ";
	$sql .= "FROM rs_data_bookings INNER JOIN rs_data_objects ON rs_data_bookings.object_id = rs_data_objects.object_id ";
	$sql .= "WHERE rs_data_objects.family_id = " . $_REQUEST["family_id"] . " ";
	
	$sql .= "AND ((rs_data_bookings.book_end > '" . $start . "' ";
	$sql .= "AND rs_data_bookings.book_end <= '" . $end . "') ";
	$sql .= "OR (rs_data_bookings.book_start < '" . $end . "' ";
	$sql .= "AND rs_data_bookings.book_start >= '" . $start . "') ";
	$sql .= "OR (rs_data_bookings.book_start <= '" . $start . "' ";
	$sql .= "AND rs_data_bookings.book_end >= '" . $end . "')) ";
	
	$unavailable_objets = db_query($database_name, $sql);

	$unavailable_list = "";

	while($unavailable_objets_ = fetch_array($unavailable_objets)) { $unavailable_list .= $unavailable_objets_["object_id"] . ","; }
	if($unavailable_list != "") { $unavailable_list = substr($unavailable_list, 0, strlen($unavailable_list)-1); } //shorts last comma

	// lists objects which are NOT booked in the specified time range
	$sql  = "SELECT DISTINCT object_id, object_name, manager_id ";
	$sql .= "FROM rs_data_objects ";
	$sql .= "WHERE rs_data_objects.family_id = " . $_REQUEST["family_id"] . " ";
	if($unavailable_list != "") { $sql .= "AND rs_data_objects.object_id NOT IN ( " . $unavailable_list . " )"; }
	$sql .= ";";

	$available_objects = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "OpenBookings.org :: " . Translate("Availables objects"); ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
		function OpenBooking(object_id) {
			window.open("book.php?book_id=0&object_id=" + object_id + "&start=<?php echo strtotime($start); ?>&end=<?php echo strtotime($end); ?>", "ajout_resa", "width=500, height=250, left=" + (screen.width-400)/2 + ", top=" + (screen.height-250)/2);
		}
--></script>

</head>

<body>

<span id="title_" style="font-size:24px"><?php echo $family_name; ?> <?php echo Translate("availables"); ?> <?php echo Translate("from"); ?> <?php echo $start_; ?> <?php echo Translate("to"); ?> <?php echo $end_; ?></span>

<table class="table2">

<tr>
	<th><?php echo Translate("Object name"); ?></th>
	<th><?php echo Translate("Person in charge"); ?></th>
	<th style="width:90px">&nbsp;</th>
</tr>

<?php while($available_objets_ = fetch_array($available_objects)) {
	
	if($available_objets_["manager_id"] != 0) {

		// gets the manager name using manager id as parameter
		$sql  = "SELECT last_name, first_name, email FROM rs_data_users ";
		$sql .= "WHERE user_id = " . $available_objets_["manager_id"] . ";";
		$manager = db_query($database_name, $sql); $manager_ = fetch_array($manager);

		$manager_name = $manager_["first_name"] . " " . $manager_["last_name"];
		$manager_email = $manager_["email"];

	} else {

		$manager_name = Translate("None");
		$manager_email = "";
	}

?><tr>

<td><?php echo $available_objets_["object_name"]; ?></td>
<td><?php if($manager_email != "") { ?><a href="mailto:<?php echo $manager_email; ?>"><?php } ?><?php echo $manager_name; ?><?php if($manager_email != "") { ?></a><?php } ?></td>
<td style="text-align:center"><button onClick="OpenBooking(<?php echo $available_objets_["object_id"]; ?>)"><?php echo Translate("Book it !"); ?></button></td>
</tr><?php } ?>

</table>

</body>

</html>