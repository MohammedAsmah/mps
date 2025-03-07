<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"])) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$date = dateFrToUs($_REQUEST["date"]);
			$service=$_REQUEST["service"];
			$client=$_REQUEST["client"];
			$statut=$_REQUEST["statut"];
			$date_open=$_REQUEST["date_open"];
			$user_open=$user_name;
/*			$date_cancel=$_REQUEST["date_cancel"];
			$user_cancel=$_REQUEST["user_cancel"];
			$motif_cancel=$_REQUEST["motif_cancel"];*/
			$observation=$_REQUEST["observation"];
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
				$sql  = "INSERT INTO registre_sans_lp (date,service,client,date_open,user_open,observation,statut ) VALUES ('$date','$service','$client','$date_open','$user_open','$observation','$statut')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE registre_sans_lp SET ";
			$sql .= "observation = '" . $observation . "' ";
			$sql .= "statut = '" . $statut . "' ";
			$sql .= "user_open = '" . $user_open . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM registre_sans_lp WHERE profile_id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";
	$sql .= "FROM registre_sans_lp ORDER BY date,service;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre_sans.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo ""; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Service";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Statut";?></th>
	<th><?php echo "Utilisateur";?></th>
	
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo dateUsToFr($users_["date"]); ?></A></td>
<td><?php echo $users_["service"]; ?></td>
<td><?php echo $users_["client"]; ?></td>
<td><?php echo $users_["statut"]; ?></td>
<td><?php echo $users_["user_open"]; ?></td>
<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>


</body>

</html>