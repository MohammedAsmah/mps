<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) ) { 

		if($_REQUEST["action_"] != "delete_user" ) {
			// prepares data to simplify database insert or update
			$produit = $_REQUEST["produit"];$depot_a=$_REQUEST["depot_a"];$depot_c=0;$depot_b=0;
			
			$date = dateFrToUs($_REQUEST["date"]);$date1 = $_REQUEST["date"];$type="reception";
			$frs = $_REQUEST["frs"];
			$commande = $_REQUEST["commande"];
			$reception = $_REQUEST["reception"];
			$livraison = $_REQUEST["livraison"];
			
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
			
		if($_REQUEST["depot_a"] != 0) {	
				$sql  = "INSERT INTO entrees_stock_mp ( produit, date,frs,reception,commande,livraison,depot_a,type,depot_b ) VALUES ( ";

				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $reception . "', ";
				$sql .= "'" . $commande . "', ";
				$sql .= "'" . $livraison . "', ";
				$sql .= "'" . $depot_a . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["depot_a1"] != 0) {	
				$sql  = "INSERT INTO entrees_stock_mp ( produit, date,frs,reception,commande,livraison,depot_a,type,depot_b ) VALUES ( ";

				$sql .= "'" . $produit1 . "', ";
				$sql .= "'" . $date . "', ";
								$sql .= "'" . $frs . "', ";
				$sql .= "'" . $reception . "', ";
				$sql .= "'" . $commande . "', ";
				$sql .= "'" . $livraison . "', ";
				$sql .= "'" . $depot_a1 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["depot_a2"] != 0) {	
				$sql  = "INSERT INTO entrees_stock_mp ( produit, date,frs,reception,commande,livraison,depot_a,type,depot_b ) VALUES ( ";

				$sql .= "'" . $produit2 . "', ";
				$sql .= "'" . $date . "', ";
								$sql .= "'" . $frs . "', ";
				$sql .= "'" . $reception . "', ";
				$sql .= "'" . $commande . "', ";
				$sql .= "'" . $livraison . "', ";
				$sql .= "'" . $depot_a2 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["depot_a3"] != 0) {	
				$sql  = "INSERT INTO entrees_stock_mp ( produit, date,frs,reception,commande,livraison,depot_a,type,depot_b ) VALUES ( ";

				$sql .= "'" . $produit3 . "', ";
				$sql .= "'" . $date . "', ";
								$sql .= "'" . $frs . "', ";
				$sql .= "'" . $reception . "', ";
				$sql .= "'" . $commande . "', ";
				$sql .= "'" . $livraison . "', ";
				$sql .= "'" . $depot_a3 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["depot_a4"] != 0) {	
				$sql  = "INSERT INTO entrees_stock_mp ( produit, date,frs,reception,commande,livraison,depot_a,type,depot_b ) VALUES ( ";

				$sql .= "'" . $produit4 . "', ";
				$sql .= "'" . $date . "', ";
								$sql .= "'" . $frs . "', ";
				$sql .= "'" . $reception . "', ";
				$sql .= "'" . $commande . "', ";
				$sql .= "'" . $livraison . "', ";
				$sql .= "'" . $depot_a4 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["depot_a5"] != 0) {	
				$sql  = "INSERT INTO entrees_stock_mp ( produit, date,frs,reception,commande,livraison,depot_a,type,depot_b ) VALUES ( ";

				$sql .= "'" . $produit5 . "', ";
				$sql .= "'" . $date . "', ";
								$sql .= "'" . $frs . "', ";
				$sql .= "'" . $reception . "', ";
				$sql .= "'" . $commande . "', ";
				$sql .= "'" . $livraison . "', ";
				$sql .= "'" . $depot_a5 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["depot_a6"] != 0) {	
				$sql  = "INSERT INTO entrees_stock_mp ( produit, date,frs,reception,commande,livraison,depot_a,type,depot_b ) VALUES ( ";

				$sql .= "'" . $produit6 . "', ";
				$sql .= "'" . $date . "', ";
								$sql .= "'" . $frs . "', ";
				$sql .= "'" . $reception . "', ";
				$sql .= "'" . $commande . "', ";
				$sql .= "'" . $livraison . "', ";
				$sql .= "'" . $depot_a6 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["depot_a7"] != 0) {	
				$sql  = "INSERT INTO entrees_stock_mp ( produit, date,frs,reception,commande,livraison,depot_a,type,depot_b ) VALUES ( ";

				$sql .= "'" . $produit7 . "', ";
				$sql .= "'" . $date . "', ";
								$sql .= "'" . $frs . "', ";
				$sql .= "'" . $reception . "', ";
				$sql .= "'" . $commande . "', ";
				$sql .= "'" . $livraison . "', ";
				$sql .= "'" . $depot_a7 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["depot_a8"] != 0) {	
				$sql  = "INSERT INTO entrees_stock_mp ( produit, date,frs,reception,commande,livraison,depot_a,type,depot_b ) VALUES ( ";

				$sql .= "'" . $produit8 . "', ";
				$sql .= "'" . $date . "', ";
								$sql .= "'" . $frs . "', ";
				$sql .= "'" . $reception . "', ";
				$sql .= "'" . $commande . "', ";
				$sql .= "'" . $livraison . "', ";
				$sql .= "'" . $depot_a8 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["depot_a9"] != 0) {	
				$sql  = "INSERT INTO entrees_stock_mp ( produit, date,frs,reception,commande,livraison,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $produit9 . "', ";
				$sql .= "'" . $date . "', ";
								$sql .= "'" . $frs . "', ";
				$sql .= "'" . $reception . "', ";
				$sql .= "'" . $commande . "', ";
				$sql .= "'" . $livraison . "', ";
				$sql .= "'" . $depot_a9 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
			break;

			case "update_user":

			$sql = "UPDATE entrees_stock_mp SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "', ";
			$sql .= "depot_a = '" . $_REQUEST["depot_a"] . "', ";
			$sql .= "reception = '" . $_REQUEST["reception"] . "', ";
			$sql .= "commande = '" . $_REQUEST["commande"] . "', ";
			
			$sql .= "livraison = '" . $_REQUEST["livraison"] . "', ";
			$sql .= "date = '" . $date . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM entrees_stock_mp WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;

			case "import":

			echo "importation en cours";
			break;


		} //switch
	} //if
	
	
	// recherche ville
	?>
	
	<?
	
		$date="";$action="Recherche";$date2="";
			if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="etat_entrees_stock_mp.php">
	<table><td><?php echo "Du: "; ?><input onClick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au: "; ?><input onClick="ds_sh(this);" name="date2" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td></td></table>
	</form>
	
	<? }
	if(isset($_REQUEST["action"])){

	$sql  = "SELECT * ";$type="reception";$date=dateFrToUs($_POST['date']);$date2=dateFrToUs($_POST['date2']);
	$sql .= "FROM entrees_stock_mp where date between '$date' and '$date2' and type='$type' GROUP BY produit ORDER BY produit;";
	$users = db_query($database_name, $sql);}else{

	$sql  = "SELECT * ";$type="reception";$date="2001-01-01";$date2="2020-12-31";
	$sql .= "FROM entrees_stock_mp where type='$type' GROUP BY produit ORDER BY produit;";
	$users = db_query($database_name, $sql);}
	

	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "ENTREE "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo " ETAT DES ENTREES M.P "; ?></span>


<table class="table2">

<tr>
	
	<th><?php echo "MATIERE";?></th>
	<th><?php echo "QUANTITE";?></th>
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>


<?php $produit=$users_["produit"]; ?><? echo "<td><a href=\"details_entrees_mp.php?produit=$produit&date=$date&date2=$date2\">$produit</a></td>";?>
<td style="text-align:right"><?php echo $users_["depot_a"]; ?></td>

<?php } ?>

</table>

<p style="text-align:center">

</body>

</html>