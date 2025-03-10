<?php

	/* OpenBookings - Copyright (C) 2005 J�r�me ROGER (jerome@openbookings.org)
	
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
	
	// finds monday of the selected week & year
	$current_day = strtotime("01/01/" . $_REQUEST["year"]);
	while(date("w", $current_day) != 1 || date("W", $current_day) != $_REQUEST["week"]) { $current_day += 86400; }
	$monday = date("Y-m-d", $current_day);
	$stamp = strtotime($monday);
	
	// extracts object info
	$sql  = "SELECT object_name, family_name ";
	$sql .= "FROM rs_data_objects INNER JOIN rs_param_families ON rs_data_objects.family_id = rs_param_families.family_id WHERE object_id = " . $_REQUEST["object_id"] . ";";
	$object = db_query($database_name, $sql); $object_ = fetch_array($object);
	$object_name = $object_["object_name"]; $object_family = $object_["family_name"];

	// extracts the bookings for the selected week
	$sql  = "SELECT book_id, book_start, book_end, user_id, misc_info, validated ";
	$sql .= "FROM rs_data_bookings ";
	$sql .= "WHERE object_id = " . $_REQUEST["object_id"] . " ";
	$sql .= "AND ((book_start >= '" . date("Y-m-d", $stamp) . "' ";
	$sql .= "AND book_start < '" . date("Y-m-d", ($stamp + 604800)) . "') ";
	$sql .= "OR (book_end >= '" . date("Y-m-d", $stamp) . "' ";
	$sql .= "AND book_end < '" . date("Y-m-d", ($stamp + 604800)) . "') ";
	$sql .= "OR (book_start <= '" .  date("Y-m-d", $stamp) . "' ";
	$sql .= "AND book_end >= '" . date("Y-m-d", $stamp) . "'));";
	
	$bookings = db_query($database_name, $sql);

	// extracts colors
	$validated_color = param_extract("validated_color");
	$unvalidated_color = param_extract("unvalidated_color");
	
	// extracts hours of activity start, end and step
	$start_hour = param_extract("activity_start");
	$end_hour = param_extract("activity_end");
	$activity_step = param_extract("activity_step") * 60;
	
	$activity_start = strtotime("1970-01-01 " . $start_hour);
	$activity_end = strtotime("1970-01-01 " . $end_hour);

	// gets screen size (outputed with a javascript by the caller)
	$screen_width = (intval($_REQUEST["screen_width"]) - 260); // 260 is the width of the left menu
	$screen_height = (intval($_REQUEST["screen_height"]) - 350);
	$column_offset = 20;
	$line_offset = 3;
	$vertical_offset = 50;

	// calculates the width of one week column in pixels
	$column_width = intval(($screen_width - $column_offset * 7) / 7);

	// calculates the height of one week column in pixels
	$coef = intval(($activity_end - $activity_start) / $screen_height);
	$step_size = intval($activity_step/$coef);
	
	$hour_size = ($step_size / $activity_step) * 3600;

	$blabla_offset = $vertical_offset + ($activity_end - $activity_start) / $activity_step * ($step_size + $line_offset) + 15;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "OpenBookings.org :: " . $object_family . " / " . $object_name . " - " . Translate("Week #") . " " . $_REQUEST["week"]; ?></title>

<style type="text/css">
a:link {color:black; text-decoration: none; }
a:visited {color:black; text-decoration: none; }
a:hover {color:red; text-decoration: none; }
table { border-collapse: collapse; }
td { padding: 0px; }
div { position:absolute; }
.hour_tag { top:58px; font-family: Comic sans MS; font-size:10px; }
.line { top:56px; width:1px; height:3px; font-size:0px; background:black; }
.free_step { cursor:pointer; top:40px; height:15px; width:<?php echo intval($activity_step / $coef) - 3; ?>px; background:#0000ff; font-size:0px; }
.booked_step { cursor:pointer; top:40px; height:15px; width:<?php echo intval($activity_step / $coef) - 3; ?>px; background:#ff0000; font-size:0px; }
.info { top:30px; visibility:hidden; background:#ffffcc; color:#000000; border: 1px ridge; padding:0px 3px 0px 3px; width:200px; font-size:12px;}
</style>

<script type="text/javascript"><!--
--></script>

</head>

<body style="background:#dfe8ff">

<?php

	$html = "<div id=\"title\" style=\"font-size:24px; top:" . ($vertical_offset - 40) . "px\">" . $object_family . " / " . $object_name . " - " . Translate("Week #") . " " . $_REQUEST["week"] . "</div>";
	
	$n = -1;
	
	for($hour=$activity_start;$hour<=$activity_end;$hour+=3600) { $n++;

		//caption : hours
		$top = ($hour_size + $line_offset * $hour_size/$step_size) * $n + $vertical_offset + 5;
		$html .= "<div style=\"font-size:12px; width:30px; left:10px; height:" . $step_size . "px; top:" . $top . "px;\">" . date("H:i",$hour) . "</div>" . chr(10);
		
		$html .= "<div style=\"font-size:2px; width:5px; left:40px; height:1px; top:" . ($top + 7) . "px; border-top: 1px solid black\"></div>" . chr(10);
	}

	for($day=1;$day<=7;$day++) {

		$left = ($day - 1) * ($column_width + $column_offset) + 50;

		//caption : days names
		$html .= "<div style=\"font-weight:bold; left:" . $left . "; top:" . ($vertical_offset - 5) . "px;\">" . Translate(date("l", strtotime($monday) + 86400 * ($day - 1))) . "</div>" . chr(10);

		$n = -1;
		
		for($hour=$activity_start;$hour<$activity_end;$hour+=$activity_step) { $n++;

			$step_id = $stamp + ($day - 1) * 86400 + $hour;
			
			// hour boxes
			$top = ($step_size + $line_offset) * $n + $vertical_offset + 14;
			$html .= "<div id=\"step_" . $step_id . "\" style=\"font-size:8px; height:" . $step_size . "px; width:" . $column_width . "px; top:" . $top . "px; left:" . $left . "px; background:blue\"></div>" . chr(10);
		}
	}

	echo $html;

	echo "<script type=\"text/javascript\"><!--" . chr(10) . chr(10);

	$n = 0; $div = ""; $color = "";

	if($bookings) {
	
	$lightcolor = $validated_color;
	
	$darkred = (hexdec(substr($lightcolor, 1, 2)) - 48);
	$darkgreen = (hexdec(substr($lightcolor, 3, 2)) - 48);
	$darkblue = (hexdec(substr($lightcolor, 5, 2)) - 48);

	if($darkred < 0) { $darkred = 0; }
	if($darkgreen < 0) { $darkgreen = 0; }
	if($darkblue < 0) { $darkblue = 0; }

	$darkred = dechex($darkred); $darkgreen = dechex($darkgreen); $darkblue = dechex($darkblue);

	if(strlen($darkred) == 1) { $darkred = "0" . $darkred; }
	if(strlen($darkgreen) == 1) { $darkgreen = "0" . $darkgreen; }
	if(strlen($darkblue) == 1) { $darkblue = "0" . $darkblue; }

	$darkcolor = "#" . $darkred . $darkgreen . $darkblue;

		while($bookings_ = fetch_array($bookings)) { $n++;

			if($color == $lightcolor) { $color = $darkcolor; } else { $color = $lightcolor; }
			
			// extracts booker's name
			$sql  = "SELECT last_name, first_name ";
			$sql .= "FROM rs_data_users WHERE user_id = " . $bookings_["user_id"] . ";";
			
			$booker = db_query("bookings", $sql);
			
			if($booker) {
				$booker_ = fetch_array($booker);
				$booking_info = $booker_["first_name"] . " " . $booker_["last_name"] . "<br>";
				$booking_info .= $bookings_["misc_info"];
			} else {
				$booking_info = $bookings_["misc_info"];
			}
			
			for($day=1;$day<=7;$day++) {
			
				$m = 0;
				$left = ($day - 1) * ($column_width + $column_offset) + 50;
				
				$start = 0; $end = 0;

				// conputes the size of the coloured range
				for($t=$activity_start; $t<$activity_end; $t+=$activity_step) { $m++;

					$step_id = $stamp + (($day-1) * 86400) + $t + 3600;

					if($step_id >= strtotime($bookings_["book_start"]) && $step_id < strtotime($bookings_["book_end"])) {
						if($start == 0) { $start = $m; } else { $end = $m; }
					}
				}
				
				$top = ($step_size + $line_offset) * $start + $vertical_offset - $step_size + $line_offset + 7;
				$height = ($step_size + $line_offset) * ($end - $start + 1) - 1;
				
				// draws the coloured range over the scale to show the booking
				if($start != 0) { $div .= "<div valign=\"center\" id=\"booking_" . $n . "\" style=\"font-size:12px; vertical-align:center;background:" . $color . "; top:" . $top . "px; left:" . $left . "px; width:" . $column_width . "px; height:" . $height . "\">" . $booking_info . "</div>" . chr(10); }
			} // for
		} // while
	} // if

	echo "--></script>" . chr(10);

	echo $div;
	echo "<div id=\"book_details\" class=\"info\"></div>";
?>

<div id="print_date" style="top:<?php echo $blabla_offset; ?>px;left:50px"><?php echo Translate("Printed"); ?> <?php echo date("d/m/Y h:i"); ?> - <?php echo Translate("You are invited to check for changes on the web site"); ?>.</div>

</body>

</html>