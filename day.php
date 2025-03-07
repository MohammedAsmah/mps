<?php

	/* OpenBookings - Copyright (C) 2005 Jérôme ROGER (jerome@openbookings.org)
	
	day.php - This file is part of OpenBookings.org (http://www.openbookings.org)

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
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<?php

	// screen width is dynamically outputed with a javascript by the caller
	$screen_width = (intval($_REQUEST["screen_width"]) - 260); $offset = 20;
	
	// extracts colors
	$validated_color = param_extract("validated_color");
	$unvalidated_color = param_extract("unvalidated_color");
	
	// extracts hours of activity start, end and step
	$start_hour = param_extract("activity_start");
	$end_hour = param_extract("activity_end");
	$activity_step = param_extract("activity_step") * 60;
	
	// calculates full timestamp of the activity for the selected day
	$activity_start = strtotime(date("Y-m-d", $_REQUEST["stamp"]) . " " . $start_hour);
	$activity_end = strtotime(date("Y-m-d", $_REQUEST["stamp"]) . " " . $end_hour);
	
	// calculates the width of one time step in pixels
	$coef = intval(($activity_end - $activity_start) / $screen_width);
	$step_size = intval($activity_step/$coef);

	// calculates the width of one hour in pixels
	$hour_step_size = $step_size * (60 / param_extract("activity_step"));

	// extracts infos about the selected object
	$sql  = "SELECT rs_param_families.family_name, rs_data_objects.object_name, rs_data_objects.manager_id ";
	$sql .= "FROM rs_data_objects INNER JOIN rs_param_families ON rs_data_objects.family_id = rs_param_families.family_id ";
	$sql .= "WHERE rs_data_objects.object_id = " . $_REQUEST["object_id"] . ";";
	$temp = db_query($database_name, $sql); $temp_ = fetch_array($temp);

	$manager_id = $temp_["manager_id"];

	if($manager_id != 0) {
		$sql = "SELECT first_name, last_name, email ";
		$sql .= "FROM rs_data_users ";
		$sql .= "WHERE user_id = " . $manager_id . ";";
		$temp = db_query($database_name, $sql); $temp_ = fetch_array($temp);

		$person_in_charge_name = $temp_["first_name"] . " " . $temp_["last_name"];
		$person_in_charge_email = $temp_["email"];
	
	} else {
		$person_in_charge_name = Translate("nobody in charge");
		$person_in_charge_email = "";
	}
?>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "OpenBookings.org :: " . date("d/m/Y", $_REQUEST["stamp"]); ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<style type="text/css">
div { position:absolute; }
.hour_tag { top:58px; font-family: Comic sans MS; font-size:10px; }
.line { top:56px; width:1px; height:3px; font-size:0px; background:black; }
.free_step { cursor:pointer; top:40px; height:15px; width:<?php echo intval($activity_step / $coef) - 3; ?>px; background:#0000ff; font-size:0px; }
.booked_step { cursor:pointer; top:40px; height:15px; width:<?php echo intval($activity_step / $coef) - 3; ?>px; background:#ff0000; font-size:0px; }
.info { top:30px; visibility:hidden; background:#ffffcc; color:#000000; border: 1px ridge; padding:0px 3px 0px 3px; width:200px; font-size:12px;}
</style>

<script type="text/javascript"><!--
	
	// this function shows a popup near the mouse pointer when overheading the hours drawing
	function ShowInfos(evenement, booking_nr) {
		
		if(document.getElementById("s" + booking_nr).value != "0") { // showing booking info is useless if there is no booking
			var infos = ""; posx = 0;
			infos += "<span style='font-weight:bold'>" + bookings[document.getElementById("s" + booking_nr).value][1] + "</span><br>"; // booker name
			infos += bookings[document.getElementById("s" + booking_nr).value][2]; // misc infos
			
			document.getElementById("book_details").innerHTML = infos;

			if(evenement.clientX < <?php echo intval($screen_width/2); ?>) {
				posx = evenement.clientX + 20;
			} else {
				posx = evenement.clientX - (200 + 20);
			}
			document.getElementById("book_details").style.left = posx;
			
			document.getElementById("book_details").style.visibility = "visible";
		}		
	}

	function HideInfos() { document.getElementById("book_details").style.visibility = "hidden"; }
	
	function OuvrirResa(stamp) {
			var book_id = document.getElementById("s" + stamp).value;
			window.open("book.php?book_id=" + book_id + "&object_id=<?php echo $_REQUEST["object_id"]; ?>&stamp=" + stamp, "ajout_resa", "width=500, height=250, left=" + (screen.width-400)/2 + ", top=" + (screen.height-250)/2);
	}

--></script>

</head>

<body>

<span id="title_" style="position:absolute; font-size:20px; top:2px; left:10px"></span>

<?php
	
	// extracts the bookings for the selected day
	$sql  = "SELECT book_id, book_start, book_end, user_id, misc_info, validated ";
	$sql .= "FROM rs_data_bookings ";
	$sql .= "WHERE object_id = " . $_REQUEST["object_id"] . " ";
	$sql .= "AND ((book_start >= '" . date("Y-m-d", $_REQUEST["stamp"]) . "' ";
	$sql .= "AND book_start < '" . date("Y-m-d", ($_REQUEST["stamp"] + 86400)) . "') ";
	$sql .= "OR (book_end >= '" . date("Y-m-d", $_REQUEST["stamp"]) . "' ";
	$sql .= "AND book_end < '" . date("Y-m-d", ($_REQUEST["stamp"] + 86400)) . "') ";
	$sql .= "OR (book_start <= '" .  date("Y-m-d", $_REQUEST["stamp"]) . "' ";
	$sql .= "AND book_end >= '" . date("Y-m-d", $_REQUEST["stamp"]) . "'));";
	
	$bookings = db_query($database_name, $sql);

	// dispays the timesteps
	$n = -1; for($t=$activity_start; $t<$activity_end; $t+=$activity_step) { $n++;
		echo "<div id=\"step_" . $t . "\" class=\"free_step\" style=\"left:" . (($step_size * $n) + $offset) . "px\" onMouseOver=\"ShowInfos(event, '" . $t . "')\" onMouseOut=\"HideInfos()\" onClick=\"OuvrirResa('" . $t . "')\"><input type=\"hidden\" id=\"s" . $t . "\" value=\"0\"></div>" .chr(10);
	}

	// displays the hours digits as a caption
	$n = -1; for($t=$activity_start; $t<=$activity_end; $t+=3600) { $n++;
		echo "<div class=\"hour_tag\" style=\"left:" . (($hour_step_size * $n) + $offset - 8) . "px\">" . date("H", $t) . "</div>" .chr(10);
		echo "<div class=\"line\" style=\"left:" . (($hour_step_size * $n) + $offset - 2) . "px\"></div>" .chr(10);
	}

	// hilight of the booked areas using javascript
	
	// var bookings[x][y] with following y values :
	// 1 = bookings #id, 2 = booker name, 3 = misc info

	echo "<script type=\"text/javascript\"><!--" . chr(10) . chr(10);
	echo "var bookings = new Array();" . chr(10) . chr(10);

	$n = 0;
	
	while($bookings_ = fetch_array($bookings)) { $n++;
		
		// extracts booker's name
		$sql  = "SELECT last_name, first_name ";
		$sql .= "FROM rs_data_users WHERE user_id = " . $bookings_["user_id"] . ";";
		$booker = db_query($database_name, $sql); $booker_ = fetch_array($booker);

		// constructs a javascript array that contains infos about bookings,
		// in order to show details about every bookings without having to query the database
		
		echo "bookings[" . $bookings_["book_id"] . "] = new Array();" . chr(10);
		
		echo "bookings[" . $bookings_["book_id"] . "][1] = \"" . $booker_["first_name"] . " " . $booker_["last_name"] . "\";" . chr(10);
		
		if($bookings_["misc_info"] == "" || $bookings_["misc_info"] == Chr(13).Chr(10)) {
			echo "bookings[" . $bookings_["book_id"] . "][2] = \"(" . Translate("no more informations") . ")\";" . chr(10) . chr(10);
		} else { 
			echo "bookings[" . $bookings_["book_id"] . "][2] = \"" . str_replace(Chr(13).Chr(10), "<br>", $bookings_["misc_info"]) . "\";" . chr(10) . chr(10);
		}

		if($bookings_["validated"]) { $book_color = $validated_color; } else { $book_color = $unvalidated_color; }
		
		for($t=$activity_start; $t<$activity_end; $t+=$activity_step) {

			if($t >= strtotime($bookings_["book_start"]) && $t < strtotime($bookings_["book_end"])) {
				echo "document.getElementById(\"s" . $t . "\").value = \"" . $bookings_["book_id"] . "\";" . chr(10);
				echo "document.getElementById(\"step_" . $t . "\").style.background = \"" . $book_color . "\";" . chr(10);
			}
		}
	}

	echo "--></script>" . chr(10);

	echo "<div id=\"book_details\" class=\"info\"></div>";
?>

<script type="text/javascript"><!--
	document.getElementById("title_").innerHTML = parent.document.getElementById("title_").value + " ( <?php echo $person_in_charge_name; ?> ) - <?php echo date("d/m/Y", $_REQUEST["stamp"]); ?>";
--></script>

</body>

</html>