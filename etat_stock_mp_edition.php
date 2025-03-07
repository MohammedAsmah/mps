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
			$produit = $_REQUEST["produit"];$condit = $_REQUEST["condit"];$prix = $_REQUEST["prix"];$type = $_REQUEST["type"];
			$unite = $_REQUEST["unite"];$stock_initial = $_REQUEST["stock_initial"];$type_c = $_REQUEST["type_c"];
			$seuil_critique = $_REQUEST["seuil_critique"];
			if(isset($_REQUEST["dispo"])) { $dispo = 1; } else { $dispo = 0; }
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO articles_commandes ( produit, unite, prix,stock_initial,seuil_critique,type,type_c, dispo ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $unite . "', ";
				$sql .= "'" . $prix . "', ";$sql .= "'" . $stock_initial . "', ";$sql .= "'" . $seuil_critique . "', ";
				$sql .= "'" . $type . "', ";$sql .= "'" . $type_c . "', ";
				$sql .= $dispo . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE articles_commandes SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "', ";
			$sql .= "unite = '" . $unite . "', ";
			$sql .= "dispo = '" . $dispo . "', ";
			$sql .= "stock_initial = '" . $stock_initial . "', ";$sql .= "seuil_critique = '" . $seuil_critique . "', ";
			$sql .= "prix = '" . $prix . "', ";
			$sql .= "type = '" . $type . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM articles_commandes WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	
	// recherche ville
	?>
	
	<?
	$sql  = "SELECT * ";$t1="mp";
	$sql .= "FROM articles_commandes where type_c='$t1' ORDER BY produit;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste articles commandes"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "histo_article_commande_mp.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "STOCK MATIERES PREMIERES"; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "Article";?></th>
	<th><?php echo " Unite ";?></th>
	<th><?php echo " INITIAL ";?></th>
	<th><?php echo "ENTREE";?></th>
	<th><?php echo "SORTIE";?></th>
	<th><?php echo "STOCK";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>


<?php $produit=$users_["produit"]; echo "<td>$produit</td>";?>


<td bgcolor="#66CCCC" align="center"><?php echo $users_["unite"]; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $users_["stock_initial"]; ?></td>
<?php
	$p=$users_["produit"];
	$sql  = "SELECT * ";$type="reception";$r=0;$s=0;$ini=$users_["stock_initial"];
	$sql .= "FROM entrees_stock_mp where produit='$p' ORDER BY date;";
	$users1 = db_query($database_name, $sql);
	
	while($users_1 = fetch_array($users1)) {
	if ($users_1["type"]=="reception"){$r=$r+$users_1["depot_a"];}else{$s=$s+$users_1["depot_a"];}
	
	}
	$stock=$ini+$r-$s;
	
if ($users_1["type"]=="reception"){?>
<td bgcolor="#66CCCC" align="right"><?php echo $r; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $s; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $stock; ?></td>


<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>
	
</body>

</html>