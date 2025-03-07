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
			$tranche_de = $_REQUEST["tranche_de"];$tranche_a = $_REQUEST["tranche_a"];$escompte = $_REQUEST["escompte"];
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
				$sql  = "INSERT INTO grille_escompte ( tranche_de,tranche_a,escompte ) VALUES ( ";
				$sql .= "'".$tranche_de . "',";
				$sql .= "'".$tranche_a . "',";
				$sql .= "'".$escompte . "');";
				db_query($database_name, $sql);

			break;

			case "update_user":

			$sql = "UPDATE grille_escompte SET ";
			$sql .= "tranche_de = '" . $tranche_de . "', ";
			$sql .= "tranche_a = '" . $tranche_a . "', ";
			$sql .= "escompte = '" . $escompte . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM grille_escompte WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	
	
	$sql  = "SELECT * ";
	$sql .= "FROM grille_escompte ORDER BY id;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "grille_escompte.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo ""; ?></span>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

<table class="table2">

<tr>
	<th><?php echo "Code ";?></th>
	<th><?php echo "Tranche de ";?></th>
	<th><?php echo "Tranche a ";?></th>
	<th><?php echo "Escompte";?></th>
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
	
	<?
	$tranche_de= $users_["tranche_de"];$tranche_a=$users_["tranche_a"];$escompte=$users_["escompte"];$id=$users_["id"];
	
	$tr="<td align=\"left\"><a href=\"grille_escompte.php?user_id=$id\">$id</a></td>";
		print("<font size=\"1\" face=\"Arial\" color=\"#000033\">$tr </font>");?>

	<td align="right"><?php echo number_format($tranche_de,2,',',' ')." dhs";?></td>
	<td align="right"><?php echo number_format($tranche_a,2,',',' ')." dhs";?></td>
	<td align="right"><?php echo number_format($escompte,2,',',' ')." %";?></td>
	
	</tr>
<?php } ?>

</body>

</html>