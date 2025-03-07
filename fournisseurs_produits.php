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
			$sql .= "c1 = '" . $_REQUEST["c1"] . "', ";
			$sql .= "c2 = '" . $_REQUEST["c2"] . "', ";
			$sql .= "c3 = '" . $_REQUEST["c3"] . "', ";
			$sql .= "c4 = '" . $_REQUEST["c4"] . "', ";
			$sql .= "c5 = '" . $_REQUEST["c5"] . "', ";
			$sql .= "c6 = '" . $_REQUEST["c6"] . "' ";
			
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
	
		


		
	$sql  = "SELECT * ";
	$sql .= "FROM rs_data_fournisseurs ORDER BY last_name;";
	$users = db_query($database_name, $sql);
	
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Fournisseurs"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "fournisseur.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Fournisseurs $ty"; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "Nom";?></th><th>
	<th><?php echo "Tel";?></th>
	<th><?php echo "Fax";?></th>
	<th><?php echo "Familles";?></th>
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<?php $frs=$users_["last_name"]; $user_id=$users_["user_id"]; echo "<td><a href=\"fournisseur_produit.php?user_id=$user_id\">$frs</a></td>";?>
<td><?php echo $users_["tel"]; ?></td>
<td><?php echo $users_["fax"]; ?></td>
<td><?php $profile_id = $users_["profile_id"]; 

$sql = "SELECT * FROM  rs_fournisseurs_profiles where profile_id='$profile_id' ORDER BY profile_name;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		$type = $temp_["profile_name"] ;
	}

echo $type;

?></td>


<?php } ?>

</table>

<p style="text-align:center">


</body>

</html>