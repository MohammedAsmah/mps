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
			$produit = $_REQUEST["produit"];$fournisseur = $_REQUEST["fournisseur"];
			$prix_unitaire = $_REQUEST["prix_unitaire"];
			
			$sql  = "SELECT * ";$famille="";$unite="";
			$sql .= "FROM articles_commandes WHERE produit = '$produit' order BY produit;";
			$user = db_query($database_name, $sql); $user_ = fetch_array($user);
			$famille=$user_["type"];
			$unite=$user_["unite"];
			
		}
		
		if ($login=="admin" or $login=="rakia" or $login=="radia" or $login=="sana" or $login=="rabia"){
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO tarifs_achats ( produit,famille,unite, fournisseur, prix_unitaire ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $famille . "', ";
				$sql .= "'" . $unite . "', ";
				$sql .= "'" . $fournisseur . "', ";
				$sql .= $prix_unitaire . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE tarifs_achats SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "', ";
			$sql .= "fournisseur = '" . $fournisseur . "', ";
			$sql .= "famille = '" . $famille . "', ";
			$sql .= "unite = '" . $unite . "', ";
			$sql .= "prix_unitaire = '" . $prix_unitaire . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM tarifs_achats WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	}
	} //if
	
	
	// recherche ville
	?>
	
	<?
	$sql  = "SELECT * ";
	$sql .= "FROM tarifs_achats ORDER BY produit;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Produits"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "tarif_achat.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Tarifs Achats"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Designation";?></th>
	<th><?php echo "Fournisseur";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Unite";?></th>
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>


<td bgcolor="#66CCCC"><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["produit"];?></A></td>
<td style="text-align:left" bgcolor="#66CCCC"><?php echo $users_["fournisseur"]; ?></td>
<td bgcolor="#66CCCC"><?php echo $users_["prix_unitaire"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="right"><?php echo $users_["unite"]; ?></td>


<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>
	
	
</body>

</html>