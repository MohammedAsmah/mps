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
			if($_REQUEST["remarks"] != "") { $remarks = "'" . $_REQUEST["remarks"] . "'"; } else { $remarks = "NULL"; }
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO rs_data_clients ( login, first_name, last_name, email, locked, profile_id,remarks ) VALUES ( ";
				$sql .= "'" . $_REQUEST["login"] . "', ";
				$sql .= "'" . $first_name . "', ";
				$sql .= "'" . $last_name . "', ";
				$sql .= "'" . $_REQUEST["email"] . "', ";
				$sql .= "'" . $locked . "', ";
				$sql .= "'" . $_REQUEST["profile_id"] . "', ";
				$sql .= $remarks . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE rs_data_clients SET ";
			$sql .= "login = '" . $_REQUEST["login"] . "', ";
			$sql .= "first_name = '" . $first_name . "', ";
			$sql .= "last_name = '" . $last_name . "', ";
			$sql .= "email = '" . $_REQUEST["email"] . "', ";
			$sql .= "locked = '" . $locked . "', ";
			$sql .= "profile_id = '" . $_REQUEST["profile_id"] . "', ";
			$sql .= "remarks = " . $remarks . " ";
			$sql .= "WHERE user_id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// deletes user's bookings
			/*$sql = "DELETE FROM rs_data_bookings WHERE user_id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);*/

			// delete user's profile
			$sql = "DELETE FROM rs_data_clients WHERE user_id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";
	$sql .= "FROM vendeurs ORDER BY ref;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Vendeurs"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "vendeur.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Vendeurs"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Code";?></th>
	<th><?php echo "Vendeur";?></th>
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["ref"];?></A></td>
<td><?php echo $users_["vendeur"]; ?></td>
<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>


</body>

</html>