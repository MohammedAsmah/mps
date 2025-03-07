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
			$vendeur = $_REQUEST["vendeur"];$ville = $_REQUEST["ville"];
		}
		
		switch($_REQUEST["action_"]) {

		
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM porte_feuilles WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles ORDER BY client,date_enc;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste encaissments"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "ecriture.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste encaissements"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Tableau";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Espece";?></th>
	<th><?php echo "Cheque";?></th>
	<th><?php echo "Effet";?></th>
	<th><?php echo "Virement";?></th>
	<th><?php echo "Avoir";?></th>
	<th><?php echo "Diff/prix";?></th>

</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><?php echo dateUsToFr($users_["date_enc"]);?></td>
<td><?php echo $users_["id_registre_regl"]; ?></td>
<td><?php echo $users_["client"]; ?></td>
<td><?php echo $users_["m_espece"]; ?></td>
<td><?php echo $users_["m_cheque"]; ?></td>
<td><?php echo $users_["m_effet"]; ?></td>
<td><?php echo $users_["m_virement"]; ?></td>
<td><?php echo $users_["m_avoir"]; ?></td>
<td><?php echo $users_["m_diff_prix"]; ?></td>

<?php } ?>

</table>

<p style="text-align:center">

</body>

</html>