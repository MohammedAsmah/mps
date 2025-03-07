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
			$banque = $_REQUEST["banque"];$oc = $_REQUEST["oc"];$av = $_REQUEST["av"];
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO rs_data_banques ( banque,oc,av ) VALUES ('$banque','$oc','$av')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE rs_data_banques SET ";
			$sql .= "banque = '" . $banque . "', ";
			$sql .= "oc = '" . $oc . "', ";
			$sql .= "av = '" . $av . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM rs_data_banques WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";
	$sql .= "FROM rs_data_banques ORDER BY banque;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "banque.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo ""; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Banque";?></th>
	<th><?php echo "Ligne O.C";?></th>
	<th><?php echo "Ligne AVAL";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["banque"];?></A></td>
<td><?php echo $users_["oc"];?></td>
<td><?php echo $users_["av"];?></td>
<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

</body>

</html>