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
			$vendeur = $_REQUEST["vendeur"];
			$ref = $_REQUEST["ref"];$com = $_REQUEST["com"];$plafond = $_REQUEST["plafond"];

		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO vendeurs ( ref, vendeur, com,plafond) VALUES ( ";
				$sql .= "'" . $_REQUEST["ref"] . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $com . "', ";
				$sql .= $plafond . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE vendeurs SET ";
			$sql .= "ref = '" . $_REQUEST["ref"] . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			$sql .= "plafond = '" . $plafond . "', ";
			$sql .= "com = " . $com . " ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// deletes user's bookings
			/*$sql = "DELETE FROM rs_data_bookings WHERE user_id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);*/

			// delete user's profile
			$sql = "DELETE FROM vendeurs WHERE id = " . $_REQUEST["user_id"] . ";";
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
	function EditUser1(user_id) { document.location = "compte_vendeur.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Vendeurs"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Code";?></th>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "Plafond";?></th>
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo "CODE-".$users_["ref"];?></A></td>
<td><?php echo $users_["vendeur"];?></td>
<td><?php echo number_format($users_["plafond"],2,',',' ');?></td>

<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>


</body>

</html>