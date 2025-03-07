<?php
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];
	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"])) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$produit = $_REQUEST["produit"];$condit = $_REQUEST["condit"];$poids = $_REQUEST["poids"];$type = $_REQUEST["type"];$matiere = $_REQUEST["matiere"];
			
			if(isset($_REQUEST["dispo"])) { $dispo = 1; } else { $dispo = 0; }
		}
		
		if ($login=="admin" or $login=="rabia"){
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO produits ( produit, condit, matiere,poids,type, dispo ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $condit . "', ";$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $poids . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $dispo . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE produits SET ";$acc=1;
			$sql .= "accessoire_1 = '" . $_REQUEST["accessoire_1"] . "', ";
			$sql .= "accessoire_2 = '" . $_REQUEST["accessoire_2"] . "', ";
			$sql .= "accessoire_3 = '" . $_REQUEST["accessoire_3"] . "', ";
			$sql .= "accessoire_4 = '" . $_REQUEST["accessoire_4"] . "', ";
			$sql .= "accessoire_5 = '" . $_REQUEST["accessoire_5"] . "', ";
			$sql .= "accessoire_6 = '" . $_REQUEST["accessoire_6"] . "', ";
			$sql .= "acc = '" . $acc . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM produits WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	}
	} //if
	
	
	// recherche ville
	?>
	
	<?
	$sql  = "SELECT * ";$type="accessoire";$vide="";
	$sql .= "FROM produits ORDER BY produit;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Produits"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "accessoire_produit.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Accessoires"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Code";?></th>
	<th><?php echo "Nom";?></th>
	<th><?php echo "Conditionnement";?></th>
	<th><?php echo "Poids";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>


<? if ($users_["acc"]==1){?>
<td bgcolor="#66CCCC"><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["id"];?></A></td>
<td style="text-align:left" bgcolor="#66CCCC"><?php echo $users_["produit"]; ?></td>
<td bgcolor="#66CCCC"><?php echo $users_["condit"]; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $users_["poids"]; ?></td>
<?php } else { ?>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["id"];?></A></td>
<td style="text-align:left"><?php echo $users_["produit"]; ?></td>
<td><?php echo $users_["condit"]; ?></td>
<td align="right"><?php echo $users_["poids"]; ?></td>
<?php } ?>
 
<?php } ?>

</table>

<p style="text-align:center">

	

</body>

</html>