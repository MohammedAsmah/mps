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
			$vendeur = $_REQUEST["vendeur"];
			$ref = $_REQUEST["ref"];$com = $_REQUEST["com"];

		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO vendeurs ( ref, vendeur, com) VALUES ( ";
				$sql .= "'" . $_REQUEST["ref"] . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= $com . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE vendeurs SET ";
			$sql .= "ref = '" . $_REQUEST["ref"] . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			$sql .= "com = " . $com . " ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// deletes user's bookings
			/*$sql = "DELETE FROM rs_data_bookings WHERE user_id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);*/

			// delete user's profile
			$sql = "DELETE FROM vendeurs WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";$null="";
	$sql .= "FROM vendeurs  where vendeur<>'$null' ORDER BY vendeur;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Vendeurs"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "vendeur.php?user_id=" + user_id; }
	function EditUser1(user_id) { document.location = "compte_vendeur.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Vendeurs"; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "Plafond";?></th>
	<th><?php echo "En compte";?></th>
	<th><?php echo "Decouvert";?></th>
	
</tr>

<?php while($users_1 = fetch_array($users)) { ?><tr>

<td><a href="JavaScript:EditUser1(<?php echo $users_1["id"]; ?>)"><?php echo $users_1["vendeur"];?></A></td>
<td align="right"><?php echo number_format($users_1["plafond"],2,',',' ');?></td>
<?
	$vendeur=$users_1["vendeur"];$encompte_client=0;$du="2024-10-01";$au="2024-11-01";$plafond=$users_1["plafond"];
	$sql  = "SELECT id,client,date_e,sum(net) As total_net,sum(reliquat) As total_reliquat ";$date_enc="2011-01-01";
	//$sql .= "FROM commandes where date_e between '$du' and '$au' and vendeur='$vendeur' group by id ORDER BY client;";
	$sql .= "FROM commandes where vendeur='$vendeur' group by vendeur ORDER BY client;";
	$users1 = db_query($database_name, $sql);
	
	while($users_ = fetch_array($users1)) { ?>
<? $client=$users_["client"];$d=$users_["date_e"];$net=$users_["net"];$encompte_client=$users_["total_reliquat"];$net=$users_["total_net"];?>
<?php $vendeur=$users_["vendeur"];$ca=$ca+$net;$reliquat=$reliquat+$encompte_client;$id=$users_["id"];



			/*$sql = "UPDATE commandes SET ";
			
			$sql .= "reliquat = '" . $net . "' ";
			
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);*/




if ($encompte_client>0){?>



<td align="right"><?php echo number_format($encompte_client,2,',',' ');?></td>
<? } else { ?>
<td align="right"><?php ?></td>
				
<? } } 


?>

<td align="right"><?php echo number_format($plafond-$encompte_client,2,',',' ');?></td>


<?php } ?>
<tr><td></td>
<td></td>
<td align="right"><?php echo number_format($reliquat,2,',',' ');?></td>
<td></td></tr>
</table>

<p style="text-align:center">




</body>

</html>