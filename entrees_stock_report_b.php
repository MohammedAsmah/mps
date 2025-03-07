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
			$produit = $_REQUEST["produit"];$depot_a=$_REQUEST["depot_a"];$depot_c=0;$depot_b=0;
			
			$date = dateFrToUs($_REQUEST["date"]);$date1 = $_REQUEST["date"];$type="Maj stock";
	if($_REQUEST["action_"] == "insert_new_user") {	
	
		$produit1 = $_REQUEST["produit1"];$depot_a1=$_REQUEST["depot_a1"];$produit2 = $_REQUEST["produit2"];$depot_a2=$_REQUEST["depot_a2"];
		$produit3 = $_REQUEST["produit3"];$depot_a3=$_REQUEST["depot_a3"];$produit7 = $_REQUEST["produit7"];$depot_a7=$_REQUEST["depot_a7"];
		$produit4 = $_REQUEST["produit4"];$depot_a4=$_REQUEST["depot_a4"];$produit5 = $_REQUEST["produit5"];$depot_a5=$_REQUEST["depot_a5"];
		$produit6 = $_REQUEST["produit6"];$depot_a6=$_REQUEST["depot_a6"];$produit8 = $_REQUEST["produit8"];$depot_a8=$_REQUEST["depot_a8"];
		$produit9 = $_REQUEST["produit9"];$depot_a9=$_REQUEST["depot_a9"]; 
		}
		
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		if($_REQUEST["produit"] != "") {	
				$sql  = "INSERT INTO entrees_stock ( produit, date,depot_b,type,depot_a ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $depot_a . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["produit1"] != "") {	
				$sql  = "INSERT INTO entrees_stock ( produit, date,depot_b,type,depot_a ) VALUES ( ";
				$sql .= "'" . $produit1 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $depot_a1 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["produit2"] != "") {	
				$sql  = "INSERT INTO entrees_stock ( produit, date,depot_b,type,depot_a ) VALUES ( ";
				$sql .= "'" . $produit2 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $depot_a2 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["produit3"] != "") {	
				$sql  = "INSERT INTO entrees_stock ( produit, date,depot_b,type,depot_a ) VALUES ( ";
				$sql .= "'" . $produit3 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $depot_a3 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["produit4"] != "") {	
				$sql  = "INSERT INTO entrees_stock ( produit, date,depot_b,type,depot_a ) VALUES ( ";
				$sql .= "'" . $produit4 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $depot_a4 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["produit5"] != "") {	
				$sql  = "INSERT INTO entrees_stock ( produit, date,depot_b,type,depot_a ) VALUES ( ";
				$sql .= "'" . $produit5 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $depot_a5 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["produit6"] != "") {	
				$sql  = "INSERT INTO entrees_stock ( produit, date,depot_b,type,depot_a ) VALUES ( ";
				$sql .= "'" . $produit6 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $depot_a6 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["produit7"] != "") {	
				$sql  = "INSERT INTO entrees_stock ( produit, date,depot_b,type,depot_a ) VALUES ( ";
				$sql .= "'" . $produit7 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $depot_a7 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["produit8"] != "") {	
				$sql  = "INSERT INTO entrees_stock ( produit, date,depot_b,type,depot_a ) VALUES ( ";
				$sql .= "'" . $produit8 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $depot_a8 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["produit9"] != "") {	
				$sql  = "INSERT INTO entrees_stock ( produit, date,depot_b,type,depot_a ) VALUES ( ";
				$sql .= "'" . $produit9 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $depot_a9 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
			$vide="";
				$sql = "DELETE FROM entrees_stock WHERE produit = '" . $vide . "';";
				db_query($database_name, $sql);
			break;

			case "update_user":

			$sql = "UPDATE entrees_stock SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "', ";
			$sql .= "depot_b = '" . $_REQUEST["depot_a"] . "', ";
			$sql .= "date = '" . $date . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM entrees_stock WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	
	// recherche ville
	?>
	
	<?
	$sql  = "SELECT * ";$type="Maj stock";$du="2017-03-03";
	$sql .= "FROM entrees_stock where type='$type' and date>='$du' and depot_b<>0 ORDER BY date;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "ENTREE STOCK"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "entree_stock_report_b.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "ENTREE STOCK INITIAL JAOUDA"; ?></span>

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

<table class="table2">

<tr>
	<th><?php echo "DATE";?></th>
	<th><?php echo "ARTICLE";?></th>
	<th><?php echo "QUANTITE";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>

<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo dateUsToFr($users_["date"]);?></A></td>
<td><?php echo $users_["produit"]; ?></td>
<td style="text-align:left"><?php echo $users_["depot_b"]; ?></td>
<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>
	

</body>

</html>