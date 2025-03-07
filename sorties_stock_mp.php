<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$famille="MATIERE";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) ) { 

		if($_REQUEST["action_"] != "delete_user" ) {
			// prepares data to simplify database insert or update
			$produit = $_REQUEST["produit"];$depot_a=$_REQUEST["depot_a"];$depot_c=0;$depot_b=0;
			
			$date = dateFrToUs($_REQUEST["date"]);$date1 = $_REQUEST["date"];$type="sortie";
			$frs = "";
			$commande = $_REQUEST["commande"];
			$reception = "";
			$livraison = "";
			
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
				$sql  = "INSERT INTO entrees_stock_mp ( produit, famille,date,frs,reception,commande,livraison,depot_a,type,depot_b ) VALUES ( ";

				$sql .= "'" . $produit . "', ";$sql .= "'" . $famille . "', ";
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
				$sql  = "INSERT INTO entrees_stock_mp ( produit, famille,date,frs,reception,commande,livraison,depot_a,type,depot_b ) VALUES ( ";

				$sql .= "'" . $produit1 . "', ";$sql .= "'" . $famille . "', ";
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
				$sql  = "INSERT INTO entrees_stock_mp ( produit, famille,date,frs,reception,commande,livraison,depot_a,type,depot_b ) VALUES ( ";

				$sql .= "'" . $produit2 . "', ";$sql .= "'" . $famille . "', ";
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
				$sql  = "INSERT INTO entrees_stock_mp ( produit, famille,date,frs,reception,commande,livraison,depot_a,type,depot_b ) VALUES ( ";

				$sql .= "'" . $produit3 . "', ";$sql .= "'" . $famille . "', ";
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
				$sql  = "INSERT INTO entrees_stock_mp ( produit, famille,date,frs,reception,commande,livraison,depot_a,type,depot_b ) VALUES ( ";

				$sql .= "'" . $produit4 . "', ";$sql .= "'" . $famille . "', ";
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
				$sql  = "INSERT INTO entrees_stock_mp ( produit, famille,date,frs,reception,commande,livraison,depot_a,type,depot_b ) VALUES ( ";

				$sql .= "'" . $produit5 . "', ";$sql .= "'" . $famille . "', ";
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
				$sql  = "INSERT INTO entrees_stock_mp ( produit, famille,date,frs,reception,commande,livraison,depot_a,type,depot_b ) VALUES ( ";

				$sql .= "'" . $produit6 . "', ";$sql .= "'" . $famille . "', ";
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
				$sql  = "INSERT INTO entrees_stock_mp ( produit, famille,date,frs,reception,commande,livraison,depot_a,type,depot_b ) VALUES ( ";

				$sql .= "'" . $produit7 . "', ";$sql .= "'" . $famille . "', ";
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
				$sql  = "INSERT INTO entrees_stock_mp ( produit, famille,date,frs,reception,commande,livraison,depot_a,type,depot_b ) VALUES ( ";

				$sql .= "'" . $produit8 . "', ";$sql .= "'" . $famille . "', ";
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
				$sql  = "INSERT INTO entrees_stock_mp ( produit, famille,date,frs,reception,commande,livraison,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $produit9 . "', ";$sql .= "'" . $famille . "', ";
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
			
			$sql .= "commande = '" . $_REQUEST["commande"] . "', ";
			
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
	
		$date="";$action="Recherche";
			if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="sorties_stock_mp.php">
	<table><td><?php echo "Date: "; ?><input onClick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td></td></table>
	</form>
	
	<? }
	if(isset($_REQUEST["action"])){

	$sql  = "SELECT * ";$type="sortie";$date=dateFrToUs($_POST['date']);$mp3="MATIERE";
	$sql .= "FROM entrees_stock_mp where date='$date' and type='$type' and famille='$mp3' ORDER BY date;";
	$users = db_query($database_name, $sql);}
	else
	{	$sql  = "SELECT * ";$type="sortie";$dj=date("Y-m-d");$mp3="MATIERE";
	$sql .= "FROM entrees_stock_mp where type='$type' and date='$dj' and famille='$mp3' ORDER BY date;";
	$users = db_query($database_name, $sql);}
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "SORTIES "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "sortie_stock_mp.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo " SORTIES "; ?></span>


<table class="table2">

<tr>
	<th><?php echo "DATE";?></th>
	<th><?php echo "ARTICLE";?></th>
	<th><?php echo "QUANTITE";?></th>
	<th><?php echo "REMARQUES";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>

<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo dateUsToFr($users_["date"]);?></A></td>
<td><?php echo $users_["produit"]; ?></td>
<td style="text-align:left"><?php echo $users_["depot_a"]; ?></td>
<td><?php echo $users_["commande"]; ?></td>
<?php } ?>

</table>

<p style="text-align:center">
<table><tr><td>
<? if ($date<>""){echo "<a href=\"sortie_stock_mp.php?date=$date&user_id=0\">Ajout SORTIE</a></td>";}?></tr><tr>
<td><? /*echo "<a href=\"entree_stock.php?date=$date&user_id=20000000\">Importation Production</a></td>";*/?></tr>
</table>
</body>

</html>