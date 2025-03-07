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
			$ville = $_REQUEST["ville"];			$secteur = $_REQUEST["secteur"];$transport = $_REQUEST["transport"];

		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO rs_data_villes ( ville,secteur,transport ) VALUES ('$ville','$secteur','$transport')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE rs_data_villes SET ";
			$sql .= "ville = '" . $ville . "', ";
			$sql .= "transport = '" . $transport . "', ";
			$sql .= "secteur = '" . $secteur . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM rs_data_villes WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";
	$sql .= "FROM rs_data_villes ORDER BY ville;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "ville.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo ""; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Ville";?></th>	<th><?php echo "Secteur";?></th>

</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["ville"];?></A></td>
<td><?php echo $users_["secteur"];?></td>
<td><?php echo $users_["transport"];$id=$users_["id"];?></td>
<td><?php echo $users_["categorie_transport"];?></td>
<?php 

if ($users_["transport"]<1000){$categorie_transport="pas de categorie";}
if ($users_["transport"]>=1000 and $users_["transport"]<=1200){$categorie_transport="TRANSPORT 1000->1200";}
if ($users_["transport"]>1200 and $users_["transport"]<=1400){$categorie_transport="TRANSPORT 1200->1400";}
if ($users_["transport"]>1400 and $users_["transport"]<=1600){$categorie_transport="TRANSPORT 1400->1600";}
if ($users_["transport"]>1600 and $users_["transport"]<=1800){$categorie_transport="TRANSPORT 1600->1800";}
if ($users_["transport"]>1800 and $users_["transport"]<=2000){$categorie_transport="TRANSPORT 1800->2000";}
if ($users_["transport"]>2000 and $users_["transport"]<=2200){$categorie_transport="TRANSPORT 2000->2200";}
if ($users_["transport"]>2200 and $users_["transport"]<=2400){$categorie_transport="TRANSPORT 2200->2400";}
if ($users_["transport"]>2400 and $users_["transport"]<=2600){$categorie_transport="TRANSPORT 2400->2600";}
if ($users_["transport"]>2600 and $users_["transport"]<=2800){$categorie_transport="TRANSPORT 2600->2800";}
if ($users_["transport"]>2800 and $users_["transport"]<=3000){$categorie_transport="TRANSPORT 2800->3000";}
if ($users_["transport"]>3000 and $users_["transport"]<=3200){$categorie_transport="TRANSPORT 3000->3200";}
if ($users_["transport"]>3200 and $users_["transport"]<=3400){$categorie_transport="TRANSPORT 3200->3400";}
if ($users_["transport"]>3400 and $users_["transport"]<=3600){$categorie_transport="TRANSPORT 3400->3600";}
if ($users_["transport"]>3600 and $users_["transport"]<=3800){$categorie_transport="TRANSPORT 3600->3800";}
if ($users_["transport"]>3800 and $users_["transport"]<=4000){$categorie_transport="TRANSPORT 3800->4000";}
if ($users_["transport"]>4000){$categorie_transport="TRANSPORT >4000";}





			$sql = "UPDATE rs_data_villes SET ";
			$sql .= "categorie_transport = '" . $categorie_transport . "' ";
			
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
			
			


} ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

</body>

</html>