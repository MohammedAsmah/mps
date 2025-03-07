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
			$produit = $_REQUEST["produit"];$condit = $_REQUEST["condit"];$poids = $_REQUEST["poids"];$type = $_REQUEST["type"];
			$matiere = $_REQUEST["matiere"];
			$stock_initial = $_REQUEST["stock_initial"];
		}
		
		if ($login=="admin" or $login=="rabia"){
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO produits ( produit, condit, matiere,stock_initial,type,poids ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $condit . "', ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $stock_initial . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $poids . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE produits SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "', ";
			$sql .= "condit = '" . $condit . "', ";$sql .= "stock_initial = '" . $stock_initial . "', ";
			$sql .= "matiere = '" . $matiere . "', ";
			$sql .= "poids = '" . $poids . "', ";
			$sql .= "type = '" . $type . "' ";
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
	$sql .= "FROM produits where type='$type' and produit<>'$vide' ORDER BY produit;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Produits"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "accessoire.php?user_id=" + user_id; }
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
	<th><?php echo "Stock";?></th>
	
</tr>

<?php 

while($users_ = fetch_array($users)) { $produit=$users_["produit"];
	
	/*$sql  = "SELECT * ";$type="production";$dj=date("Y-m-d");
	$sql .= "FROM entrees_stock where type='$type' and produit='$produit' ORDER BY date;";
	$users1 = db_query($database_name, $sql);
	while($users_1 = fetch_array($users1)) {
		
	
	}*/
	
	
	?><tr>



<td bgcolor="#66CCCC"><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["id"];?></A></td>
<td style="text-align:left" bgcolor="#66CCCC"><?php echo $users_["produit"]; ?></td>
<td bgcolor="#66CCCC"><?php echo $users_["condit"]; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $users_["poids"]; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $users_["stock_final"]; ?></td>

<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>
	

</body>

</html>