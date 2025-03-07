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
			$libelle = $_REQUEST["libelle"];
			$ref = $_REQUEST["ref"];
			$date = dateFrToUs($_REQUEST["date"]);
			$debit = $_REQUEST["debit"];
			$credit = $_REQUEST["credit"];
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO banque_rak ( date, libelle, ref, debit, credit) VALUES ( ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $libelle . "', ";
				$sql .= "'" . $ref . "', ";
				$sql .= "'" . $debit . "', ";
				$sql .= $credit . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE banque_rak SET ";
			$sql .= "date = '" . $date . "', ";
			$sql .= "libelle = '" . $libelle . "', ";
			$sql .= "ref = '" . $ref . "', ";
			$sql .= "debit = '" . $debit . "', ";
			$sql .= "credit = " . $credit . " ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":

			// delete user's profile
			$sql = "DELETE FROM banque_rak WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";
	$sql .= "FROM banque_rak ORDER BY date;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "VERSSEMENTS"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "verssement.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "VERSSEMENTS"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "date";?></th>
	<th><?php echo "libelle";?></th>
	<th><?php echo "ref";?></th>
	<th><?php echo "debit";?></th>
	<th><?php echo "credit";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo dateUsToFr($users_["date"]);?></A></td>
<td style="text-align:center"><?php echo $users_["libelle"]; ?></td>
<td><?php echo $users_["ref"]; ?></td>
<td style="text-align:right"><?php echo $users_["debit"];  ?></td>
<td style="text-align:right"><?php echo $users_["credit"]; ?></td>

<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>


</body>

</html>