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
			$profile_name = $_REQUEST["profile_name"];$stock_initial = $_REQUEST["stock_initial"];$achats = $_REQUEST["achats"];
			$to = "";$cout_revient = $_REQUEST["cout_revient"];$consomme = $_REQUEST["consomme"];$consomme1 = $_REQUEST["consomme1"];
			$type_a = "";$unites = $_REQUEST["unites"];$poids = $_REQUEST["poids"];if(isset($_REQUEST["mode_consomme"])) { $mode_consomme = 1; } else { $mode_consomme = 0; }
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
				$sql  = "INSERT INTO types_tiges ( profile_name,stock_initial,cout_revient,unites,poids,achats,type_a ) VALUES ( ";
				$sql .= "'".$profile_name . "',";
				$sql .= "'".$stock_initial . "',";
				$sql .= "'".$cout_revient . "',";
				$sql .= "'".$unites . "',";
				$sql .= "'".$poids . "',";
				$sql .= "'".$achats . "',";
				$sql .= "'".$type_a . "');";
				db_query($database_name, $sql);

			break;

			case "update_user":

			$sql = "UPDATE types_tiges SET ";
			$sql .= "profile_name = '" . $profile_name . "', ";
			$sql .= "stock_initial = '" . $stock_initial . "', ";
			$sql .= "cout_revient = '" . $cout_revient . "', ";
			$sql .= "consomme = '" . $consomme . "', ";
			$sql .= "consomme1 = '" . $consomme1 . "', ";
			$sql .= "mode_consomme = '" . $mode_consomme . "', ";
			$sql .= "unites = '" . $unites . "', ";
			$sql .= "poids = '" . $poids . "', ";
			$sql .= "achats = '" . $achats . "' ";
			$sql .= "WHERE profile_id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM types_tiges WHERE profile_id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";
	$sql .= "FROM types_tiges ORDER BY profile_name;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "tige.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo ""; ?></span>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

<table class="table2">

<tr>
	<th><?php echo "Libelle";?></th>
	<th><?php echo "Stock_initial :Kg";?></th>
	<th><?php echo "Achats Exercice :Kg";?></th>
	<th><?php echo "Unites Mesure";?></th>
	<th><?php echo "Poids : kg";?></th>
	<th><?php echo "C.M.U.P ";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["profile_id"]; ?>)"><?php echo $users_["profile_name"];?></A></td>
	<td align="center"><?php echo $users_["stock_initial"];?></td>
	<td align="center"><?php echo $users_["achats"];?></td>
	<td align="center"><?php echo $users_["unites"];?></td>
	<td align="center"><?php echo $users_["poids"];?></td>
	<td align="center"><?php echo number_format($users_["cout_revient"],2,',',' ');?></td>
	<?
				/*$condit=1;$matiere="tige";$stock_initial=0;$type="accessoire";$poids=0;
				$sql  = "INSERT INTO produits ( produit, condit, matiere,stock_initial,type,poids ) VALUES ( ";
				$sql .= "'" . $users_["profile_name"] . "', ";
				$sql .= "'" . $condit . "', ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $stock_initial . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $poids . ");";

				db_query($database_name, $sql);*/
	?>
<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

</body>

</html>