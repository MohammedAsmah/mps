<?php
	
	
	// refeshes the cookie (resets timeout)
	if(isset($_COOKIE["bookings_user_id"])) {
		$session_timeout = param_extract("session_timeout");
		if($session_timeout == "0") { $session_timeout = "3600"; } 
		// cookie never expires (in fact it does after one week)
		setcookie("bookings_user_id", $_COOKIE["bookings_user_id"], (time() + $session_timeout));
	}

	/*function checkBooking($book_id, $object_id, $booking_start, $booking_end) {

		global $database_name, $time_offset;

		// checks if the new booking does not cover an existant one
		$sql = "SELECT book_id FROM rs_data_bookings ";
		$sql .= "WHERE object_id = " . $_REQUEST["object_id"] . " ";
		
		
		// new code after #6
		
		// |  ---|---
		$sql .= "AND ((book_start >= '" . date("Y-m-d H:i:s", strtotime($booking_start) + $time_offset) . "' ";
		$sql .= "AND book_start < '" . date("Y-m-d H:i:s", strtotime($booking_end) + $time_offset) . "' ";
		$sql .= "AND book_end >= '" . date("Y-m-d H:i:s", strtotime($booking_end) + $time_offset) . "') ";

		// ---|---  |
		$sql .= "OR (book_start <= '" . date("Y-m-d H:i:s", strtotime($booking_start) + $time_offset) . "' ";
		$sql .= "AND book_end > '" . date("Y-m-d H:i:s", strtotime($booking_start) + $time_offset) . "' ";
		$sql .= "AND book_end <= '" . date("Y-m-d H:i:s", strtotime($booking_end) + $time_offset) . "') ";

		// |-------|
		$sql .= "OR (book_start >= '" . date("Y-m-d H:i:s", strtotime($booking_start) + $time_offset) . "' ";
		$sql .= "AND book_end <= '" . date("Y-m-d H:i:s", strtotime($booking_end) + $time_offset) . "') ";

		// -|-----|-
		$sql .= "OR (book_start < '" . date("Y-m-d H:i:s", strtotime($booking_start) + $time_offset) . "' ";
		$sql .= "AND book_end > '" . date("Y-m-d H:i:s", strtotime($booking_end) + $time_offset) . "')) ";

		// end of new code after #6


		$sql .= "AND book_id <> '" . $book_id . "';";
		$temp = db_query($database_name, $sql);

		if($temp_ = fetch_array($temp)) { 
			$error_msg = Translate("This booking cannot be recorded as is covers another one") . ".";
		} else {
			$error_msg = "";
		}

		return $error_msg;
	}*/
	
	function Translate($english) {

		$language = param_extract("language");
		
		global $database_name;
		
		$sql = "SELECT " . $language . " FROM rs_param_lang ";
		$sql .= "WHERE english = '" . $english . "';";
		$translation = db_query($database_name, $sql);
		
		if($translation_ = fetch_array($translation)) {
			return $translation_[$language];
		} else {
			return "translation not found";
		}
	}

	// Sticks the hour to the date
	function DateAndHour($date, $hour) {

		$segments = explode("/", $date);
		$day = $segments[0];
		$month = $segments[1];
		$year = $segments[2];
		$date_and_hour = date("Y-m-d H:i:s", strtotime($year . "-" . $month . "-". $day) + $hour + 3600);
	
		return $date_and_hour;
	}

	function param_extract($param_name) {
		
		global $database_name;
		
		$sql = "SELECT param_value FROM rs_param WHERE param_name = '" . $param_name . "';";
		$temp = db_query($database_name, $sql); $temp_ = fetch_array($temp);
		$result = $temp_["param_value"]; return $result;
		
		




	}

	function CheckCookie() {  // Resets app to the index page if timeout is reached
	
		$session_timeout = param_extract("session_timeout");
		
		if(!isset($_COOKIE["bookings_user_id"])) {
			
			echo "<html><head>" . chr(10);
			echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">" . chr(10);
			echo "<title>Session has expired</title>" . chr(10);
			echo "<script type=\"text/javascript\"><!-- " . chr(10);
			echo "top.location = \"index.php\";" . chr(10);
			echo " --></script>" . chr(10);
			echo "</head>" . chr(10);
			echo "<body></body>" . chr(10);
			echo "</html>" . chr(10);

			exit();
		}
	}
	
	function CheckCookie1() {  // Resets app to the index page if timeout is reached
	
		$session_timeout = param_extract("session_timeout");
		
		if(!isset($_COOKIE["bookings_user_id"])) {
			
			echo "<html><head>" . chr(10);
			echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">" . chr(10);
			echo "<title>Session has expired</title>" . chr(10);
			echo "<script type=\"text/javascript\"><!-- " . chr(10);
			echo "top.location = \"index.php\";" . chr(10);
			echo " --></script>" . chr(10);
			echo "</head>" . chr(10);
			echo "<body></body>" . chr(10);
			echo "</html>" . chr(10);

			exit();
		}
	}
	
	function GetUserProfile() { // Checks if the current user is an administrator
		global $database_name;
		$sql = "SELECT profile_id FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
		$temp = db_query($database_name, $sql); $temp_ = fetch_array($temp);
		$result = $temp_["profile_id"]; return $result;
	}
	function GetloginName() { // Checks if the current user is an administrator
		global $database_name;
		$sql = "SELECT login FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
		$temp = db_query($database_name, $sql); $temp_ = fetch_array($temp);
		$result = $temp_["login"]; return $result;
	}

	function GetUserName() { // Checks if the current user is an administrator
		global $database_name;
		$sql = "SELECT last_name FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
		$temp = db_query($database_name, $sql); $temp_ = fetch_array($temp);
		$result = $temp_["last_name"]; return $result;
	}
	function GetUserName1() { // Checks if the current user is an administrator
		global $database_name;
		$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
		$temp = db_query($database_name, $sql); $temp_ = fetch_array($temp);
		$result = $temp_["first_name"]." ".$temp_["last_name"]."  Email : ".$temp_["email"]; return $result;
	}

