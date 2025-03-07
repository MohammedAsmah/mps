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
			$login = $_REQUEST["login"];
			$excedents_factures = $_REQUEST["excedents_factures"];
			$avance_commande_moisprecedent = $_REQUEST["avance_commande_moisprecedent"];
			$avance_commande_moisencours = $_REQUEST["avance_commande_moisencours"];
			$tva_a_recuperer = $_REQUEST["tva_a_recuperer"];$arrondi = $_REQUEST["arrondi"];
			$caexonore = $_REQUEST["caexonore"];
			$numeroexonore = $_REQUEST["numeroexonore"];$mend = $_REQUEST["mend"];$m_represente = $_REQUEST["m_represente"];
			$credit_mois_precedent = $_REQUEST["credit_mois_precedent"];
			
		}
		if ($user_login=="admin" or $user_login=="rakia" or $user_login=="Radia" or $user_login=="najat"){
		
		
		switch($_REQUEST["action_"]) {
		

			
			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE tva_2024 SET excedents_factures = '$excedents_factures',avance_commande_moisencours = '$avance_commande_moisencours',
			avance_commande_moisprecedent = '$avance_commande_moisprecedent',tva_a_recuperer = '$tva_a_recuperer',
			credit_mois_precedent = '$credit_mois_precedent',caexonore = '$caexonore',mend = '$mend',m_represente = '$m_represente',
			numeroexonore = '$numeroexonore',arrondi = '$arrondi'
			
			 WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			

			
			break;


	
		} //switch
	} //if
		} //if
	$sql  = "SELECT * ";
	$sql .= "FROM tva_2024 ORDER BY du;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "MISE A JOUR TVA"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre_tva.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "MISE A JOUR TVA"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Mois";?></th>
	<th><?php echo "DU";?></th>
	<th><?php echo "AU";?></th>
	<th><?php echo "Excedent";?></th>
	<th><?php echo "Avance/Cde encours";?></th>
	<th><?php echo "Avance/Cde precedent";?></th>
	<th><?php echo "Tva a recuperer";?></th>
	<th><?php echo "Credit mois precedent";?></th>
	
	
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["mois"];?></A></td>
<?php $id=$users_["id"];$du=dateUsToFr($users_["du"]); $au=dateUsToFr($users_["au"]);?>

<td><?php echo $du; ?></td>
<td><?php echo $au; ?></td>

<td><?php echo number_format($users_["excedents_factures"],2,',',' '); ?></td>
<td><?php echo number_format($users_["avance_commande_moisencours"],2,',',' '); ?></td>
<td><?php echo number_format($users_["avance_commande_moisprecedent"],2,',',' '); ?></td>
<td><?php echo number_format($users_["tva_a_recuperer"],2,',',' '); ?></td>
<td><?php echo number_format($users_["credit_mois_precedent"],2,',',' '); ?></td>
<?php } ?>

</table>

<p style="text-align:center">



</body>

</html>