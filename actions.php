<?php

	/* OpenBookings.org - Copyright (C) 2005 Jérôme ROGER (jerome@openbookings.org)
	
	actions.php - This file is part of OpenBookings.org (http://www.openbookings.org)

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

	$message = "";

	switch($_REQUEST["action_"]) {

		case "add_booking":
		// the function AddBooking() is implemented in the file "functions.php"
		AddBooking($_REQUEST["manager_email"], $_REQUEST["booker_id"], $_REQUEST["object_id"], $_REQUEST["booking_start"], $_REQUEST["booking_end"], $_REQUEST["misc_info"], $_REQUEST["validated"]);
		break;

		case "confirm_booking":
			
		switch($_REQUEST["validated"]) {

			case "yes":
				$text1 = Translate("has valided your booking request");
				$text2 = Translate("Validated booking request");
				$action_sql = "UPDATE rs_data_bookings SET validated = 1 WHERE book_id = " . $_REQUEST["book_id"] . ";";
			break;

			case "no":
				$text1 = Translate("has refused your booking request");
				$text2 = Translate("Refused booking request");
				$action_sql = "DELETE FROM rs_data_bookings WHERE book_id = " . $_REQUEST["book_id"] . ";";
		}

		// extracts booking infos
		$sql = "SELECT user_id, object_id, book_start, book_end FROM rs_data_bookings WHERE book_id = " . $_REQUEST["book_id"] . ";";
		$temp = db_query($database_name, $sql);

		if($temp) { // booking still exists

			$temp_ = fetch_array($temp);

			$booker_id = $temp_["user_id"]; $object_id = $temp_["object_id"]; $booking_start = $temp_["book_start"]; $booking_end = $temp_["book_end"];

			// extracts object infos
			$sql = "SELECT object_name, manager_id FROM rs_data_objects WHERE object_id = " . $object_id . ";";
			$temp = db_query($database_name, $sql); $temp_ = fetch_array($temp);
			$object_name = $temp_["object_name"]; $manager_id = $temp_["manager_id"];
	 
			// extracts manager name
			$sql = "SELECT first_name, last_name, email FROM rs_data_users WHERE user_id = " . $manager_id . ";";
			$temp = db_query($database_name, $sql); $temp_ = fetch_array($temp);
			$manager_name = $temp_["first_name"] . " " . $temp_["last_name"]; $manager_email = $temp_["email"];

			// extracts booker email
			$sql = "SELECT first_name, last_name, email FROM rs_data_users WHERE user_id = " . $booker_id . ";";
			$temp = db_query($database_name, $sql); $temp_ = fetch_array($temp);
			$booker_name = $temp_["first_name"] . " " . $temp_["last_name"]; $booker_email = $temp_["email"];

			// do the action (confirm or cancel)
			db_query($database_name, $action_sql);
			
			// sends a confirmation email to the booker
			if($booker_email != "" && !is_null($booker_email) && param_extract("confirm_by_email") == "yes") {

				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$headers .= "From: " . $manager_name . " <" . $manager_email . ">\r\n";

				$message = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">" . chr(10);
				$message .= "<html>" . chr(10);
				$message .= "<head>" . chr(10);
				$message .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">" . chr(10);
				$message .= "<title>iframe</title>" . chr(10);
				
				$message .= "<style type=\"text/css\">" . chr(10);
				$message .= "a:link {color:black; text-decoration: none; }" . chr(10);
				$message .= "a:visited {color:black; text-decoration: none; }" . chr(10);
				$message .= "a:hover {color:red; text-decoration: none; }" . chr(10);
				$message .= "table { border-collapse: collapse; }" . chr(10);
				$message .= "td { padding: 3px; }" . chr(10);
				$message .= "</style>" . chr(10);

				$message .= "</head>" . chr(10);

				$message .= "<body>" . chr(10);

				$message .= $manager_name . " " . $text1 . " :" . chr(10);
				$message .= "<p>" . chr(10);
				$message .= Translate("Object") . " : " . $object_name . "<br>" . chr(10);
				$message .= Translate("Start") . " : " . date("d/m/Y H:i", strtotime($booking_start)) . "<br>" . chr(10);
				$message .= Translate("End") . " : " . date("d/m/Y H:i", strtotime($booking_end)) . "<p>" . chr(10);

				$message .= "</body>" . chr(10);
				$message .= "</html>";
					
				mail($booker_email, $text2, $message, $headers);

				$message = Translate("Confirmation was sent to") . " " . $booker_name;
			}
		
		} else { // booking was already cancelled

			$message = Translate("This booking was cancelled by the user even before your try to confirm it") . ".";
		}
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "OpenBookings.org :: " . Translate("Actions"); ?></title>

<style type="text/css">
a:link {color:black; text-decoration: none; }
a:visited {color:black; text-decoration: none; }
a:hover {color:red; text-decoration: none; }
table { border-collapse: collapse; border-spacing: 0px; }
td { padding: 0px; }
</style>

<script type="text/javascript"><!--
--></script>

</head>

<body style="background:#ffffff">

<?php echo $message; ?>

</body>

</html>