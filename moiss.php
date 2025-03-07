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
			if(isset($_REQUEST["encours"])) { $encours = 1; } else { $encours = 0; }
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
			break;

			case "update_user":
	$sql  = "SELECT * ";
	$sql .= "FROM mois_rak ORDER BY id;";
	$users = db_query($database_name, $sql);
		while($users_ = fetch_array($users)) { 
			$id=$users_["id"];$s=0;
			$sql = "UPDATE mois_rak SET ";
			$sql .= "encours = '" . $s . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
		}
			
				
			$sql = "UPDATE mois_rak SET ";
			$sql .= "encours = '" . $encours . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			

		} //switch
	} //if
	
	
	$sql  = "SELECT * ";
	$sql .= "FROM mois_rak ORDER BY id;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Mois"; ?></title>

<link rel="stylesheet" type="text/css" href="../mts/styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "mois.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Mois"; ?></span>

	<table class="table3">

<tr>
	<th><?php echo "Mois";?></th>
	<th><?php echo "Du";?></th>
	<th><?php echo "Au";?></th>
	<th><?php echo "Etat";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["mois"];?></A></td>
<td style="text-align:left"><?php echo dateUsToFr($users_["du"]); ?></td>
<td><?php echo dateUsToFr($users_["au"]); ?></td>
<td><?php if($users_["encours"]) { echo "Selectionne"; }?></td>
<?php } ?>

</table>

<p style="text-align:center">

</body>

</html>