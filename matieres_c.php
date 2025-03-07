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
			$profile_name = $_REQUEST["profile_name"];$stock_initial = $_REQUEST["stock_initial"];
			$to = "";$cout_revient = $_REQUEST["cout_revient"];
			$type_a = "";
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
				$sql  = "INSERT INTO types_consomables ( profile_name,stock_initial,cout_revient,type_a ) VALUES ( ";
				$sql .= "'".$profile_name . "',";
				$sql .= "'".$stock_initial . "',";
				$sql .= "'".$cout_revient . "',";
				$sql .= "'".$type_a . "');";
				db_query($database_name, $sql);

			break;

			case "update_user":

			$sql = "UPDATE types_consomables SET ";
			$sql .= "profile_name = '" . $profile_name . "', ";
			$sql .= "stock_initial = '" . $stock_initial . "', ";
			$sql .= "cout_revient = '" . $cout_revient . "' ";
			$sql .= "WHERE profile_id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM types_consomables WHERE profile_id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			$profile_id = GetUserProfile();	$user_name=GetUserName();$date_time=date("y-m-d h:m:s");
			$table_name="types_consomables";$record=$_REQUEST["user_id"];
				$sql  = "INSERT INTO deleted_files ( user,date_time,table_name,record ) VALUES ( ";
				$sql .= "'" . $user_name . "', ";
				$sql .= "'" . $date_time . "', ";
				$sql .= "'" . $table_name . "', ";
				$sql .= "'" . $record . "');";

				db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";
	$sql .= "FROM types_consomables ORDER BY profile_name;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "matiere_c.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo ""; ?></span>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

<table class="table2">

<tr>
	<th><?php $debut_exe="2011-01-01";$fin_exe="2011-12-31";echo "Libelle";?></th>
	<th><?php echo "Stock_initial :Kg";?></th>
	<th><?php echo "Achats  :Kg";?></th>
	<th><?php echo "Valeur Achats ";?></th>
	<th><?php echo "C.M.U.P ";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["profile_id"]; ?>)"><?php echo $users_["profile_name"];?></A></td>
	<td align="center"><?php echo $users_["stock_initial"];?></td>
	<? $sql  = "SELECT * ";$m=$users_["profile_name"];$achat=0;$v=0;
	$sql .= "FROM achats_mat where produit='$m' and date between '$debut_exe' and '$fin_exe' ORDER BY date;";
	$users1 = db_query($database_name, $sql);
	while($users1_ = fetch_array($users1)) { $achat=$achat+$users1_["qte"];$v=$v+($users1_["qte"]*$users1_["prix_achat"]);} ?>
	<td align="center"><?php echo $achat;?></td>
	<td align="center"><?php echo number_format($v,2,',',' ');?></td><td></td>
	

<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

</body>

</html>