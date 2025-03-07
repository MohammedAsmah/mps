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

		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":

			break;

			case "update_user":

			break;
			
			case "delete_user":
			
			break;


		} //switch
	} //if
	
	
	// recherche ville
	?>
	
	<?
	$sql  = "SELECT * ";
	$sql .= "FROM details_bookings_sejours_rak where validation_f=0 ORDER BY depart;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Sejours non Facturés"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "factuter.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Sejours non Facturés"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Réf";?></th>
	<th><?php echo "Nom";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Arrivée";?></th>
	<th><?php echo "Départ";?></th>
	<th><?php echo "Chambre";?></th>
	<th><?php echo "Nbre Pax";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Statut";?></th>

</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["v_ref"];?></A></td>
<td><?php echo $users_["noms"]; ?></td>
<td><?php echo $users_["client"]; ?></td>
<td><?php echo dateUsToFr($users_["arrivee"]); ?></td>
<td><?php echo dateUsToFr($users_["depart"]); ?></td>
<td><?php echo $users_["chambre_riad"]; ?></td>
<td><?php echo $users_["adultes"]."-".$users_["enfants"]; ?></td>
<td><?php $m=number_format($users_["montant_envoi"],2,',',' ');echo $m; ?></td>
<td><?php echo $users_["statut"]; ?></td>

<?php } ?>

</table>

<p style="text-align:center">

</body>

</html>