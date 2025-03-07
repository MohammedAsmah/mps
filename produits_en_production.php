<?php
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"])) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
						
			if(isset($_REQUEST["enproduction"])) { $enproduction = 1; } else { $enproduction = 0; }
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
			

			break;

			case "update_user":

			$sql = "UPDATE produits SET ";
			$sql .= "enproduction = '" . $enproduction . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			break;


		} //switch
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
	function EditUser(user_id) { document.location = "produit_en_production.php?user_id=" + user_id; }
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
	<th><?php echo "En production";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td bgcolor="#66CCCC"><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["id"];?></A></td>
<td style="text-align:left" bgcolor="#66CCCC"><?php echo $users_["produit"]; ?></td>
<td bgcolor="#66CCCC"><?php echo $users_["condit"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="right"><?php echo $users_["prix"]; ?></td>
<?php if ($users_["enproduction"]==0){?><td bgcolor="#FF3333"><? echo "non";}else{?><td bgcolor="#0066FF"><? echo "oui";}; ?></td>
<?php } ?>

</table>

<p style="text-align:center">

</body>

</html>