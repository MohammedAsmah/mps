<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$user_login = $user_["login"];

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$article = $_REQUEST["article"];$ordre = $_REQUEST["ordre"];
			
			// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '" . $_REQUEST["article"] . "';";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$prix_unitaire = $user_["prix"];$conditionnement = $user_["condit"];
			
		}
		if ($user_login=="admin" or $user_login=="rakia" or $user_login=="Radia" or $user_login=="nabila"){
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO articles_favoris ( ordre,article,conditionnement,prix_unitaire )
				 VALUES ('$ordre','$article','$conditionnement','$prix_unitaire')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE articles_favoris SET article = '$article',conditionnement = '$conditionnement'
			,prix_unitaire = '$prix_unitaire',ordre = '$ordre'
			 WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
						
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM articles_favoris WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
		} //switch
	} //if
	
	$sql  = "SELECT * ";
	$sql .= "FROM articles_favoris ORDER BY id;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "article_favoris.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste "; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Ordre";?></th>
	<th><?php echo "Article";?></th>
	<th><?php echo "Condit";?></th>
	<th><?php echo "Prix_unitaire";?></th>
	
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><?php echo $users_["ordre"]; ?></td>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["article"];?></A></td>

<td><?php echo $users_["conditionnement"]; ?></td>
<td><?php echo $users_["prix_unitaire"]; ?></td>

<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>


</body>

</html>