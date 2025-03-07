<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$first_name = $_REQUEST["first_name"];
			$last_name = $_REQUEST["last_name"];
			if($first_name == "") { $first_name = $last_name; }
			if($last_name == "") { $last_name = $first_name; }
			if(isset($_REQUEST["locked"])) { $locked = 1; } else { $locked = 0; }
			if(isset($_REQUEST["tout"])) { $tout = 1; } else { $tout = 0; }
			if(isset($_REQUEST["menu1"])) { $menu1 = 1; } else { $menu1 = 0; }
			if(isset($_REQUEST["menu2"])) { $menu2 = 1; } else { $menu2 = 0; }
			if(isset($_REQUEST["menu3"])) { $menu3 = 1; } else { $menu3 = 0; }
			if(isset($_REQUEST["menu4"])) { $menu4 = 1; } else { $menu4 = 0; }
			if(isset($_REQUEST["menu5"])) { $menu5 = 1; } else { $menu5 = 0; }
			if(isset($_REQUEST["menu6"])) { $menu6 = 1; } else { $menu6 = 0; }
			if(isset($_REQUEST["menu7"])) { $menu7 = 1; } else { $menu7 = 0; }
			if(isset($_REQUEST["menu8"])) { $menu8 = 1; } else { $menu8 = 0; }
			if(isset($_REQUEST["menu9"])) { $menu9 = 1; } else { $menu9 = 0; }
			if(isset($_REQUEST["menu10"])) { $menu10 = 1; } else { $menu10 = 0; }
			if(isset($_REQUEST["menu11"])) { $menu11 = 1; } else { $menu11 = 0; }
			if(isset($_REQUEST["menu12"])) { $menu12 = 1; } else { $menu12 = 0; }
			if(isset($_REQUEST["menu13"])) { $menu13 = 1; } else { $menu13 = 0; }
			if(isset($_REQUEST["menu14"])) { $menu14 = 1; } else { $menu14 = 0; }
			if(isset($_REQUEST["menu15"])) { $menu15 = 1; } else { $menu15 = 0; }
			if(isset($_REQUEST["menu16"])) { $menu16 = 1; } else { $menu16 = 0; }
			if($_REQUEST["remarks"] != "") { $remarks = "'" . $_REQUEST["remarks"] . "'"; } else { $remarks = "NULL"; }
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
			if($_REQUEST["password"] == "" || $_REQUEST["password"] != $_REQUEST["password_confirm"]) {
				$error_message = "<span style=\"color:#ff0000\">" . Translate("User was not added as password was empty or did not meet password confirmation") . ".</span>";
			} else {
			
				$sql  = "INSERT INTO rs_data_users ( login, password, first_name, last_name, email, locked, profile_id, 
				tout,menu1,menu2,menu3,menu4,menu5,menu6,menu7,menu8,menu9,menu10,menu11,menu12,menu13,menu14,menu15,menu16,remarks ) VALUES ( ";
				$sql .= "'" . $_REQUEST["login"] . "', ";
				$sql .= "'" . $_REQUEST["password"] . "', ";
				$sql .= "'" . $first_name . "', ";
				$sql .= "'" . $last_name . "', ";
				$sql .= "'" . $_REQUEST["email"] . "', ";
				$sql .= "'" . $locked . "', ";
				$sql .= "'" . $_REQUEST["profile_id"] . "', ";
				$sql .= "'" . $tout . "', ";
				$sql .= "'" . $menu1 . "', ";
				$sql .= "'" . $menu2 . "', ";
				$sql .= "'" . $menu3 . "', ";
				$sql .= "'" . $menu4 . "', ";
				$sql .= "'" . $menu5 . "', ";
				$sql .= "'" . $menu6 . "', ";
				$sql .= "'" . $menu7 . "', ";
				$sql .= "'" . $menu8 . "', ";
				$sql .= "'" . $menu9 . "', ";
				$sql .= "'" . $menu10 . "', ";
				$sql .= "'" . $menu11 . "', ";
				$sql .= "'" . $menu12 . "', ";
				$sql .= "'" . $menu13 . "', ";
				$sql .= "'" . $menu14 . "', ";$sql .= "'" . $menu15 . "', ";$sql .= "'" . $menu16 . "', ";
				$sql .= $remarks . ");";

				db_query($database_name, $sql);
			}

			break;

			case "update_user":

			$sql = "UPDATE rs_data_users SET ";
			$sql .= "login = '" . $_REQUEST["login"] . "', ";
			
			if($_REQUEST["password_confirm"] != "") {

				if($_REQUEST["password"] != $_REQUEST["password_confirm"]) {
					$error_message = "<span style=\"color:#ff0000\">" . Translate("Password was not changed as it was empty or did not meet password confirmation") . ".</span>";
				} else {
					$sql .= "password = '" . $_REQUEST["password"] . "', ";
				}
			} //if
			$sql .= "first_name = '" . $first_name . "', ";
			$sql .= "last_name = '" . $last_name . "', ";
			$sql .= "email = '" . $_REQUEST["email"] . "', ";
			$sql .= "locked = '" . $locked . "', ";
			$sql .= "tout = '" . $tout . "', ";
			$sql .= "menu1 = '" . $menu1 . "', ";
			$sql .= "menu2 = '" . $menu2 . "', ";
			$sql .= "menu3 = '" . $menu3 . "', ";
			$sql .= "menu4 = '" . $menu4 . "', ";
			$sql .= "menu5 = '" . $menu5 . "', ";
			$sql .= "menu6 = '" . $menu6 . "', ";
			$sql .= "menu7 = '" . $menu7 . "', ";
			$sql .= "menu8 = '" . $menu8 . "', ";
			$sql .= "menu9 = '" . $menu9 . "', ";
			$sql .= "menu10 = '" . $menu10 . "', ";
			$sql .= "menu11 = '" . $menu11 . "', ";
			$sql .= "menu12 = '" . $menu12 . "', ";
			$sql .= "menu13 = '" . $menu13 . "', ";
			$sql .= "menu14 = '" . $menu14 . "', ";
			$sql .= "menu15 = '" . $menu15 . "', ";
			$sql .= "menu16 = '" . $menu16 . "', ";
			$sql .= "profile_id = '" . $_REQUEST["profile_id"] . "', ";
			$sql .= "remarks = " . $remarks . " ";
			$sql .= "WHERE user_id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM rs_data_users WHERE user_id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT user_id, login, last_name, first_name, email, locked, password,profile_name, remarks ";
	$sql .= "FROM rs_data_users INNER JOIN rs_param_profiles ON rs_data_users.profile_id = rs_param_profiles.profile_id ORDER BY last_name, first_name;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . Translate("Users list"); ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "user.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo Translate("Users list"); ?></span>

<table class="table2">

<tr>
	<th><?php echo Translate("User name");?></th>
	<th><?php echo Translate("Login");?></th>
	<th><?php echo Translate("Email");?></th>
	<th><?php echo Translate("Locked");?></th>
	<th><?php echo Translate("Users profiles");?></th>
	<th><?php echo Translate("Remarks");?></th>
	<th><?php echo Translate("Password");?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["user_id"]; ?>)"><?php echo $users_["last_name"];  if($users_["last_name"] != $users_["first_name"]) { echo ", " . $users_["first_name"]; } ?></A></td>
<td style="text-align:center"><?php echo $users_["login"]; ?></td>
<td><?php echo $users_["email"]; ?></td>
<td style="text-align:center"><?php if($users_["locked"]) { echo Translate("Yes"); } else { echo Translate("No"); } ?></td>
<td style="text-align:center"><?php echo $users_["profile_name"]; ?></td>
<td><?php echo $users_["remarks"]; ?></td>
<td><?php echo $users_["password"]; ?></td>
<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>


</body>

</html>