function dateUsToFr ($datetime) {
        sscanf($datetime, "%4s-%2s-%2s", $y, $mo, $d);
        return $d.'/'.$mo.'/'.$y;
}

function dateFrToUs ($datetime) {
        sscanf($datetime, "%2s/%2s/%4s", $d, $mo, $y);
        return $y.'-'.$mo.'-'.$d;
}
function dateUsToFr1 ($datetime) {
        sscanf($datetime, "%2s-%2s-%2s", $y, $mo, $d);
        return $d.'/'.$mo.'/'."20".$y;
}

function dateFrToUs1 ($datetime) {
        sscanf($datetime, "%2s/%2s/%2s", $d, $mo, $y);
        return "20".$y.'-'.$mo.'-'.$d;
}






	function AddBooking($action, $book_id, $manager_email, $booker_id, $object_id, $booking_start, $booking_end, $misc_info, $validated) {

		global $app_path, $database_name, $time_offset;

		// extracts booker name from booker id
		$sql = "SELECT first_name, last_name, email ";
		$sql .= "FROM rs_data_users ";
		$sql .= "WHERE user_id = " . $booker_id . ";";
		$temp = db_query($database_name, $sql); $temp_ = fetch_array($temp);
		$booker_name = $temp_["first_name"] . " " . $temp_["last_name"];
		$booker_email = $temp_["email"];

		// extracts object name from object id
		$sql = "SELECT object_name FROM rs_data_objects WHERE object_id = " . $object_id . ";";
		$temp = db_query($database_name, $sql); $temp_ = fetch_array($temp);
		$object_name = $temp_["object_name"];

		switch($action) {
	
			case "update":

			$sql = "UPDATE rs_data_bookings SET ";
			$sql .= "book_start = '" . date("Y-m-d H:i:s", strtotime($booking_start) + $time_offset) . "', ";
			$sql .= "book_end = '" . date("Y-m-d H:i:s", strtotime($booking_end) + $time_offset) . "', ";
			$sql .= "validated = " . $validated . ", ";
			$sql .= "misc_info = '" . $misc_info . "' ";
			$sql .= "WHERE book_id = " . $_REQUEST["book_id"] . ";";
			db_query($database_name, $sql);

			break;
			
			case "insert":

			// creates a random code
			$rand_code = rand(0,65535);

			$misc_info = addslashes($misc_info);

			// inserts the new booking associated with the random code
			$sql  = "INSERT INTO rs_data_bookings ( rand_code, object_id, book_date, user_id, book_start, book_end, misc_info, validated ) VALUES ( ";
			$sql .= $rand_code . ", ";
			$sql .= $object_id . ", ";
			$sql .= "'" . date("Y-m-d H:i:s") . "', ";
			$sql .= $booker_id . ", ";
			$sql .= "'" . date("Y-m-d H:i:s", strtotime($booking_start) + $time_offset) . "', ";
			$sql .= "'" . date("Y-m-d H:i:s", strtotime($booking_end) + $time_offset) . "', ";
			$sql .= "'" . $misc_info . "', ";
			$sql .= $validated . " );";
		
			db_query($database_name, $sql);

			// gets new booking id using the random code
			$sql = "SELECT book_id FROM rs_data_bookings WHERE rand_code = " . $rand_code . ";";
			$new_booking = db_query($database_name, $sql); $new_booking_ = fetch_array($new_booking);
			$book_id = $new_booking_["book_id"];

			// clears random code
			$sql = "UPDATE rs_data_bookings SET rand_code = '' WHERE rand_code = " . $rand_code . ";";
			db_query($database_name, $sql);

			if(!$validated && param_extract("confirm_by_email") == "yes") { // sends an email for the object's manager to validate the new booking
				
				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$headers .= "From: " . $booker_name . " <" . $booker_email . ">\r\n";

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

				$message .= $booker_name . " " . Translate("has sent the following booking request") . " :" . chr(10);
				$message .= "<p>" . chr(10);
				$message .= Translate("Object") . " : " . $object_name . "<br>" . chr(10);
				$message .= Translate("Start") . " : " . date("d/m/Y H:i", strtotime($booking_start)) . "<br>" . chr(10);
				$message .= Translate("End") . date("d/m/Y H:i", strtotime($booking_end)) . "<p>" . chr(10);
				$message .= Translate("This booking has already been recorded to the calendar but needs one of the following action") . " :<p>" . chr(10);
				
				$message .= "<table><tr><td>" . chr(10);
				$message .= "<a	href=\"" . $app_path . "actions.php?action_=confirm_booking&book_id=" . $book_id . "&validated=yes\" target=\"action_iframe\">[ " . Translate("Accept") . " ]</A>" . chr(10);
				$message .= "</td><td style=\"width:20px\"></td><td>" . chr(10);
				$message .= "<a	href=\"" . $app_path . "actions.php?action_=confirm_booking&book_id=" . $book_id . "&validated=no\" target=\"action_iframe\">[ " . Translate("Cancel") . " ]</A>" . chr(10);
				$message .= "</td></tr></table>" . chr(10);

				$message .= "<iframe frameborder=\"0\" name=\"action_iframe\" id=\"action_iframe\" style=\"border:none; width:500px; height:100px\">" . chr(10);
				$message .= "</body>" . chr(10);
				$message .= "</html>";
				
				mail($manager_email, Translate("Booking validation request"), $message, $headers);
			}
		
			return true;
		}
	}
?>
