<?php
	
	/* OpenBookings - Copyright (C) 2005 Jérôme ROGER (jerome@openbookings.org)
	
	calendar.php - This file is part of OpenBookings.org (http://www.openbookings.org)

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

	CheckCookie(); // Resets app to the index page if timeout is reached. This finction is implemented in functions.php
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<?php

	// uses the current year if not specified by the posted vars
	if(isset($_REQUEST["stamp"])) {
		$annee = date("Y", $_REQUEST["stamp"]);
	} else {
		if(isset($_REQUEST["annee"])) { $annee = $_REQUEST["annee"]; } else { $annee = date("Y"); }
	}

	// extracts colors from the table which holds parameters
	// the function "param_extract()" is implemented in the file "functions.php"
	$validated_color = param_extract("validated_color");
	$unvalidated_color = param_extract("unvalidated_color");
	
	$sql  = "SELECT rs_param_families.family_name, rs_data_objects.object_name ";
	$sql .= "FROM rs_data_objects INNER JOIN rs_param_families ON rs_data_objects.family_id = rs_param_families.family_id ";
	$sql .= "WHERE rs_data_objects.object_id = " . $_REQUEST["object_id"] . ";";
	$temp = db_query($database_name, $sql); $temp_ = fetch_array($temp);

	$family_name = $temp_["family_name"]; $object_name = $temp_["object_name"];

	// extracts current year bookings
	$sql = "SELECT book_id, book_start, book_end FROM rs_data_bookings ";
	$sql .= "WHERE object_id = " . $_REQUEST["object_id"] . " ";
	$sql .= "AND (YEAR(book_start) = " . $annee . " ";
	$sql .= "OR YEAR(book_end) = " . $annee . ");";
	$reservations = db_query($database_name, $sql);

	// extracts infos about selected object
	$sql  = "SELECT rs_param_families.family_name, rs_data_objects.object_name ";
	$sql .= "FROM rs_data_objects INNER JOIN rs_param_families ON rs_data_objects.family_id = rs_param_families.family_id ";
	$sql .= "WHERE rs_data_objects.object_id = " . $_REQUEST["object_id"] . ";";
	$temp = db_query($database_name, $sql); $temp_ = fetch_array($temp);

	$family_name = $temp_["family_name"]; $object_name = $temp_["object_name"];
?>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "OpenBookings.org :: " . Translate("Calendar"); ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function ClickOnDay(stamp) { document.getElementById("iframe_jour").src = "day.php?stamp=" + stamp + "&object_id=<?php echo $_REQUEST["object_id"]; ?>&screen_width=" + screen.width; }
--></script>

</head>

<body style="margin-top:5px; margin-bottom:0px">

<iframe id="iframe_jour" name="iframe_jour" frameborder="0" scrolling="no" style="background:#dfe8ff; height:90px; width:100%;"></iframe>

<table><tr>

<?php
	for($mois=1;$mois<=12;$mois++) {
		$jour = 1;
?>

<td VALIGN="TOP" style="font-size:13px; font-weight:bold; width:58px; padding:0px">

<?php echo Translate(date("F", strtotime($annee . "-" . $mois . "-" . $jour))); ?><br>

<table class="table1">

<?php
	
	while(checkdate($mois, $jour, $annee)) {

		if(strlen($mois) == 1) { $mois = "0" . $mois; }
		if(strlen($jour) == 1) { $jour = "0" . $jour; }

		$date_en_cours = $annee . "-" . $mois . "-" . $jour;
		
		$day_name = Translate(date("l", strtotime($date_en_cours)));

		$range_start = $date_en_cours;
		$range_end = date("Y-m-d", strtotime($date_en_cours) + 86400);
		
		if(date("l", strtotime($date_en_cours)) == "Saturday" || date("l", strtotime($date_en_cours)) == "Sunday") {
			$couleur = "#7f7fff";
			$ferie = 0;
		} else {
			$couleur = "#efefef";
			$ferie = 1;
		}
?>

<tr id="j<?php echo strtotime($date_en_cours); ?>" style="background:<?php echo $couleur;?>; cursor: pointer" onClick="ClickOnDay(<?php echo strtotime($date_en_cours); ?>)">
<td style="width:20px; text-align:center"><?php echo date("d", strtotime($date_en_cours)); ?></td>
<td style="width:50px"><?php echo substr($day_name, 0, 3); ?><input type="hidden" id="s<?php echo strtotime($date_en_cours); ?>" name="s<?php echo strtotime($date_en_cours); ?>" value="<?php if(date("l", strtotime($date_en_cours)) == "Saturday" || date("l", strtotime($date_en_cours)) == "Sunday") { echo "c"; } else { echo "o"; } ?>"></td></tr>

<?php $jour++; }?>

</table>

</td>

<td style="width:8px"></td>

<?php } ?>

</tr></table>

<script type="text/javascript"><!--

	<?php $n = 0; while($reservations_ = fetch_array($reservations)) { $n++;

		$range_start = strtotime(date("Y-m-d", strtotime($reservations_["book_start"])));
		$range_end = strtotime(date("Y-m-d", strtotime($reservations_["book_end"])));

		// Bug fix #2 - 21/11/2005
		if(date("Y",strtotime($reservations_["book_start"])) < $annee) {
			$jour = 1;
			$mois = 1;
			$annee_ = $annee;
		} else {
			$jour = date("d", strtotime($reservations_["book_start"]));
			$mois = date("m", strtotime($reservations_["book_start"]));
			$annee_ = date("Y", strtotime($reservations_["book_start"]));
		}		

		// Old version (0.5.1b)
		//$jour = date("d", strtotime($reservations_["book_start"]));
		//$mois = date("m", strtotime($reservations_["book_start"]));
		//$annee = date("Y", strtotime($reservations_["book_start"]));

		$stamp = strtotime($annee_ . "-" . $mois . "-" . $jour);
		
		while($stamp <= $range_end) {
		
			$day_name = Translate(date("l", $stamp));

			if(date("l", $stamp) == "Saturday" || date("l", $stamp) == "Sunday") {
				$couleur = "#cf1f1f";
				$ferie = 0;
			} else {
				$couleur = "#ff3f3f";
				$ferie = 1;
			}

			echo "document.getElementById(\"j". $stamp . "\").style.background = \"" . $validated_color . "\";" . chr(10);

			$jour++;
			
			if(!checkdate($mois, $jour, $annee_)) {
				$jour = 1; $mois ++;
				if($mois > 12) { $mois = 1; $annee_++; }
			}

			$stamp = strtotime($annee_ . "-" . $mois . "-" . $jour);
		}
	} ?>
	
	<?php if(isset($_REQUEST["stamp"])) { ?>
		ClickOnDay('<?php echo $_REQUEST["stamp"]; ?>'); // shows the day where a new booking has just been set
	<?php } else { ?>
		
		<?php if($annee == date("Y")) { ?>
			ClickOnDay('<?php echo strtotime(date("Y-m-d")); ?>'); // shows today if the user asks for the current year's calendar
		<?php } else { ?>
			ClickOnDay('<?php echo strtotime($annee . "-01-01"); ?>'); // shows the 1st of january if the user asks for another year
		<?php } ?>
	<?php } ?>

--></script>

<form action=""><input type="hidden" id="title_" name="title_" value="<?php echo $family_name . " / " . $object_name; ?>"></form>

</body>
</html>