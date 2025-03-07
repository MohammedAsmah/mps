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
			$produit = $_REQUEST["produit"];$condit = $_REQUEST["condit"];$prix = $_REQUEST["prix"];$type = $_REQUEST["type"];
			
			if(isset($_REQUEST["stock_controle"])) { $stock_controle = 1; } else { $stock_controle = 0; }
		}
		
		if ($login=="admin" or $login=="rakia"){
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO produits ( produit, condit, prix,type, dispo ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $condit . "', ";
				$sql .= "'" . $prix . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $dispo . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE produits SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "', ";
			$sql .= "condit = '" . $condit . "', ";
			$sql .= "stock_controle = '" . $stock_controle . "', ";
			$sql .= "prix = '" . $prix . "', ";
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
	$sql  = "SELECT * ";
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
	function EditUser(user_id) { document.location = "controle_stock.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Produits"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Code";?></th>
	<th><?php echo "Nom";?></th>
	<th><?php echo "Conditionnement";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Poids";?></th>
	<th><?php echo "Poids_eval";?></th>
	<th><?php echo "Stock";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>


			<? 
			/*$id=$users_["id"];$poids_evaluation=$users_["poids"];
			$sql = "UPDATE produits SET ";
			$sql .= "poids_evaluation = '" . $poids_evaluation . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);*/?>







<? if ($users_["favoris"]){?>
<td bgcolor="#66CCCC"><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["id"];?></A></td>
<td style="text-align:left" bgcolor="#66CCCC"><?php echo $users_["produit"]; ?></td>
<td bgcolor="#66CCCC"><?php echo $users_["condit"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="right"><?php echo $users_["prix"]; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $users_["poids"]; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $users_["poids_evaluation"]; ?></td>
<? if ($users_["stock_controle"]==0){?><td bgcolor="#0000FF"><? echo "non";}else{?><td><? echo "oui";}; ?></td>
<? } else {?>
<? if ($users_["non_favoris"]){?>
<td bgcolor="#FFFF00"><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["id"];?></A></td>
<td style="text-align:left"  bgcolor="#FFFF00"><?php echo $users_["produit"]; ?></td>
<td  bgcolor="#FFFF00"><?php echo $users_["condit"]; ?></td>
<td style="text-align:left"  bgcolor="#FFFF00" align="right"><?php echo $users_["prix"]; ?></td>
<td  bgcolor="#FFFF00" align="right"><?php echo $users_["poids"]; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $users_["poids_evaluation"]; ?></td>

<? if ($users_["stock_controle"]==0){?><td bgcolor="#0000FF"><? echo "non";}else{?><td><? echo "oui";}; ?></td>
<? } else {?>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["id"];?></A></td>
<td style="text-align:left"><?php echo $users_["produit"]; ?></td>
<td><?php echo $users_["condit"]; ?></td>
<td style="text-align:left" align="right"><?php echo $users_["prix"]; ?></td>
<td align="right"><?php echo $users_["poids"]; ?></td>
<td align="right"><?php echo $users_["poids_evaluation"]; ?></td>
<?php
if ($users_["stock_controle"]==0){?><td bgcolor="#0000FF"><? echo "non";}else{?><td><? echo "oui";}; ?></td>

<? }?>
<? }?>
<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>
	
	<? echo "<tr><td><a href=\"produits_encours.php?\">Liste produits consommés</a></td>";?>

</body>

</html>