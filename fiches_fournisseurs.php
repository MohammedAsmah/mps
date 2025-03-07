<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$ty="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$first_name = $_REQUEST["first_name"];$fax = $_REQUEST["fax"];$ville = $_REQUEST["ville"];
			$last_name = $_REQUEST["last_name"];$tel = $_REQUEST["tel"];
			
			if(isset($_REQUEST["locked"])) { $locked = 1; } else { $locked = 0; }
			if($_REQUEST["remarks"] != "") { $remarks = "'" . $_REQUEST["remarks"] . "'"; } else { $remarks = "NULL"; }
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO rs_data_fournisseurs ( login, first_name, last_name, ville,fax,tel,email, locked, profile_id, remarks ) VALUES ( ";
				$sql .= "'" . $_REQUEST["login"] . "', ";
				$sql .= "'" . $first_name . "', ";
				$sql .= "'" . $last_name . "', ";$sql .= "'" . $ville . "', ";
				$sql .= "'" . $fax . "', ";
				$sql .= "'" . $tel . "', ";
				$sql .= "'" . $_REQUEST["email"] . "', ";
				$sql .= "'" . $locked . "', ";
				$sql .= "'" . $_REQUEST["profile_id"] . "', ";
				$sql .= $remarks . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE rs_data_fournisseurs SET ";
			$sql .= "login = '" . $_REQUEST["login"] . "', ";
			$sql .= "first_name = '" . $first_name . "', ";
			$sql .= "fax = '" . $fax . "', ";$sql .= "ville = '" . $ville . "', ";
			$sql .= "tel = '" . $tel . "', ";
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
			$sql = "DELETE FROM rs_data_fournisseurs WHERE user_id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
		// recherche ville
	$ville = "Tout";
	$sql = "SELECT ville FROM  rs_data_villes ORDER BY ville;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($ville == $temp_["ville"]) { $selected = " selected"; } else { $selected = ""; }
		
		$ville .= "<OPTION VALUE=\"" . $temp_["ville"] . "\"" . $selected . ">";
		$ville .= $temp_["ville"];
		$ville .= "</OPTION>";
	}
	
	$type = "Tout";
	$sql = "SELECT * FROM  rs_fournisseurs_profiles ORDER BY profile_name;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($type == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$type .= "<OPTION VALUE=\"" . $temp_["profile_id"] . "\"" . $selected . ">";
		$type .= $temp_["profile_name"];
		$type .= "</OPTION>";
	}

	
	$action="recherche";$tri="";
		if(isset($_REQUEST["action"]))
	{}else {?>
	<form id="form" name="form" method="post" action="fiches_fournisseurs.php">
	<td><?php echo "Type : "; ?><select id="type" name="type"><?php echo $type; ?></select></td>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<? }
	
	if(isset($_REQUEST["action"]))
	{ $type=$_POST['type'];$ty=$_POST['type'];
	$sql  = "SELECT * ";
	$sql .= "FROM rs_data_fournisseurs where profile_id='$type' ORDER last_name;";
	$users = db_query($database_name, $sql);
	}else
	{
	$sql  = "SELECT * ";
	$sql .= "FROM rs_data_fournisseurs ORDER BY last_name;";
	$users = db_query($database_name, $sql);
	}
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Fournisseurs"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "fiche_fournisseur.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Fournisseurs $ty"; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "Nom";?></th><th><?php echo "Inputation";?></th>
	<th><?php echo "Email";?></th>
	<th><?php echo "Tel";?></th>
	<th><?php echo "Fax";?></th>
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["user_id"]; ?>)"><?php echo $users_["last_name"];?></A></td>
<td style="text-align:left"><?php echo $users_["login"]; ?></td>
<td><?php echo $users_["email"]; ?></td>
<td><?php echo $users_["tel"]; ?></td>
<td><?php echo $users_["fax"]; ?></td>
<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>


</body>

</html>