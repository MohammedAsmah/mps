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
			$last_name = $_REQUEST["last_name"];$last_name1 = $_REQUEST["last_name1"];$login = $_REQUEST["login"];
			$remarks = $_REQUEST["remarks"];$remise2 = $_REQUEST["remise2"];$remise3 = $_REQUEST["remise3"];
			$vendeur = $_REQUEST["vendeur"];$ville = $_REQUEST["ville"];$ville = $_REQUEST["ville"];
			if(isset($_REQUEST["statut"])) { $statut = 1; } else { $statut = 0; }
			$categorie = $_REQUEST["categorie"];
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
				$sql  = "INSERT INTO contacts ( ref, client, remise2,remise3,ville,statut,categorie,adrresse )
				 VALUES ('$login','$last_name','$remise2','$remise3','$ville','$statut','$categorie','$remarks')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE contacts SET ref = '$login',remise2 = '$remise2',remise3 = '$remise3',adrresse = '$remarks',
			client = '$last_name' , statut = '$statut',ville = '$ville',categorie = '$categorie' WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM contacts WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";$c="CLIENT";$v="";
	$sql .= "FROM contacts where categorie<>'$v' group by categorie ORDER BY client;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste contacts"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "contact.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste contacts"; ?></span>
<table class="table2">

<tr>
	<th><?php echo "Categorie";?></th>
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<? $categorie=$users_["categorie"];echo "<td><a href=\"contacts_c.php?categorie=$categorie\">$categorie</a></td>";?>
<?php } ?>
<? $categorie="Global";echo "<tr><td><a href=\"contacts_c.php?categorie=$categorie\">$categorie</a></td>";?>

</table>

<p style="text-align:center">


</body>

</html>