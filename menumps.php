<?php

	/* OpenBookings.org - Copyright (C) 2005 Jérôme ROGER (jerome@openbookings.org)
	
	index.php - This file is part of OpenBookings.org (http://www.openbookings.org)

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

	$session_timeout = param_extract("session_timeout");

	if(isset($_REQUEST["action_"])) {
		
		switch($_REQUEST["action_"]) {

			case "login":

			$sql  = "SELECT user_id FROM rs_data_users ";
			$sql .= "WHERE login = '" . $_REQUEST["user"] . "' ";
			$sql .= "AND password = '" . $_REQUEST["password"] . "';";
			$user = db_query($database_name, $sql);
			
			if($user_ = fetch_array($user)) {
				// login successful -> sets the cookie
				
				if($session_timeout != 0) {
					setcookie("bookings_user_id", $user_["user_id"], (time() + $session_timeout));
				} else {
					setcookie("bookings_user_id", $user_["user_id"]);
				}
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];$tout = $user_["tout"];$menu1 = $user_["menu1"];$menu2 = $user_["menu2"];$menu3 = $user_["menu3"];
	$menu4 = $user_["menu4"];$menu5 = $user_["menu5"];$menu6 = $user_["menu6"];
	$menu7 = $user_["menu7"];$menu8 = $user_["menu8"];$menu9 = $user_["menu9"];$menu10 = $user_["menu10"];$menu11 = $user_["menu11"];$menu12 = $user_["menu12"];
	$menu13 = $user_["menu13"];
			} else {
				// login/password incorrect
				$error_message = Translate("Login/password incorrect ");
			}

			break;
			
			case "delog":
			// wipes the cookie
			setcookie ("bookings_user_id", "", time() - 3600);

		} // switch

} // isset

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title></title>

<meta name="author" content=""> 
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="robots" content="index,nofollow">

<link rel="stylesheet" type="text/css" href="styles1.css">

<?php if(isset($_REQUEST["action_"])) { ?>

<script type="text/javascript"><!--
	document.location = "menumps.php?rand=<?php echo rand(1,1000); ?>";
--></script>

</head>

<body></body>

</html>

<?php } else { ?>

</head>

<?php if(isset($_COOKIE["bookings_user_id"])) { // cookie is set : user is already logged ?>


<frameset cols="330">
	<frame name="left_frame" src="menudyn.php">
	
</frameset><noframes></noframes>


<body>

<?php } else { // no cookie : shows login form ?>

<center>

<form id="login_form" name="login_form" method="post" action="menumps.php">

	<table class="table3">
	<tr><td style="height:30px"></td></tr>
	<tr><td style="font-size:24px"><span style="font-size:12px"></span></td></tr>

	<tr><td>

		<table style="background: #efefef;"><tr><td style="padding:15px; border: 2px groove;">
			
			<table class="table3"><tr>
				<td style="text-align:right"><?php echo Translate("User") ?> :</td><td><input type="text" id="user" name="user"></td>
			</tr><tr>
				<td style="text-align:right"><?php echo Translate("Password") ?> :</td><td><input type="password" id="password" name="password"></td>
			</tr><tr><td style="height:15px" colspan="2"></td></tr><tr>
				<td colspan="2" style="text-align:center"><input type="submit" value="OK"></td>
			</tr>
			<td><? echo "MPS ";?></td><td></td>
			
			</table>

		</td></tr></table>

	</td></tr></table>

	<?php if(isset($error_message)) { ?><p style="color:#ff0000"><?php echo $error_message; ?></p><?php } ?>

	<input type="hidden" name="action_" value="login">

</form>

<table><tr>
<td colspan="3"style="height:20px"></td>
</tr><tr>
</table>

</center>

</body>

<?php } }?>

</html>